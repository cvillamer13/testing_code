<?php

namespace App\Http\Controllers\Reports;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AssetCount;
use App\Models\AssetCountPlot;
use App\Models\AssetScanned;
use App\Models\Asset;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Location;
use App\Models\Location_name;
use App\Models\Asset_Status;




class ReportController extends Controller
{
    function AssetCount()
    {
        $data_asset_count = AssetCount::with(['location_show'])->get();
        return view('Reports.AssetCount', compact('data_asset_count'));
    }

    function AssetCountPdf($id)
    {
        try {
            $data_asset_count = AssetCount::with(['location_show', 'asset_count_plot'])->findOrFail($id);
            // echo "<pre>";
            // print_r($data_asset_count->asset_count_plot);
            // exit;
            $pdf = \PDF::loadView('Reports.AssetCountPdf', compact('data_asset_count'));
            return $pdf->stream('AssetCount.pdf');
        } catch (\Throwable $th) {
            throw $th;
            // return redirect()->back()->with('error', 'Asset Count not found or an error occurred while generating the PDF.');
        }
    }

    function Assetscanned(){
        // $data_asset_scanned = AssetScanned::with(['asset_show', 'location_show'])->get();
        $today = now()->toDateString();
        $asset_data = Asset::with([
            'company_data',
            'department_data',
            'location_data',
            'asset_scanned_data' => function($query) use ($today) {
                $query->whereDate('scanned_date', $today)->orderBy('scanned_date', 'desc')->orderBy('scanned_time', 'desc');
            }
        ])
        ->where('isDelete', 0)
        ->get();

        $locations = Location_name::all();


        return view('Reports.AssetScanned', compact('asset_data', 'locations'));
    }


    function filterAssetScanned(Request $request)
    {
        try {
            //code...
            $location_id = $request->location;
            $date_from = $request->date_from;
            $date_to = $request->date_to;
            $scan_status = $request->scan_status;

            $assetQuery = Asset::with([
                'company_data',
                'department_data',
                'location_data',
                'asset_scanned_data' => function($query) use ($date_from, $date_to) {
                    if ($date_from && $date_to) {
                        $query->whereBetween('scanned_date', [$date_from, $date_to]);
                    } elseif ($date_from) {
                        $query->whereDate('scanned_date', '>=', $date_from);
                    } elseif ($date_to) {
                        $query->whereDate('scanned_date', '<=', $date_to);
                    }
                    $query->orderBy('scanned_date', 'desc')->orderBy('scanned_time', 'desc');
                }
            ])
            ->where('isDelete', 0);


            $location_array = Location::where('location_id', $location_id)->get();
            $location_array = $location_array->pluck('id')->toArray();
            // echo "<pre>";
            // print_r($location_array);
            // exit;
            if ($location_id !== 'all') {
                
                    $assetQuery->whereIn('location_id', $location_array);
               
            }

            // Filter by scan status
            if ($scan_status === 'scanned') {
                // Only assets that have at least one scanned record in asset_scanned_data
                $assetQuery->whereHas('asset_scanned_data', function($query) use ($date_from, $date_to) {
                    if ($date_from && $date_to) {
                        $query->whereBetween('scanned_date', [$date_from, $date_to]);
                    } elseif ($date_from) {
                        $query->whereDate('scanned_date', '>=', $date_from);
                    } elseif ($date_to) {
                        $query->whereDate('scanned_date', '<=', $date_to);
                    }
                });
            } elseif ($scan_status === 'not_scanned') {
                // Only assets that have NO scanned record in asset_scanned_data
                $assetQuery->whereDoesntHave('asset_scanned_data', function($query) use ($date_from, $date_to) {
                    if ($date_from && $date_to) {
                        $query->whereBetween('scanned_date', [$date_from, $date_to]);
                    } elseif ($date_from) {
                        $query->whereDate('scanned_date', '>=', $date_from);
                    } elseif ($date_to) {
                        $query->whereDate('scanned_date', '<=', $date_to);
                    }
                });
            }
            
            $asset_data = $assetQuery->get();

            return response()->json([
                'error' => false,
                'data' => $asset_data
            ]);

            

        } catch (\Throwable $th) {
            return response()->json([
                'error' => true,
                'message' => $th->getMessage()
            ], 500);
        }
    }


    function AssetStatus(){
        $data_asset_status = Asset::with(['asset_status_data', 'location_data', 'company_data', 'department_data'])->where('isDelete', 0)->get();
        $asset_status = Asset_Status::all();
        return view('Reports.AssetStatus', compact('data_asset_status', 'asset_status'));
    }

    function filterAssetStatus(Request $request)
    {
        try {
            $asset_status_id = $request->status_id;

            $assetQuery = Asset::with(['asset_status_data', 'location_data', 'company_data', 'department_data'])->where('isDelete', 0);
            if ($asset_status_id !== 'all') {
                $assetQuery->where('asset_status_id', $asset_status_id);
            }
            $data_asset_status = $assetQuery->get();

            return response()->json([
                'error' => false,
                'data' => $data_asset_status
            ]);

        } catch (\Throwable $th) {
            throw $th;
        }
    }


    function Assetreport()
    {
        $asset_data = Asset::with([
            'unit_data',
            'category_data',
            'supplier_data',
            'employee_data',
            'asset_status_data',
            'company_data',
            'department_data',
            'location_data'
        ])->where('isDelete', 0)->get();

        return view('Reports.AssetReport', compact('asset_data'));
    }
}