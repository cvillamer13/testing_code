<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApproversMatrix extends Model
{
    use HasFactory;
    protected $table = 'approvers_matrices';
    protected $fillable = [
        'user_id',
        'increment_num',
        'company_id',
        'department_id',
        'createdby',
        'updatedby',
        'deletedby',
        'isDelete',
        'type_of_process'
    ];
}
