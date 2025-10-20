<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\purchase_details;
use App\Models\sales_details;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Controllers\SalesDetailsController;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;

class DashboardController extends Controller
{
    public function index()
    {
        // Basic stats
        $totalUsers = User::count();
        $totalSales = sales_details::select(DB::raw('SUM(sales_rate * sales_quantity) as total'))->value('total');
        $totalPurchase = purchase_details::select(DB::raw('SUM(purchase_rate * purchase_quantity) as total'))->value('total');
        $totalReports = 5; // example, can be dynamic

        // Use SalesDetailsController logic
        $salesController = new SalesDetailsController();

        // Clustering data for last 30 days
        $clusters = $this->getClusteringData($salesController);

        // Prediction data for next 3 months
        $reportData = $this->getPredictionData($salesController);

        return view('dashboard', compact(
            'totalUsers',
            'totalSales',
            'totalPurchase',
            'totalReports',
            'clusters',
            'reportData'
        ));
    }

    private function getClusteringData($controller)
    {
        $sales = DB::table('sales_details')
            ->join('product_details', 'sales_details.product_id', '=', 'product_details.id')
            ->select(
                'product_details.id as product_id',
                'product_details.product_name',
                DB::raw('SUM(sales_details.sales_quantity) as total_quantity'),
                DB::raw('SUM(sales_details.sales_rate * sales_details.sales_quantity) as total_amount')
            )
            ->where('sales_details.created_at', '>=', now()->subDays(90))
            ->groupBy('product_details.id', 'product_details.product_name')
            ->get();

        $clusters = [];
        foreach ($sales as $sale) {
            try {
                $response = Http::post('http://127.0.0.1:5000/predict', [
                    'net_amount' => $sale->total_amount,
                    'quantity' => $sale->total_quantity
                ]);
                $sale->cluster = $response->successful() ? $response->json()['cluster'] : 'Error';
            } catch (\Exception $e) {
                $sale->cluster = 'API Error';
            }
            $clusters[] = $sale;
        }

        return $clusters;
    }

    private function getPredictionData($controller)
    {
        $salesData = DB::table('sales_details')
            ->leftJoin('product_details', 'sales_details.product_id', '=', 'product_details.id')
            ->leftJoin('category_details', 'product_details.category_id', '=', 'category_details.id')
            ->select(
                'product_details.product_name',
                'product_details.id',
                'category_details.category_name as mcat',
                'product_details.product_unit as product_unit',
                DB::raw('SUM(sales_quantity * sales_details.sales_rate) as net_amount'),
                DB::raw('SUM(sales_quantity) as total_quantity'),
                DB::raw('AVG(sales_details.sales_rate) as rate'),
                DB::raw('SUM(sales_discount) as discount_amt')
            )
            ->groupBy(
                'product_details.id',
                'product_details.product_name',
                'category_details.category_name',
                'product_details.product_unit'
            )
            ->get();

        $reportData = [];
        $startDate = Carbon::today();

        foreach ($salesData as $record) {
            $productPredictions = [];
            $totalPredictedSales = 0;

            for ($i = 0; $i < 90; $i++) {
                $predictDate = $startDate->copy()->addDays($i)->format('Y-m-d');

                try {
                    $response = Http::post('http://127.0.0.1:5000/xgb/predict', [
                        'TRNDATE' => $predictDate,
                        'MCAT' => $record->mcat ?? 'Unknown',
                        'UNIT' => $record->product_unit ?? 'PCS',
                        'Discount' => $record->discount_amt > 0 ? 1 : 0,
                        'RATE' => (float) ($record->rate ?? 0),
                        'QUANTITY' => (float) ($record->total_quantity ?? 0),
                        'Net Amount' => (float) ($record->net_amount ?? 0)
                    ]);

                    $predictedQuantity = $response->successful()
                        ? $response->json()['predicted_quantity']
                        : null;

                    if ($predictedQuantity !== null) {
                        $totalPredictedSales += $predictedQuantity;
                    }
                } catch (\Exception $e) {
                    $predictedQuantity = null;
                }

                $productPredictions[] = [
                    'date' => $predictDate,
                    'predicted_quantity' => $predictedQuantity
                ];
            }

            $reportData[] = [
                'product_name' => $record->product_name,
                'item_code' => $record->id,
                'predictions' => $productPredictions,
                'total_predicted_sales' => $totalPredictedSales
            ];
        }

        return $reportData;
    }
}
