<?php

namespace App\Console\Commands;

use App\Models\Park;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class ParkHeartbeat extends Command
{
    protected $signature = 'parks:heartbeat {--limit=200} {--type=} {--state=}';
    protected $description = 'Verify park websites are still alive and mark dead ones as inactive';

    public function handle(): int
    {
        $query = Park::orderByRaw('last_verified_at IS NULL DESC, last_verified_at ASC');

        if ($type = $this->option('type')) {
            $query->where('park_type', $type);
        }
        if ($state = $this->option('state')) {
            $query->where('state', ucwords(str_replace(['-', '_'], ' ', $state)));
        }

        $parks = $query->limit((int) $this->option('limit'))->get();

        $alive = 0;
        $dead = 0;
        $noWebsite = 0;
        $checked = $parks->count();

        $bar = $this->output->createProgressBar($checked);

        foreach ($parks as $park) {
            if (empty($park->website_url)) {
                $park->update(['last_verified_at' => now()]);
                $noWebsite++;
                $bar->advance();
                continue;
            }

            $isAlive = $this->checkUrl($park->website_url);

            // Harvest Host: also check listing page pattern
            if ($isAlive && $park->park_type === 'harvest_host') {
                // If the URL redirects to a generic page, consider it dead
                // This is a basic check; refine as needed
            }

            if ($isAlive) {
                $alive++;
            } else {
                $dead++;
                $park->update(['status' => 'inactive']);
                $this->warn("\n  Dead: {$park->name} ({$park->website_url})");
            }

            $park->update(['last_verified_at' => now()]);
            $bar->advance();
        }

        $bar->finish();
        $this->newLine(2);
        $this->info("{$checked} parks checked, {$alive} alive, {$dead} dead, {$noWebsite} no website");

        return 0;
    }

    protected function checkUrl(string $url): bool
    {
        $retries = 2;

        for ($i = 0; $i <= $retries; $i++) {
            try {
                $response = Http::timeout(10)
                    ->withOptions(['allow_redirects' => ['max' => 5]])
                    ->head($url);

                if (in_array($response->status(), [200, 301, 302, 303, 307, 308])) {
                    return true;
                }
            } catch (\Exception $e) {
                // Timeout or connection error
            }

            if ($i < $retries) {
                usleep(500000); // 0.5s between retries
            }
        }

        return false;
    }
}
