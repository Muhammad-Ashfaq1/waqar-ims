<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("SET SESSION sql_mode = ''");
        DB::statement("UPDATE issuances SET updated_at = IF(created_at IS NULL OR created_at = '0000-00-00', CURDATE(), created_at) WHERE updated_at IS NULL OR updated_at = '0000-00-00'");
        DB::statement("UPDATE issuances SET created_at = CURDATE() WHERE created_at IS NULL OR created_at = '0000-00-00'");

        if (! Schema::hasColumn('issuances', 'location_id')) {
            Schema::table('issuances', function (Blueprint $table) {
                $table->unsignedBigInteger('location_id')->nullable()->after('location');
            });
        }

        $fkExists = collect(DB::select("
            SELECT CONSTRAINT_NAME
            FROM information_schema.TABLE_CONSTRAINTS
            WHERE TABLE_SCHEMA = DATABASE()
              AND TABLE_NAME = 'issuances'
              AND CONSTRAINT_NAME = 'issuances_location_id_foreign'
              AND CONSTRAINT_TYPE = 'FOREIGN KEY'
        "))->isNotEmpty();

        if (! $fkExists) {
            Schema::table('issuances', function (Blueprint $table) {
                $table->foreign('location_id')->references('id')->on('locations')->nullOnDelete();
            });
        }

        $legacy = DB::table('issuances')
            ->whereNotNull('location')
            ->where('location', '!=', '')
            ->whereNull('location_id')
            ->distinct()
            ->pluck('location');

        foreach ($legacy as $rawName) {
            $name = trim(preg_replace('/\s+/u', ' ', (string) $rawName) ?: '');
            if ($name === '') {
                continue;
            }

            // Only link to existing eworkshop locations — never create IMS office/yard rows.
            $location = DB::table('locations')
                ->whereRaw('LOWER(TRIM(name)) = ?', [Str::lower($name)])
                ->first();

            if (! $location) {
                continue;
            }

            DB::table('issuances')
                ->whereRaw('LOWER(TRIM(location)) = ?', [Str::lower($name)])
                ->whereNull('location_id')
                ->update(['location_id' => $location->id]);
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('issuances', 'location_id')) {
            Schema::table('issuances', function (Blueprint $table) {
                $table->dropForeign(['location_id']);
                $table->dropColumn('location_id');
            });
        }
    }
};
