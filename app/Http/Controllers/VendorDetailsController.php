<?php

namespace App\Http\Controllers;

use App\Models\vendor_details;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;



class VendorDetailsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $vendors = vendor_details::all();
        return view('vendors', compact('vendors'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('vendor.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        
        $request->validate([
            'vendor_name' => 'required|string|max:255,vendor_name',
            'vendor_address' => 'required|string|max:255',
            'vendor_email' => 'nullable|email|max:255',
            'vendor_contact' => 'required|string|max:50',
           
    
        ]);
        vendor_details::create([
            'vendor_name' => $request->vendor_name,
            'vendor_address' => $request->vendor_address,
            'vendor_email' => $request->vendor_email,
            'vendor_contactno' => $request->vendor_contact,
           
        ]);
        return redirect()->route('vendor.index')->with('success', 'Vendor added successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(vendor_details $vendor_details)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(vendor_details $vendor_details)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, vendor_details $vendor_details)
    {
        //
        $request->validate([
        'vendor_id' => 'required|exists:vendor_details,id',
        'vendor_name' => 'required|string|max:255',
        'vendor_address' => 'required|string|max:255',
        'vendor_contact' => 'required|string|max:50',
        'vendor_email' => 'nullable|email|max:255',
    ]);

    $vendor = vendor_details::find($request->vendor_id);
    $vendor->update([
        'vendor_name' => $request->vendor_name,
        'vendor_address' => $request->vendor_address,
        'vendor_contact' => $request->vendor_contact,
        'vendor_email' => $request->vendor_email,
    ]);

    return redirect()->route('vendor.index')->with('success', 'Vendor updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(vendor_details $vendor_details)
    {
        //
    }
}
