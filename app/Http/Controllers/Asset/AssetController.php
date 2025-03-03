<?php

namespace App\Http\Controllers\Asset;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Asset;
use App\Models\Unit;
use App\Models\Category;
use App\Models\Supplier;
use App\Models\Asset_Status;
use App\Models\Employee;
use App\Models\Company;
use Illuminate\Support\Str;
class AssetController extends Controller
{

    // public function checkingpages(){
    //     $role_id = session('role_id');
    //     $current_page = session('current_page');

    //     $permissions = User_pages_permission::where('pages_id', $current_page)
    //                                             ->where('roles_id', $role_id)
    //                                             ->first();
            
    //     return $permissions; 
    // }


    public function view()
    {
        $permissions = checkingpages();
        if($permissions->isView){
            $asset_data = Asset::with(['unit_data', 'category_data', 'supplier_data', 'employee_data', 'asset_status_data', 'company_data', 'department_data', 'location_data'])->where('isDelete',false)->where('type_of_asset', session('type_asset'))->get();
            // echo "<pre>";
            // print_r(session()->all());
            // exit;
            // echo "<pre>";
            // print_r($asset_data);
            // exit;
            return view('Asset.view', [
                'asset' => $asset_data,
                
            ]);
        }else {
            return redirect('/dashboard')->with('error', 'Sorry you dont have right on this module.');
        }
        
    }

    public function add(){
        $permissions = checkingpages();
        if($permissions->isCreate){
            $unit = Unit::where('isDelete',false)->where('type_of_asset', session('type_asset'))->get();
            $category = Category::where('isDelete',false)->where('type_of_asset', session('type_asset'))->get();
            $supplier = Supplier::where('isDelete',false)->where('type_of_asset', session('type_asset'))->get();
            $status_asset = Asset_Status::where('isDelete',false)->where('type_of_asset', session('type_asset'))->get();
            $employee = Employee::all();
            $company = Company::all();
            // echo "<pre>";
            // print_r($unit[0]->name);
            // exit;
            return view('Asset.add', [
                'unit' => $unit,
                'category' => $category,
                'supplier' => $supplier,
                'status_asset' => $status_asset,
                'employee' => $employee,
                'company' => $company
            ]);
        }else{
            return redirect('/dashboard')->with('error', 'Sorry you dont have right on this module.');
        }
    }


    public function store(Request $request){
        try {
            // echo "<pre>";
            // print_r($request->all());
            // exit;

            $request->validate([
                'AssetId' => 'required',
                'MISAssetNo' => 'required',
                'AssetModelNo' => 'required',
                'Name' => 'required',
                'Company' => 'required',
                'Department' => 'required',
                'LocationArea' => 'required',
                'Description' => 'required',
                'Category' => 'required',
                'Unit' => 'required'
            ]);

            $asset = new Asset();
            $asset->asset_id = $request->AssetId;
            $asset->name = $request->Name;
            $asset->asset_description = $request->Description;
            $asset->unit_id = $request->Unit;
            $asset->model_no = $request->AssetModelNo;
            $asset->unit_price = $request->UnitPrice;
            $asset->category = $request->Category;
            // $asset->image_path = $request->file('image_path') ? $request->file('image_path')->store('assets/images') : null;
            // $asset->reciept_path = $request->file('reciept_path') ? $request->file('reciept_path')->store('assets/receipts') : null;
            $asset->date_of_purchase = $request->DateOfPurchase;
            $asset->supplier_id = $request->Supplier;
            $asset->assign_employee_id = $request->AssignEmployeeId;
            $asset->asset_status_id = $request->AssetStatus;
            $asset->company_id = $request->Company;
            $asset->department_id = $request->Department;
            $asset->location_id = $request->LocationArea;
            $asset->type_of_asset = "3";
            $asset->note = $request->Note;
            $asset->os_details = $request->OSDetails;
            $asset->processor_model = $request->processor_model;
            $asset->desk_details = $request->desk_details;
            $asset->ram_details = $request->ram_details;
            $asset->serial_number = $request->serial_number;
            $asset->accounting_code = $request->MISAssetNo;
            $asset->date_manufacture = $request->DateOfManufacture;
            $asset->warranty_month = $request->WarranetyInMonth;
            $asset->deprication_month = $request->DepreciationInMonth;
            $asset->isDepartmentAssign = $request->assntodep;

            $asset->si_no = $request->si_no;
            $asset->dr_no = $request->dr_no;
            $asset->createdby = session('user_email'); // Assuming the authenticated user creates the asset

            if ($request->hasFile('ImageURLDetails')) {
                $image = $request->file('ImageURLDetails');
                $extension = $image->getClientOriginalExtension(); // Get file extension
                $imageName = Str::uuid() . '.' . $extension; // Generate a unique filename
                $path = $image->storeAs('public/', $imageName); // Store the image
            
                $asset->image_path = $imageName; // Save the filename in DB
            }

            if ($request->hasFile('PurchaseReceiptDetails')) {
                $image1 = $request->file('PurchaseReceiptDetails');
                $extension1 = $image1->getClientOriginalExtension(); // Get file extension
                $imageName1 = Str::uuid() . '.' . $extension1; // Generate a unique filename
                $path1 = $image1->storeAs('public/', $imageName1); // Store the image
            
                $asset->reciept_path = $imageName1; // Save the filename in DB
            }
            // echo "<pre>";
            // print_r($asset);
            // exit;
            $asset->save();
            return redirect()->route('Asset.view')->with('success', 'Asset ' . $asset->asset_id . ' added successfully.');
        } catch (\Throwable $th) {
            // echo "Error: " . $th->getMessage() . "<br>";
            // echo "File: " . $th->getFile() . "<br>";
            // echo "Line: " . $th->getLine() . "<br>";
            // exit;
            return redirect()->back()->with('error', $th->getMessage());
        }
    }


    public function edit(Request $request, $id){
        try {
            $permissions = checkingpages();
            if($permissions->isUpdate){
                $unit = Unit::where('isDelete',false)->where('type_of_asset', session('type_asset'))->get();
                $category = Category::where('isDelete',false)->where('type_of_asset', session('type_asset'))->get();
                $supplier = Supplier::where('isDelete',false)->where('type_of_asset', session('type_asset'))->get();
                $status_asset = Asset_Status::where('isDelete',false)->where('type_of_asset', session('type_asset'))->get();
                $employee = Employee::all();
                $company = Company::all();
                $asset_data = Asset::find($id);

                return view('Asset.edit', [
                    'unit' => $unit,
                    'category' => $category,
                    'supplier' => $supplier,
                    'status_asset' => $status_asset,
                    'employee' => $employee,
                    'company' => $company,
                    'asset_data' => $asset_data
                ]);
            }else {
                return redirect('/dashboard')->with('error', 'Sorry you dont have right on this module.');
            }
        } catch (\Throwable $th) {
            //throw $th;
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function update(Request $request, $id){
        try {
            $request->validate([
                'AssetId' => 'required',
                'MISAssetNo' => 'required',
                'AssetModelNo' => 'required',
                'Name' => 'required',
                'Company' => 'required',
                'Department' => 'required',
                'LocationArea' => 'required',
                'Description' => 'required',
                'Category' => 'required',
                'Unit' => 'required'
            ]);

            $asset = Asset::find($id);
            $asset->asset_id = $request->AssetId;
            $asset->name = $request->Name;
            $asset->asset_description = $request->Description;
            $asset->unit_id = $request->Unit;
            $asset->model_no = $request->AssetModelNo;
            $asset->unit_price = $request->UnitPrice;
            $asset->category = $request->Category;
            $asset->date_of_purchase = $request->DateOfPurchase;
            $asset->supplier_id = $request->Supplier;
            $asset->assign_employee_id = $request->AssignEmployeeId;
            $asset->asset_status_id = $request->AssetStatus;
            $asset->company_id = $request->Company;
            $asset->department_id = $request->Department;
            $asset->location_id = $request->LocationArea;
            $asset->type_of_asset = "3";
            $asset->note = $request->Note;
            $asset->os_details = $request->OSDetails;
            $asset->processor_model = $request->processor_model;
            $asset->desk_details = $request->desk_details;
            $asset->ram_details = $request->ram_details;
            $asset->serial_number = $request->serial_number;
            $asset->accounting_code = $request->MISAssetNo;
            $asset->date_manufacture = $request->DateOfManufacture;
            $asset->warranty_month = $request->WarranetyInMonth;
            $asset->deprication_month = $request->DepreciationInMonth;
            $asset->isDepartmentAssign = $request->assntodep;
            $asset->si_no = $request->si_no;
            $asset->dr_no = $request->dr_no;
            $asset->updatedby = session('user_email'); // Assuming the authenticated user creates the asset

            if ($request->hasFile('ImageURLDetails')) {
                $image = $request->file('ImageURLDetails');
                $extension = $image->getClientOriginalExtension(); // Get file extension
                $imageName = Str::uuid() . '.' . $extension; // Generate a unique filename
                $path = $image->storeAs('public/', $imageName); // Store the image
                $asset->image_path = $imageName; // Save the filename in DB
            }

            if ($request->hasFile('PurchaseReceiptDetails')) {
                $image1 = $request->file('PurchaseReceiptDetails');
                $extension1 = $image1->getClientOriginalExtension(); // Get file extension
                $imageName1 = Str::uuid() . '.' . $extension1; // Generate a unique filename
                $path1 = $image1->storeAs('public/', $imageName1); // Store the image
                $asset->reciept_path = $imageName1; // Save the filename in DB
            }
            // echo "<pre>";
            // print_r($asset);
            // exit;
            $asset->save();
            return redirect()->route('Asset.view')->with('success', 'Asset ' . $asset->asset_id . ' updated successfully.');
        } catch (\Throwable $th) {
            //throw $th;
            return redirect()->back()->with('error', $th->getMessage());
        }
    }
    
}
