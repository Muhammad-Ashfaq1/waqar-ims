<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (DB::getDriverName() === 'mysql') {
            DB::statement("SET SESSION sql_mode = ''");
            DB::statement("UPDATE stocks SET updated_at = IF(created_at IS NULL OR created_at = '0000-00-00', CURDATE(), created_at) WHERE updated_at IS NULL OR updated_at = '0000-00-00'");
            DB::statement("UPDATE stocks SET created_at = CURDATE() WHERE created_at IS NULL OR created_at = '0000-00-00'");
        }

        if (! Schema::hasColumn('stocks', 'location_id')) {
            Schema::table('stocks', function (Blueprint $table) {
                $table->unsignedBigInteger('location_id')->nullable()->after('status');
            });
        }

        $fkExists = false;
        if (DB::getDriverName() === 'mysql') {
            $fkExists = collect(DB::select("
                SELECT CONSTRAINT_NAME
                FROM information_schema.TABLE_CONSTRAINTS
                WHERE TABLE_SCHEMA = DATABASE()
                  AND TABLE_NAME = 'stocks'
                  AND CONSTRAINT_NAME = 'stocks_location_id_foreign'
                  AND CONSTRAINT_TYPE = 'FOREIGN KEY'
            "))->isNotEmpty();
        }

        if (! $fkExists) {
            Schema::table('stocks', function (Blueprint $table) {
                $table->foreign('location_id')->references('id')->on('locations')->nullOnDelete();
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('stocks', 'location_id')) {
            Schema::table('stocks', function (Blueprint $table) {
                $table->dropForeign(['location_id']);
                $table->dropColumn('location_id');
            });
        }
    }
};
