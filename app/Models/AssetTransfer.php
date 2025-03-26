<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssetTransfer extends Model
{
    use HasFactory;
    protected $table = "asset_transfer";
    protected $fillable = [
        'emp_id',
        'from_issuance',
        'from_assign',
        'to_assign',
        'status',
        'date_requested',
        'date_needed',
        'requested_by',
        'apprver_references',
        'is_finalized',
        'finalizedby',
        'finalize_at',
        'approved_status',
        'approved_by',
        'approved_at',
        'approved_uid',
        'ref_rss',
        'rev_num',
        'createdby',
        'updatedby',
        'deletedby',
        'isDelete',
        'deleted_at',
        'duration_from',
        'duration_to',
        'deployment_type',
        'location_id',
        'report_to'
    ];
    

    public function details()
    {
        return $this->hasMany(AssetTransferDetl::class, 'asset_transfer_main_id')
            ->where('isDelete', false);
    }

    public function assetDetails()
    {
        return $this->hasManyThrough(Asset::class, AssetTransferDetl::class, 'asset_transfer_main_id', 'id', 'id', 'asset_id')->where('asset_transfer_detl.isDelete', false)->with('category_data');
            
    }

    function getEmployee()
    {
        return $this->belongsTo(Employee::class, 'from_assign');
    }

    function getEmployee_to()
    {
        return $this->belongsTo(Employee::class, 'to_assign');
    }


    function getLocation_to()
    {
        return $this->belongsTo(Location::class, 'location_id');
    }

}
