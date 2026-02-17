<?php

namespace App\Console\Commands;

use App\Models\Park;
use App\Models\ParkPhoto;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class EnrichOutscraper extends Command
{
    protected $signature = 'parks:enrich-outscraper
        {file : Path to Outscraper CSV or JSON file}
        {--dry-run : Show matches without saving}
        {--create-new : Create new parks for unmatched records}
        {--download-photos : Download and store photos locally}';

    protected $description = 'Enrich park data from Outscraper Google Maps export';

    private int $matched = 0;
    private int $enriched = 0;
    private int $created = 0;
    private int $skipped = 0;
    private int $photosDownloaded = 0;

    public function handle()
    {
        $file = $this->argument('file');
        $dryRun = $this->option('dry-run');
        $createNew = $this->option('create-new');
        $downloadPhotos = $this->option('download-photos');

        if (!file_exists($file)) {
            $this->error("File not found: {$file}");
            return 1;
        }

        $extension = strtolower(pathinfo($file, PATHINFO_EXTENSION));
        $records = $extension === 'json'
            ? $this->loadJson($file)
            : $this->loadCsv($file);

        $this->info("Loaded " . count($records) . " records from Outscraper export");

        $bar = $this->output->createProgressBar(count($records));
        $bar->start();

        foreach ($records as $record) {
            $this->processRecord($record, $dryRun, $createNew, $downloadPhotos);
            $bar->advance();
        }

        $bar->finish();
        $this->newLine(2);

        // Calculate quality scores for all active parks
        if (!$dryRun) {
            $this->info('Recalculating quality scores...');
            $this->recalculateQualityScores();
        }

        $this->info('=== Enrichment Summary ===');
        $this->info("Matched to existing: {$this->matched}");
        $this->info("Enriched (fields updated): {$this->enriched}");
        $this->info("Created new: {$this->created}");
        $this->info("Skipped (no match, --create-new not set): {$this->skipped}");
        $this->info("Photos downloaded: {$this->photosDownloaded}");

        return 0;
    }

    private function processRecord(array $record, bool $dryRun, bool $createNew, bool $downloadPhotos): void
    {
        $name = trim($record['name'] ?? '');
        $lat = floatval($record['latitude'] ?? 0);
        $lng = floatval($record['longitude'] ?? 0);
        $googlePlaceId = $record['google_id'] ?? $record['place_id'] ?? null;

        if (empty($name)) {
            $this->skipped++;
            return;
        }

        // Try to match existing park
        $park = $this->findMatch($name, $lat, $lng, $googlePlaceId);

        if ($park) {
            $this->matched++;
            if (!$dryRun) {
                $updated = $this->enrichPark($park, $record, $downloadPhotos);
                if ($updated) $this->enriched++;
            } else {
                $this->line("  MATCH: \"{$name}\" -> [{$park->id}] \"{$park->name}\"");
            }
        } elseif ($createNew) {
            if (!$dryRun) {
                $this->createPark($record, $downloadPhotos);
                $this->created++;
            } else {
                $state = $record['state'] ?? $record['state_code'] ?? '';
                $this->line("  NEW: \"{$name}\" ({$state})");
                $this->created++;
            }
        } else {
            $this->skipped++;
        }
    }

    private function findMatch(string $name, float $lat, float $lng, ?string $googlePlaceId): ?Park
    {
        // 1. Match by Google Place ID
        if ($googlePlaceId) {
            $park = Park::where('google_place_id', $googlePlaceId)->first();
            if ($park) return $park;
        }

        // 2. Match by name similarity + proximity (<1km = ~0.009 degrees)
        $candidates = Park::whereNotNull('latitude')
            ->whereNotNull('longitude')
            ->whereRaw('ABS(CAST(latitude AS DECIMAL(10,6)) - ?) < 0.01', [$lat])
            ->whereRaw('ABS(CAST(longitude AS DECIMAL(10,6)) - ?) < 0.01', [$lng])
            ->get();

        foreach ($candidates as $candidate) {
            $similarity = 0;
            similar_text(strtolower($name), strtolower($candidate->name), $similarity);
            if ($similarity >= 75) {
                return $candidate;
            }
        }

        // 3. Exact name match in same state
        // (less reliable but catches parks without coordinates)
        $exactName = Park::where('name', $name)->first();
        if ($exactName) return $exactName;

        return null;
    }

    private function enrichPark(Park $park, array $record, bool $downloadPhotos): bool
    {
        $updates = [];

        // Only fill empty fields
        $fieldMap = [
            'phone'         => ['phone'],
            'website_url'   => ['site', 'website'],
            'address'       => ['full_address', 'address'],
            'city'          => ['city'],
            'state'         => ['state', 'state_code'],
            'postal_code'   => ['postal_code'],
            'description'   => ['description', 'about'],
        ];

        foreach ($fieldMap as $ourField => $theirFields) {
            if (empty($park->{$ourField})) {
                foreach ($theirFields as $theirField) {
                    if (!empty($record[$theirField])) {
                        $updates[$ourField] = trim($record[$theirField]);
                        break;
                    }
                }
            }
        }

        // Always update Google data
        $googlePlaceId = $record['google_id'] ?? $record['place_id'] ?? null;
        if ($googlePlaceId) $updates['google_place_id'] = $googlePlaceId;

        $rating = floatval($record['rating'] ?? 0);
        if ($rating > 0) $updates['google_rating'] = $rating;

        $reviews = intval($record['reviews'] ?? $record['reviews_count'] ?? 0);
        if ($reviews > 0) $updates['google_review_count'] = $reviews;

        // Hours of operation
        $hours = $this->parseHours($record);
        if ($hours) $updates['hours_of_operation'] = $hours;

        $updates['last_enriched_at'] = now();

        $park->update($updates);

        // Photos
        if ($downloadPhotos) {
            $this->processPhotos($park, $record);
        }

        return count($updates) > 1; // >1 because last_enriched_at always set
    }

    private function createPark(array $record, bool $downloadPhotos): void
    {
        $name = trim($record['name'] ?? '');
        $slug = Str::slug($name);
        $state = $record['state'] ?? $record['state_code'] ?? '';
        $stateSlug = Str::slug($state);

        // Ensure unique slug
        $baseSlug = $slug;
        $counter = 1;
        while (Park::where('slug', $slug)->exists()) {
            $slug = "{$baseSlug}-{$counter}";
            $counter++;
        }

        $park = Park::create([
            'name'                => $name,
            'slug'                => $slug,
            'slug_path'           => $stateSlug ? "{$stateSlug}/{$slug}" : $slug,
            'address'             => $record['full_address'] ?? $record['address'] ?? null,
            'city'                => $record['city'] ?? null,
            'state'               => $state ?: null,
            'postal_code'         => $record['postal_code'] ?? null,
            'country'             => 'US',
            'latitude'            => $record['latitude'] ?? null,
            'longitude'           => $record['longitude'] ?? null,
            'phone'               => $record['phone'] ?? null,
            'website_url'         => $record['site'] ?? $record['website'] ?? null,
            'description'         => $record['description'] ?? $record['about'] ?? null,
            'google_place_id'     => $record['google_id'] ?? $record['place_id'] ?? null,
            'google_rating'       => floatval($record['rating'] ?? 0) ?: null,
            'google_review_count' => intval($record['reviews'] ?? 0) ?: null,
            'hours_of_operation'  => $this->parseHours($record),
            'data_source'         => 'outscraper',
            'park_type'           => $this->detectParkType($record),
            'status'              => 'active',
            'last_enriched_at'    => now(),
        ]);

        if ($downloadPhotos) {
            $this->processPhotos($park, $record);
        }
    }

    private function processPhotos(Park $park, array $record): void
    {
        // Outscraper returns photo URLs in 'photo' or 'photos' field
        $photoUrl = $record['photo'] ?? $record['main_photo'] ?? null;
        $photos = [];

        if (!empty($record['photos'])) {
            // Could be JSON string or already array
            $photos = is_string($record['photos'])
                ? json_decode($record['photos'], true) ?? []
                : (array)$record['photos'];
        }

        if ($photoUrl && !in_array($photoUrl, $photos)) {
            array_unshift($photos, $photoUrl);
        }

        // Take first 5
        $photos = array_slice(array_filter($photos), 0, 5);

        $hasPrimary = $park->park_photos()->where('is_primary', true)->exists();
        $sort = $park->park_photos()->max('sort_order') ?? 0;

        foreach ($photos as $i => $url) {
            if (!is_string($url) || !filter_var($url, FILTER_VALIDATE_URL)) continue;

            // Skip if we already have this URL
            if ($park->park_photos()->where('url', $url)->exists()) continue;

            $localPath = null;
            if ($this->option('download-photos')) {
                $localPath = $this->downloadPhoto($park->id, $url, $sort + $i + 1);
            }

            ParkPhoto::create([
                'park_id'    => $park->id,
                'url'        => $url,
                'local_path' => $localPath,
                'source'     => 'google',
                'is_primary' => !$hasPrimary && $i === 0,
                'sort_order' => $sort + $i + 1,
            ]);

            $this->photosDownloaded++;
            $hasPrimary = true;
        }
    }

    private function downloadPhoto(int $parkId, string $url, int $index): ?string
    {
        try {
            $response = Http::timeout(15)->get($url);
            if (!$response->successful()) return null;

            $ext = 'jpg';
            $contentType = $response->header('Content-Type');
            if (str_contains($contentType, 'png')) $ext = 'png';
            elseif (str_contains($contentType, 'webp')) $ext = 'webp';

            $path = "parks/{$parkId}/photo_{$index}.{$ext}";
            Storage::disk('public')->put($path, $response->body());

            return $path;
        } catch (\Exception $e) {
            return null;
        }
    }

    private function parseHours(array $record): ?array
    {
        // Outscraper has 'working_hours' as JSON or structured fields
        $hours = $record['working_hours'] ?? $record['hours'] ?? null;

        if (is_string($hours)) {
            $decoded = json_decode($hours, true);
            if ($decoded) return $decoded;
        }

        if (is_array($hours)) return $hours;

        // Try individual day fields
        $days = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'];
        $parsed = [];
        foreach ($days as $day) {
            $key = "working_hours_{$day}" ;
            if (!empty($record[$key])) {
                $parsed[$day] = $record[$key];
            }
        }

        return !empty($parsed) ? $parsed : null;
    }

    private function detectParkType(array $record): string
    {
        $subtypes = strtolower($record['subtypes'] ?? $record['type'] ?? '');
        $name = strtolower($record['name'] ?? '');

        if (str_contains($subtypes, 'state park') || str_contains($name, 'state park')) return 'state_park';
        if (str_contains($subtypes, 'national park') || str_contains($name, 'national park')) return 'federal_nps';
        if (str_contains($name, 'national forest')) return 'federal_forest';
        if (str_contains($name, 'corps of engineers') || str_contains($name, 'army corps')) return 'federal_corps';
        if (str_contains($name, 'blm') || str_contains($name, 'bureau of land')) return 'federal_blm';
        if (str_contains($subtypes, 'county') || str_contains($name, 'county park')) return 'county';

        return 'private';
    }

    private function recalculateQualityScores(): void
    {
        Park::where('status', 'active')->chunkById(500, function ($parks) {
            foreach ($parks as $park) {
                $score = 0;
                if (!empty($park->name)) $score += 10;
                if (!empty($park->address)) $score += 10;
                if (!empty($park->city) && !empty($park->state)) $score += 10;
                if (!empty($park->phone)) $score += 15;
                if (!empty($park->website_url)) $score += 15;
                if ($park->google_rating > 0) $score += 10;
                if ($park->park_photos()->exists()) $score += 15;
                if (!empty($park->description)) $score += 10;
                if (!empty($park->hours_of_operation)) $score += 5;

                $park->update(['quality_score' => $score]);
            }
        });
    }

    private function loadCsv(string $file): array
    {
        $records = [];
        $handle = fopen($file, 'r');
        $headers = fgetcsv($handle);

        // Clean BOM from first header
        if ($headers) {
            $headers[0] = preg_replace('/^\xEF\xBB\xBF/', '', $headers[0]);
        }

        while (($row = fgetcsv($handle)) !== false) {
            if (count($row) === count($headers)) {
                $records[] = array_combine($headers, $row);
            }
        }
        fclose($handle);

        return $records;
    }

    private function loadJson(string $file): array
    {
        $data = json_decode(file_get_contents($file), true);

        // Outscraper JSON may be nested
        if (isset($data[0]) && is_array($data[0]) && isset($data[0][0])) {
            return $data[0]; // Nested array format
        }

        return $data;
    }
}
