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
        'borrowed_main_id',
        'category_id',
        'condition',
        'status'
    ];

    public function asset_details(){
        return $this->belongsTo(Asset::class, 'asset_id');
    }

    public function category_details(){
        return $this->belongsTo(Category::class, 'category_id');
    }
    
}
