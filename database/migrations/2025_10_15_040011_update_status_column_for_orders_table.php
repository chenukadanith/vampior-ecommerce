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
        
         // Remove the 'status' column from the 'orders' table
         Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('status');
        });

        // Add the 'status' column to the 'order_items' table
        Schema::table('order_items', function (Blueprint $table) {
            $table->string('status')->default('pending')->after('price');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
        // Revert the changes if we roll back
        Schema::table('orders', function (Blueprint $table) {
            $table->string('status')->default('pending');
        });

        Schema::table('order_items', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
};
