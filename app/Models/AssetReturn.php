<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssetReturn extends Model
{
    use HasFactory;
    protected $table = 'asset_return';
    protected $fillable = [
        'emp_id',
        'separate_date',
        'createdby',
        'updatedby',
        'deletedby',
        'isDelete',
        'is_finalized',
        'finalizedby',
        'finalize_at',
        'confirmed_by',
        'confirmed_at',
        'confirmed_uid'
    ];

    public function details()
    {
        return $this->hasMany(AssetReturnDetl::class, 'asset_return_id');
    }

    public function assetDetails()
    {
        return $this->hasManyThrough(Asset::class, AssetReturnDetl::class, 'asset_return_id', 'id', 'id', 'asset_id')->where('asset_return_detl.isDelete', false);
            
    }

    public function employee_data(){
        return $this->belongsTo(Employee::class, 'emp_id');
    }
}
