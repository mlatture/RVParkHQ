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
        Park::factory()->count(10)->create();
    }
}
