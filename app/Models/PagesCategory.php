<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PagesCategory extends Model
{
    use HasFactory;
    protected $table = 'pages_category';
    protected $fillable = [
        'name',
        'code',
    ];
}
