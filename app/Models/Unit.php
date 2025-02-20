<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'secondary_unit',
        'type_of_asset',
        'createdby',
        'updatedby',
        'deletedby',
        'isDelete',
    ];
}
