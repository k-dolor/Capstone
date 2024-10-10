<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;


class DashboardController extends Controller
{
    // public function index(){
    //     return view('dashboard.index', [
    //         'total_paid' => Order::sum('pay'),
    //         'total_due' => Order::sum('due'),
    //         'complete_orders' => Order::where('order_status', 'complete')->get(),
    //         'products' => Product::orderBy('product_store')->take(5)->get(),
    //         'new_products' => Product::orderBy('buying_date')->take(2)->get(),
    //     ]);
    
    // -------------------------------------------xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
//     public function index()
//     {
//         // Fetching totals and other relevant data
//         $totalPaid = Order::sum('pay');
//         $totalDue = Order::sum('due');
//         $completeOrders = Order::where('order_status', 'complete')->get();
//         $products = Product::orderBy('product_store')->take(5)->get();
//         $newProducts = Product::orderBy('buying_date')->take(2)->get();

//         // Prepare data for stock analysis chart
//         $labels = Product::pluck('product_name'); // Get product names for labels
//         $data = Product::pluck('product_store'); // Get stock quantities for data

//         return view('dashboard.index', [
//             'total_paid' => $totalPaid,
//             'total_due' => $totalDue,
//             'complete_orders' => $completeOrders,
//             'products' => $products,
//             'new_products' => $newProducts,
//             'labels' => $labels,
//             'data' => $data,
//         ]); 
//     }
// }

public function index()
{
    // Fetch totals and other relevant data
    $totalPaid = Order::sum('pay');
    $totalDue = Order::sum('due');
    $completeOrders = Order::where('order_status', 'complete')->get();
    $products = Product::orderBy('product_store')->take(5)->get();
    $newProducts = Product::orderBy('buying_date')->take(2)->get();

    // Prepare data for stock analysis chart
    $labels = Product::pluck('product_name'); // Product names
    $data = Product::pluck('product_store');  // Stock quantities

    // Prepare data for total sales per month for the current year
    $currentYear = now()->year;
    $monthlySales = Order::select(DB::raw('SUM(pay) as total_sales'), DB::raw('MONTH(created_at) as month'))
        ->whereYear('created_at', $currentYear)
        ->groupBy(DB::raw('MONTH(created_at)'))
        ->get();

    // Initialize sales data arrays for all months
    $salesData = array_fill(0, 12, 0); // Array of 12 months initialized to 0
    $salesLabels = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];

    foreach ($monthlySales as $sale) {
        $salesData[$sale->month - 1] = $sale->total_sales;  // Assign the sales to the correct month (0-based index)
    }

    return view('dashboard.index', [
        'total_paid' => $totalPaid,
        'total_due' => $totalDue,
        'complete_orders' => $completeOrders,
        'products' => $products,
        'new_products' => $newProducts,
        'labels' => $labels,
        'data' => $data,
        'salesLabels' => $salesLabels,
        'salesData' => $salesData,
    ]);
}
}