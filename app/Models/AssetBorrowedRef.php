<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssetBorrowedRef extends Model
{
    use HasFactory;
    protected $table = "asset_borrowed_reference";
    protected $fillable = [
        'reference_number', 
        'createdby'
    ];
}
