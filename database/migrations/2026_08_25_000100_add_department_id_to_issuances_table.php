<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasColumn('issuances', 'department_id')) {
            Schema::table('issuances', function (Blueprint $table) {
                // Match the legacy departments.id column type.
                $table->integer('department_id')->nullable()->after('location_id');
                $table->foreign('department_id')->references('id')->on('departments')->nullOnDelete();
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('issuances', 'department_id')) {
            Schema::table('issuances', function (Blueprint $table) {
                $table->dropForeign(['department_id']);
                $table->dropColumn('department_id');
            });
        }
    }
};
