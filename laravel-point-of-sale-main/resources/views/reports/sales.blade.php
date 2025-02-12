@extends('dashboard.body.main')

@section('container')

<div class="container-fluid">
     <!-- Title -->
     <h1 class="text-center mb-4" style="font-family: 'Poppins', sans-serif;">Reports & Analytics</h1>

    <!-- Tab Navigation -->
    <div class="d-flex justify-content-center mb-4">
        <a href="{{ route('reports.index') }}" class="btn mx-2" style="background-color: #FB8500; color: #ffffff; border: none;">Main Page</a> <!-- Powder Blue -->
        <a href="{{ route('reports.sales') }}" class="btn mx-2" style="background-color: #B0E0E6; color: #000; border: none;">Sales Report</a> <!-- Light Sky Blue -->
        <a href="{{ route('reports.stock') }}" class="btn mx-2" style="background-color: #4682B4; color: #fff; border: none;">Stock Report</a> <!-- Steel Blue -->
        <a href="{{ route('reports.income') }}" class="btn mx-2" style="background-color: #1E90FF; color: #fff; border: none;">Income Report</a> <!-- Dodger Blue -->
        <a href="{{ route('reports.products') }}" class="btn mx-2" style="background-color: #003459; color: #fff; border: none;">Products Report</a> <!-- Dark Blue -->
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="d-flex align-items-center justify-content-between mb-4">
                <h3 class="mb-3">Sales Report</h3>
                    


       <!-- Centered Filter Form -->
    <div class="d-flex flex-grow-1 justify-content-center">
        <form action="{{ route('reports.sales') }}" method="GET" class="d-flex gap-3 flex-wrap">
            <div style="display: flex; gap: 5px;">
                <label for="filter" style="white-space: nowrap;">Filter by:</label>
                <select name="filter" id="filter" class="form-select" style="height: 38px; width: 140px; padding: 5px 10px; font-size: 14px; border-radius: 0px; border: 1px solid #ccc;">
                    <option value="" disabled selected>Select Filter</option>
                    <option value="day" {{ request('filter') === 'day' ? 'selected' : '' }}>Today</option>
                    <option value="week" {{ request('filter') === 'week' ? 'selected' : '' }}>This Week</option>
                    <option value="month" {{ request('filter') === 'month' ? 'selected' : '' }}>This Month</option>
                    <option value="specific_day" {{ request('filter') === 'specific_day' ? 'selected' : '' }}>Specific Day</option>
                    <option value="specific_week" {{ request('filter') === 'specific_week' ? 'selected' : '' }}>Specific Week</option>
                    <option value="specific_month" {{ request('filter') === 'specific_month' ? 'selected' : '' }}>Specific Month</option>
                </select>
            </div>

            <!-- Specific Day Input -->
            <div class="filter-group" id="specificDayInput" style="display: none; margin-left: 10px;">
              <div class="d-flex align-items-center">
                 <label for="specific_day" class="form-label me-2">Select Day:</label>
                  <input type="date" name="specific_day" id="specific_day" class="form-control" style="margin-left: 5px;" value="{{ request('specific_day') }}">
              </div>
            </div>

            <!-- Specific Week Input -->
            <div class="filter-group" id="specificWeekInput" style="display: none; margin-left: 10px;">
              <div class="d-flex align-items-center">
                  <label for="specific_week" class="form-label me-2">Select Week:</label>
                   <input type="week" name="specific_week" id="specific_week" class="form-control" style="margin-left: 5px;" value="{{ request('specific_week') }}">
              </div>
            </div>

            <!-- Specific Month Input -->
            <div class="filter-group" id="specificMonthInput" style="display: none; margin-left: 10px;">
                <div class="d-flex align-items-center">
                 <label for="specific_month" class="form-label me-2">Select Month:</label>
                  <input type="month" name="specific_month" id="specific_month" class="form-control" style="margin-left: 5px;" value="{{ request('specific_month') }}">
              </div>
            </div>  
                 
            <!-- Search Button -->
            <div style="display: flex; gap: 0;">
                <button type="submit" class="btn btn-primary" style="height: 38px; padding: 0 10px; font-size: 14px; border-radius: 0px;">Filter</button>
                <a href="{{ route('reports.sales') }}" class="btn btn-secondary" style="height: 38px; padding: 0 20px; font-size: 14px; border-radius: 0px; display: flex; align-items: center; justify-content: center;">Clear</a>
            </div>
            
             </form>
        </div>

        <!-- Print and Export Buttons -->
<div style="display: flex; gap: 0;">
     <button class="btn" style="background-color: #3a33ff; color: white;height: 38px; padding: 0 20px; font-size: 14px; display: flex; align-items: center; justify-content: center; border-radius: 1px;" onclick="window.print()">Print</button>
    <a href="{{ route('sales.exportData', ['filter' => request('filter'), 'specific_day' => request('specific_day'), 'specific_week' => request('specific_week'), 'specific_month' => request('specific_month')]) }}" class="btn btn-primary" style="background-color: #ff8400; height: 38px; padding: 0 20px; font-size: 14px; display: flex; align-items: center; justify-content: center;border-radius: 1px;">Export</a>
</div>

</div>

 <!-- Displaying Date Range -->
 <div id="dateDisplay" class="mb-4 mt-4 text-center">
    @if(request('filter') == 'day')
        <h3>{{ \Carbon\Carbon::today()->format('F j, Y') }}</h3>
    @elseif(request('filter') == 'week')
        @php
            $weekStart = \Carbon\Carbon::now()->startOfWeek();
            $weekEnd = $weekStart->copy()->endOfWeek();
        @endphp
        <h3>{{ $weekStart->format('F j, Y') }} - {{ $weekEnd->format('F j, Y') }}</h3>
    @elseif(request('filter') == 'month')
        @php
            $currentMonth = \Carbon\Carbon::now();
        @endphp
        <h3>{{ $currentMonth->format('F Y') }}</h3>
    @elseif(request('filter') == 'specific_day' && request('specific_day'))
        <h3>{{ \Carbon\Carbon::parse(request('specific_day'))->format('F j, Y') }}</h3>
    @elseif(request('filter') == 'specific_week' && request('specific_week'))
        @php
            $weekStart = \Carbon\Carbon::parse(request('specific_week') . '-1')->startOfWeek();
            $weekEnd = $weekStart->copy()->endOfWeek();
        @endphp
        <h3>{{ $weekStart->format('F j, Y') }} - {{ $weekEnd->format('F j, Y') }}</h3>
    @elseif(request('filter') == 'specific_month' && request('specific_month'))
        <h3>{{ \Carbon\Carbon::parse(request('specific_month') . '-01')->format('F Y') }}</h3>
    @endif


    <!-- Sales Table -->
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead style="background-color: #dfe3e8;">
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
                            <span class="badge-status">Complete</span>
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
                specificDayInput.style.display = 'block';
            } else if (filterSelect.value === 'specific_week') {
                specificWeekInput.style.display = 'block';
            } else if (filterSelect.value === 'specific_month') {
                specificMonthInput.style.display = 'block';
            }
        }

        filterSelect.addEventListener('change', toggleFilterInputs);
        toggleFilterInputs();
    });
</script>

<style>
/* Consistent Styles */
.form-select,
#specific_day, #specific_week, #specific_month {
    height: 38px;
    font-size: 14px;
    border-radius: 0px;
}

.btn {
        font-family: 'Poppins', sans-serif;
        border-radius: 30px;
        padding: 10px 20px;
        font-size: 15px;
    }

.btn-primary {
    background-color: #0066cc;
    border: none;
}

.btn-secondary {
    background-color: #6c757d;
    border: none;
}

.btn-dark {
    background-color: #343a40;
    border: none;
}

.btn:hover {
    opacity: 0.9;
}

.card {
    border-radius: 10px;
    background-color: #f9f9f9;
}

h1, h5 {
    font-family: 'Poppins', sans-serif;
}

.filter-group {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-right: 10px;
}

.filter-group label {
    font-size: 14px;
    font-weight: bold;
}

#specific_day, #specific_week, #specific_month {
    width: 120px;
    font-size: 14px;
    padding: 4px;
}

/* Payment Status Styles */
.badge-status {
    background-color: #059511ef !important;
    color: #ffffff !important;
    font-weight: bolder !important;
    padding: 8px 10px;
    border-radius: 3px !important;
    font-size: 15px !important;
}


</style>
@endsection
