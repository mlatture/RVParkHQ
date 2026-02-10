<?php

namespace App\Console\Commands;

use App\Models\Amenity;
use App\Models\Park;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class ImportOsmParks extends Command
{
    protected $signature = 'parks:import-osm {state?} {--all} {--dry-run}';
    protected $description = 'Import campgrounds/RV parks from OpenStreetMap Overpass API';

    protected array $states = [
        'Alabama', 'Alaska', 'Arizona', 'Arkansas', 'California',
        'Colorado', 'Connecticut', 'Delaware', 'Florida', 'Georgia',
        'Hawaii', 'Idaho', 'Illinois', 'Indiana', 'Iowa',
        'Kansas', 'Kentucky', 'Louisiana', 'Maine', 'Maryland',
        'Massachusetts', 'Michigan', 'Minnesota', 'Mississippi', 'Missouri',
        'Montana', 'Nebraska', 'Nevada', 'New Hampshire', 'New Jersey',
        'New Mexico', 'New York', 'North Carolina', 'North Dakota', 'Ohio',
        'Oklahoma', 'Oregon', 'Pennsylvania', 'Rhode Island', 'South Carolina',
        'South Dakota', 'Tennessee', 'Texas', 'Utah', 'Vermont',
        'Virginia', 'Washington', 'West Virginia', 'Wisconsin', 'Wyoming',
    ];

    protected array $amenityMap = [
        'internet_access'  => 'WiFi',
        'swimming_pool'    => 'Swimming Pool',
        'shower'           => 'Showers',
        'toilets'          => 'Restrooms',
        'drinking_water'   => 'Drinking Water',
        'power_supply'     => 'Electric Hookups',
        'sanitary_dump_station' => 'Dump Station',
        'playground'       => 'Playground',
        'dog'              => 'Pet Friendly',
        'laundry'          => 'Laundry',
        'shop'             => 'Store',
        'bbq'              => 'BBQ/Grill',
        'picnic_table'     => 'Picnic Tables',
        'fire_pit'         => 'Fire Pit',
    ];

    public function handle(): int
    {
        $dryRun = $this->option('dry-run');

        if ($this->option('all')) {
            $statesToImport = $this->states;
        } elseif ($state = $this->argument('state')) {
            $stateName = ucwords(str_replace(['-', '_'], ' ', $state));
            if (!in_array($stateName, $this->states)) {
                $this->error("Unknown state: {$stateName}");
                return 1;
            }
            $statesToImport = [$stateName];
        } else {
            $this->error('Provide a state name or use --all');
            return 1;
        }

        $totalNew = 0;
        $totalUpdated = 0;
        $totalSkipped = 0;

        foreach ($statesToImport as $i => $stateName) {
            if ($i > 0) {
                sleep(2); // Rate limit
            }

            $this->info("Importing {$stateName}...");

            try {
                $elements = $this->fetchFromOverpass($stateName);
            } catch (\Exception $e) {
                $this->warn("  Failed for {$stateName}: {$e->getMessage()}");
                continue;
            }

            $new = 0;
            $updated = 0;
            $skipped = 0;

            foreach ($elements as $el) {
                $tags = $el['tags'] ?? [];
                $name = $tags['name'] ?? null;
                $lat = $el['lat'] ?? ($el['center']['lat'] ?? null);
                $lon = $el['lon'] ?? ($el['center']['lon'] ?? null);
                $osmId = $el['id'] ?? null;

                if (!$name || !$lat || !$lon) {
                    $skipped++;
                    continue;
                }

                if ($dryRun) {
                    $new++;
                    continue;
                }

                // Check existing by osm_id
                $existing = $osmId ? Park::where('osm_id', $osmId)->first() : null;

                // Fuzzy match: same name within ~0.5 miles (0.008 degrees)
                if (!$existing) {
                    $existing = Park::where('name', $name)
                        ->whereBetween('latitude', [$lat - 0.008, $lat + 0.008])
                        ->whereBetween('longitude', [$lon - 0.008, $lon + 0.008])
                        ->first();
                }

                $city = $tags['addr:city'] ?? null;
                $parkType = $this->determineParkType($tags);
                $slug = $this->generateUniqueSlug($name, $stateName, $city, $existing->id ?? null);
                $slugPath = strtolower(
                    Str::slug($stateName) . '/' .
                    ($city ? Str::slug($city) . '/' : '') .
                    $slug
                );

                $data = [
                    'name'        => $name,
                    'slug'        => $slug,
                    'slug_path'   => $slugPath,
                    'address'     => trim(($tags['addr:housenumber'] ?? '') . ' ' . ($tags['addr:street'] ?? '')) ?: null,
                    'city'        => $city,
                    'state'       => $stateName,
                    'country'     => 'United States',
                    'postal_code' => $tags['addr:postcode'] ?? null,
                    'latitude'    => $lat,
                    'longitude'   => $lon,
                    'phone'       => $tags['phone'] ?? $tags['contact:phone'] ?? null,
                    'email'       => $tags['email'] ?? $tags['contact:email'] ?? null,
                    'website_url' => $tags['website'] ?? $tags['contact:website'] ?? $tags['url'] ?? null,
                    'park_type'   => $parkType,
                    'data_source' => 'osm',
                    'osm_id'      => $osmId,
                    'description' => $tags['description'] ?? null,
                ];

                if ($existing) {
                    // Only update OSM-sourced fields, don't overwrite manual edits
                    $existing->update(array_filter($data, fn($v) => $v !== null));
                    $existing->update(['osm_id' => $osmId]); // always set osm_id
                    $park = $existing;
                    $updated++;
                } else {
                    $data['status'] = 'active';
                    $park = Park::create($data);
                    $new++;
                }

                // Sync amenities
                $this->syncAmenities($park, $tags);
            }

            $count = count($elements);
            $this->info("  Found {$count} campgrounds: {$new} new, {$updated} updated, {$skipped} skipped");

            $totalNew += $new;
            $totalUpdated += $updated;
            $totalSkipped += $skipped;
        }

        $this->info("Done! Total: {$totalNew} new, {$totalUpdated} updated, {$totalSkipped} skipped" . ($dryRun ? ' (DRY RUN)' : ''));

        return 0;
    }

    protected function fetchFromOverpass(string $stateName): array
    {
        $query = <<<EOT
[out:json][timeout:120];
area["name"="{$stateName}"]["admin_level"="4"]->.searchArea;
(
  node["tourism"="camp_site"](area.searchArea);
  node["camp_site"="caravan_site"](area.searchArea);
  way["tourism"="camp_site"](area.searchArea);
  way["camp_site"="caravan_site"](area.searchArea);
  relation["tourism"="camp_site"](area.searchArea);
  relation["camp_site"="caravan_site"](area.searchArea);
);
out center tags;
EOT;

        $response = Http::timeout(120)->asForm()->post('http://overpass-api.de/api/interpreter', [
            'data' => $query,
        ]);

        if (!$response->successful()) {
            throw new \RuntimeException("Overpass API returned HTTP {$response->status()}");
        }

        return $response->json('elements') ?? [];
    }

    protected function determineParkType(array $tags): string
    {
        $operator = strtolower(($tags['operator'] ?? '') . ' ' . ($tags['operator:type'] ?? ''));

        $map = [
            'federal_nps'    => ['national park service', 'nps'],
            'federal_forest' => ['forest service', 'usfs', 'national forest'],
            'federal_blm'    => ['bureau of land management', 'blm'],
            'federal_corps'  => ['army corps', 'usace'],
            'state_park'     => ['state park', 'state recreation'],
            'county'         => ['county', 'municipal'],
        ];

        foreach ($map as $type => $keywords) {
            foreach ($keywords as $keyword) {
                if (str_contains($operator, $keyword)) {
                    return $type;
                }
            }
        }

        // Also check name for hints
        $nameLower = strtolower($tags['name'] ?? '');
        if (str_contains($nameLower, 'state park')) return 'state_park';
        if (str_contains($nameLower, 'national forest')) return 'federal_forest';

        return 'private';
    }

    protected function generateUniqueSlug(string $name, string $state, ?string $city, ?int $excludeId = null): string
    {
        $base = Str::slug($name . ' ' . ($city ?? '') . ' ' . $state);
        $slug = $base;
        $i = 1;

        while (true) {
            $query = Park::where('slug', $slug);
            if ($excludeId) {
                $query->where('id', '!=', $excludeId);
            }
            if (!$query->exists()) break;
            $slug = $base . '-' . $i++;
        }

        return $slug;
    }

    protected function syncAmenities(Park $park, array $tags): void
    {
        $amenityIds = [];

        foreach ($this->amenityMap as $osmKey => $amenityName) {
            $hasAmenity = false;

            // Check various OSM tag patterns
            if (isset($tags[$osmKey]) && !in_array(strtolower($tags[$osmKey]), ['no', 'none', '0'])) {
                $hasAmenity = true;
            }

            // Check in semicolon-delimited 'amenity' or 'leisure' tags
            foreach (['amenity', 'leisure'] as $multiTag) {
                if (isset($tags[$multiTag]) && str_contains(strtolower($tags[$multiTag]), strtolower($osmKey))) {
                    $hasAmenity = true;
                }
            }

            if ($hasAmenity) {
                $amenity = Amenity::firstOrCreate(
                    ['amenity' => $amenityName],
                    ['category' => 'General']
                );
                $amenityIds[] = $amenity->id;
            }
        }

        if (!empty($amenityIds)) {
            $park->amenities()->syncWithoutDetaching($amenityIds);
        }
    }
}
