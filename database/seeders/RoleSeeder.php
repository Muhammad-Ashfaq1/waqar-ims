<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $roles = [
            UserRole::SuperAdmin->value,
            UserRole::InventoryManager->value,
            UserRole::Employee->value,
        ];

        foreach ($roles as $role) {
            Role::findOrCreate($role, 'web');
        }

        // Clean up obsolete role names if any
        Role::where('name', 'read_only')->where('guard_name', 'web')->delete();
    }
}
