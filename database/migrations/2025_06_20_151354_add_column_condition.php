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
        Schema::table('asset_barrowed_detl', function (Blueprint $table) {
            $table->string('condition')->nullable();
            $table->string('status')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('asset_barrowed_detl', function (Blueprint $table) {
            $table->dropColumn('condition');
            $table->dropColumn('status');
        });
    }
};
