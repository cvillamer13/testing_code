<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asset_Status extends Model
{
    use HasFactory;
    protected $table = 'asset_statuses';
    protected $fillable = [
        'status',
        'type_of_asset',
        'createdby',
        'updatedby',
        'deletedby',
        'isDelete'
    ];
}
