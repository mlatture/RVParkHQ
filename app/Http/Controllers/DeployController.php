<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;
use Symfony\Component\Process\Process;

class DeployController extends Controller
{
    public function run(Request $request)
    {
        // Verify deploy key
        $key = $request->query('key');
        $validKey = config('app.deploy_key');

        if (!$validKey || $key !== $validKey) {
            abort(403, 'Unauthorized');
        }

        Log::info('Deploy triggered', ['ip' => $request->ip()]);

        $output = [];
        $basePath = base_path();

        // 1. Git fetch and reset
        $commands = [
            ['git', 'fetch', 'origin', 'main'],
            ['git', 'reset', '--hard', 'origin/main'],
        ];

        foreach ($commands as $cmd) {
            $process = new Process($cmd, $basePath);
            $process->setTimeout(120);
            $process->run();
            $output[] = '$ ' . implode(' ', $cmd);
            $output[] = $process->getOutput();
            if ($process->getErrorOutput()) {
                $output[] = $process->getErrorOutput();
            }
        }

        // 2. Composer install (try composer2 first for Hostinger, fall back to composer)
        $composerCmd = null;
        foreach (['composer2', 'composer'] as $bin) {
            $which = new Process(['which', $bin]);
            $which->run();
            if ($which->isSuccessful()) {
                $composerCmd = trim($which->getOutput());
                break;
            }
        }

        if ($composerCmd) {
            $process = new Process([$composerCmd, 'install', '--no-dev', '--optimize-autoloader', '--no-interaction'], $basePath);
            $process->setTimeout(300);
            $process->run();
            $output[] = '$ composer install --no-dev --optimize-autoloader';
            $output[] = $process->getOutput();
            if ($process->getErrorOutput()) {
                $output[] = $process->getErrorOutput();
            }
        } else {
            $output[] = 'WARNING: composer not found, skipping install';
        }

        // 3. Run migrations
        try {
            Artisan::call('migrate', ['--force' => true]);
            $output[] = '$ php artisan migrate --force';
            $output[] = Artisan::output();
        } catch (\Exception $e) {
            $output[] = 'Migration error: ' . $e->getMessage();
        }

        // 4. Clear and rebuild caches
        $artisanCmds = [
            'config:cache',
            'route:cache',
            'view:cache',
        ];

        foreach ($artisanCmds as $cmd) {
            try {
                Artisan::call($cmd);
                $output[] = "$ php artisan {$cmd}";
                $output[] = Artisan::output();
            } catch (\Exception $e) {
                $output[] = "{$cmd} error: " . $e->getMessage();
            }
        }

        // 5. Show current git commit
        $process = new Process(['git', 'log', '--oneline', '-1'], $basePath);
        $process->run();
        $output[] = '$ git log --oneline -1';
        $output[] = $process->getOutput();

        Log::info('Deploy complete');

        // Return plain text output
        return response(
            "=== DEPLOY COMPLETE ===\n" .
            "Time: " . now()->toDateTimeString() . "\n\n" .
            implode("\n", $output),
            200,
            ['Content-Type' => 'text/plain']
        );
    }

    /**
     * Run an artisan command via web request.
     * Usage: /run?key=DEPLOY_KEY&cmd=parks:import-osm&--state=florida
     */
    public function runCommand(Request $request)
    {
        $key = $request->query('key');
        $validKey = config('app.deploy_key');

        if (!$validKey || $key !== $validKey) {
            abort(403, 'Unauthorized');
        }

        $cmd = $request->query('cmd');
        if (!$cmd) {
            return response("Missing 'cmd' parameter.\n\nAvailable commands:\n" .
                "  parks:import-osm     - Import parks from OpenStreetMap\n" .
                "  parks:heartbeat      - Check/update park status\n" .
                "  parks:clean          - Clean junk OSM data\n" .
                "  migrate              - Run migrations\n",
                400, ['Content-Type' => 'text/plain']);
        }

        // Allowlist of safe commands
        $allowed = ['parks:import-osm', 'parks:heartbeat', 'parks:clean',
                     'migrate', 'config:cache', 'route:cache', 'view:cache',
                     'cache:clear', 'config:clear', 'route:clear', 'view:clear'];

        $baseCmd = explode(' ', $cmd)[0];
        if (!in_array($baseCmd, $allowed)) {
            return response("Command not allowed: {$baseCmd}", 403, ['Content-Type' => 'text/plain']);
        }

        // Parse extra parameters from query string
        $params = [];
        foreach ($request->query() as $k => $v) {
            if (in_array($k, ['key', 'cmd'])) continue;
            if (str_starts_with($k, '--')) {
                $params[$k] = $v === '' ? true : $v;
            }
        }

        Log::info("Run command: {$cmd}", ['params' => $params, 'ip' => $request->ip()]);

        set_time_limit(600); // OSM imports can take a while

        try {
            Artisan::call($cmd, array_merge($params, ['--no-interaction' => true]));
            $output = Artisan::output();
        } catch (\Exception $e) {
            $output = "Error: " . $e->getMessage();
        }

        return response(
            "=== RUN: {$cmd} ===\n" .
            "Time: " . now()->toDateTimeString() . "\n\n" .
            $output,
            200,
            ['Content-Type' => 'text/plain']
        );
    }
}
