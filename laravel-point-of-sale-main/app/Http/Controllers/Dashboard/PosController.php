<?php

namespace App\Http\Controllers\Dashboard;

use Carbon\Carbon;
use App\Models\Product;
use App\Models\Customer;
use App\Models\Notification;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\DB;


class PosController extends Controller
{    
//     public function index()
// {
//     $row = (int) request('row', 20);

//     if ($row < 1 || $row > 100) {
//         abort(400, 'The per-page parameter must be an integer between 1 and 100.');
//     }

//     return view('pos.index', [
//         'customers' => Customer::all()->sortBy('name'),
//         'productItem' => Cart::content(),
//         'products' => Product::filter(request(['search']))
//             ->sortable()
//             ->paginate($row)
//             ->appends(request()->query()),
//     ]);
// }

public function index()
{
    $row = (int) request('row', 20);
    if ($row < 1 || $row > 100) {
        abort(400, 'The per-page parameter must be an integer between 1 and 100.');
    }

    // Fetch VAT from settings table
    $vat = DB::table('orders')->value('vat'); 

    
    $lowStockThreshold = 10; // Customize the threshold as needed

    // Fetch low-stock products
    $lowStockProducts = Product::where('product_store', '<=', $lowStockThreshold)->get();

    // Create notifications for low-stock products (if not already created for this session)
    foreach ($lowStockProducts as $product) {
        if (!Notification::where('product_id', $product->id)->where('is_read', false)->exists()) {
            Notification::create([
                'product_id' => $product->id,
                'user_id' => auth()->id(), // Current user
                'message' => "Low stock alert: {$product->product_name} ({$product->product_store} left)",
                'is_read' => false
            ]);
        }
    }

    // Fetch unread notifications
    $notifications = Notification::where('user_id', auth()->id())->where('is_read', false)->get();



    return view('pos.index', [
        'customers' => Customer::all()->sortBy('name'),
        'productItem' => Cart::content(),
        'products' => Product::filter(request(['search']))
            ->sortable()
            ->paginate($row)
            ->appends(request()->query()),
        'vat' => $vat, // Pass VAT to the view
        'notifications' => $notifications,
    ]);
}


// OLD WORKING--------------------------

    // public function addCart(Request $request)
    // {
    //     $rules = [
    //         'id' => 'required|numeric',
    //         'name' => 'required|string',
    //         'price' => 'required|numeric',
    //     ];

    //     $validatedData = $request->validate($rules);

    //     Cart::add([
    //         'id' => $validatedData['id'],
    //         'name' => $validatedData['name'],
    //         'qty' => 1,
    //         'price' => $validatedData['price'],
    //         // 'options' => ['size' => 'large']
    //     ]);

    //     return Redirect::back()->with('success', 'Product has been added!');
    // }


    public function addCart(Request $request)
{
    $rules = [
        'id' => 'required|numeric',
        'name' => 'required|string',
        'price' => 'required|numeric',
    ];

    $validatedData = $request->validate($rules);

    // Store the full price (which already includes tax)
    Cart::add([
        'id' => $validatedData['id'],
        'name' => $validatedData['name'],
        'qty' => 1,
        'price' => $validatedData['price'], // Keep the displayed price as is
        'options' => ['size' => 'large'] // No tax computation here yet
    ]);

    return Redirect::back()->with('success', 'Product has been added!');
}


    public function updateCart(Request $request, $rowId)
{
    $request->validate([
        'qty' => 'required|numeric|min:1',
    ]);

    Cart::update($rowId, ['qty' => $request->qty]);

    return response()->json([
        'success' => 'Cart updated successfully!',
        'subtotal' => number_format(Cart::get($rowId)->subtotal, 2),
        'cartSubtotal' => number_format(Cart::subtotal(), 2),
        'cartTax' => number_format(Cart::tax(), 2),
        'cartTotal' => number_format(Cart::total(), 2),
    ]);
}

    

    


    public function deleteCart(String $rowId)
    {
        Cart::remove($rowId);

        return Redirect::back()->with('success', 'Cart has been deleted!');
    }

    public function createInvoice(Request $request)
    {

        $validatedData = $request->validate($rules);
        $content = Cart::content();

        return view('pos.create-invoice', [
            'content' => $content
        ]);
    }

    public function printInvoice(Request $request)
    {

        $validatedData = $request->validate($rules);
        $content = Cart::content();

        return view('pos.print-invoice', [
            'content' => $content
        ]);
    }
    
}
