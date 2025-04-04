<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssetDisposalRef extends Model
{
    use HasFactory;
    protected $table = "asset_disposal_reference";
    protected $fillable = [
        'reference_number', 
        'createdby'
    ];
}
