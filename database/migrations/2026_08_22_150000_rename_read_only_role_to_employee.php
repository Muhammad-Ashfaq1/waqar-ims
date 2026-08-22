<?php

use App\Enums\UserRole;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('roles')
            ->where('name', 'read_only')
            ->where('guard_name', 'web')
            ->update(['name' => UserRole::Employee->value]);
    }

    public function down(): void
    {
        DB::table('roles')
            ->where('name', UserRole::Employee->value)
            ->where('guard_name', 'web')
            ->update(['name' => 'read_only']);
    }
};
