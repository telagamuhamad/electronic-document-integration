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
        Schema::create('delivery_order_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('delivery_order_id')->index()->nullable();
            $table->unsignedBigInteger('customer_id')->index()->nullable();
            $table->string('delivery_order_number')->nullable();
            $table->string('product_name')->nullable();
            $table->decimal('quantity', 28,2)->nullable();
            $table->longText('product_description')->nullable();
            $table->decimal('product_weight', 28, 2)->nullable();
            $table->string('product_dimentions')->nullable();
            $table->decimal('product_price', 28, 2)->nullable();
            $table->longText('delivery_to_address')->nullable();
            $table->string('delivery_to_name')->nullable();
            $table->string('status')->nullable();
            $table->dateTime('delivered_at')->nullable();
            $table->dateTime('delivery_deadline')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('delivery_order_items');
    }
};
