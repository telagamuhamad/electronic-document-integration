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
        Schema::create('good_return_note_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('good_return_note_id')->index()->nullable();
            $table->string('good_return_note_number')->nullable();
            $table->unsignedBigInteger('delivery_order_id')->index()->nullable();
            $table->unsignedBigInteger('delivery_order_item_id')->index()->nullable();
            $table->string('product_name')->nullable();
            $table->longText('product_description')->nullable();
            $table->decimal('product_price', 28, 2)->nullable();
            $table->longText('delivery_to_address')->nullable();
            $table->string('delivery_to_name')->nullable();
            $table->string('status')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('good_return_note_items');
    }
};
