<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssetBorrowed extends Model
{
    use HasFactory;
    protected $table = 'asset_barrowed';
    protected $fillable = [
        'emp_id',
        'from_location',
        'to_location',
        'ref_num',
        'ref_rss',
        'deployed_at',
        'requested_by',
        'requested_at',
        'approvers_ref',
        'status',
        'createdby',
        'updatedby',
        'deletedby',
        'isDelete',
        'is_finalized',
        'finalizedby',
        'finalize_at',
    ];

    public function getEmployee(){
        return $this->belongsTo(Employee::class, 'emp_id');
    }

    function getLocation_from()
    {
        return $this->belongsTo(Location::class, 'from_location');
    }


    function getLocation_to()
    {
        return $this->belongsTo(Location::class, 'to_location');
    }
}
