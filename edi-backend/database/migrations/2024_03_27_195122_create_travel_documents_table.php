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
        Schema::create('travel_documents', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('car_id')->nullable()->index();
            $table->unsignedBigInteger('delivery_order_id')->nullable()->index();
            $table->string('travel_document_number')->nullable();
            $table->date('delivery_date')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('travel_documents');
    }
};
