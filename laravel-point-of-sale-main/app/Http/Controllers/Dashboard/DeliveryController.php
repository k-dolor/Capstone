<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Delivery;
use App\Models\Product;
use App\Models\Order;

class DeliveryController extends Controller
{
    public function index()
    {
        // Fetch all deliveries from the database
        $deliveries = Delivery::all();

        // Pass the deliveries to the view
        return view('delivery.index', compact('deliveries'));
    }

    // public function create()
    // {
    //     // In the real application, you would fetch inventory data from the database here.
    //     // For now, we just return the view.
    //     return view('delivery.create');
    // }

//     public function create()
// {
//     $products = Product::all(); // Assuming you have a Product model
//     return view('delivery.create', compact('products'));
// }

public function create()
{
    $orders = Order::with('orderDetails.product')->get(); // Fetch orders with related products via OrderDetails
    return view('delivery.create', compact('orders'));
}

// public function getOrderDetails($id)
// {
//     $order = Order::with('orderDetails.product')->find($id);
//     return response()->json($order);
// }
// public function getOrderDetails($id)
// {
//     // Fetch the order and its related order details and products
//     $order = Order::with('orderDetails.product')->find($id);

//     // Check if the order exists
//     if (!$order) {
//         return response()->json(['error' => 'Order not found'], 404);
//     }

//     // Return order ID and the details
//     return response()->json([
//         'order_id' => $order->id,
//         'orderDetails' => $order->orderDetails, // This should include product details
//     ]);
// }

public function getOrderDetails($id)
{
    $order = Order::with('orderDetails.product')->find($id); // Assuming 'orderDetails' is the relationship
    if (!$order) {
        return response()->json(['error' => 'Order not found'], 404);
    }

    return response()->json([
        'orderDetails' => $order->orderDetails
    ]);
}

public function store(Request $request)
{
    $request->validate([
        'orderId' => 'required',
        'customerName' => 'required',
        'deliveryAddress' => 'required',
        'deliveryDate' => 'required',
    ]);

    // Create the new delivery record
    Delivery::create([
        'order_id' => $request->orderId,
        'customer_name' => $request->customerName,
        'delivery_address' => $request->deliveryAddress,
        'delivery_date' => $request->deliveryDate,
        'driver_name' => $request->driver,
    ]);

    return redirect()->route('deliveries.index')->with('success', 'Delivery created successfully.');
}







//     public function store(Request $request)
//     {
//     $validatedData = $request->validate([
//         'orderId' => 'required|string|max:255',
//         'customerName' => 'required|string|max:255',
//         'product' => 'required|string|max:255',
//         'deliveryAddress' => 'required|string',
//         'deliveryDate' => 'required|date',
//         'driver' => 'required|string|max:255',  // Ensure this is included
//     ]);

//     $delivery = new Delivery();
//     $delivery->order_id = $request->input('orderId');
//     $delivery->customer_name = $request->input('customerName');
//     $delivery->product = $request->input('product');
//     $delivery->delivery_address = $request->input('deliveryAddress');
//     $delivery->delivery_date = $request->input('deliveryDate');
//     $delivery->driver_name = $request->input('driver');  // Assign driver here
//     $delivery->save();

//     return redirect()->route('delivery.index')->with('success', 'Delivery created successfully.');
//     }

    public function markAsDelivered($id)
    {
        $delivery = Delivery::findOrFail($id);
        $delivery->status = 'Delivered';
        $delivery->save();

        return redirect()->route('delivery.index')->with('success', 'Delivery marked as delivered');
    }

    public function updateStatusForm($id)
    {
        $delivery = Delivery::findOrFail($id);
        return view('delivery.edit', compact('delivery'));
    }

    public function updateStatus(Request $request, $id)
    {
        $delivery = Delivery::findOrFail($id);
        $delivery->status = $request->status;
        $delivery->save();

        return redirect()->route('delivery.index')->with('success', 'Delivery status updated');
    }

    public function cancelDelivery($id)
    {
        $delivery = Delivery::findOrFail($id);
        $delivery->status = 'Cancelled';
        $delivery->save();

        return redirect()->route('delivery.index')->with('success', 'Delivery cancelled');
    }


}