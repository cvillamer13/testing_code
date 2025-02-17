<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'description', 'comp_id', 'department_id'];
    protected $table = 'location';


    public function company()
    {
        return $this->belongsTo(Company::class, 'comp_id');
    }

    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id');
    }
}
