<?php

namespace App\Http\Controllers;

use App\Models\sales_details;
use Illuminate\Http\Request;
use App\Models\purchase_details;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

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
     public function purchaseReport(Request $request)
    {
        // Get the 'from' and 'to' date parameters from the request
        $fromDate = $request->input('from', Carbon::now()->startOfMonth()->toDateString());
        $toDate = $request->input('to', Carbon::now()->toDateString());

        // Use Carbon to set the time range
        $fromDateTime = Carbon::parse($fromDate)->startOfDay();  // Starting from 00:00:00
        $toDateTime = Carbon::parse($toDate)->endOfDay();        // Ending at 23:59:59

        // Query the PurchaseDetails model using whereBetween for the full date-time range
        $purchaseData = purchase_details::whereBetween('created_at', [$fromDateTime, $toDateTime])
                                ->orderBy('created_at', 'asc')
                                ->get();

        // Return the view with the purchase data
        return view('purchasereport', compact('purchaseData', 'fromDate', 'toDate'));
    }


    // inventory report
    public function inventoryReport(Request $request)
    {
    $fromDate = $request->input('from', Carbon::now()->startOfMonth()->toDateString());
    $toDate   = $request->input('to', Carbon::now()->toDateString());

    $fromDateTime = Carbon::parse($fromDate)->startOfDay();
    $toDateTime   = Carbon::parse($toDate)->endOfDay();

    $inventoryData = DB::table('purchase_details as p')
        ->leftJoin('sales_details as s', 'p.product_id', '=', 's.product_id')
        ->leftJoin('product_details as pd', 'p.product_id', '=', 'pd.id')
        ->select(
            'p.product_id',
            'pd.product_name',
            DB::raw('SUM(p.purchase_quantity) as total_purchase_qty'),
            DB::raw('COALESCE(SUM(s.sales_quantity), 0) as total_sales_qty'),
            DB::raw(value: 'SUM(p.purchase_quantity) - COALESCE(SUM(s.sales_quantity), 0) as remaining_stock'),
            DB::raw('AVG(p.purchase_rate) as purchase_rate'),
            DB::raw('(SUM(p.purchase_quantity) - COALESCE(SUM(s.sales_quantity), 0)) * AVG(p.purchase_rate) as stock_value')
        )
        ->whereBetween('p.created_at', [$fromDateTime, $toDateTime])
        ->groupBy('p.product_id', 'pd.product_name')
        ->get();

    return view('inventoryreport', compact('inventoryData', 'fromDate', 'toDate'));
}

}
