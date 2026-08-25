<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('department_location', function (Blueprint $table) {
            $table->foreignId('location_id')->constrained()->cascadeOnDelete();
            // Legacy departments use a signed INT primary key.
            $table->integer('department_id');
            $table->foreign('department_id')->references('id')->on('departments')->cascadeOnDelete();
            $table->timestamps();
            $table->unique(['location_id', 'department_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('department_location');
    }
};
