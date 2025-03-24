<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssetIssuance extends Model
{
    use HasFactory;
    protected $table = "asset_issuance";
    protected $fillable = [
        'emp_id',
        'reports_to',
        'deployment_type',
        'deployment_duration_from',
        'deployment_duration_to',
        'date_requested',
        'date_needed',
        'issued_by',
        'apprver_references',
        'date_of_issuance',
        'ref_rss',
        'location_id',
        'is_finalized',
        'rev_num',
        'createdby',
        'updatedby',
        'deletedby',
        'isDelete',
        'deleted_at',
        'is_finalized',
        'finalizedby',
        'finalized_at',
        'is_outside',
        'approved_by',
        'approved_at',
        'uid',
    ];

    protected $casts = [
        'isDelete' => 'boolean',
    ];

    public function details()
    {
        return $this->hasMany(AssetIssuanceDetl::class, 'issuance_main_id')
            ->where('isDelete', false);
    }

    public function assetDetails()
    {
        return $this->hasManyThrough(Asset::class, AssetIssuanceDetl::class, 'issuance_main_id', 'id', 'id', 'asset_id')->where('asset_issuance_detl.isDelete', false);
            
    }


    function getEmployee()
    {
        return $this->belongsTo(Employee::class, 'emp_id');
    }
    
    public function getLocation()
    {
        return $this->belongsTo(Location::class, 'location_id');
    }
}
