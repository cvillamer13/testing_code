<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;
    protected $table = 'company';
    protected $fillable = ['name', 'description'];


    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('orderByName', function ($query) {
            $query->orderBy('name', 'asc');
        });
    }
}
