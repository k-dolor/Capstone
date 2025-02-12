<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
class InventoryController extends Controller
{
     // Display inventory list
     public function index()
     {
         $row = (int) request('row', 10);
     
         if ($row < 1 || $row > 100) {
             abort(400, 'The per-page parameter must be an integer between 1 and 100.');
         }
     
         $query = Product::with(['category', 'supplier']);
     
         // Apply search filter if present
         if (request('search')) {
             $query->where(function($q) {
                 // Assuming the correct column name for product name is `product_name`
                 $q->where('product_name', 'like', '%' . request('search') . '%')
                   ->orWhere('product_code', 'like', '%' . request('search') . '%'); // Also search by product code
             });
         }
     
         // Apply category filter if selected
         if (request('category')) {
             $query->where('category_id', request('category'));
         }
     
         // Get products from the database
         $products = $query->sortable()->get();
     
         // Apply stock status filter dynamically
         if (request('stock_status')) {
             $products = $products->filter(function ($product) {
                 $stockStatus = $this->getStockStatus($product);
                 switch (request('stock_status')) {
                     case 'in_stock':
                         return $stockStatus === 'IN STOCK';
                     case 'low_stock':
                         return $stockStatus === 'LOW STOCK';
                     case 'out_of_stock':
                         return $stockStatus === 'OUT OF STOCK';
                 }
             });
         }
     
         // Check if no products are found
         $noProducts = $products->isEmpty();
     
         // Paginate the filtered results
         $paginatedProducts = $products->forPage(request('page', 1), $row);
     
         return view('inventory.index', [
             'products' => new \Illuminate\Pagination\LengthAwarePaginator(
                 $paginatedProducts,
                 $products->count(),
                 $row,
                 request('page', 1),
                 ['path' => request()->url(), 'query' => request()->query()]
             ),
             'categories' => Category::all(),
             'noProducts' => $noProducts,
         ]);
     }
     



/**
 * Determine the stock status of a product.
 */
private function getStockStatus($product)
{
    if ($product->product_store > 5) {
        return 'IN STOCK';
    } elseif ($product->product_store > 0) {
        return 'LOW STOCK';
    } else {
        return 'OUT OF STOCK';
    }
}

  /////////////////////////////////////////////////////

public function stockIn(Request $request)
{
    $request->validate([
        'product_id' => 'required|exists:products,id',
        'quantity_added' => 'required|integer|min:1',
    ]);

    $product = Product::findOrFail($request->product_id);

    // Update product stock
    $product->increment('product_store', $request->quantity_added);

    // Save stock-in history
    DB::table('stock_in_histories')->insert([
        'product_id' => $request->product_id,
        'quantity_added' => $request->quantity_added,
        'added_at' => now(),
    ]);

    return redirect()->route('inventory.index')->with('success', 'Stock added successfully!');
}


public function stockInHistory($productId)
{
    $product = Product::findOrFail($productId);
    $history = DB::table('stock_in_histories')
        ->where('product_id', $productId)
        ->orderBy('added_at', 'desc')
        ->get();

    return view('inventory.stock-in-history', compact('product', 'history'));
}

///////////////////////////////////////////////
 
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