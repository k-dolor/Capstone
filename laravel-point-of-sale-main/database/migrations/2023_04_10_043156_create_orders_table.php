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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('customer_name')->nullable();
            $table->string('address')->nullable();
            $table->string('order_date');
            $table->string('order_status');
            $table->integer('total_products');
            $table->integer('sub_total')->nullable();
            $table->integer('vat')->nullable();
            $table->string('invoice_no')->nullable();
            $table->integer('discount')->nullable();
            $table->integer('total')->nullable();
            $table->string('payment_status')->nullable();
            $table->integer('pay')->nullable();
            $table->integer('due')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
