<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User_pages_permission extends Model
{
    use HasFactory;
    protected $fillable = ['roles_id', 'pages_id', 'isView', 'isCreate', 'isUpdate', 'isDelete', 'isProcess'];
    protected $table = 'user_pages_permission';

    public function page()
    {
        return $this->belongsTo(Pages::class, 'pages_id');
    }

    public function role()
    {
        return $this->belongsTo(Roles::class, 'roles_id');
    }

}
