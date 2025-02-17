<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pages extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'URL', 'page_code', 'page_category', 'icon_data'];

    public function page_category_data()
    {
        return $this->belongsTo(PagesCategory::class, 'page_category', 'code');
    }
}
