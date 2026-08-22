<?php

namespace Database\Seeders;

use App\Enums\UserPermission;
use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        foreach (UserPermission::values() as $permission) {
            Permission::firstOrCreate([
                'name' => $permission,
                'guard_name' => 'web',
            ]);
        }

        $superAdmin = Role::firstOrCreate([
            'name' => UserRole::SuperAdmin->value,
            'guard_name' => 'web',
        ]);
        $superAdmin->syncPermissions(UserPermission::values());

        $inventoryManager = Role::firstOrCreate([
            'name' => UserRole::InventoryManager->value,
            'guard_name' => 'web',
        ]);
        $inventoryManager->syncPermissions([UserPermission::InventoryManage->value]);

        Role::firstOrCreate([
            'name' => UserRole::Employee->value,
            'guard_name' => 'web',
        ]);

        Role::where('name', 'read_only')->where('guard_name', 'web')->delete();

        if (Schema::hasColumn('users', 'role')) {
            User::query()->each(function (User $user) {
                $legacyRole = $user->getAttributes()['role'] ?? UserRole::SuperAdmin->value;
                if ($legacyRole === 'read_only') {
                    $legacyRole = UserRole::Employee->value;
                }

                if ($legacyRole && Role::where('name', $legacyRole)->where('guard_name', 'web')->exists()) {
                    $user->syncRoles([$legacyRole]);
                }
            });

            Schema::table('users', function ($table) {
                $table->dropColumn('role');
            });
        } else {
            User::query()->doesntHave('roles')->each(function (User $user) {
                $user->assignRole(UserRole::SuperAdmin->value);
            });
        }
    }
}
