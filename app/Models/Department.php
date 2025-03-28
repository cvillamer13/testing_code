<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'description', 'company_id'];
    protected $table = 'department';

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }
}
