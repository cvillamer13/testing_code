<?php

namespace App\Http\Controllers\Asset_Count;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\AssetCount;
use App\Models\Location_name;
use App\Models\Location;
use App\Models\Asset;
use App\Models\Company;
use App\Models\Department;
use App\Models\AssetCountPlot;

class AssetCountController extends Controller
{
    function view()
    {
        $data = AssetCount::with(['location_show'])->get();
        // echo "<pre>";
        // print_r($data[0]->location_show->location_data->name);
        // echo "</pre>";
        // exit;
        return view('AssetCount.view', [
            'asset_count' => $data,
        ]);
    }

    function add()
    {
        $locations = Location_name::all();
        return view('AssetCount.add', [
            'locations' => $locations,
        ]);
    }

    // public function getLocationScope(Request $request)
    // {
    //     $locationId = $request->location_id;

    //     // Get all locations with relationships
    //     $locations = Location::with(['company', 'department'])
    //         ->where('location_id', $locationId)
    //         ->get();

    //     // Group by company and list unique departments
    //     $grouped = [];

    //     foreach ($locations as $loc) {
    //         $companyName = $loc->company->name ?? 'Unknown Company';
    //         $departmentName = $loc->department->name ?? 'Unknown Department';

    //         // Initialize company if not set
    //         if (!isset($grouped[$companyName])) {
    //             $grouped[$companyName] = [];
    //         }

    //         // Add department if it's not already added
    //         if (!in_array($departmentName, $grouped[$companyName])) {
    //             $grouped[$companyName][] = $departmentName;
    //         }
    //     }

    //     return response()->json([
    //         'status' => 'success',
    //         'data' => $grouped,
    //         'assets' => $assets,
    //     ]);
    // }

    public function getLocationScope(Request $request)
    {
        $locationId = $request->location_id;

        // Get all locations with relationships
        $locations = Location::with(['company', 'department'])
            ->where('location_id', $locationId)
            ->get();

        // Group by company name and list unique department names
        $grouped = [];
        $companyDeptPairs = [];

        foreach ($locations as $loc) {
            $companyName = $loc->company->name ?? 'Unknown Company';
            $departmentName = $loc->department->name ?? 'Unknown Department';

            // Grouping for frontend
            if (!isset($grouped[$companyName])) {
                $grouped[$companyName] = [];
            }

            if (!in_array($departmentName, $grouped[$companyName])) {
                $grouped[$companyName][] = $departmentName;
            }

            // Collecting for asset query
            $key = $loc->comp_id . '-' . $loc->department_id;

            if (!isset($companyDeptPairs[$key])) {
                $companyDeptPairs[$key] = [
                    'company_id' => $loc->comp_id,
                    'department_id' => $loc->department_id,
                ];
            }
        }

        // Now query assets based on company and department pairs
        $structured = [];

        foreach ($companyDeptPairs as $pair) {
            $companyName = Company::find($pair['company_id'])->name ?? 'Unknown Company';
            $departmentName = Department::find($pair['department_id'])->name ?? 'Unknown Department';
        
            $assets = Asset::where('company_id', $pair['company_id'])
                ->where('department_id', $pair['department_id'])
                ->get()
                // ->pluck('name', 'asset_id', 'asset_description') // or any identifying field
                ->toArray();
        
            if (!isset($structured[$companyName])) {
                $structured[$companyName] = [];
            }
        
            $structured[$companyName][$departmentName] = $assets;
        }
        

        return response()->json([
            'status' => 'success',
            'data' => $structured,
            // 'assets' => $assets,
        ]);
    }

    public function store(Request $request)
    {
        try {
            // Validate the request data
            // echo "<pre>";
            // print_r($request->all());
            // echo "</pre>";
            // exit;
            $request->validate([
                'location' => 'required',
                'year' => 'required',
                'from_date' => 'required',
                'to_date' => 'required',
                'count_type' => 'required',
            ]);

            $data = new AssetCount();
            $data->year = $request->year;
            $data->quarter = $request->quarter;
            $data->date_from = $request->from_date;
            $data->date_to = $request->to_date;
            $data->type = $request->count_type;
            $data->location = $request->location;
            $data->is_finalized = 0;
            $data->finalizedby = null;
            $data->finalize_at = null;
            $data->ref_num = Str::uuid();
            $data->createdby = session('user_email');
            $data->updatedby = null;
            $data->created_at = now();
            $data->updated_at = null;
            $data->deleted_at = null;
            $data->deletedby = null;
            $data->isDelete = 0;
            $data->save();


            // Loop through the assets and save them to the asset_count_plot table
            $get_location = Location::where('location_id', $data->location)->first();
            $assets = Asset::where('company_id', $get_location->comp_id)
                ->where('department_id', $get_location->department_id)
                ->where('location_id', $get_location->id)
                ->get();

            foreach ($assets as $asset) {
                $assetCountPlot = new AssetCountPlot();
                $assetCountPlot->asset_count_id = $data->id;
                $assetCountPlot->asset_id = $asset->id;
                $assetCountPlot->location_id = $data->location;
                $assetCountPlot->company_id = $get_location->comp_id;
                $assetCountPlot->department_id = $get_location->department_id;
                $assetCountPlot->createdby = session('user_email');
                $assetCountPlot->save();
            }
            // Optionally, you can redirect or return a response
            return redirect('/AssetCount/for_finalize/'.$data->id)->with('success', 'Asset Count Schedule Add Successfully');
        } catch (\Throwable $th) {
            // throw $th;
            return redirect()->back()->with('error', 'Something went wrong: ' . $th->getMessage());
        }
    }


    function list_asset($id)
    {
        $asset_count = AssetCount::with(['location_show', 'asset_count_plot'])->find($id);

        if ($asset_count) {
            return view('AssetCount.list_asset', [
                'asset_count' => $asset_count,
            ]);
        } else {
            return redirect()->back()->with('error', 'Asset Count not found');
        }
    }


    function lock_schedule(Request $request)
    {
        try {
            $data = AssetCount::find($request->id);
            $data->is_finalized = 1;
            $data->finalizedby = session('user_email');
            $data->finalize_at = now();
            $data->save();

            return response()->json([
                'status' => 'success',
                'message' => 'Asset Count Schedule Locked Successfully'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error',
                'message' => 'Something went wrong: ' . $th->getMessage()
            ]);
        }
    }



}
