<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Company;

class CompanyController extends Controller
{
    public function view()
    {
        $company = Company::all();
        return view('Company.view', [
            'company' => $company,
        ]);
    }

    public function Add_Company(Request $request)
    {

        try {
            $request->validate([
                'name' => 'required',
                'description' => 'required',
            ]);
    
            $company = new Company();
            $company->name = $request->name;
            $company->description = $request->description;
            $company->save();
    
            return response()->json([
                'status' => 'success',
                'message' => $company->name . ' Company Add Successfully'
            ], 200); 
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error',
                'message' => $th->getMessage()
            ], 400);
        }
    }

    public function Edit_Company(Request $request, $id)
    {
        try {
            $request->validate([
                'name' => 'required',
                'description' => 'required',
            ]);

            $company = Company::find($id);
            $company->name = $request->name;
            $company->description = $request->description;
            $company->save();

            return response()->json([
                'status' => 'success',
                'message' => $company->name . ' Company Updated Successfully'
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error',
                'message' => $th->getMessage()
            ], 400);
        }
    }
}
