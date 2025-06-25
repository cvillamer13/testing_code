<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssetDisposalDetl extends Model
{
    use HasFactory;
    protected $table = 'asset_disposal_detl';
    protected $fillable = [
        'asset_disposal_main_id',
        'asset_id',
        'remarks',
        'qty',
        'unit',
        'createdby',
        'updatedby',
        'deletedby',
        'isDelete',
        'deleted_at',
        'asset_type',
        'consumable_item'
    ];

    protected $casts = [
        'isDelete' => 'boolean',
    ];

    public function disposal()
    {
        return $this->belongsTo(AssetDisposal::class, 'asset_disposal_main_id');
    }

    public function asset_details()
    {
        return $this->hasOne(Asset::class, 'id', 'asset_id');
    }

}
