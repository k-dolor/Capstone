<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Order;
use App\Models\Product;
use App\Models\OrderDetails;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use Gloudemans\Shoppingcart\Facades\Cart;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Support\Facades\Notification;
use App\Notifications\LowStockNotification;
use App\Models\User;
// use Spatie\Permission\Models\Role;
// use App\Models\User;
// use App\Notifications\LowStockNotification;
use Spatie\Permission\Models\Role;
// use Illuminate\Support\Facades\Notification;


class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */


    public function completeOrders()
{
    $row = (int) request('row', 10);

    if ($row < 1 || $row > 100) {
        abort(400, 'The per-page parameter must be an integer between 1 and 100.');
    }

    // Retrieve query parameters
    $search = request('search');
    $orderDate = request('order_date');

    // Build the query
    $query = Order::where('order_status', 'complete');

    if ($search) {
        $query->where(function ($q) use ($search) {
            $q->where('invoice_no', 'like', "%$search%")
              ->orWhere('pay', 'like', "%$search%");
        });
    }

    if ($orderDate) {
        $query->whereDate('order_date', $orderDate);
    }

    // Paginate the results
    $orders = $query->sortable()->paginate($row);

    return view('orders.complete-orders', [
        'orders' => $orders
    ]);
}
//////////////////////////////////////

/////////////////////////////////////////////////

    public function stockManage()
    {
        $row = (int) request('row', 10);

        if ($row < 1 || $row > 100) {
            abort(400, 'The per-page parameter must be an integer between 1 and 100.');
        }

        return view('stock.index', [
            'products' => Product::with(['category', 'supplier'])
                ->filter(request(['search']))
                ->sortable()
                ->paginate($row)
                ->appends(request()->query()),
        ]);
    }

    
    /////////////////////////////////////

///-----------------------------------------------------

// public function storeOrder(Request $request)
// {
//     // Validation rules
//     $rules = [
//         'customer_name' => 'nullable|string|max:255', // Corrected nullable validation
//         'payment_status' => 'required|string',
//         'pay' => 'nullable|numeric', // Adjusted to allow null for 'pay'
//         'discount' => 'nullable|numeric|min:0|max:100', // Discount validation
//     ];

//     // Generate a unique invoice number
//     $invoice_no = IdGenerator::generate([
//         'table' => 'orders',
//         'field' => 'invoice_no',
//         'length' => 10,
//         'prefix' => 'INV-'
//     ]);

//     // Validate the request data
//     $validatedData = $request->validate($rules);

//     // Get discount value (default to 0 if not provided)
//     $discount = $request->input('discount', 0);

//     // Calculate the total after discount
//     $subTotal = Cart::subtotal();
//     $vat = Cart::tax();
//     $totalBeforeDiscount = $subTotal + $vat;
//     $discountAmount = $totalBeforeDiscount * ($discount / 100);  // Calculate discount amount
//     $totalAfterDiscount = $totalBeforeDiscount - $discountAmount;  // Apply discount to total

//     // Add additional data to the validated array
//     $validatedData['order_date'] = Carbon::now(); // Store as a Carbon instance
//     $validatedData['order_status'] = 'complete'; // Order status
//     $validatedData['total_products'] = Cart::count(); // Total count of products in the cart
//     $validatedData['sub_total'] = $subTotal; // Subtotal from cart
//     $validatedData['vat'] = $vat; // Tax from cart
//     $validatedData['invoice_no'] = $invoice_no; // Generated invoice number
//     $validatedData['discount'] = $discountAmount; // Discount applied
//     $validatedData['total'] = $totalAfterDiscount; // Total after discount
//     $validatedData['due'] = $totalAfterDiscount - ($validatedData['pay'] ?? 0); // Calculate due (considering 'pay' may be null)
//     $validatedData['created_at'] = Carbon::now(); // Timestamp for creation

//     // Insert order and get the ID
//     $order_id = Order::insertGetId($validatedData);

//     // Create Order Details
//     $contents = Cart::content();
//     $oDetails = []; // Array to hold order details

//     foreach ($contents as $content) {
//         $oDetails[] = [
//             'order_id' => $order_id,
//             'product_id' => $content->id,
//             'quantity' => $content->qty,
//             'unitcost' => $content->price,
//             'total' => $content->total,
//             'created_at' => Carbon::now(),
//         ];
//     }

//     // Insert all order details at once
//     OrderDetails::insert($oDetails);

//     // Clear the shopping cart
//     Cart::destroy();

//     // Redirect to the invoice page with the order ID
//     return redirect()->route('invoice.show', ['order_id' => $order_id]);
// }
///xxxxxxxxxxxxxold working before notifcxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
public function storeOrder(Request $request)
{
    // Validation rules
    $rules = [
        'customer_name' => 'nullable|string|max:255', 
        'payment_status' => 'required|string',
        'pay' => 'nullable|numeric', 
        'discount' => 'nullable|numeric|min:0|max:100', 
    ];

    // Generate a unique invoice number
    $invoice_no = IdGenerator::generate([
        'table' => 'orders',
        'field' => 'invoice_no',
        'length' => 10,
        'prefix' => 'INV-'
    ]);

    // Validate the request data
    $validatedData = $request->validate($rules);

    // Get discount value (default to 0 if not provided)
    $discount = $request->input('discount', 0);

    // Calculate the total after discount
    $subTotal = Cart::subtotal();
    $vat = Cart::tax();
    $totalBeforeDiscount = $subTotal + $vat;
    $discountAmount = $totalBeforeDiscount * ($discount / 100);  
    $totalAfterDiscount = $totalBeforeDiscount - $discountAmount;  

    // Add additional data to the validated array
    $validatedData['order_date'] = Carbon::now();
    $validatedData['order_status'] = 'complete';
    $validatedData['total_products'] = Cart::count();
    $validatedData['sub_total'] = $subTotal;
    $validatedData['vat'] = $vat;
    $validatedData['invoice_no'] = $invoice_no;
    $validatedData['discount'] = $discountAmount;
    $validatedData['total'] = $totalAfterDiscount;
    $validatedData['due'] = $totalAfterDiscount - ($validatedData['pay'] ?? 0);
    $validatedData['created_at'] = Carbon::now();

    // Insert order and get the ID
    $order_id = Order::insertGetId($validatedData);

    // Create Order Details and Deduct Stock
    $contents = Cart::content();
    $oDetails = [];

    foreach ($contents as $content) {
        $oDetails[] = [
            'order_id' => $order_id,
            'product_id' => $content->id,
            'quantity' => $content->qty,
            'unitcost' => $content->price,
            'total' => $content->total,
            'created_at' => Carbon::now(),
        ];

        // Deduct stock
        Product::where('id', $content->id)
            ->decrement('product_store', $content->qty);
    }

    // Insert all order details at once
    OrderDetails::insert($oDetails);

    // Clear the shopping cart
    Cart::destroy();

    // Redirect to the invoice page with the order ID
    return redirect()->route('invoice.show', ['order_id' => $order_id]);
}
/////////OLD WORKING//////////////021225/

///////////////NEW WITH NOTFI 021225/////////////////
// public function storeOrder(Request $request)
// {
//     // Validation rules
//     $rules = [
//         'customer_name' => 'nullable|string|max:255', 
//         'payment_status' => 'required|string',
//         'pay' => 'nullable|numeric', 
//         'discount' => 'nullable|numeric|min:0|max:100', 
//     ];

//     // Generate a unique invoice number
//     $invoice_no = IdGenerator::generate([
//         'table' => 'orders',
//         'field' => 'invoice_no',
//         'length' => 10,
//         'prefix' => 'INV-'
//     ]);

//     // Validate the request data
//     $validatedData = $request->validate($rules);

//     // Get discount value (default to 0 if not provided)
//     $discount = $request->input('discount', 0);

//     // Calculate the total after discount
//     $subTotal = Cart::subtotal();
//     $vat = Cart::tax();
//     $totalBeforeDiscount = $subTotal + $vat;
//     $discountAmount = $totalBeforeDiscount * ($discount / 100);  
//     $totalAfterDiscount = $totalBeforeDiscount - $discountAmount;  

//     // Add additional data to the validated array
//     $validatedData['order_date'] = Carbon::now();
//     $validatedData['order_status'] = 'complete';
//     $validatedData['total_products'] = Cart::count();
//     $validatedData['sub_total'] = $subTotal;
//     $validatedData['vat'] = $vat;
//     $validatedData['invoice_no'] = $invoice_no;
//     $validatedData['discount'] = $discountAmount;
//     $validatedData['total'] = $totalAfterDiscount;
//     $validatedData['due'] = $totalAfterDiscount - ($validatedData['pay'] ?? 0);
//     $validatedData['created_at'] = Carbon::now();

//     // Insert order and get the ID
//     $order_id = Order::insertGetId($validatedData);

//     // Create Order Details and Deduct Stock
//     $contents = Cart::content();
//     $oDetails = [];

//      // Deduct stock and check for low stock
//      foreach ($contents as $content) {
//         $product = Product::find($content->id);
        
//         // Deduct stock
//         $product->decrement('product_store', $content->qty);

//         // Check if stock is below reorder level
//         if ($product->product_store < $product->reorder_level) {
//             $admins = User::role('Admin')->get(); // Get all admins

//             Notification::send($admins, new LowStockNotification($product));
//         }
//     }

//     // Insert all order details at once
//     OrderDetails::insert($oDetails);

//     // Clear the shopping cart
//     Cart::destroy();

//     // Redirect to the invoice page with the order ID
//     return redirect()->route('invoice.show', ['order_id' => $order_id]);
// }

////////////////NEW NOTIF 021225 not working.................


// protected function sendLowStockNotification($product)
// {
//     // Get all users with the "admin" role
//     $admins = User::role('admin')->get();

//     // Send notifications to all admins
//     Notification::send($admins, new LowStockNotification($product));
// }


public function showInvoice($orderId)
{
    // Find the order and associated details
    $order = Order::with('orderDetails.product')->findOrFail($orderId);

    // Calculate the total after discount
    $totalAfterDiscount = ($order->sub_total + $order->vat) - $order->discount;

    // Pass both order and orderDetails to the view
    return view('orders.invoice-order', [
        'order' => $order,
        'orderDetails' => $order->orderDetails, // Assuming you have an orderDetails relationship
        'totalAfterDiscount' => $totalAfterDiscount
    ]);
}



/////////////////////////////////////////////

public function getOrderDetails($id)
{
    $order = Order::with('orderDetails.product')->find($id);

    if (!$order) {
        return response()->json(['error' => 'Order not found'], 404);
    }

    return response()->json([
        'orderDetails' => $order->orderDetails
    ]);
}




    /**
     * Update the specified resource in storage.
     */
    // public function updateStatus(Request $request)
    // {
    //     $order_id = $request->id;

    //     // Reduce the stock
    //     $products = OrderDetails::where('order_id', $order_id)->get();

    //     foreach ($products as $product) {
    //         Product::where('id', $product->product_id)
    //                 ->update(['product_store' => DB::raw('product_store-'.$product->quantity)]);
    //     }

    //     Order::findOrFail($order_id)->update(['order_status' => 'complete']);

    //     return Redirect::route('order.completeOrders')->with('success', 'Order has been completed!');
    // }

    public function invoiceDownload(Int $order_id)
    {
        $order = Order::where('id', $order_id)->first();
        $orderDetails = OrderDetails::with('product')
                        ->where('order_id', $order_id)
                        ->orderBy('id', 'DESC')
                        ->get();

        // show data (only for debugging)
        return view('orders.invoice-order', [
            'order' => $order,
            'orderDetails' => $orderDetails,
        ]);
    }

    public function pendingDue()
    {
        $row = (int) request('row', 10);

        if ($row < 1 || $row > 100) {
            abort(400, 'The per-page parameter must be an integer between 1 and 100.');
        }

        $orders = Order::where('due', '>', '0')
            ->sortable()
            ->paginate($row);

        return view('orders.pending-due', [
            'orders' => $orders
        ]);
    }

    // public function orderDueAjax(Int $id)
    // {
    //     $order = Order::findOrFail($id);

    //     return response()->json($order);
    // }

    // public function updateDue(Request $request)
    // {
    //     $rules = [
    //         'order_id' => 'required|numeric',
    //         'due' => 'required|numeric',
    //     ];

    //     $validatedData = $request->validate($rules);

    //     $order = Order::findOrFail($request->order_id);
    //     $mainPay = $order->pay;
    //     $mainDue = $order->due;

    //     $paid_due = $mainDue - $validatedData['due'];
    //     $paid_pay = $mainPay + $validatedData['due'];

    //     Order::findOrFail($request->order_id)->update([
    //         'due' => $paid_due,
    //         'pay' => $paid_pay,
    //     ]);

    //     return Redirect::route('order.pendingDue')->with('success', 'Due Amount Updated Successfully!');
    // }
}
