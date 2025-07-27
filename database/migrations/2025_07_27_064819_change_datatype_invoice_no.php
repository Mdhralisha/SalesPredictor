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
         Schema::table('purchase_details', function (Blueprint $table) {
            // Convert invoice_no to string
            $table->string('invoice_no')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
       Schema::table('purchase_details', function (Blueprint $table) {
            // Revert back to integer if needed
            $table->integer('invoice_no')->change();
        });
    }
};
