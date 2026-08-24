<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('departments')) {
            Schema::create('departments', function (Blueprint $table) {
                $table->id();
                $table->string('dep_name');
                $table->timestamps();
            });
        }

        if (! Schema::hasTable('assets')) {
            Schema::create('assets', function (Blueprint $table) {
                $table->id();
                $table->string('type');
                $table->timestamps();
            });
        }

        if (! Schema::hasTable('employees')) {
            Schema::create('employees', function (Blueprint $table) {
                $table->id();
                $table->string('emp_name');
                $table->string('designation');
                $table->unsignedBigInteger('department_id')->nullable();
                $table->string('status')->nullable();
                $table->string('type')->nullable();
                $table->timestamps();
            });
        }

        if (! Schema::hasTable('stocks')) {
            Schema::create('stocks', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('asset_id')->nullable();
                $table->string('model')->nullable();
                $table->string('serial_no')->nullable();
                $table->string('ram')->nullable();
                $table->string('rom')->nullable();
                $table->string('processor')->nullable();
                $table->string('generation')->nullable();
                $table->date('purchase_date')->nullable();
                $table->date('expiry_date')->nullable();
                $table->string('status')->nullable();
                $table->timestamps();
            });
        }

        if (! Schema::hasTable('issuances')) {
            Schema::create('issuances', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('stock_id')->nullable();
                $table->unsignedBigInteger('employee_id')->nullable();
                $table->date('issuance_date')->nullable();
                $table->string('location')->nullable();
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('issuances');
        Schema::dropIfExists('stocks');
        Schema::dropIfExists('employees');
        Schema::dropIfExists('assets');
        Schema::dropIfExists('departments');
    }
};
