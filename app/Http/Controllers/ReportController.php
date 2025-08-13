<?php

namespace App\Http\Controllers;

use App\Models\sales_details;
use Illuminate\Http\Request;
use App\Models\purchase_details;
use Carbon\Carbon;

class ReportController extends Controller
{
    //
    public function salesReport(Request $request)
    {
        // Get the 'from' and 'to' date parameters from the request
        $fromDate = $request->input('from', Carbon::now()->startOfMonth()->toDateString());
        $toDate = $request->input('to', Carbon::now()->toDateString());

        // Use Carbon to set the time range
        $fromDateTime = Carbon::parse($fromDate)->startOfDay();  // Starting from 00:00:00
        $toDateTime = Carbon::parse($toDate)->endOfDay();        // Ending at 23:59:59

        // Query the SalesDetails model using whereBetween for the full date-time range
        $salesData = sales_details::whereBetween('created_at', [$fromDateTime, $toDateTime])
                                ->orderBy('created_at', 'asc')
                                ->get();

        // Return the view with the sales data
        return view('salesreport', compact('salesData', 'fromDate', 'toDate'));
    }
}
