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
            $table->unsignedBigInteger('car_id')->nullable()->index();
            $table->unsignedBigInteger('travel_document_id')->nullable()->index();
            $table->string('delivery_order_number')->nullable();
            $table->string('sender_name')->nullable();
            $table->string('sender_phone_number')->nullable();
            $table->longText('sender_address')->nullable();
            $table->string('receiver_name')->nullable();
            $table->string('receiver_phone_number')->nullable();
            $table->longText('receiver_address')->nullable();
            $table->decimal('total_weight', 28,2)->nullable();
            $table->string('status')->nullable();
            $table->longText('remarks')->nullable();
            $table->decimal('total_price', 28,2)->nullable();
            $table->unsignedBigInteger('last_updated_by_user_id')->nullable();
            $table->string('last_updated_by_user_name')->nullable();
            $table->boolean('is_delivered')->default(false);
            $table->boolean('is_paid')->default(false);
            $table->string('payment_method')->nullable();
            $table->string('payment_status')->nullable();
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
