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
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class EmployeeController extends Controller
{   
    
    public function view()
    {
        $permissions = checkingpages();

        if($permissions->isView){
            $employees = Employee::where('isDelete', '0')->get();
            return view('Employee.view', ['employees' => $employees]);
        }else{
            return redirect('/dashboard')->with('error', 'Sorry you dont have right on this module.');
        }
        
    }

    public function add()
    {

        
        $permissions = checkingpages();

        if($permissions->isCreate){
            // $position = Position::all();
            // $company = Company::all();
            // $department = Department::all();
            // $position = Position::all()->groupBy('position_name', 'desc');
            $position = Position::orderBy('position_name', 'asc')->get();
            $company = Company::orderBy('name', 'asc')->get();
            $department = Department::orderBy('name', 'asc')->get();
            $gender = Gender::all();
           
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
            // print_r($request->all());
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

            if ($request->hasFile('profile_picture')) {
                $image = $request->file('profile_picture');
                $extension = $image->getClientOriginalExtension(); // Get file extension
                $imageName = Str::uuid() . '.' . $extension; // Generate a unique filename
                $path = $image->storeAs('public/', $imageName); // Store the image
            
                $emp->image_path = $imageName; // Save the filename in DB
            }
        
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

            $permissions = checkingpages();

            if($permissions->isUpdate){
                $employee = Employee::with(['gender', 'position', 'company', 'department'])->find($id);
                // $position = Position::all();
                $gender = Gender::all();
                // $company = Company::all();
                // $department = Department::all();
                $position = Position::orderBy('position_name', 'asc')->get();

                $company = Company::orderBy('name', 'asc')->get();
                $department = Department::orderBy('name', 'asc')->get();

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
                'emp_no' => 'required',
                'l_name' => 'required',
                'gender_data' => 'required',
                'email_data' => 'required',
                'phone_number' => 'required',
                'position_data' => 'required',
                'company_data' => 'required',
                'depart_data' => 'required',
                'pass_wd' => 'string|min:8|confirmed'
            ]);

            $emp = Employee::find($id);
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
            $emp->pwd_data = Hash::make($request->pass_wd);
            $emp->updated_by = session('user_email');
            if ($request->hasFile('profile_picture')) {
                $image = $request->file('profile_picture');
                $extension = $image->getClientOriginalExtension(); // Get file extension
                $imageName = Str::uuid() . '.' . $extension; // Generate a unique filename
                $path = $image->storeAs('public/', $imageName); // Store the image
            
                $emp->image_path = $imageName; // Save the filename in DB
            }
            $emp->save();

            return redirect()->route('employee.view')->with('success', 'Employee '. $emp->emp_no .' updated successfully');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', $th->getMessage());
        }

    }

    public function delete_soft(Request $request, $id){
        try {
            $emp = Employee::find($id);
            $emp->isDelete = true;
            $emp->deletedby = session('user_email');
            $emp->deleted_at = now();
            $emp->save();
            // $emp->delete();
            return redirect()->route('employee.view')->with('success', 'Employee '. $emp->emp_no .' deleted successfully');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', $th->getMessage());
        }
    }
}
