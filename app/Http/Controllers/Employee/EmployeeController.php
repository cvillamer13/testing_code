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

    public function add_emp(Request $request){

        try {
            // echo "<pre>";
            // print_r(session('user_email'));
            // exit;
            $request->validate([
                'emp_no' => 'required',
                'f_name' => 'required',
                'l_name' => 'required',
                'gender_data' => 'required',
                'email_data' => 'required',
                'phone_number' => 'required',
                'position_data' => 'required',
                'company_data' => 'required',
                'depart_data' => 'required',
            ]);
            $emp = new Employee();
            $emp->emp_no = $request->emp_no;
            $emp->first_name = $request->f_name;
            $emp->middle_name = $request->m_name;
            $emp->last_name = $request->l_name;
            $emp->date_of_birth = $request->dob;
            $emp->gender_id = $request->gender_data;
            $emp->email = $request->email_data;
            $emp->company_data_id = $request->company_data;
            $emp->department_data_id = $request->depart_data;
            $emp->phone_number = $request->phone_number;
            $emp->position_id = $request->position_data;
            // $emp->pwd_data = $request->emp_no;
            $emp->address1 = $request->address1;
            $emp->address2 = $request->address2;
            $emp->barangay = $request->barangay;
            $emp->city = $request->city;
            $emp->province = $request->province;
            $emp->country = $request->country;
            $emp->zip = $request->zip;
            $emp->created_by = session('user_email');
        
            $emp->save();

            return redirect()->route('employee.view')->with('success', 'Employee '. $emp->emp_no .' created successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
        
        
    }
}
