<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssetBorrowedDetl extends Model
{
    use HasFactory;
    protected $table = 'asset_barrowed_detl';
    protected $fillable = [
        'asset_id',
        'qty',
        'comments',
        'date',
        'createdby',
        'updatedby',
        'deletedby',
        'isDelete',
    ];
}
