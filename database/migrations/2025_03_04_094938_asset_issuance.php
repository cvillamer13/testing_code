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
        Schema::create('asset_issuance', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('emp_id');
            $table->string('reports_to');
            $table->string('deployment_type');
            $table->string('deployment_duration_from');
            $table->string('deployment_duration_to');
            $table->string('date_requested');
            $table->string('date_needed');
            $table->string('issued_by');
            $table->string('apprver_references');
            $table->string('date_of_issuance')->nullable();
            $table->string('ref_rss')->nullable();
            $table->string('rev_num');
            $table->string('createdby')->nullable();
            $table->string('updatedby')->nullable();
            $table->string('deletedby')->nullable();
            $table->boolean('isDelete')->default(false);
            $table->string('deleted_at')->nullable();
            $table->timestamps();
        });


        Schema::create('asset_issuance_detl', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('issuance_main_id');
            $table->unsignedBigInteger('asset_id');
            $table->string('peripherals')->nullable();
            $table->string('type_of_section')->nullable();
            $table->string('os_detl')->nullable();
            $table->string('os_patch_ver')->nullable();
            $table->boolean('isMSoffice')->default(false);
            $table->boolean('isHCS')->default(false);
            $table->boolean('isNetSuite')->default(false);
            $table->boolean('isStandardtUtil')->default(false);
            $table->boolean('isAcrobat_r')->default(false);
            $table->boolean('isAcrobat_a')->default(false);
            $table->string('others')->nullable();
            $table->boolean('int_isfull')->default(false);
            $table->boolean('int_islimited')->default(false);
            $table->string('int_limited_detls')->nullable();
            $table->string('date_of_issuance')->nullable();
            $table->boolean('int_isNone')->default(false);
            $table->boolean('int_isvoip_ext')->default(false);
            $table->boolean('int_ispbx_ext')->default(false);
            $table->string('int_isvoip_ext_detls')->nullable();
            $table->string('int_ispbx_ext_detls')->nullable();
            $table->string('int_ip_assign')->nullable();
            $table->string('int_mac_address')->nullable();
            $table->string('int_network_group')->nullable();
            $table->string('int_wifi_ssid')->nullable();
            $table->string('int_shared_drives')->nullable();
            $table->string('int_shared_printers')->nullable();
            $table->string('int_subnet')->nullable();
            $table->string('int_detailsandnote')->nullable();
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
        Schema::dropIfExists('asset_issuance');
        Schema::dropIfExists('asset_issuance_detl');
    }
};
