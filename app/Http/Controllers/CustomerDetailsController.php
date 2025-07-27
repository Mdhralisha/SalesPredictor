<?php

namespace App\Http\Controllers;

use App\Models\customer_details;
use Illuminate\Http\Request;

class CustomerDetailsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
         $customers = customer_details::all();
        return view('customers', compact('customers'));
        //
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
    
        $request->validate([
            'customername' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'contact' => 'required|string|max:10',
          
        ]);
        customer_details::create([
            'customer_name' => $request->customername,
            'customer_address' => $request->address,
            'customer_contactno' => $request->contact,
            'created_by' => 1
        ]);
        return redirect()->route('customer.index')->with('success', 'Customer added successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(customer_details $customer_details)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(customer_details $customer_details)
    {
        
        //

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, customer_details $customer_details)
    {

        //dd($request->all());
        $request->validate([
            'id' => 'required|exists:customer_details,id',
            'customername' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'contact' => 'required|string|max:10',
        ]);

        $customer_details = customer_details::findOrFail($request->id);


        $customer_details->update([
            'customer_name' => $request->customername,
            'customer_address' => $request->address,
            'customer_contactno' => $request->contact,
        ]);
        return redirect()->route('customer.index')->with('success', 'Customer updated successfully!');
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(customer_details $customer_details)
    {
        //
         $customer = customer_details::findOrFail($customer_details->id);
        $customer->delete();

        return redirect()->back()->with('success', 'Customer deleted successfully!');
    }
    }

