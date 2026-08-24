<?php

namespace App\Console\Commands;

use App\Enums\UserRole;
use Database\Seeders\DatabaseSeeder;
use Database\Seeders\PermissionSeeder;
use Database\Seeders\RolePermissionSeeder;
use Database\Seeders\RoleSeeder;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

#[Signature('app:sync-permissions {--seed-users : Also seed and update default role user accounts}')]
#[Description('Synchronize roles, permissions, and role-permission matrices')]
class SyncPermissions extends Command
{
    public function handle(): int
    {
        $this->components->info('Starting permissions synchronization...');

        // 1. Clear cached permissions
        app(PermissionRegistrar::class)->forgetCachedPermissions();

        // 2. Run Seeders
        $this->components->task('Seeding permissions', function () {
            app(PermissionSeeder::class)->run();
        });

        $this->components->task('Seeding roles', function () {
            app(RoleSeeder::class)->run();
        });

        $this->components->task('Syncing permissions to roles', function () {
            app(RolePermissionSeeder::class)->run();
        });

        if ($this->option('seed-users')) {
            $this->components->task('Syncing default role users', function () {
                app(DatabaseSeeder::class)->run();
            });
        }

        // 3. Clear cache again to guarantee live state
        app(PermissionRegistrar::class)->forgetCachedPermissions();

        // 4. Output Summary Table
        $this->newLine();
        $this->components->info('Synchronized Role & Permission Matrix:');

        $rows = [];
        $roles = Role::query()->where('guard_name', 'web')->with('permissions')->get();

        foreach ($roles as $role) {
            $permissionNames = $role->permissions->pluck('name')->implode(', ');
            $rows[] = [
                'Role' => $role->name,
                'Label' => UserRole::labelFor($role->name),
                'Permissions Count' => $role->permissions->count(),
                'Permissions' => $permissionNames ?: '— (View only)',
            ];
        }

        $this->table(['Role', 'Label', 'Permissions Count', 'Assigned Permissions'], $rows);

        $this->newLine();
        $this->components->info('All roles and permissions synchronized successfully.');

        return self::SUCCESS;
    }
}
