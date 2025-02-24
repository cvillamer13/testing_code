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
        Schema::create('asset_assigned', function (Blueprint $table) {
            $table->id();
            $table->string('asset_id')->nullable();
            $table->string('employee_id')->nullable();
            $table->string('status')->nullable();
            $table->boolean('isDelete')->default(false);
            $table->string('createdby')->nullable();
            $table->string('updatedby')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('asset_assigned');
    }
};
