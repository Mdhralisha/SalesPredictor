<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Sale;
use App\Models\Purchase;
use App\Models\purchase_details;
use App\Models\Report;
use App\Models\sales_details;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Count users
        $totalUsers = User::count();

        $totalSales = sales_details::select(DB::raw('SUM(sales_rate * sales_quantity) as total'))
            ->value('total');

        // Total purchase = sum of (purchase_rate * purchase_quantity)
        $totalPurchase = purchase_details::select(DB::raw('SUM(purchase_rate * purchase_quantity) as total'))
            ->value('total');

        // Count reports
        $totalReports = 5;;

        return view('dashboard', compact(
            'totalUsers',
            'totalSales',
            'totalPurchase',
            'totalReports'
        ));
    }
}
