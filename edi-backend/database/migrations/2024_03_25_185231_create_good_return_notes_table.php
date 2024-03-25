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
        Schema::create('good_return_notes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('delivery_order_id')->index()->nullable();
            $table->unsignedBigInteger('customer_id')->index()->nullable();
            $table->string('delivery_order_number')->nullable();
            $table->string('good_return_note_number')->nullable();
            $table->dateTime('delivery_date')->nullable();
            $table->longText('delivery_from')->nullable();
            $table->longText('delivery_to')->nullable();
            $table->decimal('total_cost', 28,2)->nullable();
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
        Schema::dropIfExists('good_return_notes');
    }
};
