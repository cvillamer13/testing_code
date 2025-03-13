<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApproversStatus extends Model
{
    use HasFactory;
    protected $table = 'approvers_statuses';
    protected $fillable = [
        'data_id',
        'pages_id',
        'user_id',
        'status',
        'remarks',
        'createdby',
        'updatedby',
        'deletedby',
        'isDelete',
        'deleted_at',
        'remarks'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function pages()
    {
        return $this->belongsTo(Pages::class, 'pages_id', 'id');
    }

}
