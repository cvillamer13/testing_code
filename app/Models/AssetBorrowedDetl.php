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
        'deleted_at',
        'borrowed_main_id'
    ];

    public function asset_details(){
        return $this->belongsTo(Asset::class, 'asset_id');
    }
    
}
