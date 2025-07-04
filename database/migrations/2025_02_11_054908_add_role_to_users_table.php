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
        if (Schema::hasTable('users') && !Schema::hasColumn('users', 'roles_id')) {
            // Schema::dropIfExists('users');
            Schema::table('users', function (Blueprint $table) {
                $table->unsignedBigInteger('roles_id'); // Foreign key to roles table

                // $table->foreign('roles_id')->references('id')->on('roles')->onDelete('cascade');
            });
        }
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            Schema::dropIfExists('users');
        });
    }
};
