<?php

namespace App\Http\Controllers;

use App\Models\product_details;
use Illuminate\Http\Request;
use App\Models\category_details;
use App\Models\vendor_details;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;


class ProductDetailsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
    $products = product_details::with('category')->get(); // Eager load the category
    $categories = category_details::all();
    $vendors = vendor_details::all(); // Assuming you have a vendor_details model
    return view('product', compact('products', 'categories','vendors'));;
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('product.create');
    }

    
    public function store(Request $request)
    {
            // Check incoming data:
        //dd($request->all());
         Log::info('Store function called', ['data' => $request->all()]);
        $request->validate([
            'productname' => 'required|string|max:255|unique:product_details,product_name',
            'productquantity' => 'required|integer|min:0',
            'purchaserate' => 'required|numeric|min:0',
            'salesrate' => 'required|numeric|min:0',
            'category' => 'required|exists:category_details,id',
            'productunit' => 'required|string|max:50',
            'vendor' => 'required|exists:vendor_details,id', // Ensure vendor exists
        ]);
        try {
            product_details::create([
                'product_name' => $request->productname,
                'product_quantity' => $request->productquantity,
                'product_rate' => $request->purchaserate,
                'sales_rate' => $request->salesrate,
                'category_id' => $request->category,
                'created_by' => 1,
                'product_unit' => $request->productunit,
                'vendor_id' => $request->vendor, // Save vendor ID
            ]);
        } catch (\Exception $e) {
            dd('Error saving product:'. $e->getMessage());
        }
        return redirect()->route('product.index')->with('success', 'Product added successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(product_details $product_details)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(product_details $product_details)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, product_details $product_details)
    {
        //dd($request->all());
         $request->validate([
            'product_id' => 'required',
            'productname' => 'required|string|max:255',
            'productquantity' => 'required|integer|min:1',
            'productunit' => 'required|string|max:50',
            'purchaserate' => 'required|numeric|min:0',
            'category' => 'required',
            'salesrate' => 'required|numeric|min:0',
        ]);

        $product = product_details::findOrFail($request->product_id);

        $product->update([
            'product_name' => $request->productname,
            'product_quantity' => $request->productquantity,
            'product_unit' => $request->productunit,
            'product_rate' => $request->purchaserate,
            'sales_rate' => $request->salesrate,
            'category_id' => $request->category,
             'vendor_id' => $request->vendor, // Update vendor ID
        ]);

        return redirect()->route('product.index')->with('success', 'Product updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(product_details $product_details)
    
    {
        $product = product_details::find($product_details->id);

        if (!$product) {
            return redirect()->route('product.index')->with('error', 'Product not found.');
        }

        $product->delete();

        return redirect()->route('product.index')->with('success', 'Product deleted successfully!');
    }
}
