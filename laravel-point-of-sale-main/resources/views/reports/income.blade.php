@extends('dashboard.body.main')

@section('container')
<div class="container-fluid">
    <!-- Title -->
    <h1 class="text-center mb-4 no-print" style="font-family: 'Poppins', sans-serif;">Reports & Analytics</h1>

    <!-- Tab Navigation -->
    <div class="d-flex justify-content-center mb-4 flex-wrap">
        <a href="{{ route('reports.index') }}" class="btn report-tab no-print">
            <i class="fas fa-home"></i> Main Page
        </a>
        <a href="{{ route('reports.sales') }}" class="btn report-tab no-print">
            <i class="fas fa-chart-line"></i> Sales Report
        </a>
        <a href="{{ route('reports.stock') }}" class="btn report-tab no-print">
            <i class="fas fa-box"></i> Stock Report <!-- Changed to fa-box -->
        </a>
        <a href="{{ route('reports.income') }}" class="btn report-tab active no-print">
            <i class="fas fa-dollar-sign"></i> Income Report
        </a>
        <a href="{{ route('reports.products') }}" class="btn report-tab no-print">
            <i class="fas fa-box-open"></i> Products Report <!-- Changed to fa-box-open -->
        </a>
    </div>
    
    <div class="row">
        <div class="col-lg-12">
            <div class="d-flex flex-wrap align-items-center justify-content-between mb-4">
                <div>
                    <h3 class="mb-3">Net & Gross Income Report</h3>
                </div>
                <div>

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
    
    /* Hide elements for print */
    @media print {
        .no-print {
            display: none !important;
        }
    }

    /* Container for the buttons */
    .d-flex {
        display: flex;
        justify-content: center;
        gap: 15px;
        flex-wrap: wrap;
    }

    /* Smooth Transition Effects */
    .report-tab {
        background-color: #007BFF; /* Soft blue background */
        color: white;
        border-radius: 30px;
        padding: 12px 25px;
        font-size: 16px;
        margin: 8px;
        text-align: center;
        text-transform: uppercase; /* Make text all caps for uniformity */
        font-weight: 500; /* Slightly bolder text */
        transition: all 0.3s ease-in-out, box-shadow 0.2s ease, transform 0.2s ease; /* Added transitions */
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1); /* Add subtle shadow for depth */
        border: none;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px; /* Space between icon and text */
    }

    /* Active tab (highlighted) */
    .report-tab.active {
        background-color: #012a57; /* Darker blue */
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2); /* Darker shadow on active */
    }

    /* Hover effect with animation */
    .report-tab:hover {
        background-color: #0056b3; /* Darker blue on hover */
        transform: translateY(-3px); /* Slightly raise the button */
        color: white;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2); /* Deeper shadow on hover */
    }

    /* Adding icons styles */
    .report-tab i {
        font-size: 20px; /* Icon size */
        transition: transform 0.2s ease; /* Smooth icon transition */
    }

    .report-tab:hover i {
        transform: translateX(5px); /* Slight movement of the icon when hovering */
    }

    /* Flexbox layout for the buttons */
    .d-flex {
        display: flex;
        justify-content: center;
        gap: 15px;
        flex-wrap: wrap;
        margin-top: 20px;
    }

    /* Card Layout for Content (optional if you want to apply to other parts of the page) */
    .card {
        border-radius: 12px;
        background-color: #fff;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1); /* Elevation effect */
        padding: 20px;
        margin: 15px;
    }

    /* General Button Style */
    .btn {
        font-family: 'Poppins', sans-serif;
        border-radius: 30px;
        padding: 12px 25px;
        font-size: 16px;
    }

    /* Button active color */
    .btn-primary {
        background-color: #0066cc;
        border: none;
    }

    /* Buttons hover effects */
    .btn:hover {
        opacity: 0.9;
        transform: translateY(-2px); /* Slight upward movement */
    }

    /* For mobile responsiveness */
    @media (max-width: 768px) {
        .report-tab {
            font-size: 14px; /* Smaller font size on mobile */
            padding: 10px 18px; /* Adjust padding */
        }

        .report-tab i {
            font-size: 18px; /* Slightly smaller icons for smaller screens */
        }
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
