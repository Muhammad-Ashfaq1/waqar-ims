<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

return new class extends Migration
{
    /**
     * Import locations from eworkshop LocationSeeder + existing IMS issuance options.
     * Data lives in a migration (not a seeder) as requested.
     */
    public function up(): void
    {
        $now = now();

        $rows = [
            // eworkshop workshops
            ['name' => 'Children Workshop', 'location_type' => 'workshop'],
            ['name' => 'Outfall Road Workshop South', 'location_type' => 'workshop'],
            ['name' => 'Outfall Road Workshop North', 'location_type' => 'workshop'],
            ['name' => 'Thokari Workshop', 'location_type' => 'workshop'],
            ['name' => 'Compost Plant Workshop', 'location_type' => 'workshop'],

            // eworkshop towns
            ['name' => 'Allama Iqbal Town', 'location_type' => 'town'],
            ['name' => 'Aziz Bhatti Town', 'location_type' => 'town'],
            ['name' => 'DGBT', 'location_type' => 'town'],
            ['name' => 'Gulberg Town', 'location_type' => 'town'],
            ['name' => 'Nishtar Town', 'location_type' => 'town'],
            ['name' => 'Ravi Town', 'location_type' => 'town'],
            ['name' => 'Ring Road', 'location_type' => 'town'],
            ['name' => 'Samanabad Town', 'location_type' => 'town'],
            ['name' => 'Shalimar Town', 'location_type' => 'town'],
            ['name' => 'Wahga Town', 'location_type' => 'town'],
            ['name' => 'Night Operations', 'location_type' => 'town'],
            ['name' => 'Compost Plant', 'location_type' => 'town'],
            ['name' => 'Lakhodair', 'location_type' => 'town'],
            ['name' => 'Rajgarh Centre', 'location_type' => 'town'],
            ['name' => 'RWMC', 'location_type' => 'town'],
            ['name' => 'Communication', 'location_type' => 'town'],
            ['name' => 'MBS Multan', 'location_type' => 'town'],
            ['name' => 'TR-Saggian', 'location_type' => 'town'],
            ['name' => 'TR-Valencia', 'location_type' => 'town'],
            ['name' => 'Pool Vehicle', 'location_type' => 'town'],
            ['name' => 'Pole Vehicle', 'location_type' => 'town'],

            // IMS existing issuance locations (office / workshop / yard)
            ['name' => 'Head Office', 'location_type' => 'office'],
            ['name' => 'Lakhodair Admin Block', 'location_type' => 'office'],
            ['name' => 'Lakhodair Weighbridge', 'location_type' => 'office'],
            ['name' => 'Children Hospital Workshop', 'location_type' => 'workshop'],
            ['name' => 'Thokar Workshop', 'location_type' => 'workshop'],
            ['name' => 'Vigilance Office', 'location_type' => 'office'],
            ['name' => 'Outfall Road Vigilance Office', 'location_type' => 'office'],
            ['name' => 'Southworkshop Fleet Office (Rizwan)', 'location_type' => 'office'],
            ['name' => 'Saggian Yard', 'location_type' => 'yard'],
            ['name' => 'Badami Bagh Yard', 'location_type' => 'yard'],
            ['name' => 'Mehmood Booti Yard', 'location_type' => 'yard'],
            ['name' => 'Salamatpura Yard', 'location_type' => 'yard'],
            ['name' => 'Jallo Mor Yard', 'location_type' => 'yard'],
            ['name' => 'Barki Yard', 'location_type' => 'yard'],
            ['name' => 'Bedian Yard', 'location_type' => 'yard'],
            ['name' => 'Sofiabad yard', 'location_type' => 'yard'],
            ['name' => 'Childern Workshop Yard', 'location_type' => 'yard'],
            ['name' => 'Thokar Yard', 'location_type' => 'yard'],
            ['name' => 'Thokar SBT Yard', 'location_type' => 'yard'],
            ['name' => 'Raiwind AIT Yard', 'location_type' => 'yard'],
            ['name' => 'Chunge Yard', 'location_type' => 'yard'],
        ];

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

            DB::table('locations')->insert([
                'name' => $name,
                'slug' => $slug,
                'location_type' => $row['location_type'],
                'is_active' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }
    }

    public function down(): void
    {
        // Keep imported rows; dropping the locations table handles cleanup.
    }
};
