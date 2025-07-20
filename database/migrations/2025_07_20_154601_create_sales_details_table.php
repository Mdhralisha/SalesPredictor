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
        Schema::create('sales_details', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->unsignedBigInteger('customer_id');
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('user_id'); // Assuming this is the user who created the sales record
            $table->integer('invoice_no'); // Assuming an invoice ID for sales details
            $table->foreign('customer_id')->references('id')->on('customer_details')->onDelete('cascade');
            $table->foreign('product_id')->references('id')->on('product_details')->onDelete('cascade');
            $table->decimal('sales_rate', 8, 2); // Assuming a precision of 8 and scale of 2 for the sales rate 
            $table->decimal('sales_quantity', 8, 2); // Assuming a precision for sales quantity
            $table->decimal('sales_discount', 8, 2); // Optional
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });

      
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales_details');
    }
};
