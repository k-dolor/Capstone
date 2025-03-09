<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
// use App\Http\Controllers\Dashboard\Delivery;
use App\Models\Delivery;
use App\Models\Product;
use App\Models\Order;
use App\Models\Category;
use Carbon\Carbon;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xls;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    /**
     * Display the product report page.
     */
    public function index()
    {
        // Get total sales for this month
        $thisMonthSales = DB::table('order_details')
            ->join('products', 'order_details.product_id', '=', 'products.id')
            ->select('products.product_name', DB::raw('SUM(order_details.quantity * order_details.unitcost) as total_sales'))
            ->whereMonth('order_details.created_at', Carbon::now()->month)
            ->whereYear('order_details.created_at', Carbon::now()->year)
            ->groupBy('products.product_name')
            ->get();
    
        // Get total sales for last month
        $lastMonthSales = DB::table('order_details')
            ->join('products', 'order_details.product_id', '=', 'products.id')
            ->select('products.product_name', DB::raw('SUM(order_details.quantity * order_details.unitcost) as total_sales'))
            ->whereMonth('order_details.created_at', Carbon::now()->subMonth()->month)
            ->whereYear('order_details.created_at', Carbon::now()->subMonth()->year)
            ->groupBy('products.product_name')
            ->get();
    
        // Get monthly sales data for the bar chart
        $monthlySales = DB::table('order_details')
            ->join('products', 'order_details.product_id', '=', 'products.id')
            ->join('orders', 'orders.id', '=', 'order_details.order_id')
            ->select(DB::raw('MONTH(orders.created_at) as month'), 
                     DB::raw('YEAR(orders.created_at) as year'),
                     'products.product_name as product_name', 
                     DB::raw('SUM(order_details.quantity * order_details.unitcost) as total_sales'))
            ->groupBy(DB::raw('YEAR(orders.created_at), MONTH(orders.created_at), products.product_name'))
            ->get();
    
        // Pass all necessary data to the view
        return view('reports.index', compact('thisMonthSales', 'lastMonthSales', 'monthlySales'));
    }
    
    

    
    public function products(Request $request)
{
    // Fetch the category filter from the request
    $categoryFilter = $request->input('category_filter');

    // Base query for products with their category
    $query = Product::with('category');

    // Apply category filter if selected
    if ($categoryFilter) {
        $query->whereHas('category', function ($q) use ($categoryFilter) {
            $q->where('id', $categoryFilter);
        });
    }

    // Fetch the filtered products
    $products = $query->get();

    // Fetch all categories for the filter dropdown
    $categories = Category::all();

    // Pass the products and categories data to the view
    return view('reports.products', compact('products', 'categories', 'categoryFilter'));
}

    public function sales(Request $request)
    {
        // Fetch filters from the request
        $filter = $request->input('filter'); // 'day', 'week', 'month', 'specific_day', 'specific_month'
        $specificDay = $request->input('specific_day');
        $specificMonth = $request->input('specific_month');
    
        // Base query for sales data
        $query = Order::with('customer');
    
        // Apply date filter based on the user's selection
        if ($filter == 'day') {
            // Filter for today
            $query->whereDate('order_date', Carbon::today());
        } elseif ($filter == 'week') {
            // Filter for this week
            $startOfWeek = Carbon::now()->startOfWeek();
            $endOfWeek = Carbon::now()->endOfWeek();
            $query->whereBetween('order_date', [$startOfWeek, $endOfWeek]);
        } elseif ($filter == 'month') {
            // Filter for this month
            $query->whereMonth('order_date', Carbon::now()->month);
        } elseif ($filter == 'specific_day' && $specificDay) {
            // Filter for specific day
            $query->whereDate('order_date', $specificDay);
        } elseif ($filter == 'specific_week' && $request->input('specific_week')) {
            // Filter for specific week
            $specificWeek = $request->input('specific_week');
            $startOfWeek = Carbon::parse($specificWeek . '-1')->startOfWeek();
            $endOfWeek = $startOfWeek->copy()->endOfWeek();
            $query->whereBetween('order_date', [$startOfWeek, $endOfWeek]);
        } elseif ($filter == 'specific_month' && $specificMonth) {
            // Filter for specific month
            $query->whereMonth('order_date', Carbon::parse($specificMonth)->month);
        }
    
        // Execute the query to get the sales data
        $sales = $query->get();
    
        // Pass sales data and filter type to the view
        return view('reports.sales', compact('sales', 'filter', 'specificDay', 'specificMonth'));
    }
    

    //===================================================================

public function exportSales(Request $request)
{
    ini_set('max_execution_time', 0);
    ini_set('memory_limit', '4000M');

    // Retrieve the filters from the request
    $filter = $request->input('filter');
    $specificDay = $request->input('specific_day');
    $specificWeek = $request->input('specific_week');
    $specificMonth = $request->input('specific_month');

    // Apply filters to fetch the sales data
    $query = Order::query();
    if ($filter === 'specific_day' && $specificDay) {
        $query->whereDate('order_date', $specificDay);
    } elseif ($filter === 'specific_week' && $specificWeek) {
        $startDate = date('Y-m-d', strtotime($specificWeek));
        $endDate = date('Y-m-d', strtotime('+6 days', strtotime($startDate)));
        $query->whereBetween('order_date', [$startDate, $endDate]);
    } elseif ($filter === 'specific_month' && $specificMonth) {
        $query->whereMonth('order_date', date('m', strtotime($specificMonth)))
              ->whereYear('order_date', date('Y', strtotime($specificMonth)));
    }
    $sales = $query->get();

    // Prepare data for export
    $salesData[] = ['Order Date', 'Total Amount', 'Payment Status', 'Order Status'];
    foreach ($sales as $sale) {
        $salesData[] = [
            $sale->order_date,
            $sale->total,
            ucfirst($sale->payment_status),
            ucfirst($sale->order_status),
        ];
    }

    // Export data to Excel
    try {
        $spreadsheet = new Spreadsheet();
        $spreadsheet->getActiveSheet()->getDefaultColumnDimension()->setWidth(20);
        $spreadsheet->getActiveSheet()->fromArray($salesData);
        $writer = new Xls($spreadsheet);

        // Set headers for download
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Sales_Report.xls"');
        header('Cache-Control: max-age=0');
        ob_end_clean();
        $writer->save('php://output');
        exit();
    } catch (\Exception $e) {
        return redirect()->back()->withErrors('Error exporting sales data.');
    }
}
//=============================================================================================



    /**
     * Display the stock report page.
     */

    public function stockReport(Request $request)
{
    $query = Product::query();

    if ($request->has('stock_filter')) {
        $filter = $request->stock_filter;
        if ($filter === 'low_stock') {
            $query->where('product_store', '>', 0)->where('product_store', '<', 10);
        } elseif ($filter === 'out_of_stock') {
            $query->where('product_store', '<=', 0);
        } elseif ($filter === 'in_stock') {
            $query->where('product_store', '>=', 10);
        }
    }

    $products = $query->get();

    return view('reports.stock', compact('products'));
}


    // public function incomeReport(Request $request)
    // {
    //     // Retrieve the start and end dates from the request
    //     $startDate = $request->input('start_date');
    //     $endDate = $request->input('end_date');
    
    //     // Query the orders based on the date range
    //     $query = Order::with('orderDetails.product');
    
    //     if ($startDate && $endDate) {
    //         $query->whereBetween('order_date', [$startDate, $endDate]);
    //     }
    
    //     $orders = $query->get();
    
    //     $grossIncome = 0;
    //     $netIncome = 0;
    
    //     // Prepare details for display
    //     $details = [];
    
    //     // Loop through orders and calculate gross and net income
    //     foreach ($orders as $order) {
    //         foreach ($order->orderDetails as $item) {
    //             $quantity = $item->quantity;
    //             $sellingPrice = $item->unitcost; // Selling price
    //             $buyingPrice = $item->product->buying_price; // Assuming you have a buying price field in the products table
    
    //             // Calculate gross income and net income
    //             $grossIncome += ($sellingPrice * $quantity);
    //             $netIncome += (($sellingPrice - $buyingPrice) * $quantity);
    
    //             // Add details for this item
    //             $details[] = [
    //                 'product' => $item->product->product_name,
    //                 'quantity' => $quantity,
    //                 'selling_price' => $sellingPrice,
    //                 'buying_price' => $buyingPrice,
    //                 'total_selling' => $sellingPrice * $quantity,
    //                 'total_profit' => ($sellingPrice - $buyingPrice) * $quantity,
    //             ];
    //         }
    //     }
    
    //     // Pass values to the view
    //     return view('reports.income', compact('grossIncome', 'netIncome', 'details', 'startDate', 'endDate'));
    // }

    public function incomeReport(Request $request) 
{
    // Retrieve the start and end dates from the request
    $startDate = $request->input('start_date');
    $endDate = $request->input('end_date');

    // Query the orders based on the date range
    $query = Order::with('orderDetails.product');

    if ($startDate && $endDate) {
        $query->whereBetween('order_date', [$startDate, $endDate]);
    }

    $orders = $query->get();

    $grossIncome = 0;
    $netIncome = 0;

    // Grouping sales details by product
    $details = [];

    // Loop through orders and calculate gross and net income
    foreach ($orders as $order) {
        foreach ($order->orderDetails as $item) {
            $productName = $item->product->product_name;
            $quantity = $item->quantity;
            $sellingPrice = $item->unitcost; // Selling price
            $buyingPrice = $item->product->buying_price; // Buying price from the product table

            // Calculate total selling and total profit for the current order detail
            $totalSelling = $sellingPrice * $quantity;
            $totalProfit = ($sellingPrice - $buyingPrice) * $quantity;

            // Add to the total gross and net income
            $grossIncome += $totalSelling;
            $netIncome += $totalProfit;

            // Group by product name
            if (!isset($details[$productName])) {
                $details[$productName] = [
                    'product' => $productName,
                    'quantity' => 0,
                    'selling_price' => $sellingPrice,
                    'buying_price' => $buyingPrice,
                    'total_selling' => 0,
                    'total_profit' => 0,
                ];
            }

            // Aggregate totals
            $details[$productName]['quantity'] += $quantity;
            $details[$productName]['total_selling'] += $totalSelling;
            $details[$productName]['total_profit'] += $totalProfit;
        }
    }

    // Convert details to an array for the Blade template
    $details = array_values($details);

    // Pass values to the view
    return view('reports.income', compact('grossIncome', 'netIncome', 'details', 'startDate', 'endDate'));
}

    
    


}
