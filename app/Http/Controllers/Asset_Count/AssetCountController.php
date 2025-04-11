<?php

namespace App\Http\Controllers\Asset_Count;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\AssetCount;
use App\Models\Location_name;
use App\Models\Location;

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

    public function getLocationScope(Request $request)
    {
        $locationId = $request->location_id;

        // Get all locations with relationships
        $locations = Location::with(['company', 'department'])
            ->where('location_id', $locationId)
            ->get();

        // Group by company and list unique departments
        $grouped = [];

        foreach ($locations as $loc) {
            $companyName = $loc->company->name ?? 'Unknown Company';
            $departmentName = $loc->department->name ?? 'Unknown Department';

            // Initialize company if not set
            if (!isset($grouped[$companyName])) {
                $grouped[$companyName] = [];
            }

            // Add department if it's not already added
            if (!in_array($departmentName, $grouped[$companyName])) {
                $grouped[$companyName][] = $departmentName;
            }
        }

        return response()->json([
            'status' => 'success',
            'data' => $grouped,
        ]);
    }


    public function store(Request $request)
    {
        try {
            // Validate the request data
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
            $data->createdby = auth()->user()->id;
            $data->updatedby = null;
            $data->created_at = now();
            $data->updated_at = null;
            $data->deleted_at = null;
            $data->deletedby = null;
            $data->isDelete = 0;
            $data->save();
            // Optionally, you can redirect or return a response
            return redirect('/AssetCount/for_finalize/'.$data->id)->with('success', 'Asset Count Schedule Add Successfully');
        } catch (\Throwable $th) {
            //throw $th;
            return redirect()->back()->with('error', 'Something went wrong: ' . $th->getMessage());
        }
    }


    function list_asset($id)
    {
        $asset_count = AssetCount::with(['location_show'])->find($id);
        if ($asset_count) {
            return view('AssetCount.list_asset', [
                'asset_count' => $asset_count,
            ]);
        } else {
            return redirect()->back()->with('error', 'Asset Count not found');
        }
    }

}
