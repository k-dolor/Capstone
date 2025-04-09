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
        background-color: #000288 !important;
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
        <a href="{{ route('reports.sales') }}" class="btn report-tab no-print">
            <i class="fas fa-chart-line"></i> Sales Report
        </a>
        <a href="{{ route('reports.stock') }}" class="btn report-tab no-print">
            <i class="fas fa-box"></i> Stock Report <!-- Changed to fa-box -->
        </a>
        <a href="{{ route('reports.income') }}" class="btn report-tab no-print">
            <i class="fas fa-dollar-sign"></i> Income Report
        </a>
        <a href="{{ route('reports.products') }}" class="btn report-tab active no-print">
            <i class="fas fa-box-open"></i> Products Report <!-- Changed to fa-box-open -->
        </a>
    </div>  

    <div class="row">
        <div class="col-lg-12">
            <div class="d-flex flex-wrap align-items-center justify-content-between mb-4">
                <div>
                    <h3 class="mb-3">Products Report</h3>
                </div>
                <div>
                        {{-- <label for="category" class="form-label no-print">Filter Category:</label> --}}
                         <!-- Category Filter Form -->
                     <form action="{{ route('reports.products') }}" method="GET" class="form-inline ">
                         <select name="category_filter" class="form-select modern-select no-print">
                             <option value="">All Categories</option>
                             @foreach($categories as $category)
                                 <option value="{{ $category->id }}" @if($categoryFilter == $category->id) selected @endif>{{ $category->name }}</option>
                             @endforeach
                         </select>
                         <button type="submit"  class="btn modern-btn-primary no-print" style="margin-left: 5px;">Filter</button>
                     </form>
                    </div>
                

            <!-- Print and Export Buttons -->
            <div class="d-flex gap-2 no-print">
                <button class="modern-btn-dark" onclick="window.print()">
                    <i class="fas fa-print"></i> Print
                </button>
                <a href="{{ route('sales.exportData', ['filter' => request('filter')]) }}"class="modern-btn-warning">
                    <i class="fas fa-file-export"></i> Export
                </a>
            </div>
        </div>
        
        <!--Table------>
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped text-center">
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
                    <tbody class="ligth-body text-center">
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
                            <td colspan="6">No products available.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection
