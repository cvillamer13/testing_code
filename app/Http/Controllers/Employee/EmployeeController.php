<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\Company;
use App\Models\Department;
use App\Models\Position;
use App\Models\Gender;
use App\Models\User_pages_permission;

class EmployeeController extends Controller
{   
    public function checkingpages(){
        $role_id = session('role_id');
        $current_page = session('current_page');

        $permissions = User_pages_permission::where('pages_id', $role_id)
                                                ->where('roles_id', $role_id)
                                                ->first();
            
            return $permissions; 
    }
    
    public function view()
    {
        $permissions = $this->checkingpages();
            // echo "<pre>";
            // print_r($permissions->isView);
            // exit;

        if($permissions->isView){
            $employees = Employee::all();
            return view('Employee.view', ['employees' => $employees]);
        }else{
            return redirect('/dashboard')->with('error', 'Sorry you dont have right on this module.');
        }
        
    }

    public function add()
    {
        $permissions = $this->checkingpages();

        if($permissions->isCreate){
            $position = Position::all();
            $gender = Gender::all();
            $company = Company::all();
            $department = Department::all();
            return view('Employee.add', [
                'position' => $position,
                'gender' => $gender,
                'company' => $company,
                'department' => $department
            ]);
        }else{
            return redirect('/dashboard')->with('error', 'Sorry you dont have right on this module.');
        }

        
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
            $emp->date_of_hired = $request->doh;
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


    public function get_employee(Request $request){
        try {
            $request->validate([
                'id' => 'required'
            ]);

            // $employee_data = Employee::find($request->id);
            $employee_data = Employee::with(['gender', 'position', 'company', 'department'])->find($request->id);
            return response()->json($employee_data);
        } catch (\Throwable $th) {
            return response()->json($th);
            //throw $th;
        }
    }

    public function edit(Request $request, $id){
        try {

            $permissions = $this->checkingpages();

            if($permissions->isUpdate){
                $employee = Employee::with(['gender', 'position', 'company', 'department'])->find($id);
                $position = Position::all();
                $gender = Gender::all();
                $company = Company::all();
                $department = Department::all();
                return view('Employee.edit', [
                    'position' => $position,
                    'gender' => $gender,
                    'company' => $company,
                    'department' => $department,
                    'employee' => $employee
                ]);
            }else{
                return redirect('/dashboard')->with('error', 'Sorry you dont have right on this module.');
            }
            
        } catch (\Throwable $th) {
            //throw $th;
        }

    }


    public function update(Request $request, $id){
        try {
            // echo "<pre>";
            // print_r($request->all());
            // exit;

            $request->validate([
                'f_name' => 'required',
                'l_name' => 'required',
                'gender_data' => 'required',
                'email_data' => 'required',
                'phone_number' => 'required',
                'position_data' => 'required',
                'company_data' => 'required',
                'depart_data' => 'required',
            ]);

            $emp = Employee::find($id);
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
            $emp->date_of_hired = $request->doh;
            $emp->address1 = $request->address1;
            $emp->address2 = $request->address2;
            $emp->barangay = $request->barangay;
            $emp->city = $request->city;
            $emp->province = $request->province;
            $emp->country = $request->country;
            $emp->zip = $request->zip;
            $emp->updated_by = session('user_email');
            $emp->save();

            return redirect()->route('employee.view')->with('success', 'Employee '. $emp->emp_no .' updated successfully');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', $e->getMessage());
        }

    }
}
