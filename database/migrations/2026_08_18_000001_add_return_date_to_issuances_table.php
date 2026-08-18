<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('issuances')) {
            return;
        }

        if (! Schema::hasColumn('issuances', 'return_date')) {
            Schema::table('issuances', function (Blueprint $table) {
                $table->date('return_date')->nullable()->after('issuance_date');
            });
        }

        $stockIds = DB::table('issuances')->distinct()->pluck('stock_id');

        foreach ($stockIds as $stockId) {
            $stock = DB::table('stocks')->where('id', $stockId)->first();
            $issuances = DB::table('issuances')
                ->where('stock_id', $stockId)
                ->orderBy('id')
                ->get();

            $keepOpenId = null;
            if ($stock && $stock->status === 'Issued') {
                $keepOpenId = $issuances->last()?->id;
            }

            foreach ($issuances as $issuance) {
                if ($issuance->id === $keepOpenId || $issuance->return_date) {
                    continue;
                }

                DB::table('issuances')->where('id', $issuance->id)->update([
                    'return_date' => $issuance->updated_at ?: $issuance->issuance_date,
                ]);
            }
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('issuances') && Schema::hasColumn('issuances', 'return_date')) {
            Schema::table('issuances', function (Blueprint $table) {
                $table->dropColumn('return_date');
            });
        }
    }
};
