<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Sample data
        $transactions = collect([
            ['date' => '2024-08-01', 'transaction_id' => 'T0001', 'product' => 'LPG Gas', 'quantity' => 10, 'amount' => 150],
            ['date' => '2024-08-02', 'transaction_id' => 'T0002', 'product' => 'Oxygen', 'quantity' => 5, 'amount' => 100],
            // Add more sample data as needed
        ]);

        // Pagination simulation
        $perPage = $request->input('row', 10);
        $currentPage = $request->input('page', 1);
        $offset = ($currentPage - 1) * $perPage;

        $paginatedTransactions = $transactions->slice($offset, $perPage);

        return view('transactions.index', [
            'transactions' => $paginatedTransactions,
        ]);
    }
}
