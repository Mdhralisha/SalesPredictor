<?php

namespace App\Http\Controllers;

use App\Models\sales_details;
use Illuminate\Http\Request;
use App\Models\customer_details;
use App\Models\product_details; 
use Illuminate\Support\Facades\Auth;   
use Illuminate\Support\Facades\Validator;



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
    // $customers = customer_details::all();
    // $products = product_details::all();

    //     return view('sales', compact('customers', 'products'));
    //     //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
           // Validate request data
        $request->validate([
            'invoice_no' => 'required|integer',
            'customer_id' => 'required|exists:customer_details,id',
            'product_id' => 'required|exists:product_details,id',
            'sales_rate' => 'required|numeric|min:0',
            'sales_quantity' => 'required|numeric|min:1',
        ]);

        // Create and save new sales record
        $sale = new sales_details();
        $sale->invoice_no = $request->invoice_no;
        $sale->customer_id = $request->customer_id;
        $sale->product_id = $request->product_id;
        $sale->sales_rate = $request->sales_rate;
        $sale->sales_quantity = $request->sales_quantity;
        $sale->user_id = 1;// current logged-in user
        $sale->save();

        // Redirect back with success message
        return redirect()->route('sales')->with('success', 'Sale added successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(sales_details $sales_details)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(sales_details $sales_details)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, sales_details $sales_details)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(sales_details $sales_details)
    {
        //
    }

    public function saveMultiple(Request $request)
    {
         $validator = Validator::make($request->all(), [
            'sales' => 'required|array|min:1',
            'sales.*.invoice_no' => 'required|max:255',
            'sales.*.product_id' => 'required|exists:product_details,id',
            'sales.*.quantity' => 'required|integer|min:1',
            'sales.*.sales_rate' => 'required|numeric|min:0',
            'sales.*.customer_id' => 'required|exists:customer_details,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        try {
            foreach ($request->sales as $sale) {
                sales_details::create([
                    'invoice_no' => $sale['invoice_no'],
                    'product_id' => $sale['product_id'],
                    'sales_quantity' => $sale['quantity'],
                    'sales_rate' => $sale['sales_rate'],
                    'customer_id' => $sale['customer_id'],
                    'user_id' => 1, // Replace with Auth::id() when auth is setup
                    'sales_discount' => $sale['sales_discount'] ?? 0, // Optional field
                ]);
            }

            return response()->json(['message' => 'Sales saved successfully.']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error saving sales: ' . $e->getMessage()], 500);
        }
    }

    public function getProductSalePrice($id)
    {
        $product = product_details::find($id);

        if (!$product) {
            return response()->json(['sales_rate' => null], 404);
        }

        return response()->json(['sales_rate' => $product->sales_rate]);
    }
    }


