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
        Schema::create('product_details', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('created_by');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
            $table->string('product_name');
            $table->integer('product_quantity');
            $table->decimal('product_rate', 8, 2); // Assuming a precision of 8 and scale of 2 for the rate
            $table->decimal('sales_rate', 8, 2); // Assuming a precision of 8 and scale of 2 for the sales rate
            $table->foreign('category_id')->references('id')->on('category_details')->onDelete('cascade');
            $table->integer('product_unit'); // Optional field for product unit
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_details');
    }
};
