<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable; 

class Employee extends Authenticatable
{
    use HasFactory;
    protected $fillable = [
        'emp_no',
        'email',
        'first_name',
        'middle_name',
        'last_name',
        'date_of_birth',
        'position_id ',
        'gender_id ',
        'company_data_id ',
        'department_data_id ',
        'phone_number',
        'date_of_hired',
        'address1',
        'address2',
        'barangay',
        'city',
        'province',
        'country',
        'zip',
        'created_by',
        'updated_by',
        'created_at',
        'updated_at',
        'image_path',
        'pwd_data',
        'is_active',
        'is_resigned',
        'date_of_resigned',

    ];


    protected $hidden = [
        'pwd_data',
        'remember_token',
    ];


    protected $casts = [
        'pwd_data' => 'hashed',
    ];

    public function getAuthPassword()
    {
        return $this->pwd_data; // Custom password field
    }

    public function gender()
    {
        return $this->belongsTo(Gender::class, 'gender_id');
    }

    public function position()
    {
        return $this->belongsTo(Position::class, 'position_id');
    }

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_data_id');
    }

    public function department()
    {
        return $this->belongsTo(Department::class, 'department_data_id');
    }
}
