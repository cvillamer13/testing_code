<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asset extends Model
{
    use HasFactory;
    protected $table = 'asset';
    protected $fillable = [
        'asset_id',
        'name',
        'asset_description',
        'unit_id',
        'model_no',
        'unit_price',
        'category',
        'sub_category',
        'image_path',
        'reciept_path',
        'date_of_purchase',
        'supplier_id',
        'assign_employee_id',
        'asset_status_id',
        'company_id',
        'department_id',
        'location_id',
        'type_of_asset',
        'note',
        'os_details',
        'processor_model',
        'desk_details',
        'ram_details',
        'serial_number',
        'accounting_code',
        'createdby',
        'updatedby',
        'deletedby',
        'isDelete',
    ];

    public function unit_data(){
        return $this->belongsTo(Unit::class, 'unit_id');
    }

    public function category_data(){
        return $this->belongsTo(Category::class, 'category');
    }

    public function supplier_data(){
        return $this->belongsTo(Supplier::class, 'supplier_id');
    }

    public function employee_data(){
        return $this->belongsTo(Employee::class, 'assign_employee_id');
    }
    
    public function asset_status_data(){
        return $this->belongsTo(Asset_Status::class, 'asset_status_id');
    }

    public function company_data(){
        return $this->belongsTo(Company::class, 'company_id');
    }

    public function department_data(){
        return $this->belongsTo(Department::class, 'department_id');
    }

    public function location_data(){
        return $this->belongsTo(Location::class, 'location_id');
    }
}
