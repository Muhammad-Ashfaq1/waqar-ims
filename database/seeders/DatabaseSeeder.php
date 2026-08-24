<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            PermissionSeeder::class,
            RoleSeeder::class,
            RolePermissionSeeder::class,
        ]);

        $users = [
            [
                'email' => 'admin@ims.lwmc.com',
                'name' => 'Super Admin',
                'first_name' => 'Super',
                'last_name' => 'Admin',
                'role' => UserRole::SuperAdmin->value,
                'password' => 'SuperAdmin@2026$!',
            ],
            [
                'email' => 'inventory@ims.lwmc.com',
                'name' => 'Inventory Manager',
                'first_name' => 'Inventory',
                'last_name' => 'Manager',
                'role' => UserRole::InventoryManager->value,
                'password' => 'Inv#Mgr9824$Kz!',
            ],
            [
                'email' => 'employee@ims.lwmc.com',
                'name' => 'Read Only User',
                'first_name' => 'Read',
                'last_name' => 'Only',
                'role' => UserRole::Employee->value,
                'password' => 'ReadOnly!8391#Tv&',
            ],
        ];

        foreach ($users as $data) {
            $user = User::query()->updateOrCreate(
                ['email' => $data['email']],
                [
                    'name' => $data['name'],
                    'first_name' => $data['first_name'],
                    'last_name' => $data['last_name'],
                    'password' => $data['password'],
                    'is_active' => true,
                ]
            );

            $user->syncRoles([$data['role']]);
        }
    }
}
