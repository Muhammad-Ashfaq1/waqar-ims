<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call(RolesAndPermissionsSeeder::class);

        $admin = User::query()->firstOrCreate(
            ['email' => 'admin@ims.lwmc.com'],
            [
                'name' => 'Admin',
                'password' => 'password',
                'is_active' => true,
            ]
        );

        if ($admin->roles()->count() === 0) {
            $admin->assignRole(\App\Enums\UserRole::SuperAdmin->value);
        }
    }
}
