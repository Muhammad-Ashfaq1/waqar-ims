<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasColumn('issuances', 'assignment_type')) {
            Schema::table('issuances', function (Blueprint $table) {
                $table->string('assignment_type', 20)->nullable()->after('employee_id');
            });
        }

        Schema::table('issuances', function (Blueprint $table) {
            $table->unsignedBigInteger('employee_id')->nullable()->change();
        });

        DB::table('issuances')->whereNull('assignment_type')->update([
            'assignment_type' => 'employee',
        ]);
    }

    public function down(): void
    {
        if (Schema::hasColumn('issuances', 'assignment_type')) {
            Schema::table('issuances', function (Blueprint $table) {
                $table->dropColumn('assignment_type');
            });
        }
    }
};
