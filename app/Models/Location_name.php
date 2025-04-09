<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Location_name extends Model
{
    use HasFactory;
    protected $table = 'location_name';
    protected $fillable = ['name', 'createdby', 'updatedby', 'deletedby', 'isDeleted', 'created_at', 'updated_at', 'deleted_at'];
    
}
