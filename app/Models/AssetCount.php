<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssetCount extends Model
{
    use HasFactory;
    protected $table = 'asset_count';
    protected $fillable = [
        'year',
        'quarter',
        'date_from',
        'date_to',
        'type',
        'location',
        'is_finalized',
        'finalizedby',
        'finalize_at',
        'ref_num',
        'createdby',
        'updatedby',
        'created_at',
        'updated_at',
        'deleted_at',
        'deletedby',
        'isDelete',
    ];
}
