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
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('delivery_order_id')->index()->nullable();
            $table->unsignedBigInteger('goods_receipt_id')->index()->nullable();
            $table->string('invoice_number')->nullable();
            $table->decimal('total_cost', 28,2)->nullable();
            $table->string('payment_method')->nullable();
            $table->string('payment_status')->nullable();
            $table->boolean('is_paid')->default(false);
            $table->boolean('is_delivered')->default(false);
            $table->date('delivery_date')->nullable();
            $table->date('received_date')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
