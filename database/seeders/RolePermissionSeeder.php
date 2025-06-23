<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\User;
use App\Services\PermissionService;
use App\Services\RolesService;
use Illuminate\Database\Seeder;

class RolePermissionSeeder extends Seeder
{
    public function __construct(
        private readonly PermissionService $permissionService,
        private readonly RolesService $rolesService
    ) {
    }

    public function run()
    {
        $this->command->info('Creating permissions...');
        $this->permissionService->createPermissions();

        $this->command->info('Creating predefined roles...');
        $roles = $this->rolesService->createPredefinedRoles();

        // Assign Superadmin role
        $superadmin = User::where('username', 'superadmin')->first();
        if ($superadmin) {
            $superadmin->assignRole($roles['superadmin']);
        }

        // Assign Owner role
        $owner = User::where('username', 'owner')->first();
        if ($owner) {
            $owner->assignRole($roles['owner']);
        }

        // Assign Camper role
        $camper = User::where('username', 'camper')->first();
        if ($camper) {
            $camper->assignRole($roles['camper']);
        }

        $this->command->info('Roles assigned successfully!');
    }
}
