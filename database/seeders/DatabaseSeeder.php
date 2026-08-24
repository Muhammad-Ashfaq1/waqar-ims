<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call(RolesAndPermissionsSeeder::class);

        $users = [
            [
                'email' => 'admin@ims.lwmc.com',
                'name' => 'Admin',
                'first_name' => 'Admin',
                'last_name' => null,
                'role' => UserRole::SuperAdmin->value,
            ],
            [
                'email' => 'inventory@ims.lwmc.com',
                'name' => 'Inventory Manager',
                'first_name' => 'Inventory',
                'last_name' => 'Manager',
                'role' => UserRole::InventoryManager->value,
            ],
            [
                'email' => 'employee@ims.lwmc.com',
                'name' => 'Employee User',
                'first_name' => 'Employee',
                'last_name' => 'User',
                'role' => UserRole::Employee->value,
            ],
        ];

        foreach ($users as $data) {
            $user = User::query()->firstOrCreate(
                ['email' => $data['email']],
                [
                    'name' => $data['name'],
                    'first_name' => $data['first_name'],
                    'last_name' => $data['last_name'],
                    'password' => 'password',
                    'is_active' => true,
                ]
            );

            $user->syncRoles([$data['role']]);
        }
    }
}
