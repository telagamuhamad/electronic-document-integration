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
            $table->string('invoice_number')->nullable();
            $table->unsignedBigInteger('delivery_order_id')->index()->nullable();
            $table->unsignedBigInteger('delivery_order_item_id')->index()->nullable();
            $table->unsignedBigInteger('good_return_note_id')->index()->nullable();
            $table->unsignedBigInteger('good_return_note_item_id')->index()->nullable();
            $table->decimal('price', 28, 2)->nullable();
            $table->string('payment_method')->nullable();
            $table->boolean('is_paid')->default(false);
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
