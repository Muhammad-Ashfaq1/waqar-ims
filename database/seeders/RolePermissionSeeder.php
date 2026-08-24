<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // 1. Super Admin gets all permissions
        Role::findByName(UserRole::SuperAdmin->value, 'web')->syncPermissions(
            Permission::query()->where('guard_name', 'web')->get()
        );

        // 2. Inventory Manager gets inventory management & read permissions
        Role::findByName(UserRole::InventoryManager->value, 'web')->syncPermissions([
            Permission::findByName('dashboard.view', 'web'),
            Permission::findByName('base-data.view', 'web'),
            Permission::findByName('inventory.view', 'web'),
            Permission::findByName('inventory.manage', 'web'),
        ]);

        // 3. Read Only User (Employee) gets view-only permissions
        Role::findByName(UserRole::Employee->value, 'web')->syncPermissions([
            Permission::findByName('dashboard.view', 'web'),
            Permission::findByName('base-data.view', 'web'),
            Permission::findByName('inventory.view', 'web'),
        ]);
    }
}
