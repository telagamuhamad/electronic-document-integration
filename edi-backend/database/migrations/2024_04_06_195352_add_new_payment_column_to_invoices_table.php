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
        Schema::table('invoices', function (Blueprint $table) {
            $table->decimal('paid_amount', 28,2)->nullable();
            $table->decimal('payment_change', 28,2)->nullable();
            $table->string('payment_document')->nullable();
            $table->dateTime('payment_date')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('invoices', function (Blueprint $table) {
            $table->dropColumn('paid_amount');
            $table->dropColumn('payment_change');
            $table->dropColumn('payment_document');
            $table->dropColumn('payment_date');
        });
    }
};
