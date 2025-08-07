<?php

namespace App\Http\Controllers;

use App\Models\purchase_details;
use Illuminate\Http\Request;

use App\Models\vendor_details;
use App\Models\product_details;
use Illuminate\Support\Facades\Auth;
class PurchaseDetailsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //

        // Fetch all purchase details from the database
        $purchaseDetails = purchase_details::with('vendor', 'product')->get();
        $vendors = vendor_details::all();
        $products = product_details::all();
        // Return a view with the purchase details
        return view('purchase', compact('purchaseDetails','vendors', 'products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $validated = $request->validate([
        'invoice_no' => 'required|integer',
        'purchase_quantity' => 'required|numeric|min:0',
        'purchase_rate' => 'required|numeric|min:0',
        'purchase_discount' => 'nullable|numeric|min:0',
        'vendor_id' => 'required|exists:vendor_details,id',
        'product_id' => 'required|exists:product_details,id',
    ]);

    $validated['created_by'] = Auth::id();

    purchase_details::create($validated);

    return redirect()->back()->with('success', 'Purchase record added successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(purchase_details $purchase_details)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(purchase_details $purchase_details)
    {
        // You can return a view with the purchase details to edit
        return view('editpurchase', compact('purchase_details'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, purchase_details $purchase_details)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(purchase_details $purchase_details)
    {
        //
    }
    public function getProductsByVendor($vendor_id)
{
    $products = product_details::where('vendor_id', $vendor_id)->get(['id', 'product_name']);
    return response()->json($products);
}
public function getProductDetails($product_id)
{
    $product = product_details::find($product_id);

    if ($product) {
        return response()->json([
            'purchase_rate' => $product->product_rate
        ]);
    }

    return response()->json(['purchase_rate' => 0], 404);
}


public function saveMultiple(Request $request)
{
    // Validate input including optional purchase_discount
    $data = $request->validate([
        'purchases' => 'required|array|min:1',
        'purchases.*.invoice_no' => 'required|string',
        'purchases.*.quantity' => 'required|integer|min:1',
        'purchases.*.vendor_id' => 'required|integer|exists:vendor_details,id',
        'purchases.*.product_id' => 'required|integer|exists:product_details,id',
        'purchases.*.purchase_rate' => 'required|numeric|min:0',
        'purchases.*.purchase_discount' => 'nullable|numeric|min:0',
    ]);

    // Loop through each purchase and create a record
    foreach ($data['purchases'] as $purchase) {
        purchase_details::create([
            'invoice_no' => $purchase['invoice_no'],
            'product_id' => $purchase['product_id'],
            'purchase_quantity' => $purchase['quantity'],
            'vendor_id' => $purchase['vendor_id'],
            'purchase_rate' => $purchase['purchase_rate'],
            'purchase_discount' => $purchase['purchase_discount'] ?? 0, // default 0 if not set
            'created_by' => 1,
        ]);
    }

    return response()->json(['message' => 'Purchases saved successfully']);
}



}
