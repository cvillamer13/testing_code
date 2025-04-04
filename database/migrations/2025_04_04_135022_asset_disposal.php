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
        Schema::create('asset_disposal', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('trans_emp_id');
            $table->string('date')->nullable();
            $table->string('apprver_references');
            $table->string('status')->default("P");

            $table->boolean('is_finalized')->default(false);
            $table->string('finalizedby')->nullable();
            $table->string('finalize_at')->nullable();

            $table->string('approved_status')->nullable();
            $table->string('approved_by')->nullable();
            $table->string('approved_at')->nullable();
            $table->string('approved_uid')->nullable();

            $table->string('ref_num')->nullable();

            $table->string('createdby')->nullable();
            $table->string('updatedby')->nullable();
            $table->timestamps();

            $table->string('deletedby')->nullable();
            $table->boolean('isDelete')->default(false);
            $table->string('deleted_at')->nullable();
        });

        Schema::create('asset_disposal_detl', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('asset_disposal_main_id');
            $table->unsignedBigInteger('asset_id');
            $table->string('remarks')->nullable();
            $table->string('qty')->nullable();
            $table->string('unit')->nullable();
            $table->string('createdby')->nullable();
            $table->string('updatedby')->nullable();
            $table->string('deletedby')->nullable();
            $table->boolean('isDelete')->default(false);
            $table->string('deleted_at')->nullable();
            $table->timestamps();
            $table->foreign('asset_disposal_main_id')->references('id')->on('asset_disposal')->onDelete('cascade');
            $table->foreign('asset_id')->references('id')->on('asset')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('asset_disposal');
        Schema::dropIfExists('asset_disposal_detl');
    }
};
