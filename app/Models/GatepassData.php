<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GatepassData extends Model
{
    use HasFactory;
    protected $table = 'gatepass_data';
    protected $fillable = [
        'uid',
        'isRequest',
        'data_id',
        'module_from',
        'from_location',
        'to_location',
        'gatepass_no',
        'date_issued',
        'purpose',
        'status',
        'approvers_ref',
        'inspected_by',
        'inspected_date',
        'recieved',
        'recieved_date',
        'createdby',
        'updatedby',
        'deletedby',
        'isDelete',
        'finalizedby',
        'finalize_at',
        'is_finalized',
        'approved_status',
        'approved_at',
        'approved_by'
    ];
}
