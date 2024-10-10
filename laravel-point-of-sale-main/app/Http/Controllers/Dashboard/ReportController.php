<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
// use App\Http\Controllers\Dashboard\Delivery;
use App\Models\Delivery;
use App\Models\Product;
use App\Models\Order;

class ReportController extends Controller
{
    /**
     * Display the product report page.
     */
    public function products()
    {
        // Fetch all products with their category
        $products = Product::with('category')->get();

        // Pass the products data to the view
        return view('reports.products', compact('products'));
    }

    /**
     * Display the sales report page.
     */
    // public function sales()
    // {
    //     return view('reports.sales');
    // }
    public function sales()
    {
        // Fetch all sales data from the orders table
        $sales = Order::with('customer') // Include related customer data if needed
            ->get();

        // Pass the sales data to the view
        return view('reports.sales', compact('sales'));
    }

    /**
     * Display the stock report page.
     */
    public function stock()
    {
        $products = Product::all(); 
        return view('reports.stock' , compact('products'));
    }

     /**
     * Display the stock report page.
     */
    public function deliveryReport()
    {
        // Retrieve all deliveries from the database
        $deliveries = Delivery::all();

        // Pass the deliveries data to the view
        return view('reports.deliveries', compact('deliveries'));
    }

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
    
        // Prepare details for display
        $details = [];
    
        // Loop through orders and calculate gross and net income
        foreach ($orders as $order) {
            foreach ($order->orderDetails as $item) {
                $quantity = $item->quantity;
                $sellingPrice = $item->unitcost; // Selling price
                $buyingPrice = $item->product->buying_price; // Assuming you have a buying price field in the products table
    
                // Calculate gross income and net income
                $grossIncome += ($sellingPrice * $quantity);
                $netIncome += (($sellingPrice - $buyingPrice) * $quantity);
    
                // Add details for this item
                $details[] = [
                    'product' => $item->product->product_name,
                    'quantity' => $quantity,
                    'selling_price' => $sellingPrice,
                    'buying_price' => $buyingPrice,
                    'total_selling' => $sellingPrice * $quantity,
                    'total_profit' => ($sellingPrice - $buyingPrice) * $quantity,
                ];
            }
        }
    
        // Pass values to the view
        return view('reports.income', compact('grossIncome', 'netIncome', 'details', 'startDate', 'endDate'));
    }
    


}
