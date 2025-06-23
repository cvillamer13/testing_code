<?php

namespace App\Http\Controllers\Reports;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AssetCount;
use App\Models\AssetCountPlot;
use Barryvdh\DomPDF\Facade\Pdf;


class ReportController extends Controller
{
    function AssetCount(Request $request)
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
}
