<?php

namespace App\Http\Controllers;

use App\Models\sales_details;
use Illuminate\Http\Request;
use App\Models\customer_details;
use App\Models\product_details;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;

class SalesDetailsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sales = sales_details::with(['product', 'customer'])->get();
        $customers = customer_details::all();
        $products = product_details::all();

        return view('sales', compact('sales', 'customers', 'products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Not needed for API/SPA approach
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'invoice_no' => 'required|integer',
            'customer_id' => 'required|exists:customer_details,id',
            'product_id' => 'required|exists:product_details,id',
            'sales_rate' => 'required|numeric|min:0',
            'sales_quantity' => 'required|numeric|min:1',
        ]);

        $sale = new sales_details();
        $sale->invoice_no = $request->invoice_no;
        $sale->customer_id = $request->customer_id;
        $sale->product_id = $request->product_id;
        $sale->sales_rate = $request->sales_rate;
        $sale->sales_quantity = $request->sales_quantity;
        $sale->user_id = Auth::id() ?? 1;
        $sale->save();

        return redirect()->route('sales.index')->with('success', 'Sale added successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try {
            $sale = sales_details::with(['product', 'customer'])->findOrFail($id);

            return response()->json([
                'success' => true,
                'sale' => $sale
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Sale not found'
            ], 404);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(sales_details $sales_details)
    {
        // Not needed for API/SPA approach
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, sales_details $sales_details)
    {
        $validator = Validator::make($request->all(), [
            'invoice_no' => 'required|string|max:255',
            'customer_id' => 'required|exists:customer_details,id',
            'product_id' => 'required|exists:product_details,id',
            'sales_quantity' => 'required|integer|min:1',
            'sales_rate' => 'required|numeric|min:0',
            'sales_discount' => 'nullable|numeric|min:0',
        ]);


        $sales_details->update($validator->validated());

        return response()->json(['message' => 'Sales updated successfully']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $sale = sales_details::findOrFail($id);
            $sale->delete();

            return redirect()->route('sales.index')->with('success', 'Sale Deleted successfully!');

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return redirect()->route('sales.index')->with('success', 'Deletion Failed!');
        } catch (\Exception $e) {
            Log::error('Error deleting sale: ' . $e->getMessage());
            return redirect()->route('sales.index')->with('success', 'Deletion Failed!');
        }
    }

    /**
     * Save multiple sales records
     */
    public function saveMultiple(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'sales' => 'required|array|min:1',
            'sales.*.invoice_no' => 'required|string|max:255',
            'sales.*.product_id' => 'required|exists:product_details,id',
            'sales.*.quantity' => 'required|integer|min:1',
            'sales.*.sales_rate' => 'required|numeric|min:0',
            'sales.*.sales_discount' => 'nullable|numeric|min:0',
            'sales.*.customer_id' => 'required|exists:customer_details,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        try {
            $savedSales = [];

            foreach ($request->sales as $saleData) {
                $product = product_details::find($saleData['product_id']);

                if (!$product) {
                    throw new \Exception('Product not found.');
                }

                if ($product->product_quantity < $saleData['quantity']) {
                    throw new \Exception("Insufficient stock for product: {$product->product_name}. Available: {$product->product_quantity}");
                }

                $product->product_quantity -= $saleData['quantity'];
                $product->save();

                $sale = sales_details::create([
                    'invoice_no' => $saleData['invoice_no'],
                    'product_id' => $saleData['product_id'],
                    'sales_quantity' => $saleData['quantity'],
                    'sales_rate' => $saleData['sales_rate'],
                    'customer_id' => $saleData['customer_id'],
                    'user_id' => Auth::id() ?? 1,
                    'sales_discount' => $saleData['sales_discount'] ?? 0,
                ]);

                $savedSales[] = $sale;
            }

            return response()->json([
                'message' => 'Sales saved successfully.',
                'sales' => $savedSales
            ]);
        } catch (\Exception $e) {
            Log::error('Error saving sales: ' . $e->getMessage());
            return response()->json([
                'error' => 'Error saving sales: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get product sale price
     */
    public function getProductSalePrice($id)
    {
        try {
            $product = product_details::findOrFail($id);
            return response()->json(['sales_rate' => $product->sales_rate]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Product not found',
                'sales_rate' => null
            ], 404);
        }
    }
    public function generateInvoiceNo()
    {
        // Fetch the latest sale by ID (descending order)
        $lastSale = sales_details::orderBy('id', 'desc')->first();

        if ($lastSale && preg_match('/SI_(\d+)/', $lastSale->invoice_no, $matches)) {
            // Increment the numeric part
            $number = intval($matches[1]) + 1;
        } else {
            $number = 1; // Start from 1 if no previous sale exists
        }

        // Pad with leading zeros to 3 digits (e.g., SI_001, SI_002)
        return 'SI_' . str_pad($number, 3, '0', STR_PAD_LEFT);
    }


    public function latestInvoice()
    {
        return response()->json([
            'invoice_no' => $this->generateInvoiceNo()
        ]);
    }

    public function getSalesClusters()
    {
        // Fetch sales data with related product info
        $sales = DB::table('sales_details')
            ->join('product_details', 'sales_details.product_id', '=', 'product_details.id')
            ->select(
                'product_details.id as product_id',
                'product_details.product_name',
                DB::raw('SUM(sales_details.sales_quantity) as total_quantity'),
                DB::raw('SUM(sales_details.sales_rate*sales_details.sales_quantity) as total_amount')
            )
            ->groupBy('product_details.id', 'product_details.product_name')
            ->get();


        $results = [];

        foreach ($sales as $sale) {
            try {
                // Call Flask API for clustering
                $response = Http::post('http://127.0.0.1:5000/predict', [
                    'net_amount' => $sale->total_amount,       // Replace with Net Amount if needed
                    'quantity'   => $sale->total_quantity
                ]);

                if ($response->successful()) {
                    $clusterData = $response->json();
                    $sale->cluster = $clusterData['cluster'];
                } else {
                    $sale->cluster = "Error";
                }
            } catch (\Exception $e) {
                $sale->cluster = "API Error";
            }

            $results[] = $sale;
        }

        return view('salesclusteringreport', compact('results'));
    }
    public function salesPredictReport(Request $request)
    {
        // Fetch historical sales data
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
            $totalPredictedSales = 0; // new variable to hold total predicted quantity

            // Predict for 90 days (~3 months)
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
                        $totalPredictedSales += $predictedQuantity; // accumulate
                    }
                } catch (\Exception $e) {
                    Log::error('Prediction API error: ' . $e->getMessage());
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
                'total_predicted_sales' => $totalPredictedSales // new field
            ];
        }

        return view('salespredictreport', compact('reportData'));
    }
}
