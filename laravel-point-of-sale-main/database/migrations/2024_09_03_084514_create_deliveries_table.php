<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        // Schema::create('deliveries', function (Blueprint $table) {
        //     $table->id();
        //     $table->string('order_id'); // This will store the Order ID
        //     $table->string('customer_name');
        //     $table->string('product');
        //     $table->string('delivery_address');
        //     $table->date('delivery_date');
        //     $table->timestamps();
        // });
        Schema::create('deliveries', function (Blueprint $table) {
            $table->id();
            $table->string('order_id'); // Store the order ID
            $table->string('customer_name');
            $table->text('delivery_address');
            $table->date('delivery_date');
            $table->string('status')->default('Pending'); // Delivery status
            $table->string('driver_name')->nullable(); // Driver assignment
            $table->timestamps();
        });
        
    }        

    /**
     * Reverse the migrations.
     */

public function down()
{
    Schema::table('deliveries', function (Blueprint $table) {
        $table->dropForeign(['product_id']);
        $table->dropColumn('product_id');
        $table->string('product')->after('customer_name');
    });
}

};
