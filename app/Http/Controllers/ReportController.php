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

        $purchaseAgg = DB::table('purchase_details')
            ->select(
                'product_id',
                DB::raw('SUM(purchase_quantity) as total_purchase_qty'),
                DB::raw('AVG(purchase_rate) as purchase_rate')
            )
            ->where('created_at', '<=', $toDateTime)
            ->groupBy('product_id');

        $salesAgg = DB::table('sales_details')
            ->select(
                'product_id',
                DB::raw('SUM(sales_quantity) as total_sales_qty')
            )
            ->whereBetween('created_at', [$fromDateTime, $toDateTime])
            ->groupBy('product_id');

        $inventoryData = DB::table('product_details as pd')
            ->leftJoinSub($purchaseAgg, 'p', 'pd.id', '=', 'p.product_id')
            ->leftJoinSub($salesAgg, 's', 'pd.id', '=', 's.product_id')
            ->select(
                'pd.id as product_id',
                'pd.product_name',
                DB::raw('COALESCE(p.total_purchase_qty, 0) as total_purchase_qty'),
                DB::raw('COALESCE(s.total_sales_qty, 0) as total_sales_qty'),
                DB::raw('(COALESCE(p.total_purchase_qty,0) - COALESCE(s.total_sales_qty,0)) as remaining_stock'),
                DB::raw('p.purchase_rate'),
                DB::raw('(COALESCE(p.total_purchase_qty,0) - COALESCE(s.total_sales_qty,0)) * p.purchase_rate as stock_value')
            )
            ->get();

        return view('inventoryreport', compact('inventoryData', 'fromDate', 'toDate'));
    }
}
