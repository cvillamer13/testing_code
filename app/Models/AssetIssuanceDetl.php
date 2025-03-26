<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssetIssuanceDetl extends Model
{
    use HasFactory;
    protected $table = "asset_issuance_detl";
    protected $fillable = [
        'issuance_main_id',
        'asset_id',
        'peripherals',
        'type_of_section',
        'os_detl',
        'os_patch_ver',
        'isMSoffice',
        'isHCS',
        'isNetSuite',
        'isStandardtUtil',
        'isAcrobat_r',
        'isAcrobat_a',
        'others',
        'int_isfull',
        'int_islimited',
        'int_limited_detls',
        'date_of_issuance',
        'int_isNone',
        'int_isvoip_ext',
        'int_ispbx_ext',
        'int_isvoip_ext_detls',
        'int_ispbx_ext_detls',
        'int_ip_assign',
        'int_mac_address',
        'int_network_group',
        'int_wifi_ssid',
        'int_shared_drives',
        'int_shared_printers',
        'int_subnet',
        'int_detailsandnote',
        'createdby',
        'updatedby',
        'deletedby',
        'isDelete',
        'deleted_at',
        'status',
        'issuance_no_transfer'
    ];

    protected $casts = [
        'isMSoffice' => 'boolean',
        'isHCS' => 'boolean',
        'isNetSuite' => 'boolean',
        'isStandardtUtil' => 'boolean',
        'isAcrobat_r' => 'boolean',
        'isAcrobat_a' => 'boolean',
        'int_isfull' => 'boolean',
        'int_islimited' => 'boolean',
        'int_isNone' => 'boolean',
        'int_isvoip_ext' => 'boolean',
        'int_ispbx_ext' => 'boolean',
        'isDelete' => 'boolean',
    ];

    public function issuance()
    {
        return $this->belongsTo(AssetIssuance::class, 'issuance_main_id');
    }

    public function asset_details()
    {
        return $this->belongsTo(Asset::class, 'asset_id');
    }


}
