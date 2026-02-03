<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class SuperAdminSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::updateOrCreate(
            ['email' => 'mark@latture.com'],
            [
                'name' => 'Mark Latture',
                'username' => 'marklatture',
                'type' => 'admin',
                'password' => Hash::make('47Wilson!'),
            ]
        );

        $user->assignRole('superadmin');

        $this->command->info('Super admin user created: mark@latture.com');
    }
}
