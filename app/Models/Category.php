<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'type_of_asset',
        'createdby',
        'updatedby',
        'deletedby',
        'isDelete'
    ];
}
