<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssetScanned extends Model
{
    use HasFactory;
    protected $table = 'asset_scanned';
    protected $fillable = [
        'asset_id',
        'scanned_date',
        'scanned_time',
        'isDelete',
        'createdby',
        'updatedby',
    ];

    public function getAsset(){
        return $this->belongsTo(Asset::class, 'asset_id');
    }
}
