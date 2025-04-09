@extends('dashboard.body.main')

@section('container')

<style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap');

    h1 {
        font-size: 2.5rem;
        font-weight: 600;
        color: #1e1e2f;
    }

    .report-tab {
        margin: 0.5rem;
        padding: 0.75rem 1.5rem;
        border: none;
        border-radius: 12px;
        background: rgba(255, 255, 255, 0.7);
        backdrop-filter: blur(8px);
        -webkit-backdrop-filter: blur(8px);
        color: #1e1e2f;
        font-weight: 500;
        font-size: 1rem;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        transition: all 0.3s ease;
    }

    .report-tab:hover,
    .report-tab.active {
        background-color: #1e1e2f;
        color: #fff;
        font-weight: 600;
    }

      /* Responsive Flex Wrap Handling */
      @media (max-width: 768px) {
        .report-tab {
            flex: 1 1 100%;
            justify-content: center;
        }
    }
 /* Buttons */
    .modern-btn-primary {
        background: #0b0bf8 !important;
        color: white;
        border: none;
        padding: 0.5rem 1rem;
        border-radius: 6px;
        transition: 0.3s ease;
    }

    .modern-btn-primary:hover {
        background-color: #000288 !important;
        color: rgb(255, 255, 255);
        transform: scale(1.05) !important;
    }

    .modern-btn-secondary {
        background: #616161;
        color: white;
        border: none;
        padding: 0.5rem 1rem;
        border-radius: 6px;
    }

    .modern-btn-secondary:hover {
        background-color: #21212a !important;
        color: rgb(255, 255, 255);
        transform: scale(1.05) !important;
    }

    .modern-btn-warning {
        background-color: #ff8400;
        color: white;
        padding: 0.5rem 1rem;
        border-radius: 6px;
        border: none;
    }
    .modern-btn-warning:hover {
        background-color: #ffffff;
        color: rgb(0, 0, 0);
        transform: scale(1.05) !important;
    }

    .modern-btn-dark {
        background-color: #16161f;
        color: white;
        padding: 0.5rem 1rem;
        border-radius: 6px;
        border: none;
    }

    .modern-btn-dark:hover {
        background-color: #ffffff;
        color: rgb(0, 0, 0);
        transform: scale(1.03) !important;
    }

    /* Select & Input */
    .modern-select,
    .modern-input {
        height: 38px;
        padding: 5px 10px;
        font-size: 14px;
        border: 1px solid #ccc;
        border-radius: 6px;
    }
    @media print {
        .no-print {
            display: none !important;
        }
    }

    /*FILTER AND DATE PICKER */
    /* Summary Card Styling */
    .summary-card {
        background: linear-gradient(135deg, #1E90FF, #003459);
        color: white;
        border-radius: 15px;
        padding: 10px;
        text-align: center;
        width: 100%;
        height: 70%;
    }

    .summary-amount {
        font-size: 24px;
        font-weight: bold;
    }

    /* Date Picker Styling */
    .datepicker {
        border: 2px solid #1E90FF;
        border-radius: 8px;
        padding: 7px;
        font-size: 16px;
        text-align: center;
        width: 100%;
        height: 15% !important;
    }

    .datepicker:focus {
        border-color: #003459;
        box-shadow: 0 0 8px rgba(30, 144, 255, 0.5);
    }
</style>


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
                    <h3 class="mb-2">Net & Gross Income Report</h3>
                </div>
               

        <!-- Print Button (Aligned Right) -->
        <div class="d-flex justify-content-end gap-2 no-print">           
            <button class="modern-btn-dark" onclick="window.print()">
                <i class="fas fa-print"></i> Print
            </button>
            <a href="{{ route('reports.export.stock', request()->query()) }}" class="modern-btn-warning">
                <i class="fas fa-file-export"></i> Export
            </a>
        </div>
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
        <div class="d-flex gap-2">
            <button type="submit" class="btn modern-btn-primary no-print">Filter</button>
            <a href="{{ route('reports.income') }}" class="btn modern-btn-secondary no-print">Clear</a>
        </div>
    </form>

    </form>

    <!-- Summary Section -->
    <div class="row justify-content-center mb-0">
        <div class="col-md-6">
            <div class="card summary-card shadow-sm">
                <div class="card-body text-center">
                    <h4>Gross Income</h4>
                    <p class="summary-amount">₱{{ number_format($grossIncome, 2) }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-6">
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

@endsection
