<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use App\Models\Notification; 
use Illuminate\Support\Facades\Auth;
class InventoryController extends Controller
{
     // Display inventory list
    //  public function index()
    //  {
    //      $row = (int) request('row', 10);
     
    //      if ($row < 1 || $row > 100) {
    //          abort(400, 'The per-page parameter must be an integer between 1 and 100.');
    //      }

    //     //  $products = $query->sortable()->paginate($row);

     
    //      $query = Product::with(['category', 'supplier']);
     
    //      // Apply search filter if present
    //      if (request('search')) {
    //          $query->where(function($q) {
    //              // Assuming the correct column name for product name is `product_name`
    //              $q->where('product_name', 'like', '%' . request('search') . '%')
    //                ->orWhere('product_code', 'like', '%' . request('search') . '%'); // Also search by product code
    //          });
    //      }
     
    //      // Apply category filter if selected
    //      if (request('category')) {
    //          $query->where('category_id', request('category'));
    //      }
     
    //      // Get products from the database (as a collection).
    //         $products = $query->sortable()->get();

    //         // Apply stock status filter dynamically if set.
    //         if (request('stock_status')) {
    //             $products = $products->filter(function ($product) {
    //                 // Call your helper method to get the stock status.
    //                 $stockStatus = $this->getStockStatus($product);
                    
    //                 // Compare based on the selected filter.
    //                 switch (request('stock_status')) {
    //                     case 'in_stock':
    //                         return $stockStatus === 'IN STOCK';
    //                     case 'low_stock':
    //                         return $stockStatus === 'LOW STOCK';
    //                     case 'out_of_stock':
    //                         return $stockStatus === 'OUT OF STOCK';
    //                     default:
    //                         return true;
    //                 }
    //             });
    //         }

     
    //      // Check if no products are found
    //      $noProducts = $products->isEmpty();
     
    //      // Paginate the filtered results
    //      $paginatedProducts = $products->forPage(request('page', 1), $row);
     
    //      return view('inventory.index', [
    //          'products' => new \Illuminate\Pagination\LengthAwarePaginator(
    //              $paginatedProducts,
    //              $products->count(),
    //              $row,
    //              request('page', 1),
    //              ['path' => request()->url(), 'query' => request()->query()]
    //          ),
    //          'categories' => Category::all(),
    //          'noProducts' => $noProducts,
    //      ]);
    //  }
// Import Notification Model

public function index()
{
    $row = (int) request('row', 10);

    if ($row < 1 || $row > 100) {
        abort(400, 'The per-page parameter must be an integer between 1 and 100.');
    }

    $query = Product::with(['category', 'supplier']);

    if (request('search')) {
        $query->where(function($q) {
            $q->where('product_name', 'like', '%' . request('search') . '%')
              ->orWhere('product_code', 'like', '%' . request('search') . '%');
        });
    }

    if (request('category')) {
        $query->where('category_id', request('category'));
    }

    $products = $query->sortable()->get();

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
                default:
                    return true;
            }
        });
    }

    // Check and store low-stock notifications
    $this->checkLowStock();

    // Get unread notifications
    $notifications = Notification::where('is_read', false)->get();

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
        'noProducts' => $products->isEmpty(),
        'notifications' => $notifications, // Pass notifications to view
    ]);
}

/**NEWWWWWWW */
protected function checkLowStock()
{
    $lowStockProducts = Product::where('product_store', '<', 10)->get();

    foreach ($lowStockProducts as $product) {
        $existingNotification = Notification::where('product_id', $product->id)
            ->where('is_read', false)
            ->first();

        if (!$existingNotification) {
            Notification::create([
                'user_id' => Auth::id(), // Ensure user ID is set
                'product_id' => $product->id,
                // 'message' => "Low stock alert for {$product->product_name}!",
                'message' => "Low stock alert: {$product->product_name} ({$product->product_store} left)",
                'is_read' => false,
            ]);
        }
    }
}


public function markAsRead($id)
{
    $notification = Notification::findOrFail($id);
    $notification->update(['is_read' => true]);

    return redirect()->back()->with('success', 'Notification marked as read');
}


     



/**
 * Determine the stock status of a product.
 */


protected function getStockStatus(Product $product)
{
    // If stock is 0 or less, it's "OUT OF STOCK"
    if ($product->product_store <= 0) {
        return 'OUT OF STOCK';
    }
    // If stock is less than 10, consider it "LOW STOCK"
    elseif ($product->product_store < 10) {
        return 'LOW STOCK';
    }
    // Otherwise, it's "IN STOCK"
    return 'IN STOCK';
}


  /////////////////////////////////////////////////////

// public function stockIn(Request $request)
// {
//     $request->validate([
//         'product_id' => 'required|exists:products,id',
//         'quantity_added' => 'required|integer|min:1',
//     ]);

//     $product = Product::findOrFail($request->product_id);

//     // Update product stock
//     $product->increment('product_store', $request->quantity_added);

//     // Save stock-in history
//     // DB::table('stock_in_histories')->insert([
//     //     'product_id' => $request->product_id,
//     //     'quantity_added' => $request->quantity_added,
//     //     'added_at' => now(),
//     // ]);
//     DB::transaction(function () use ($request, $product) {
//         $product->increment('product_store', $request->quantity_added);
    
//         DB::table('stock_in_histories')->insert([
//             'product_id' => $request->product_id,
//             'quantity_added' => $request->quantity_added,
//             'added_at' => now(),
//         ]);
//     });
    

//     return redirect()->route('inventory.index')->with('success', 'Stock added successfully!');
// }
public function stockIn(Request $request)
{
    $request->validate([
        'product_id' => 'required|exists:products,id',
        'quantity_added' => 'required|integer|min:1',
    ]);

    $product = Product::findOrFail($request->product_id);

    DB::transaction(function () use ($request, $product) {
        $product->increment('product_store', $request->quantity_added);

        DB::table('stock_in_histories')->insert([
            'product_id' => $request->product_id,
            'quantity_added' => $request->quantity_added,
            'added_at' => now(),
            
        ]);

        // Remove the low-stock notification if stock is now sufficient
        if ($product->product_store >= 10) {
            Notification::where('product_id', $product->id)->delete();
        }
    });

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
    //  public function create()
    //  {
    //      return view('inventory.create');
    //  }
 
    //  // Store a newly created product in the database
    //  public function store(Request $request)
    //  {
    //     //  $validated = $request->validate([
    //     //      'product_name' => 'required|string|max:255',
    //     //      'category' => 'required|string|max:255',
    //     //      'supplier' => 'required|string|max:255',
    //     //      'quantity' => 'required|integer',
    //     //      'reorder_level' => 'required|integer',
    //     //      'price' => 'required|numeric',
    //     //      'last_refill_date' => 'required|date',
    //     //      'next_inspection_due' => 'required|date',
    //     //      'maintenance_date' => 'required|date',
    //     //  ]);
    //     $validated = $request->validate([
    //         'product_name' => 'required|string|max:255',
    //         'category_id' => 'required|exists:categories,id',
    //         'supplier_id' => 'required|exists:suppliers,id',
    //         'product_store' => 'required|integer',
    //         'reorder_level' => 'required|integer',
    //         'price' => 'required|numeric',
    //         'last_refill_date' => 'required|date',
    //         'next_inspection_due' => 'required|date',
    //         'maintenance_date' => 'required|date',
    //     ]);
        

    //      Product::create($validated);

    //      return redirect()->route('inventory.index')->with('success', 'Product added successfully!');
    //  }
 
     // Show the form for editing the specified product
    //  public function edit(Product $product)
    //  {
    //      return view('inventory.edit', compact('product'));
    //  }
 
     // Update the specified product in the database
    //  public function update(Request $request, Product $product)
    //  {
    //      $validated = $request->validate([
    //          'name' => 'required|string|max:255',
    //          'category' => 'required|string|max:255',
    //          'supplier' => 'required|string|max:255',
    //          'quantity' => 'required|integer',
    //          'reorder_level' => 'required|integer',
    //          'price' => 'required|numeric',
    //          'last_refill_date' => 'required|date',
    //          'next_inspection_due' => 'required|date',
    //          'maintenance_date' => 'required|date',
    //      ]);
 
    //      $product->update($validated);

    //      return redirect()->route('inventory.index')->with('success', 'Product updated successfully!');
    //     }
    
    //     // Remove the specified product from the database
    //     public function destroy(Product $product)
    //     {
    //         $product->delete();
    
    //         return redirect()->route('inventory.index')->with('success', 'Product deleted successfully!');
    //     }
}