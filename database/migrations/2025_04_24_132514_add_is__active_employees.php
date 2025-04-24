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
        Schema::table('employees', function (Blueprint $table) {
            //
            // Adding the is_active column to the employees table
            $table->boolean('is_active')->default(true)->after('pwd_data');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('employees', function (Blueprint $table) {
            //
            // Dropping the is_active column from the employees table
            $table->dropColumn('is_active');
            // If you want to drop the column, uncomment the line below
            // $table->dropColumn('is_active');
        });
    }
};
