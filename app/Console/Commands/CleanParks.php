<?php

namespace App\Console\Commands;

use App\Models\Park;
use Illuminate\Console\Command;

class CleanParks extends Command
{
    protected $signature = 'parks:clean {--dry-run}';
    protected $description = 'Remove junk/invalid park entries from the database';

    public function handle()
    {
        $dryRun = $this->option('dry-run');
        $deleted = 0;

        $parks = Park::where('data_source', 'osm')->get();

        foreach ($parks as $park) {
            $name = trim($park->name);
            $shouldDelete = false;
            $reason = '';

            if (strlen($name) < 3) {
                $shouldDelete = true;
                $reason = 'name too short';
            } elseif (is_numeric($name)) {
                $shouldDelete = true;
                $reason = 'numeric name';
            } elseif (preg_match('/^[^a-zA-Z]*$/', $name)) {
                $shouldDelete = true;
                $reason = 'no letters in name';
            } elseif (preg_match('/^(site|lot|spot|space|pad)\s*\d*$/i', $name)) {
                $shouldDelete = true;
                $reason = 'generic site name';
            }

            if ($shouldDelete) {
                $this->line("  Removing: \"{$name}\" ({$reason})");
                if (!$dryRun) {
                    $park->amenities()->detach();
                    $park->delete();
                }
                $deleted++;
            }
        }

        $this->info("Done! Removed {$deleted} junk entries" . ($dryRun ? ' (DRY RUN)' : ''));
    }
}
