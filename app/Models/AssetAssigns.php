<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssetAssigns extends Model
{
    use HasFactory;
    protected $table = 'asset_assigned';
    protected $fillable = [
        'asset_id',
        'employee_id',
        'status',
        'isDelete',
        'createdby',
        'updatedby',
        'created_at',
        'updated_at'
    ];


    public function getAsset_data(){
        return $this->belongsTo(Asset::class, 'asset_id');
    }

    public function getEmployee(){
        return $this->belongsTo(Employee::class, 'employee_id');
    }
}
