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
        Schema::create('purchase_details', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('vendor_id');
      
            $table->integer('invoice_no'); // Assuming an invoice ID for purchase details
            $table->decimal('purchase_rate', 8, 2); // Assuming a precision
            $table->decimal('purchase_quantity', 8, 2); // Assuming a precision for purchase quantity
            $table->decimal('purchase_discount', 8, 2)->nullable(); // Optional field for purchase discount
            
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('product_id')->references('id')->on('product_details')->onDelete('cascade');
            $table->foreign('vendor_id')->references('id')->on('vendor_details')->onDelete('cascade');
            });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchase_details');
    }
};
