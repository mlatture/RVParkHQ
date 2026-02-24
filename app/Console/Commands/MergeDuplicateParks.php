<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use App\Models\Park;

class MergeDuplicateParks extends Command
{
    protected $signature = 'parks:merge-duplicates {--dry-run : Show what would be merged without making changes}';
    protected $description = 'Merge duplicate parks (same name, state, within ~2km) keeping the richest record';

    public function handle()
    {
        $dryRun = $this->option('dry-run');

        // Find clusters: same normalized name + state + within 0.02 degrees (~2km)
        $groups = DB::select("
            SELECT LOWER(TRIM(name)) as norm_name, state, COUNT(*) as cnt,
                   GROUP_CONCAT(id ORDER BY id) as ids
            FROM parks
            WHERE name IS NOT NULL
            GROUP BY norm_name, state
            HAVING cnt > 1
            AND (MAX(latitude) - MIN(latitude)) < 0.02
            AND (MAX(longitude) - MIN(longitude)) < 0.02
            ORDER BY cnt DESC
        ");

        $this->info("Found " . count($groups) . " duplicate clusters");

        $merged = 0;
        $deleted = 0;

        foreach ($groups as $group) {
            $ids = array_map('intval', explode(',', $group->ids));
            $parks = Park::whereIn('id', $ids)->get();

            if ($parks->count() < 2) continue;

            // Score each park by data richness
            $scored = $parks->map(function ($park) {
                $score = 0;
                if ($park->phone) $score += 10;
                if ($park->email) $score += 10;
                if ($park->website_url) $score += 10;
                if ($park->google_place_id) $score += 15;
                if ($park->google_rating) $score += 10;
                if ($park->google_review_count) $score += 5;
                if ($park->description) $score += 5;
                if ($park->address) $score += 5;
                if ($park->city) $score += 5;
                if ($park->postal_code) $score += 3;
                if ($park->hours_of_operation) $score += 3;
                if ($park->main_image_url) $score += 5;
                if ($park->data_source === 'outscraper') $score += 5; // Outscraper data is generally richer
                return ['park' => $park, 'score' => $score];
            })->sortByDesc('score');

            $keeper = $scored->first()['park'];
            $duplicates = $scored->slice(1)->pluck('park');

            // Merge: fill in any null fields on keeper from duplicates
            $fillableFields = [
                'phone', 'email', 'website_url', 'google_place_id', 'google_rating',
                'google_review_count', 'description', 'short_description', 'address',
                'city', 'postal_code', 'hours_of_operation', 'main_image_url',
                'quality_score', 'last_enriched_at',
            ];

            $enriched = [];
            foreach ($duplicates as $dupe) {
                foreach ($fillableFields as $field) {
                    if (empty($keeper->$field) && !empty($dupe->$field)) {
                        $keeper->$field = $dupe->$field;
                        $enriched[] = $field;
                    }
                }

                // Merge photos if park_photos table exists
                try {
                    DB::table('park_photos')
                        ->where('park_id', $dupe->id)
                        ->update(['park_id' => $keeper->id]);
                } catch (\Throwable $e) {
                    // park_photos table may not exist
                }

                // Merge amenities
                try {
                    $keeperAmenities = DB::table('amenity_park')->where('park_id', $keeper->id)->pluck('amenity_id')->toArray();
                    $dupeAmenities = DB::table('amenity_park')->where('park_id', $dupe->id)->pluck('amenity_id')->toArray();
                    $newAmenities = array_diff($dupeAmenities, $keeperAmenities);
                    foreach ($newAmenities as $amenityId) {
                        DB::table('amenity_park')->insert(['park_id' => $keeper->id, 'amenity_id' => $amenityId]);
                    }
                    DB::table('amenity_park')->where('park_id', $dupe->id)->delete();
                } catch (\Throwable $e) {
                    // amenity_park may not exist
                }
            }

            if ($dryRun) {
                $this->line("  KEEP #{$keeper->id} ({$keeper->name}, {$keeper->state}) score={$scored->first()['score']}");
                $this->line("  DELETE " . $duplicates->pluck('id')->implode(', '));
                if (!empty($enriched)) {
                    $this->line("  ENRICH: " . implode(', ', array_unique($enriched)));
                }
            } else {
                $keeper->save();

                foreach ($duplicates as $dupe) {
                    // Move reviews
                    try {
                        DB::table('reviews')->where('park_id', $dupe->id)->update(['park_id' => $keeper->id]);
                    } catch (\Throwable $e) {}

                    $dupe->delete();
                    $deleted++;
                }
            }

            $merged++;
        }

        $action = $dryRun ? 'Would merge' : 'Merged';
        $this->info("{$action} {$merged} clusters, {$deleted} records removed");

        return 0;
    }
}
