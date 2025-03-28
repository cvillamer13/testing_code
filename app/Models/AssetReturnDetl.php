<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssetReturnDetl extends Model
{
    use HasFactory;
    protected $table = 'asset_return_detl';
    protected $fillable = [
        'asset_return_id',
        'asset_id',
        'remarks',
        'isClear',
        'is_not_applicable',
        'createdby',
        'updatedby',
        'deletedby',
        'isDelete',
        'is_finalized',
        'finalizedby',
        'finalize_at'
    ];

    public function assetReturn()
    {
        return $this->belongsTo(AssetReturn::class, 'asset_return_id');
    }

    public function asset_detls()
    {
        return $this->belongsTo(Asset::class, 'asset_id');
    }
}
