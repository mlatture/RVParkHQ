<?php

namespace App\Console\Commands;

use App\Models\Park;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class CleanParkData extends Command
{
    protected $signature = 'parks:clean-data {--dry-run : Show what would be cleaned without making changes}';
    protected $description = 'Clean up junk park entries from OSM import';

    public function handle()
    {
        $dryRun = $this->option('dry-run');
        $deleted = 0;
        $flagged = 0;
        $shortNames = [];

        if ($dryRun) {
            $this->info('DRY RUN - no changes will be made');
        }

        $this->info('Scanning parks for cleanup...');
        $total = Park::count();
        $this->info("Total parks: {$total}");

        // 1. Delete: Name is 3 characters or fewer
        $short = Park::whereRaw('CHAR_LENGTH(name) <= 3')->get();
        foreach ($short as $park) {
            $this->line("  DELETE (short name): [{$park->id}] \"{$park->name}\" - {$park->city}, {$park->state}");
            if (!$dryRun) $park->delete();
            $deleted++;
        }

        // 2. Delete: Name is purely numeric
        $numeric = Park::whereRaw("name REGEXP '^[0-9]+$'")->get();
        foreach ($numeric as $park) {
            $this->line("  DELETE (numeric name): [{$park->id}] \"{$park->name}\"");
            if (!$dryRun) $park->delete();
            $deleted++;
        }

        // 3. Delete: No location data at all
        $noLocation = Park::whereNull('address')
            ->whereNull('city')
            ->whereNull('state')
            ->where(function ($q) {
                $q->whereNull('latitude')->orWhere('latitude', '');
            })
            ->where(function ($q) {
                $q->whereNull('longitude')->orWhere('longitude', '');
            })
            ->get();
        foreach ($noLocation as $park) {
            $this->line("  DELETE (no location): [{$park->id}] \"{$park->name}\"");
            if (!$dryRun) $park->delete();
            $deleted++;
        }

        // 4. Delete: Exact duplicates (same name + very close coordinates)
        $dupes = DB::select("
            SELECT p1.id, p1.name, p1.latitude, p1.longitude
            FROM parks p1
            INNER JOIN parks p2 ON p1.name = p2.name
                AND p1.id > p2.id
                AND ABS(CAST(p1.latitude AS DECIMAL(10,6)) - CAST(p2.latitude AS DECIMAL(10,6))) < 0.001
                AND ABS(CAST(p1.longitude AS DECIMAL(10,6)) - CAST(p2.longitude AS DECIMAL(10,6))) < 0.001
            WHERE p1.latitude IS NOT NULL AND p2.latitude IS NOT NULL
        ");
        foreach ($dupes as $dupe) {
            $this->line("  DELETE (duplicate): [{$dupe->id}] \"{$dupe->name}\" ({$dupe->latitude}, {$dupe->longitude})");
            if (!$dryRun) Park::where('id', $dupe->id)->delete();
            $deleted++;
        }

        // 5. Flag inactive: No address but has coordinates
        $noAddress = Park::where('status', 'active')
            ->whereNull('address')
            ->whereNotNull('latitude')
            ->where('latitude', '!=', '')
            ->get();
        foreach ($noAddress as $park) {
            if (!$dryRun) {
                $park->update(['status' => 'inactive']);
            }
            $flagged++;
        }
        if ($flagged > 0) {
            $this->line("  FLAGGED inactive (no address): {$flagged} parks");
        }

        // 6. Flag: Generic names only
        $genericPatterns = ['Campsite', 'Parking', 'Rest Area', 'Picnic Area', 'Trailhead', 'Boat Launch', 'Boat Ramp'];
        $genericFlagged = 0;
        foreach ($genericPatterns as $pattern) {
            $generic = Park::where('status', 'active')
                ->where('name', $pattern)
                ->get();
            foreach ($generic as $park) {
                if (!$dryRun) $park->update(['status' => 'inactive']);
                $genericFlagged++;
            }
        }
        if ($genericFlagged > 0) {
            $this->line("  FLAGGED inactive (generic name): {$genericFlagged} parks");
            $flagged += $genericFlagged;
        }

        // 7. Report: Suspiciously short names (4-6 chars) for manual review
        $suspicious = Park::where('status', 'active')
            ->whereRaw('CHAR_LENGTH(name) BETWEEN 4 AND 6')
            ->orderBy('name')
            ->limit(50)
            ->get(['id', 'name', 'city', 'state']);
        if ($suspicious->count() > 0) {
            $this->warn("\nShort names (4-6 chars) for manual review:");
            foreach ($suspicious as $park) {
                $this->line("  [{$park->id}] \"{$park->name}\" - {$park->city}, {$park->state}");
            }
        }

        // 8. Report: Parks with no state
        $noState = Park::where('status', 'active')->whereNull('state')->count();

        // Summary
        $remaining = $dryRun ? ($total - $deleted) : Park::where('status', 'active')->count();
        $this->newLine();
        $this->info('=== Cleanup Summary ===');
        $this->info("Deleted: {$deleted}");
        $this->info("Flagged inactive: {$flagged}");
        $this->info("No state assigned: {$noState}");
        $this->info("Active parks remaining: {$remaining}");

        if ($dryRun) {
            $this->warn('Run without --dry-run to apply changes');
        }

        return 0;
    }
}
