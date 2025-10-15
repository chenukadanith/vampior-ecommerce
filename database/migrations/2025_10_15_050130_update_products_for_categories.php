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
        Schema::table('products', function (Blueprint $table) {
            // Add the new foreign key column. It's nullable for a smooth transition.
            $table->foreignId('category_id')->nullable()->constrained()->onDelete('set null')->after('price');
            // Drop the old text-based column
            $table->dropColumn('category');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->string('category');
            $table->dropForeign(['category_id']);
            $table->dropColumn('category_id');
        });
    }
};
