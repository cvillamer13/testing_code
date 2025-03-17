<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReferenceGatepassNumber extends Model
{
    use HasFactory;
    protected $table = 'gatepass_reference_numbers';
    protected $fillable = ['reference_number', 'createdby'];
}
