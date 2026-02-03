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
        User::updateOrCreate(
            ['email' => 'mark@rvparkhq.com'],
            [
                'name' => 'Super Admin',
                'username' => 'superadmin',
                'type' => 'admin',
                'password' => Hash::make('12345678'),
            ]
        );

        User::updateOrCreate(
            ['email' => 'owner@example.com'],
            [
                'name' => 'Owner',
                'username' => 'Owner',
                'type' => 'owner',
                'password' => Hash::make('12345678'),
            ]
        );

        User::updateOrCreate(
            ['email' => 'camper@example.com'],
            [
                'name' => 'Camper',
                'username' => 'Camper',
                'type' => 'camper',
                'password' => Hash::make('12345678'),
            ]
        );
    }
}
