<?php

namespace App\Http\Controllers;

use App\Models\sales_details;
use Illuminate\Http\Request;
use App\Models\customer_details;
use App\Models\product_details;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

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

            return response()->json([
                'success' => true,
                'message' => 'Sale deleted successfully!'
            ]);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Sale not found'
            ], 404);
        } catch (\Exception $e) {
            Log::error('Error deleting sale: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error deleting sale: ' . $e->getMessage()
            ], 500);
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
}
