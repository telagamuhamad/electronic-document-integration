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
            $table->string('license_plate')->nullable();
            $table->string('driver_name_1')->nullable();
            $table->string('driver_name_2')->nullable();
            $table->decimal('capacity', 28,2)->nullable();
            $table->boolean('is_fulfilled')->nullable();
            $table->boolean('is_departed')->nullable();
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
