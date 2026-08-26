<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

return new class extends Migration
{
    /**
     * Import locations from live eworkshop (town + workshop only).
     * Data lives in a migration (not a seeder) as requested.
     */
    public function up(): void
    {
        if (DB::getDriverName() === 'mysql' && Schema::hasColumn('locations', 'location_type')) {
            DB::statement("ALTER TABLE locations MODIFY location_type ENUM('town', 'workshop') NOT NULL DEFAULT 'town'");
        }

        $now = now();

        $rows = [
            ['name' => 'Children Workshop'],
            ['name' => 'Outfall Road Workshop South'],
            ['name' => 'Outfall Road Workshop North'],
            ['name' => 'Thokari Workshop'],

            ['name' => 'Allama Iqbal Town'],
            ['name' => 'Aziz Bhatti Town'],
            ['name' => 'DGBT'],
            ['name' => 'Gulberg Town'],
            ['name' => 'Nishtar Town'],
            ['name' => 'Nishter Town'],
            ['name' => 'North Workshop'],
            ['name' => 'Ravi Town'],
            ['name' => 'Ring Road'],
            ['name' => 'Samanabad Town'],
            ['name' => 'Shalimar Town'],
            ['name' => 'Wahga Town'],
            ['name' => 'Night Operations'],
            ['name' => 'Compost Plant'],
            ['name' => 'Lakhodair'],
            ['name' => 'Rajgarh Centre'],
            ['name' => 'RWMC'],
            ['name' => 'Communication'],
            ['name' => 'MBS Multan'],
            ['name' => 'TR-Saggian'],
            ['name' => 'TR-Valencia'],
            ['name' => 'Pool Vehicle'],
            ['name' => 'Pole Vehicle'],
        ];

        $hasLocationType = Schema::hasColumn('locations', 'location_type');
        $seen = [];
        foreach ($rows as $row) {
            $name = trim($row['name']);
            $key = Str::lower($name);
            if ($name === '' || isset($seen[$key])) {
                continue;
            }
            $seen[$key] = true;

            $slug = Str::slug($name);
            $exists = DB::table('locations')->where('name', $name)->orWhere('slug', $slug)->exists();
            if ($exists) {
                continue;
            }

            $insertData = [
                'name' => $name,
                'slug' => $slug,
                'is_active' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ];

            if ($hasLocationType) {
                $insertData['location_type'] = 'town';
            }

            DB::table('locations')->insert($insertData);
        }
    }

    public function down(): void
    {
        DB::table('locations')->delete();
    }
};
