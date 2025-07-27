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
        // Step 1: Add nullable column
        Schema::table('product_details', function (Blueprint $table) {
            $table->unsignedBigInteger('vendor_id')->nullable()->after('id');
        });

        // Step 2: Update rows AFTER column is added
        \Illuminate\Support\Facades\DB::statement("UPDATE product_details SET vendor_id = 1 WHERE vendor_id IS NULL");

        // Step 3: Add foreign key with ON DELETE SET NULL
        Schema::table('product_details', function (Blueprint $table) {
            $table->foreign('vendor_id')
                  ->references('id')
                  ->on('vendors')
                  ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('product_details', function (Blueprint $table) {
            $table->dropForeign(['vendor_id']);
            $table->dropColumn('vendor_id');
        });
    }
};
