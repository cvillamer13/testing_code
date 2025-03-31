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
        Schema::create('asset_barrowed', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('emp_id');
            $table->unsignedBigInteger('from_location');
            $table->unsignedBigInteger('to_location');


            $table->string('ref_num')->nullable();
            $table->string('ref_rss')->nullable();
            $table->string('deployed_at')->nullable();
            $table->string('requested_by')->nullable();
            $table->string('requested_at')->nullable();
            $table->string('approvers_ref')->nullable();
            $table->string('status')->default("P");

            $table->string('createdby')->nullable();
            $table->string('updatedby')->nullable();
            $table->string('deletedby')->nullable();
            $table->boolean('isDelete')->default(false);

            $table->boolean('is_finalized')->default(false);
            $table->string('finalizedby')->nullable();
            $table->string('finalize_at')->nullable();
            $table->timestamps();
        });


        Schema::create('asset_barrowed_detl', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('asset_id');
            $table->string('qty')->nullable();
            $table->string('comments')->nullable();
            $table->string('date')->nullable();
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
        Schema::dropIfExists('asset_barrowed');
        Schema::dropIfExists('asset_barrowed_detl');
    }
};
