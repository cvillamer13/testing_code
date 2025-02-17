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

        Schema::create('position', function (Blueprint $table) {
            $table->id();
            $table->string('position_name');
            $table->string('created_by');
            $table->string('updated_by');
            $table->timestamps();
        });
        Schema::create('gender', function (Blueprint $table) {
            $table->id();
            $table->string('gender_name');
            $table->string('created_by');
            $table->string('updated_by');
            $table->timestamps();
        });

        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->string('emp_no')->unique();
            $table->string('email')->unique();
            $table->string('first_name');
            $table->string('middle_name');
            $table->string('last_name');
            $table->string('date_of_birth');
            $table->unsignedBigInteger('position_id');
            $table->unsignedBigInteger('gender_id');
            $table->unsignedBigInteger('company_data_id');
            $table->unsignedBigInteger('department_data_id');
            $table->string('phone_number');
            $table->string('pwd_data');
            $table->string('address1');
            $table->string('address2');
            $table->string('city');
            $table->string('province');
            $table->string('country');
            $table->string('zip');
            $table->string('created_by');
            $table->string('updated_by');
            $table->timestamps();

            $table->foreign('position_id')->references('id')->on('position')->onDelete('cascade');
            $table->foreign('gender_id')->references('id')->on('gender')->onDelete('cascade');
            $table->foreign('company_data_id')->references('id')->on('company')->onDelete('cascade');
            $table->foreign('department_data_id')->references('id')->on('department')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
        Schema::dropIfExists('position');
        Schema::dropIfExists('gender');
    }
};
