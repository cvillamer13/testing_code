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
        'rev_num',
        'createdby',
        'updatedby',
        'deletedby',
        'isDelete',
        'deleted_at',
    ];

    protected $casts = [
        'isDelete' => 'boolean',
    ];

    public function details()
    {
        return $this->hasMany(AssetIssuanceDetl::class, 'issuance_main_id');
    }
}
