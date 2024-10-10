@extends('dashboard.body.main')

@section('container')
<div class="container">
    <h1 class="mb-4">Sales Management</h1>

    <!-- New Sales Order Button -->
    {{-- <a href="#" class="btn btn-primary mb-4">Create New Sales Order</a> --}}

    <!-- Sales Summary Section -->
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card text-white bg-success mb-3">
                <div class="card-header">Total Sales</div>
                <div class="card-body">
                    <h5 class="card-title">₱ 150,000</h5>
                    <p class="card-text">Total sales revenue for this month.</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-white bg-info mb-3">
                <div class="card-header">Total Orders</div>
                <div class="card-body">
                    <h5 class="card-title">250</h5>
                    <p class="card-text">Total number of sales orders this month.</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-white bg-warning mb-3">
                <div class="card-header">Pending Payments</div>
                <div class="card-body">
                    <h5 class="card-title">₱ 30,000</h5>
                    <p class="card-text">Amount pending from sales orders.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Sales Orders Table -->
    <div class="card">
        <div class="card-header">
            Recent Sales Orders
        </div>
        <div class="card-body">
            <table class="table">
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Customer Name</th>
                        <th>Product</th>
                        <th>Quantity</th>
                        <th>Total Price</th>
                        <th>Payment Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>#000123</td>
                        <td>Alice Johnson</td>
                        <td>LPG Cylinder</td>
                        <td>50</td>
                        <td>₱ 25,000</td>
                        <td><span class="badge bg-success">Paid</span></td>
                        <td>
                            <button class="btn btn-info btn-sm">View Details</button>
                            <button class="btn btn-danger btn-sm">Cancel Order</button>
                        </td>
                    </tr>
                    <tr>
                        <td>#000124</td>
                        <td>John Doe</td>
                        <td>Oxygen Tank</td>
                        <td>30</td>
                        <td>₱ 18,000</td>
                        <td><span class="badge bg-warning">Pending</span></td>
                        <td>
                            <button class="btn btn-info btn-sm">View Details</button>
                            <button class="btn btn-danger btn-sm">Cancel Order</button>
                        </td>
                    </tr>
                    <!-- Add more rows as needed -->
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
