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
        Schema::table('asset_issuance', function (Blueprint $table) {
            $table->string('location_id')->nullable()->after('rev_num');
            $table->boolean('is_finalized')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('asset_issuance', function (Blueprint $table) {
            //
        });
    }
};
