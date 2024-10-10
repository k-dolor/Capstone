@extends('dashboard.body.main')

@section('container')

    <div class="income-report-container" style="max-width: 800px; margin: 0 auto; padding: 20px; background-color: #fff;">
        <h2 class="text-center mb-4">Net and Gross Income Report</h2>

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
@endsection
