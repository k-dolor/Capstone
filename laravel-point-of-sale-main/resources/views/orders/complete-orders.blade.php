@extends('dashboard.body.main')

@section('container')
<style>
/* Adjust modal styles */
.modal-content {
    border-radius: 8px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
}

.modal-header {
    background-color: #f8f9fa;
    border-bottom: 1px solid #dee2e6;
}

.modal-body {
    padding: 20px;
}

.modal-footer {
    border-top: 1px solid #dee2e6;
}

/* Table row hover effect */
.table tbody tr:hover {
    background-color: #f9f9f9;
}

.table-card {
    border: 1px solid #dee2e6;
    border-radius: 8px;
    overflow: hidden;
}

/* Styles for Filter Form */
.page-rows {
    width: 40% !important;
    height: 40px !important;
    font-size: 13px !important;
    padding: 8px 15px !important;
    border-radius: 0px !important;
    border: 1px solid #ced4da !important;
    background-color: #f8f9fa !important;
    color: #495057 !important;
    transition: border-color 0.3s ease !important;
}

.rows-per-page:focus {
    border-color: #007bff !important;
    box-shadow: 0 0 4px rgba(0, 123, 255, 0.25) !important;
}

.search-input {
    width: 105% !important;
    height: 40px !important;
    font-size: 14px !important;
    padding: 8px 15px !important;
    border-radius: 0px !important;
}

.search-input, 
#order_date {
    height: 40px !important;
    font-size: 14px !important;
    padding: 8px 15px !important;
}

/* Order Date Filter Styling */
#order_date {
    border: 1px solid #ced4da !important;
    border-radius: 0px !important;
    background-color: #f8f9fa !important;
    color: #495057 !important;
    transition: border-color 0.3s ease !important;
}

thead {
    background-color: #eceff2;
}
thead th {
    color: #3f3935 !important;
}

/* Payment Status Styles */
.badge-status {
    background-color: #8bf393ef !important;
    color: #0c4e02 !important;
    font-weight: bolder !important;
    padding: 8px 10px;
    border-radius: 3px !important;
    font-size: 15px !important;
}

/* Column Borders */
.table-bordered th,
.table-bordered td {
    border: 1px solid #dee2e6 !important;
    border-radius: 3px;
}

/* Card Styling */
.table-card {
    width: 100%;
    margin: 0;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

/* Table Styling */
.table-bordered {
    border-collapse: collapse;
}

.table-bordered th,
.table-bordered td {
    border: 1px solid #ddd;
    text-align: center;
    vertical-align: middle;
}

/* Button Styles */
.btn-custom-search {
    background-color: #007bff !important;
    color: #fff !important;
    border: none;
    border-radius: 0% !important;
    padding: 7px 8px !important;
    transition: background-color 0.3s ease !important;
}

.btn-custom-search:hover {
    background-color: #0056b3 !important;
}

.btn-custom-clear {
    background-color: #6c757d !important;
    color: #fff !important;
    border: none;
    border-radius: 0% !important;
    padding: 7px 8px !important;
    transition: background-color 0.3s ease !important;
}

.btn-custom-clear:hover {
    background-color: #495057 !important;
}

.btn-custom-actions {
    background-color: #0173ba !important;
    color: #fff !important;
    border: none;
    border-radius: 5px !important;
    padding: 5px 10px !important;
    transition: background-color 0.3s ease !important;
}   

.btn-custom-actions:hover {
    background-color:  #003df4 !important;
}

.btn-custom-print {
    background-color: #ff8800 !important;
    color: #fff !important;
    border: none;
    border-radius: 5px !important;
    padding: 5px 10px !important;
    transition: background-color 0.3s ease !important;
}   

.btn-custom-print:hover {
    background-color:  #323232 !important;
}
</style>

<h1 class="text-center" style="font-family: 'Poppins', sans-serif; color: rgb(42, 23, 5);">Order Transactions</h1>

<div class="container-fluid">
    <!-- Filter Form -->
    <form action="{{ route('order.completeOrders') }}" method="get" class="mb-3">
        <div class="row">
            <!-- Rows per Page -->
            <div class="col-md-2">
                <label for="row" class="form-label">Page Rows:</label>
                <select class="form-control page-rows" name="row">
                    <option value="10" @if(request('row') == '10') selected @endif>10</option>
                    <option value="25" @if(request('row') == '25') selected @endif>25</option>
                    <option value="50" @if(request('row') == '50') selected @endif>50</option>
                    <option value="100" @if(request('row') == '100') selected @endif>100</option>
                </select>
            </div>

            <!-- Search and Order Date Filter -->
            <div class="col-md-12 d-flex justify-content-end align-items-end">
                <div class="form-group mb-0 flex-grow-1 me-2">
                    <input type="text" id="search" class="form-control search-input" name="search" placeholder="Search by Invoice No" value="{{ request('search') }}">
                </div>

                <div class="form-group mb-0 me-2">
                    <label for="order_date" class="form-label">Filter Date:</label>
                    <input type="date" id="order_date" class="form-control" name="order_date" value="{{ request('order_date') }}">
                </div>

                <div class="form-group mb-0 d-flex">
                    <button type="submit" class="btn btn-custom-search me-2">
                        <i class="fa-solid fa-magnifying-glass"></i> Search
                    </button>
                    <a href="{{ route('order.completeOrders') }}" class="btn btn-custom-clear">
                        Clear
                    </a>
                </div>
            </div>
        </div>
    </form>

    <!-- Order Table -->
    <div class="card table-card">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Invoice No</th>
                            <th>@sortablelink('order_date', 'Order Date')</th>
                            <th>Customer</th>
                            <th>@sortablelink('total', 'Total')</th>
                            <th>Payment Type</th>
                            {{-- <th>Status</th> --}}
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($orders as $order)
                        <tr>
                            <td>{{ $order->invoice_no }}</td>
                            <td>{{ $order->order_date }}</td>
                            <td>{{ $order->customer_name }}</td>
                            <td>{{ $order->total }}</td>
                            <td>{{ $order->payment_status }}</td>
                            {{-- <td>
                                <span class="badge badge-status">{{ $order->order_status }}</span>
                            </td> --}}
                            <td>
                                <button type="button" class="btn btn-custom-actions" data-bs-toggle="modal" data-bs-target="#orderDetailsModal{{ $order->id }}">
                                    Details
                                </button>
                                <a href="{{ route('order.invoiceDownload', $order->id) }}" class="btn btn-custom-print">Print</a>
                            </td>
                        </tr>

                        <!-- Order Details Modal -->
                        <div class="modal fade " id="orderDetailsModal{{ $order->id }}" tabindex="-1" aria-labelledby="orderDetailsModalLabel{{ $order->id }}" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Order Details</h5>
                                        {{-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> --}}
                                    </div>
                                    <div class="modal-body">
                                        <p><strong>Customer Name:</strong> {{ $order->customer_name }}</p>
                                        <p><strong>Order Date:</strong> {{ $order->order_date }}</p>
                                        <p><strong>Invoice No:</strong> {{ $order->invoice_no }}</p>
                                        <p><strong>Payment Status:</strong> {{ $order->payment_status }}</p>
                                        <p><strong>Paid Amount:</strong> {{ $order->pay }}</p>
                                        <p><strong>Due Amount:</strong> {{ $order->due }}</p>
                                    
                                        <!-- Fetch Products and Quantities -->
                                        <h5><strong>Products Ordered:</strong></h5>
                                        <ul>
                                            @foreach ($order->orderDetails as $detail)
                                                <li>
                                                    <strong>Product:</strong> {{ $detail->product->product_name }} 
                                                    - <strong>Quantity:</strong> {{ $detail->quantity }}
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                    
                                    
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center" style="font-weight: bold; color: rgb(255, 21, 21)">No orders available for the selected search or filters.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Pagination -->
    <div class="mt-3">
        {{ $orders->links() }}
    </div>
</div>


<script>
    document.addEventListener('DOMContentLoaded', function () {
        const orderDetailsModal = document.getElementById('orderDetailsModal');
        const orderDetailsContent = document.getElementById('orderDetailsContent');

        orderDetailsModal.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget; // Button that triggered the modal
            const url = button.getAttribute('data-url'); // URL to fetch order details
            const orderId = button.getAttribute('data-id'); // Order ID for display

            // Show loading state
            orderDetailsContent.innerHTML = `<p>Loading details for Order #${orderId}...</p>`;

            // Fetch order details via AJAX
            fetch(url)
                .then(response => response.text())
                .then(html => {
                    orderDetailsContent.innerHTML = html; // Populate modal with details
                })
                .catch(error => {
                    orderDetailsContent.innerHTML = `<p class="text-danger">Failed to load details. Please try again later.</p>`;
                    console.error('Error fetching order details:', error);
                });
        });
    });
</script>
@endsection