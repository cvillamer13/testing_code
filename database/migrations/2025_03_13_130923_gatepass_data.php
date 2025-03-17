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
        Schema::create('gatepass_data', function (Blueprint $table) {
            $table->id();
            $table->string('uid')->unique();
            $table->boolean('isRequest')->default(false);
            $table->string('data_id')->nullable();
            $table->string('module_from')->nullable();
            $table->string('from_location')->nullable();
            $table->string('to_location')->nullable();
            $table->string('gatepass_no')->nullable();
            $table->string('date_issued')->nullable();
            $table->string('purpose')->nullable();
            $table->string('status')->nullable();
            $table->string('approvers_ref')->nullable();
            $table->string('inspected_by')->nullable();
            $table->string('inspected_date')->nullable();
            $table->string('recieved')->nullable();
            $table->string('recieved_date')->nullable();
            $table->string('createdby')->nullable();
            $table->string('updatedby')->nullable();
            $table->string('deletedby')->nullable();
            $table->boolean('isDelete')->default(false);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gatepass_data');
    }
};
