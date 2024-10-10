<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Sale;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Redirect;

class SalesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // If you have sales data to pass to the view, do it here.
        return view('sales.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('sales.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $rules = [
            'product_name' => 'required|string|max:50',
            'customer_name' => 'required|string|max:50',
            'amount' => 'required|numeric',
            'date' => 'required|date',
            // Add more rules as per your Sale model
        ];

        $validatedData = $request->validate($rules);

        Sale::create($validatedData);

        return Redirect::route('sales.index')->with('success', 'Sale has been created!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Sale $sale)
    {
        return view('sales.show', [
            'sale' => $sale,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Sale $sale)
    {
        return view('sales.edit', [
            'sale' => $sale
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Sale $sale)
    {
        $rules = [
            'product_name' => 'required|string|max:50',
            'customer_name' => 'required|string|max:50',
            'amount' => 'required|numeric',
            'date' => 'required|date',
            // Add more rules as per your Sale model
        ];

        $validatedData = $request->validate($rules);

        Sale::where('id', $sale->id)->update($validatedData);

        return Redirect::route('sales.index')->with('success', 'Sale has been updated!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Sale $sale)
    {
        Sale::destroy($sale->id);

        return Redirect::route('sales.index')->with('success', 'Sale has been deleted!');
    }
}
