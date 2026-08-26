<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('locations') && Schema::hasColumn('locations', 'location_type')) {
            Schema::table('locations', function (Blueprint $table) {
                $table->dropColumn('location_type');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('locations') && ! Schema::hasColumn('locations', 'location_type')) {
            Schema::table('locations', function (Blueprint $table) {
                $table->string('location_type')->nullable()->after('slug');
            });
        }
    }
};
