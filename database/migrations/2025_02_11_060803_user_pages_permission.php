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

        Schema::create('user_pages_permission', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->unsignedBigInteger('roles_id'); // Foreign key to roles table
            $table->unsignedBigInteger('pages_id'); // Foreign key to pages table
            $table->boolean('isView')->default(false); // View permission
            $table->boolean('isCreate')->default(false); // Create permission
            $table->boolean('isUpdate')->default(false); // Update permission
            $table->boolean('isDelete')->default(false); // Delete permission
            $table->boolean('isProcess')->default(false); // Process permission
            $table->timestamps(); // created_at & updated_at

            $table->foreign('roles_id')->references('id')->on('roles')->onDelete('cascade');
            $table->foreign('pages_id')->references('id')->on('pages')->onDelete('cascade');
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_pages_permission');
    }
};
