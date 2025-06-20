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
        if(Schema::hasTable('asset_issuance') && !Schema::hasColumn('asset_issuance', 'deleted_at')) {
            // Schema::dropIfExists('asset_issuance');
            Schema::table('asset_issuance', function (Blueprint $table) {
            $table->softDeletes();
        });
        }
        
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
