@extends('dashboard.body.main')

@section('container') 
<div class="container">
    
    <h1 class="text-center mb-4 no-print" style="font-family: 'Poppins', sans-serif;">Reports & Analytics</h1>

    <!-- Tab Navigation -->
    <div class="d-flex justify-content-center mb-4">
        <a href="{{ route('reports.index') }}" class="btn report-tab no-print">Main Page</a>
        <a href="{{ route('reports.sales') }}" class="btn report-tab no-print">Sales Report</a>
        <a href="{{ route('reports.stock') }}" class="btn report-tab no-print">Stock Report</a>
        <a href="{{ route('reports.income') }}" class="btn report-tab active no-print">Income Report</a>
        <a href="{{ route('reports.products') }}" class="btn report-tab no-print">Products Report</a>
    </div>
    
    {{-- <h3 class="text-center mb-4" style="font-family: 'Poppins', sans-serif; font-weight: 600;">Net and Gross Income Report</h3> --}}
    <h3 class="text- mb-4" style="font-family: 'Poppins';"> Net and Gross Income Report</h3>

        <!-- Print Button (Aligned Right) -->
        <div class="d-flex justify-content-end gap-2 no-print">
            <button class="btn" style="background-color: #3a33ff; color: white;height: 38px; padding: 0 20px; font-size: 14px; display: flex; align-items: center; justify-content: center; border-radius: 1px;" onclick="window.print()">Print</button>
        </div>

    <!-- Date Picker Form -->
    <form method="GET" action="{{ route('reports.income') }}" class="row justify-content-center align-items-end mb-4">
        <div class="col-md-3 no-print">
            <label for="start_date" class="form-label">Start Date:</label>
            <input type="text" id="start_date" name="start_date" class="form-control datepicker no-print" value="{{ request('start_date') }}">
        </div>
        <div class="col-md-3 no-print">
            <label for="end_date" class="form-label">End Date:</label>
            <input type="text" id="end_date" name="end_date" class="form-control datepicker no-print" value="{{ request('end_date') }}">
        </div>
        <div class="col-md-2 d-flex">
            <button type="submit" class="btn btn-primary w-100 filter-btn no-print"><i class="fas fa-filter"></i> Filter</button>
        </div>
        <div class="col-md-2 d-flex">
            <a href="{{ route('reports.income') }}" class="btn btn-secondary w-100 clear-btn no-print"><i class="fas fa-sync"></i> Clear</a>
        </div>
    </form>

    <!-- Summary Section -->
    <div class="row justify-content-center mb-3">
        <div class="col-md-4">
            <div class="card summary-card shadow-sm">
                <div class="card-body text-center">
                    <h4>Gross Income</h4>
                    <p class="summary-amount">₱{{ number_format($grossIncome, 2) }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card summary-card shadow-sm">
                <div class="card-body text-center">
                    <h4>Net Income</h4>
                    <p class="summary-amount">₱{{ number_format($netIncome, 2) }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Income Report Details Table -->
    <div class="card shadow-sm p-4">
        <h4 class="mb-3">Income Breakdown</h4>
        <div class="table-responsive">
            <table class="table table-hover table-bordered text-center">
                <thead class="table-dark">
                    <tr>
                        <th>Product</th>
                        <th>Quantity Sold</th>
                        <th>Selling Price (₱)</th>
                        <th>Buying Price (₱)</th>
                        <th>Total Sales (₱)</th>
                        <th>Total Profit (₱)</th>
                        <th>Profit Margin (%)</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $totalSales = 0;
                        $totalProfit = 0;
                    @endphp
                    @foreach($details as $detail)
                        @php
                            $totalSales += $detail['total_selling'];
                            $totalProfit += $detail['total_profit'];
                            $profitMargin = ($detail['total_profit'] / $detail['total_selling']) * 100;
                        @endphp
                        <tr>
                            <td>{{ $detail['product'] }}</td>
                            <td>{{ $detail['quantity'] }}</td>
                            <td>₱{{ number_format($detail['selling_price'], 2) }}</td>
                            <td>₱{{ number_format($detail['buying_price'], 2) }}</td>
                            <td>₱{{ number_format($detail['total_selling'], 2) }}</td>
                            <td>₱{{ number_format($detail['total_profit'], 2) }}</td>
                            <td>{{ number_format($profitMargin, 2) }}%</td>
                        </tr>
                    @endforeach
                
                    <!-- Calculate Total Profit Margin -->
                    @php
                        $totalProfitMargin = ($totalSales > 0) ? ($totalProfit / $totalSales) * 100 : 0;
                    @endphp
                
                    <tr class="table-warning">
                        <td colspan="4" class="text-end"><strong>Total:</strong></td>
                        <td><strong>₱{{ number_format($totalSales, 2) }}</strong></td>
                        <td><strong>₱{{ number_format($totalProfit, 2) }}</strong></td>
                        <td><strong>{{ number_format($totalProfitMargin, 2) }}%</strong></td>
                    </tr>
                </tbody>
                
            </table>
        </div>
    </div>

    <!-- Back Button -->
    <div class="text-center mt-4">
        <a href="{{ route('dashboard') }}" class="btn btn-secondary no-print">Back to Dashboard</a>
    </div>
</div>

<!-- Flatpickr CSS and JS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

<script>
    // Initialize Flatpickr
    flatpickr(".datepicker", {
        dateFormat: "Y-m-d",
        allowInput: true
    });
</script>

<style>
     @media print {
        .no-print {
            display: none !important;
        }
    }
    /* Tab Styling */
    .report-tab {
        background-color: #1E90FF;
        color: white;
        border-radius: 30px;
        padding: 10px 20px;
        font-size: 15px;
        margin: 5px;
        transition: all 0.3s ease-in-out;
    }

    .report-tab:hover {
        background-color: #004080;
        color: white;
        transform: scale(1.05);
    }

    .report-tab.active {
        background-color: #003459;
    }

    /* Summary Card Styling */
    .summary-card {
        background: linear-gradient(135deg, #1E90FF, #003459);
        color: white;
        border-radius: 15px;
        padding: 20px;
        text-align: center;
    }

    .summary-amount {
        font-size: 24px;
        font-weight: bold;
    }

    /* Print Button Styling */
    .print-btn {
        background-color: #4843d1;
        color: white;
        font-weight: 600;
        padding: 10px 20px;
        border-radius: 8px;
        transition: all 0.3s ease-in-out;
    }

    .print-btn:hover {
        background-color: #ff651e;
        color: white;
        transform: scale(1.03);
    }

    /* Date Picker Styling */
    .datepicker {
        border: 2px solid #1E90FF;
        border-radius: 8px;
        padding: 12px;
        font-size: 16px;
        text-align: center;
        width: 100%;
    }

    .datepicker:focus {
        border-color: #003459;
        box-shadow: 0 0 8px rgba(30, 144, 255, 0.5);
    }

    /* Filter and Clear Buttons */
    .filter-btn, .clear-btn {
        font-size: 16px;
        padding: 12px;
        border-radius: 8px;
    }

    .clear-btn {
        background-color: #dc3545;
        color: white;
    }

    .clear-btn:hover {
        background-color: #b02a37;
        transform: scale(1.05);
    }
</style>
@endsection
