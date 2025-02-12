<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Order;
use App\Models\Product;
use App\Models\Notification;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;


class DashboardController extends Controller
{



public function index()
{
    // Fetch totals and other relevant data
    $totalPaid = Order::sum('pay');
    $totalDue = Order::sum('due');
    $completeOrders = Order::where('order_status', 'complete')->get();
    $products = Product::orderBy('product_store')->take(5)->get();
    $newProducts = Product::orderBy('buying_date')->take(2)->get();

    // Calculate total number of products
    $totalProducts = Product::count(); // Count the total number of products

    

    // Prepare data for stock analysis chart
$labels = Product::pluck('product_name'); // Product names
$data = Product::pluck('product_store'); // Stock quantities

// Generate colors dynamically based on the number of labels
$colors = collect($labels)->map(function () {
    return sprintf('#%06X', mt_rand(0, 0xFFFFFF)); // Random hex color
});
 // Fetch stock data for the donut chart
 $stockData = Product::select('product_name', 'product_store')->get();
 $stockLabels = $stockData->pluck('product_name');
 $stockValues = $stockData->pluck('product_store');

 // Prepare data for total sales per month for the current year
 $currentYear = now()->year;
 $monthlySales = Order::select(DB::raw('SUM(total) as total_sales'), DB::raw('MONTH(created_at) as month'))
     ->whereYear('created_at', $currentYear)
     ->groupBy(DB::raw('MONTH(created_at)'))
     ->get();

 // Initialize sales data arrays for all months
 $salesData = array_fill(0, 12, 0); // Array of 12 months initialized to 0
 $salesLabels = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];

 foreach ($monthlySales as $sale) {
     $salesData[$sale->month - 1] = $sale->total_sales;  // Assign the sales to the correct month (0-based index)
 }

 // Prepare data for total sales for the current month
 $currentMonth = now()->month;
 $dailySales = Order::select(DB::raw('SUM(total) as total_sales'), DB::raw('DAY(created_at) as day'))
     ->whereYear('created_at', $currentYear)
     ->whereMonth('created_at', $currentMonth)
     ->groupBy(DB::raw('DAY(created_at)'))
     ->get();

 // Initialize sales data arrays for all days in the current month
 $monthlySalesData = array_fill(0, now()->daysInMonth, 0); // Array of days in the current month initialized to 0
 $monthlySalesLabels = range(1, now()->daysInMonth); // Array of day numbers

 foreach ($dailySales as $sale) {
     $monthlySalesData[$sale->day - 1] = $sale->total_sales;  // Assign the sales to the correct day (0-based index)
 }

 // Prepare data for total sales for the previous month
 $previousMonth = now()->subMonth()->month;
 $previousMonthSales = Order::select(DB::raw('SUM(total) as total_sales'), DB::raw('DAY(created_at) as day'))
     ->whereYear('created_at', $currentYear)
     ->whereMonth('created_at', $previousMonth)
     ->groupBy(DB::raw('DAY(created_at)'))
     ->get();

 // Initialize sales data arrays for all days in the previous month
 $previousMonthDays = now()->subMonth()->daysInMonth;
 $previousMonthSalesData = array_fill(0, $previousMonthDays, 0); // Array of days in the previous month initialized to 0
 $previousMonthSalesLabels = range(1, $previousMonthDays); // Array of day numbers

 foreach ($previousMonthSales as $sale) {
     $previousMonthSalesData[$sale->day - 1] = $sale->total_sales;  // Assign the sales to the correct day (0-based index)
 }

 // Prepare data for total sales for the current week
 $currentWeek = now()->weekOfYear;
 $weeklySales = Order::select(DB::raw('SUM(total) as total_sales'), DB::raw('DAYOFWEEK(created_at) as day'))
     ->whereYear('created_at', $currentYear)
     ->where(DB::raw('WEEKOFYEAR(created_at)'), $currentWeek)
     ->groupBy(DB::raw('DAYOFWEEK(created_at)'))
     ->get();

 // Initialize sales data arrays for all days in the current week
 $weeklySalesData = array_fill(0, 7, 0); // Array of 7 days initialized to 0
 $weeklySalesLabels = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];

 foreach ($weeklySales as $sale) {
     $weeklySalesData[$sale->day - 1] = $sale->total_sales;  // Assign the sales to the correct day (0-based index)
 }

 return view('dashboard.index', [
     'total_paid' => $totalPaid,
     'total_due' => $totalDue,
     'complete_orders' => $completeOrders,
     'products' => $products,
     'new_products' => $newProducts,
     'total_products' => $totalProducts, // Pass total products to view
     'salesLabels' => $salesLabels,
     'salesData' => $salesData,
     'monthlySalesLabels' => $monthlySalesLabels,
     'monthlySalesData' => $monthlySalesData,
     'previousMonthSalesLabels' => $previousMonthSalesLabels,
     'previousMonthSalesData' => $previousMonthSalesData,
     'weeklySalesLabels' => $weeklySalesLabels,
     'weeklySalesData' => $weeklySalesData,
     'stockLabels' => $stockLabels,
     'stockValues' => $stockValues,
 ]);
}
}