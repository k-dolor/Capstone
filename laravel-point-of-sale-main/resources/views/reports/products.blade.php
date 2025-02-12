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
                    <h3 class="mb-3">Products Report</h3>
                </div>
                <div>
                        <label for="category" class="form-label">Filter Category:</label>
                         <!-- Category Filter Form -->
                     <form action="{{ route('reports.products') }}" method="GET" class="form-inline mb-4">
                         <select name="category_filter" class="form-control" style="height: 38px; border-radius: 1px;">
                             <option value="">All Categories</option>
                             @foreach($categories as $category)
                                 <option value="{{ $category->id }}" @if($categoryFilter == $category->id) selected @endif>{{ $category->name }}</option>
                             @endforeach
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
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead style="background-color: #dfe3e8;">
                            <tr>
                            <th>No.</th>
                            <th>Product Name</th>
                            <th>Category</th>
                            <th>Stock</th>
                            <th>Price</th>
                            <th>Last Restock Date</th>
                        </tr>
                    </thead>
                    <tbody class="ligth-body">
                        @forelse($products as $index => $product)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $product->product_name }}</td>
                            <td>{{ $product->category->name ?? 'N/A' }}</td>
                            <td>{{ $product->product_store }}</td>
                            <td>₱{{ number_format($product->selling_price, 2) }}</td>
                            <td>{{ $product->buying_date }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center">No products available.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<style>
    .search-input {
    width: 88% !important; /* Longer search input */
    height: 40px !important;
    font-size: 14px !important;
    padding: 8px 15px !important;
    border-radius: 0px !important;  
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
