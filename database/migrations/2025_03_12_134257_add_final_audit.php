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
            $table->string('approved_by')->nullable();
            $table->string('approved_at')->nullable();
            $table->string('uid')->nullable();
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
