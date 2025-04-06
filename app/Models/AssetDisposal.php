<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssetDisposal extends Model
{
    use HasFactory;
    protected $table = 'asset_disposal';
    protected $fillable = [
        'trans_emp_id',
        'date',
        'apprver_references',
        'status',
        'is_finalized',
        'finalizedby',
        'finalize_at',
        'approved_status',
        'approved_by',
        'approved_at',
        'approved_uid',
        'ref_num',
        'createdby',
        'updatedby',
        'deletedby',
        'isDelete',
        'deleted_at',
        'recieved_emp',
        'is_recieved',
        'recieved_at',
    ];

    protected $casts = [
        'is_finalized' => 'boolean',
        'isDelete' => 'boolean',
    ];

    public function details()
    {
        return $this->hasMany(AssetDisposalDetl::class, 'asset_disposal_main_id');
    }

    public function transmitted_emp(){
        return $this->belongsTo(Employee::class, 'trans_emp_id');
    }

    public function recieved_by(){
        return $this->belongsTo(Employee::class, 'recieved_emp');
    }
}
