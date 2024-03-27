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
        Schema::create('invoice_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('invoice_id')->index()->nullable();
            $table->unsignedBigInteger('delivery_order_id')->index()->nullable();
            $table->unsignedBigInteger('delivery_order_item_id')->index()->nullable();
            $table->unsignedBigInteger('goods_receipt_id')->index()->nullable();
            $table->unsignedBigInteger('goods_receipt_item_id')->index()->nullable();
            $table->decimal('total_item', 28,2)->nullable();
            $table->decimal('total_weight', 28,2)->nullable();
            $table->decimal('total_price', 28,2)->nullable();
            $table->longText('remarks')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoice_items');
    }
};
