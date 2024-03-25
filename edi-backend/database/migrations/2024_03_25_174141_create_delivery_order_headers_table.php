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
        Schema::create('delivery_order_headers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('curier_id')->index()->nullable();
            $table->unsignedBigInteger('storage_location_id')->index()->nullable();
            $table->string('delivery_order_number')->nullable();
            $table->date('delivery_date')->nullable();
            $table->string('delivery_order_status')->nullable();
            $table->string('delivery_type')->nullable();
            $table->decimal('total_cost', 28,2)->nullable();
            $table->unsignedBigInteger('created_by_user_id')->index()->nullable();
            $table->string('created_by_user_name')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('delivery_order_headers');
    }
};
