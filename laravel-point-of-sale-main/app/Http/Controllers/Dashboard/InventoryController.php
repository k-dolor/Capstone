<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;

class InventoryController extends Controller
{
     // Display inventory list
     public function index()
     {
         $products = Product::all(); // Retrieve all products from the database
         return view('inventory.index', compact('products'));
     }
 
     // Show form for creating a new product
     public function create()
     {
         return view('inventory.create');
     }
 
     // Store a newly created product in the database
     public function store(Request $request)
     {
         $validated = $request->validate([
             'name' => 'required|string|max:255',
             'category' => 'required|string|max:255',
             'supplier' => 'required|string|max:255',
             'quantity' => 'required|integer',
             'reorder_level' => 'required|integer',
             'price' => 'required|numeric',
             'last_refill_date' => 'required|date',
             'next_inspection_due' => 'required|date',
             'maintenance_date' => 'required|date',
         ]);

         Product::create($validated);

         return redirect()->route('inventory.index')->with('success', 'Product added successfully!');
     }
 
     // Show the form for editing the specified product
     public function edit(Product $product)
     {
         return view('inventory.edit', compact('product'));
     }
 
     // Update the specified product in the database
     public function update(Request $request, Product $product)
     {
         $validated = $request->validate([
             'name' => 'required|string|max:255',
             'category' => 'required|string|max:255',
             'supplier' => 'required|string|max:255',
             'quantity' => 'required|integer',
             'reorder_level' => 'required|integer',
             'price' => 'required|numeric',
             'last_refill_date' => 'required|date',
             'next_inspection_due' => 'required|date',
             'maintenance_date' => 'required|date',
         ]);
 
         $product->update($validated);

         return redirect()->route('inventory.index')->with('success', 'Product updated successfully!');
        }
    
        // Remove the specified product from the database
        public function destroy(Product $product)
        {
            $product->delete();
    
            return redirect()->route('inventory.index')->with('success', 'Product deleted successfully!');
        }
    }