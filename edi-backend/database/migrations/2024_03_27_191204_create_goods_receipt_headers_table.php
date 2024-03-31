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
        Schema::create('goods_receipt_headers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('delivery_order_id')->nullable()->index();
            $table->string('goods_receipt_number')->nullable();
            $table->string('sender_name')->nullable();
            $table->longText('sender_address')->nullable();
            $table->string('receiver_name')->nullable();
            $table->longText('receiver_address')->nullable();
            $table->decimal('total_cost', 28,2)->nullable();
            $table->date('delivery_date')->nullable();
            $table->date('received_date')->nullable();
            $table->decimal('total_items', 28,2)->nullable();
            $table->unsignedBigInteger('last_updated_by_user_id')->nullable();
            $table->string('last_updated_by_user_name')->nullable();
            $table->boolean('is_delivered')->default(false);
            $table->boolean('is_paid')->default(false);
            $table->string('payment_method')->nullable();
            $table->string('payment_status')->nullable();
            $table->decimal('total_weight', 28,2)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('goods_receipt_headers');
    }
};
