@extends('dashboard.body.main')

@section('container')
<div class="container-fluid">
    <h1 class="mb-4">Delivery Management</h1>
    
    <!-- New Delivery Order Button -->
    <a href="{{ route('delivery.create') }}" class="btn btn-primary mb-3">Create New Delivery</a>
    
    <!-- Active Deliveries Table -->
    <div class="card">
        <div class="card-header">
            Active Deliveries
        </div>
        <div class="card-body">
            <table class="table">
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Customer Name</th>
                        {{-- <th>Products</th> <!-- Changed from Product to Products --> --}}
                        <th>Delivery Status</th>
                        <th>Driver Assigned</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($deliveries as $delivery)
                    <tr>
                        <td>{{ $delivery->order_id }}</td>
                        <td>{{ $delivery->customer_name }}</td>
                        {{-- <td>
                            @if($delivery->product) <!-- Check if products exist -->
                                @php
                                    $products = json_decode($delivery->product, true); // Decode JSON to array
                                @endphp
                                <ul>
                                    @foreach($products as $product) <!-- Loop through products -->
                                        <li>{{ $product['product_name'] }} - Quantity: {{ $product['quantity'] }}</li>
                                    @endforeach
                                </ul>
                            @else
                                No products added.
                            @endif
                        </td> --}}
                        <td>{{ $delivery->status ?? 'Pending' }}</td>
                        <td>{{ $delivery->driver_name ?? 'Not Assigned' }}</td>
                        <td>
                            <form action="{{ route('delivery.markAsDelivered', $delivery->id) }}" method="POST" style="display:inline;">
                                @csrf
                                <button type="submit" class="btn btn-success btn-sm">Mark as Delivered</button>
                            </form>
                        
                            <a href="{{ route('delivery.updateStatusForm', $delivery->id) }}" class="btn btn-warning btn-sm">Update Status</a>
                        
                            <form action="{{ route('delivery.cancel', $delivery->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Cancel Delivery</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
