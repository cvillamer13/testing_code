<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\Company;
use App\Models\Department;
use App\Models\Position;
use App\Models\Gender;

class EmployeeController extends Controller
{
    public function view()
    {
        $employees = Employee::all();
        return view('employee.view', ['employees' => $employees]);
    }

    public function add()
    {
        $position = Position::all();
        $gender = Gender::all();
        $company = Company::all();
        $department = Department::all();
        return view('employee.add', [
            'position' => $position,
            'gender' => $gender,
            'company' => $company,
            'department' => $department
        ]);
    }
}
