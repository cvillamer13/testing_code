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
        Schema::create('approvers_matrices', function (Blueprint $table) {
            $table->id();
            $table->string('user_id');
            $table->string('increment_num');
            $table->string('data_id');
            $table->string('pages_id');
            $table->string('company_id');
            $table->string('department_id');
            $table->string('createdby')->nullable();
            $table->string('updatedby')->nullable();
            $table->string('deletedby')->nullable();
            $table->boolean('isDelete')->default(false);
            $table->timestamps();
        });


        Schema::create('approvers_statuses', function (Blueprint $table) {
            $table->id();
            $table->string('user_id');
            $table->string('status');
            $table->string('data_id');
            $table->string('pages_id');
            $table->string('createdby')->nullable();
            $table->string('updatedby')->nullable();
            $table->string('deletedby')->nullable();
            $table->boolean('isDelete')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('approvers_matrices');
        Schema::dropIfExists('approvers_statuses');
    }
};
