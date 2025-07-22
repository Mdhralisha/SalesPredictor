<?php

namespace App\Http\Controllers;

use App\Models\category_details;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class CategoryDetailsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = category_details::all();
        return view('category', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
             return view('category.create');
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
        'category_name' => 'required|string|max:255|unique:category_details,category_name',]);
        //
        category_details::create([ //insert data into category_details table
        'category_name' => $request->category_name, // form ma vareko data haru yo req ma aauxa
        'created_by' => 1,
         ]);
        return redirect()->route('category.index')->with('success', 'Category added successfully!');
       
    }

    /**
     * Display the specified resource.
     */
    public function show(category_details $category_details)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(category_details $category_details)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, category_details $category_details)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(category_details $category_details)
    {
        //
    }
}
