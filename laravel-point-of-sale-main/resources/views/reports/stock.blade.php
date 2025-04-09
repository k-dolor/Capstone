@extends('dashboard.body.main')

@section('container')

<style>
    /* Import a clean, modern font */
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap');

    h1 {
        font-size: 2.5rem;
        font-weight: 600;
        color: #1e1e2f;
    }

    /* Tab Button Base */
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

    /* Hover & Active State */
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
        <a href="{{ route('reports.stock') }}" class="btn report-tab active no-print">
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
            <div class="d-flex flex-wrap align-items-center justify-content-between mb-4">
                <div>
                    <h3 class="mb-3">Stock Report</h3>
                </div>
                <div>
                    <!-- Stock Filter -->
                    <form action="{{ route('reports.stock') }}" method="GET" class="form-inline no-print">
                        <select name="stock_filter" class="form-select modern-select">
                            <option value="">All Stock</option>
                            <option value="in_stock" @if(request('stock_filter') == 'in_stock') selected @endif>IN STOCK</option>
                            <option value="average" @if(request('stock_filter') == 'average') selected @endif>AVERAGE</option>
                            <option value="low_stock" @if(request('stock_filter') == 'low_stock') selected @endif>LOW STOCK</option>
                            <option value="out_of_stock" @if(request('stock_filter') == 'out_of_stock') selected @endif>OUT OF STOCK</option>
                        </select>                        

                        <button type="submit" class="btn modern-btn-primary" style="margin-left: 5px;">Filter</button>
                    </form>
                </div>

                <!-- Print and Export Buttons -->
                <div class="d-flex gap-2 no-print">
                    <button class="modern-btn-dark" onclick="window.print()">
                        <i class="fas fa-print"></i> Print
                    </button>
                    <a href="{{ route('reports.export.stock', request()->query()) }}" class="modern-btn-warning">
                        <i class="fas fa-file-export"></i> Export
                    </a>
                </div>
            </div>

            <!-- Stock Report Table -->
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped text-center">
                            <thead style="background-color: #dfe3e8;">
                                <tr>
                                    <th>No.</th>
                                    <th>Product Name</th>
                                    <th>In Stock</th>
                                    <th>Stock Level</th>
                                    <th>Last Restock Date</th>
                                    <th>Quantity Restocked</th>
                                </tr>
                            </thead>
                            <tbody class="text-center">
                                @forelse ($products as $index => $product)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $product->product_name }}</td>
                                    <td>{{ $product->product_store }}</td>
                                    <td>
                                        @php
                                            $stock = (int) $product->product_store;
                                            $badgeColor = '';
                                            $textColor = '#fff';
                                            $statusText = '';
                    
                                            if ($stock <= 0) {
                                                $badgeColor = '#ff4141'; // Red for Out of Stock
                                                $statusText = 'No Stock';
                                            } elseif ($stock > 0 && $stock < 10) {
                                                $badgeColor = '#d33707'; // Red-Orange for Very Low Stock
                                                $statusText = 'LOW STOCK';
                                            } elseif ($stock >= 10 && $stock <= 49) {
                                                $badgeColor = '#ff8000'; // Orange for Low Stock
                                                $statusText = 'LOW STOCK';
                                            } elseif ($stock >= 50 && $stock <= 70) {
                                                $badgeColor = '#ffcc00'; // Yellow for Medium Stock
                                                $textColor = '#333'; // Dark text for better visibility
                                                $statusText = 'AVERAGE';
                                            } else {
                                                $badgeColor = '#109130'; // Green for In Stock
                                                $statusText = 'IN STOCK';
                                            }
                                        @endphp
                    
                                        <span style="color: {{ $textColor }}; font-weight: bold; font-size: 15px; background-color: {{ $badgeColor }}; padding: 8px 8px; border-radius: 5px;">
                                            {{ $statusText }}
                                        </span>
                                    </td>
                                    <td>{{ $product->lastRestockDate ? $product->lastRestockDate->format('Y-m-d') : 'N/A' }}</td>
                                    <td>{{ $product->lastRestockQuantity ?? 'N/A' }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6">No products available</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>      
                    </div>
                    <!-- Pagination Links -->
                    <div class="pagination-wrapper text-center mt-4">
                        {{ $products->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection





