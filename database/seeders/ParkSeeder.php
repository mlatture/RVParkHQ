<?php

namespace Database\Seeders;

use App\Models\Park;
use Illuminate\Database\Seeder;

class ParkSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Skip if parks already exist to avoid duplicate test data
        if (Park::count() > 0) {
            $this->command->info('Parks already exist, skipping ParkSeeder.');
            return;
        }

        Park::factory()->count(10)->create();
    }
}
