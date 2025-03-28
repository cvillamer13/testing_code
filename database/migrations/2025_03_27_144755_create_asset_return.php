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
        Schema::create('asset_return', function (Blueprint $table) {
            $table->id();
            $table->string('emp_id');
            $table->string('separate_date');
            $table->string('createdby')->nullable();
            $table->string('updatedby')->nullable();
            $table->string('deletedby')->nullable();
            $table->boolean('isDelete')->default(false);
            $table->boolean('is_finalized')->default(false);
            $table->string('finalizedby')->nullable();
            $table->string('finalize_at')->nullable();
            
            $table->string('confirmed_by')->nullable();
            $table->string('confirmed_at')->nullable();
            $table->string('confirmed_uid')->nullable();

            $table->timestamps();
        });


        Schema::create('asset_return_detl', function (Blueprint $table) {
            $table->id();
            $table->string('asset_return_id');
            $table->string('asset_id');
            $table->string('remarks')->nullable();
            $table->boolean('isClear')->default(false);
            $table->boolean('is_not_applicable')->default(false);
            $table->string('createdby')->nullable();
            $table->string('updatedby')->nullable();
            $table->string('deletedby')->nullable();
            $table->boolean('isDelete')->default(false);
            $table->boolean('is_finalized')->default(false);
            $table->string('finalizedby')->nullable();
            $table->string('finalize_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('asset_return');
        Schema::dropIfExists('asset_return_detl');
    }
};
