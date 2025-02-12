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


<div class="d-flex flex-wrap align-items-center justify-content-between mb-4">
    <div>
        <h2 class="mb-3">Net and Gross Income Report</h2>
    </div>
</div>

        <div class="income-report-container" style="max-width: 800px; margin: 0 auto; padding: 20px; background-color: #fff;">

        <!-- Date Range Filter Form -->
        <form action="{{ route('reports.income') }}" method="GET" class="mb-4">
            <div class="row">
                <div class="col-md-5">
                    <input type="date" name="start_date" class="form-control" placeholder="Start Date" value="{{ request('start_date') }}">
                </div>
                <div class="col-md-5">
                    <input type="date" name="end_date" class="form-control" placeholder="End Date" value="{{ request('end_date') }}">
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary">Filter</button>
                </div>
            </div>
        </form>


        <!-- Summary Table -->
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Description</th>
                    <th>Amount (₱)</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><strong>Gross Income</strong></td>
                    <td>₱{{ number_format($grossIncome, 2) }}</td>
                </tr>
                <tr>
                    <td><strong>Net Income</strong></td>
                    <td>₱{{ number_format($netIncome, 2) }}</td>
                </tr>
            </tbody>
        </table>

        <h4 class="mt-4">Details:</h4>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Quantity Sold</th>
                    <th>Selling Price (₱)</th>
                    <th>Buying Price (₱)</th>
                    <th>Total Selling (₱)</th>
                    <th>Total Profit (₱)</th>
                </tr>
            </thead>
            <tbody>
                @foreach($details as $detail)
                    <tr>
                        <td>{{ $detail['product'] }}</td>
                        <td>{{ $detail['quantity'] }}</td>
                        <td>₱{{ number_format($detail['selling_price'], 2) }}</td>
                        <td>₱{{ number_format($detail['buying_price'], 2) }}</td>
                        <td>₱{{ number_format($detail['total_selling'], 2) }}</td>
                        <td>₱{{ number_format($detail['total_profit'], 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <hr>

        <div class="text-center">
            <a href="{{ route('dashboard') }}" class="btn btn-secondary">Back to Dashboard</a>
        </div>
    </div>

    <style>
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
    
        /* Tab Navigation Style */
        .nav-tabs .nav-link {
            font-family: 'Poppins', sans-serif;
            border-radius: 30px;
            padding: 10px 20px;
            font-size: 14px;
            text-align: center;
        }
    
        .nav-tabs .nav-link.active {
            background-color: #0066cc;
            border-color: #0066cc;
            color: white;
        }
    
        .nav-tabs .nav-link:hover {
            opacity: 0.9;
        }
    
        .nav-tabs {
            margin-bottom: 20px;
        }
    </style>
@endsection
