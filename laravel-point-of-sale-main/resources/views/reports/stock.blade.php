@extends('dashboard.body.main')

@section('container')

<div class="container-fluid">
    <!-- Title -->
    <h1 class="text-center mb-4" style="font-family: 'Poppins', sans-serif;">Reports & Analytics</h1>

    <!-- Tab Navigation -->
    <div class="d-flex justify-content-center mb-4">
        <a href="{{ route('reports.index') }}" class="btn mx-2" style="background-color: #FB8500; color: #ffffff; border: none;">Main Page</a>
        <a href="{{ route('reports.sales') }}" class="btn mx-2" style="background-color: #B0E0E6; color: #000; border: none;">Sales Report</a>
        <a href="{{ route('reports.stock') }}" class="btn mx-2" style="background-color: #4682B4; color: #fff; border: none;">Stock Report</a>
        <a href="{{ route('reports.income') }}" class="btn mx-2" style="background-color: #1E90FF; color: #fff; border: none;">Income Report</a>
        <a href="{{ route('reports.products') }}" class="btn mx-2" style="background-color: #003459; color: #fff; border: none;">Products Report</a>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="d-flex flex-wrap align-items-center justify-content-between mb-4">
                <div>
                    <h3 class="mb-3">Stock Report</h3>
                </div>
                
                <div>
                    <!-- Stock Filter -->
                    <form action="{{ route('reports.stock') }}" method="GET" class="form-inline">
                        <select name="stock_filter" class="form-control" style="height: 38px;border-radius: 1px;">
                            <option value="">All Stock</option>
                            <option value="in_stock" @if(request('stock_status') == 'in_stock') selected @endif>In Stock</option>
                            <option value="low_stock" @if(request('stock_status') == 'low_stock') selected @endif>Low Stock</option>
                            <option value="out_of_stock" @if(request('stock_status') == 'out_of_stock') selected @endif>Out of Stock</option>
                        </select>
                        <button type="submit" class="btn btn-primary" style="margin-left: 5px; height: 38px; border-radius: 2px;">Filter</button>
                    </form>
                </div>

            <!-- Print and Export Buttons -->
            <div style="display: flex; gap: 0;">
                <button class="btn" style="background-color: #3a33ff; color: white;height: 38px; padding: 0 20px; font-size: 14px; display: flex; align-items: center; justify-content: center; border-radius: 1px;" onclick="window.print()">Print</button>
                <a href="{{ route('sales.exportData', ['filter' => request('filter')]) }}" class="btn btn-primary" style="background-color: #ff8400; height: 38px; padding: 0 20px; font-size: 14px; display: flex; align-items: center; justify-content: center;border-radius: 1px;">Export</a>
            </div>
        </div>

        <!-- Stock Report Table -->
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead style="background-color: #dfe3e8;">
                            <tr>
                        <th>No.</th>
                        <th>Product Name</th>
                        <th>In Stock</th>
                        <th>Stock Level</th>
                    </tr>
                </thead>
                <tbody class="light-body">
                    @forelse ($products as $index => $product)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $product->product_name }}</td>
                        <td>{{ $product->product_store }}</td>
                        <td>
                            @if ((int)$product->product_store <= 0)
                            <span style="color: #ff0000; font-weight: bold; background-color: #ff4141; padding: 8px 8px; border-radius: 5px;">No Stock</span>
                        @elseif ((int)$product->product_store > 0 && (int)$product->product_store < 20)
                            <span style="color: #000000; font-weight: bold; font-size: 15px; background-color: #ffcc00; padding: 8px 8px; border-radius: 5px;">Low Stock</span>
                        @else
                            <span style="color: #ffffff; font-weight: bold; font-size: 15px; background-color: #109130; padding: 8px 8px; border-radius: 5px;">In Stock</span>
                        @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4">No products available</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
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
