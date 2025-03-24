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
        Schema::create('asset_transfer', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('emp_id');
            $table->unsignedBigInteger('from_issuance');
            $table->unsignedBigInteger('from_assign');
            $table->string('to_assign');
            $table->string('status');
            $table->string('date_requested');
            $table->string('date_needed');
            $table->string('requested_by');
            $table->string('apprver_references');

            $table->boolean('is_finalized')->default(false);
            $table->string('finalizedby')->nullable();
            $table->string('finalize_at')->nullable();

            $table->string('approved_status')->nullable();
            $table->string('approved_by')->nullable();
            $table->string('approved_at')->nullable();
            $table->string('approved_uid')->nullable();

            $table->string('ref_rss')->nullable();
            $table->string('rev_num')->nullable();
            $table->string('createdby')->nullable();
            $table->string('updatedby')->nullable();
            $table->string('deletedby')->nullable();
            $table->boolean('isDelete')->default(false);
            $table->string('deleted_at')->nullable();
            $table->timestamps();
        });

        Schema::create('asset_transfer_detl', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('asset_transfer_main_id');
            $table->unsignedBigInteger('asset_id');
            $table->string('createdby')->nullable();
            $table->string('updatedby')->nullable();
            $table->string('deletedby')->nullable();
            $table->boolean('isDelete')->default(false);
            $table->string('deleted_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('asset_transfer');
        Schema::dropIfExists('asset_transfer_detl');
    }
};
