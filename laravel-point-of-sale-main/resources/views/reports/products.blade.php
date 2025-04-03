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
                         <select name="category_filter" class="form-control no-print" style="height: 38px; border-radius: 1px;">
                             <option value="">All Categories</option>
                             @foreach($categories as $category)
                                 <option value="{{ $category->id }}" @if($categoryFilter == $category->id) selected @endif>{{ $category->name }}</option>
                             @endforeach
                         </select>
                         <button type="submit" class="btn btn-primary no-print" style="margin-left: 5px; height: 38px; border-radius: 2px;">Filter</button>
                     </form>
                    </div>
                

            <!-- Print and Export Buttons -->
            <div style="display: flex; gap: 0;">
                <button class="btn no-print" style="background-color: #3a33ff; color: white;height: 38px; padding: 0 20px; font-size: 14px; display: flex; align-items: center; justify-content: center; border-radius: 1px;" onclick="window.print()">Print</button>
                <a href="{{ route('sales.exportData', ['filter' => request('filter')]) }}" class="btn btn-primary no-print" style="background-color: #ff8400; height: 38px; padding: 0 20px; font-size: 14px; display: flex; align-items: center; justify-content: center;border-radius: 1px;">Export</a>
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

</style>
@endsection
