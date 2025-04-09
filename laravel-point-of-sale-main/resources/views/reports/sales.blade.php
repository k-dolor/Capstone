@extends('dashboard.body.main')

@section('container')

<style>
        /* Font and container */
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap');

    h1 {
        font-size: 2.5rem;
        font-weight: 600;
        color: #1e1e2f;
    }

    /* Modern Tabs */
    .report-tab {
        margin: 0.5rem;
        padding: 0.75rem 1.5rem;
        border: none;
        border-radius: 12px;
        background: rgba(255, 255, 255, 0.7);
        backdrop-filter: blur(8px);
        color: #1e1e2f;
        font-weight: 500;
        font-size: 1rem;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        transition: all 0.3s ease;
        text-decoration: none;
    }

    .report-tab:hover,
    .report-tab.active {
        background-color: #1e1e2f;
        color: #fff;
        font-weight: 600;
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
        background: #000;
    }

    .modern-btn-secondary {
        background: #616161;
        color: white;
        border: none;
        padding: 0.5rem 1rem;
        border-radius: 6px;
    }

    .modern-btn-warning {
        background-color: #ff8400;
        color: white;
        padding: 0.5rem 1rem;
        border-radius: 6px;
        border: none;
    }

    .modern-btn-dark {
        background-color: #16161f;
        color: white;
        padding: 0.5rem 1rem;
        border-radius: 6px;
        border: none;
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

    /* Filter Group Styling */
    .filter-block {
        display: flex;
        align-items: center;
        gap: 5px;
    }

     /* Styling for the labels and inputs */
     .filter-group {
        display: flex;
        align-items: center;
        gap: 15px;
        /* margin-bottom: 10px; */
    }

    .filter-group label {
        font-size: 15px;
        /* font-weight: bold; */
        width: 120px; /* Adjust the width of the label */
        text-align: left; /* Align the label to the right */
    }

    .filter-group input {
        width: 150px; /* Set a fixed width for the input fields */
        font-size: 14px;
        padding: 5px 10px;
    }

    /* Hide input fields by default */
    .filter-group {
        display: none;
    }

    /* Card + Table */
    .modern-card {
        border: 1px solid #e1e5ec;
        border-radius: 10px;
        box-shadow: 0 3px 8px rgba(0, 0, 0, 0.05);
    }

    .modern-table thead {
        background-color: #f1f3f7;
        font-weight: 600;
    }
    /* Payment Status Styles */
    .badge-status {
        background-color: #059511ef !important;
        color: #ffffff !important;
        font-weight: bolder !important;
        padding: 8px 10px;
        border-radius: 3px !important;
        font-size: 15px !important;
        text-transform: capitalize !important; /* Capitalize text */
    }

    @media print {
        .no-print {
            display: none !important;
        }
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
        <a href="{{ route('reports.sales') }}" class="btn report-tab active no-print">
            <i class="fas fa-chart-line"></i> Sales Report
        </a>
        <a href="{{ route('reports.stock') }}" class="btn report-tab no-print">
            <i class="fas fa-box"></i> Stock Report
        </a>
        <a href="{{ route('reports.income') }}" class="btn report-tab no-print">
            <i class="fas fa-dollar-sign"></i> Income Report
        </a>
        <a href="{{ route('reports.products') }}" class="btn report-tab no-print">
            <i class="fas fa-box-open"></i> Products Report
        </a>
    </div>

    <div class="row">
        <div class="col-lg-12">

            <div class="d-flex align-items-center justify-content-between flex-wrap mb-4 gap-3">

                <h3 class="section-heading">Sales Report</h3>

                <form action="{{ route('reports.sales') }}" method="GET" class="d-flex gap-3 flex-wrap align-items-center no-print">
                    <div class="filter-block">
                        <label for="filter">Filter by:</label>
                        <select name="filter" id="filter" class="form-select modern-select">
                            <option value="" disabled selected>Select Filter</option>
                            <option value="day" {{ request('filter') === 'day' ? 'selected' : '' }}>Today</option>
                            <option value="week" {{ request('filter') === 'week' ? 'selected' : '' }}>This Week</option>
                            <option value="month" {{ request('filter') === 'month' ? 'selected' : '' }}>This Month</option>
                            <option value="specific_day" {{ request('filter') === 'specific_day' ? 'selected' : '' }}>Specific Day</option>
                            <option value="specific_week" {{ request('filter') === 'specific_week' ? 'selected' : '' }}>Specific Week</option>
                            <option value="specific_month" {{ request('filter') === 'specific_month' ? 'selected' : '' }}>Specific Month</option>
                        </select>
                    </div>

                    <div class="filter-group" id="specificDayInput">
                        <label for="specific_day">Select Day:</label>
                        <input type="date" name="specific_day" id="specific_day" class="form-control modern-input" value="{{ request('specific_day') }}">
                    </div>

                    <div class="filter-group" id="specificWeekInput">
                        <label for="specific_week">Select Week:</label>
                        <input type="week" name="specific_week" id="specific_week" class="form-control modern-input" value="{{ request('specific_week') }}">
                    </div>

                    <div class="filter-group" id="specificMonthInput">
                        <label for="specific_month">Select Month:</label>
                        <input type="month" name="specific_month" id="specific_month" class="form-control modern-input" value="{{ request('specific_month') }}">
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn modern-btn-primary">Filter</button>
                        <a href="{{ route('reports.sales') }}" class="btn modern-btn-secondary">Clear</a>
                    </div>
                </form>

                {{-- <div class="d-flex gap-2">
                    <button class="btn modern-btn-dark no-print" onclick="window.print()">Print</button>
                    <a href="{{ route('sales.exportData', request()->all()) }}" class="btn modern-btn-warning no-print">Export</a>
                </div> --}}
                <div class="d-flex gap-2 no-print">
                    <button class="modern-btn-dark" onclick="window.print()">
                        <i class="fas fa-print"></i> Print
                    </button>
                    <a href="{{ route('sales.exportData', request()->all()) }}" class="btn modern-btn-warning no-print">
                        <i class="fas fa-file-export"></i> Export
                    </a>
                </div>
            </div>
            
            <!-- Display Filtered Date -->
            <div class="mb-4">
                @if(request('filter') == 'day')
                    <p class="text-center font-weight-bold" style="font-size: 1.5rem;">{{ \Carbon\Carbon::today()->format('F j, Y') }}</p>
                @elseif(request('filter') == 'week')
                    <p class="text-center font-weight-bold" style="font-size: 1.5rem;">{{ \Carbon\Carbon::now()->startOfWeek()->format('F j, Y') }} to {{ \Carbon\Carbon::now()->endOfWeek()->format('F j, Y') }}</p>
                @elseif(request('filter') == 'month')
                    <p class="text-center font-weight-bold" style="font-size: 1.5rem;">{{ \Carbon\Carbon::now()->startOfMonth()->format('F Y') }} to {{ \Carbon\Carbon::now()->endOfMonth()->format('F Y') }}</p>
                @elseif(request('filter') == 'specific_day' && request('specific_day'))
                    <p class="text-center font-weight-bold" style="font-size: 1.5rem;">{{ \Carbon\Carbon::parse(request('specific_day'))->format('F j, Y') }}</p>
                @elseif(request('filter') == 'specific_week' && request('specific_week'))
                    <p class="text-center font-weight-bold" style="font-size: 1.5rem;">{{ \Carbon\Carbon::parse(request('specific_week').'-1')->format('F j, Y') }} to {{ \Carbon\Carbon::parse(request('specific_week').'-7')->format('F j, Y') }}</p>
                @elseif(request('filter') == 'specific_month' && request('specific_month'))
                    <p class="text-center font-weight-bold" style="font-size: 1.5rem;">{{ \Carbon\Carbon::parse(request('specific_month').'-01')->format('F Y') }}</p>
                @endif
            </div>



            <!-- Sales Table -->
            <div class="card modern-card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped modern-table">
                            <thead>
                                <tr>
                                    <th>Order Date</th>
                                    <th>Total Amount</th>
                                    <th>Payment Type</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($sales as $sale)
                                    <tr>
                                        <td>{{ $sale->order_date }}</td>
                                        <td>₱{{ number_format($sale->total, 2) }}</td>
                                        <td>{{ ucfirst($sale->payment_status) }}</td>
                                        <td>
                                            @if ($sale->order_status == 'pending')
                                            <span class="badge bg-warning">Pending</span>
                                            @elseif ($sale->order_status == 'complete')
                                                <span class="badge-status">COMPLETE</span>
                                            @else
                                                <span class="badge bg-secondary">{{ ucfirst($sale->order_status) }}</span>
                                            @endif                                      
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center">No sales data available for the selected period.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                <!-- Pagination Links -->
                <div class="pagination-wrapper text-center">
                    {{ $sales->links() }}
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const filterSelect = document.getElementById('filter');
        const specificDayInput = document.getElementById('specificDayInput');
        const specificWeekInput = document.getElementById('specificWeekInput');
        const specificMonthInput = document.getElementById('specificMonthInput');

        function toggleFilterInputs() {
            specificDayInput.style.display = 'none';
            specificWeekInput.style.display = 'none';
            specificMonthInput.style.display = 'none';

            if (filterSelect.value === 'specific_day') {
                specificDayInput.style.display = 'flex';
            } else if (filterSelect.value === 'specific_week') {
                specificWeekInput.style.display = 'flex';
            } else if (filterSelect.value === 'specific_month') {
                specificMonthInput.style.display = 'flex';
            }
        }

        filterSelect.addEventListener('change', toggleFilterInputs);
        toggleFilterInputs();
    });
</script>

@endsection