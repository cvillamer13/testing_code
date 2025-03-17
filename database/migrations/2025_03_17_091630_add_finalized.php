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
        Schema::table('gatepass_data', function (Blueprint $table) {
            $table->boolean('is_finalized')->default(false);
            $table->string('finalizedby')->nullable();
            $table->string('finalize_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('gatepass_data', function (Blueprint $table) {
            //
        });
    }
};
