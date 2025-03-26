<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssetTransferDetl extends Model
{
    use HasFactory;
    protected $table = 'asset_transfer_detl';
    protected $fillable = [
        'asset_transfer_main_id',
        'asset_id',
        'createdby',
        'updatedby',
        'deletedby',
        'isDelete',
        'deleted_at',
    ];
}
