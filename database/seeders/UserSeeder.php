<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        User::insert([
            [
                'name' => 'Super Admin',
                'email' => 'superadmin@example.com',
                'username' => 'superadmin',
                'type' => 'admin',
                'password' => Hash::make('12345678'),
            ],
            [
                'name' => 'Owner',
                'email' => 'owner@example.com',
                'username' => 'Owner',
                'type' => 'owner',
                'password' => Hash::make('12345678'),
            ],
            [
                'name' => 'Camper',
                'email' => 'camper@example.com',
                'username' => 'Camper',
                'type' => 'camper',
                'password' => Hash::make('12345678'),
            ],
        ]);

        // Run factory to create additional users with unique details.
        //User::factory()->count(500)->create();
        //$this->command->info('Users table seeded with 502 users!');
    }
}
