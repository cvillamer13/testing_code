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
        Schema::create('asset_count', function (Blueprint $table) {
            $table->id();
            $table->string('year')->nullable();
            $table->string('quarter')->nullable();
            $table->string('date_from')->nullable();
            $table->string('date_to')->nullable();
            
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
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
