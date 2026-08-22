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

        foreach ($legacy as $name) {
            $name = trim((string) $name);
            if ($name === '') {
                continue;
            }

            $location = DB::table('locations')->where('name', $name)->first();
            if (! $location) {
                $slug = Str::slug($name);
                $baseSlug = $slug;
                $i = 1;
                while (DB::table('locations')->where('slug', $slug)->exists()) {
                    $slug = $baseSlug.'-'.$i++;
                }

                $id = DB::table('locations')->insertGetId([
                    'name' => $name,
                    'slug' => $slug,
                    'location_type' => 'office',
                    'is_active' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            } else {
                $id = $location->id;
            }

            DB::table('issuances')->where('location', $name)->update(['location_id' => $id]);
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
