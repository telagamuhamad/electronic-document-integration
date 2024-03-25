<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('cars', function (Blueprint $table) {
            $table->id();
            $table->string('type')->nullable();
            $table->string('vin_number')->nullable();
            $table->string('license_plate_number')->nullable();
            $table->decimal('capacity', 28, 2)->nullable();
            $table->boolean('is_available')->default(true);
            $table->boolean('is_full')->default(false);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cars');
    }
};
