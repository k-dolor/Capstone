{{-- @extends('dashboard.body.main')

@section('container')
<div class="container-fluid">
    <h1 class="mb-4">Create New Delivery</h1>
    
    <div class="card-header">
        Delivery Details
    </div>
    <div class="card-body">
        <form action="{{ route('deliveries.store') }}" method="POST">
            @csrf        
            <div class="form-group mb-3">
                <label for="orderId">Order ID</label>
                <input type="text" class="form-control" id="orderId" name="orderId" placeholder="Enter Order ID" >
            </div>
            <div class="form-group mb-3">
                <label for="customerName">Customer Name</label>
                <input type="text" class="form-control" id="customerName" name="customerName" placeholder="Enter Customer Name">
            </div>
            <div class="form-group mb-3">
                <label for="product">Product</label>
                <select class="form-control" id="product" name="product">
                    @foreach($products as $product)
                        <option value="{{ $product->id }}">{{ $product->product_name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group mb-3">
                <label for="deliveryAddress">Delivery Address</label>
                <textarea class="form-control" id="deliveryAddress" name="deliveryAddress" rows="3" placeholder="Enter Delivery Address"></textarea>
            </div>
            <div class="form-group mb-3">
                <label for="deliveryDate">Delivery Date</label>
                <input type="date" class="form-control" id="deliveryDate" name="deliveryDate">
            </div>

              <div class="form-group mb-3">
                <label for="driver">Assign Driver</label>
                <select class="form-control" id="driver" name="driver">
                    <option value="Jane Smith" selected>Jane Smith</option>
                    <option value="John Doe">John Doe</option>
                </select>
            </div>
    
            <button type="submit" class="btn btn-primary">Submit Delivery</button>
            <a href="{{ route('delivery.index') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</div>
</div>
@endsection --}}


@extends('dashboard.body.main')

@section('container')
<div class="container-fluid">
    <h1 class="mb-4">Create New Delivery</h1>
    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif


    <div class="card-header">
        Delivery Details
    </div>
    <div class="card-body">
        <form action="{{ route('deliveries.store') }}" method="POST">
            @csrf
            <!-- Removed the Product dropdown -->
<div class="form-group mb-3">
    <label for="orderSelect">Select Order</label>
    <select id="orderSelect" name="orderId">
        <option value="">Select an Order</option>
        @foreach($orders as $order)
            <option value="{{ $order->id }}">{{ $order->invoice_no }}</option>
        @endforeach
    </select>
</div>


            <div class="form-group mb-3">
                <label for="customerName">Customer Name</label>
                <input type="text" class="form-control" id="customerName" name="customerName" placeholder="Enter Customer Name">
            </div>

            <div class="form-group mb-3">
                <label>Order Products</label>
                <table id="orderDetailsTable">
                    <thead>
                        <tr>
                            <th>Product Name</th>
                            <th>Quantity</th>
                            <th>Unit Cost</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Order details will be appended here dynamically -->
                    </tbody>
                </table>
            </div>
            

            <div class="form-group mb-3">
                <label for="deliveryAddress">Delivery Address</label>
                <textarea class="form-control" id="deliveryAddress" name="deliveryAddress" rows="3" placeholder="Enter Delivery Address"></textarea>
            </div>
            <div class="form-group mb-3">
                <label for="deliveryDate">Delivery Date</label>
                <input type="date" class="form-control" id="deliveryDate" name="deliveryDate">
            </div>
            <div class="form-group mb-3">
                <label for="driver">Assign Driver</label>
                <select class="form-control" id="driver" name="driver">
                    <option value="Jane Smith" selected>Jane Smith</option>
                    <option value="John Doe">John Doe</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Submit Delivery</button>
            <a href="{{ route('delivery.index') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</div>

<script>
function fetchOrderDetails(orderId) {
    if (orderId) {
        $.ajax({
    url: '/orders/' + orderId, // Adjust based on your routing
    method: 'GET',
    success: function(data) {
        // Clear previous details
        $('#orderDetailsTable tbody').empty();

        // Populate the table with order details
        data.orderDetails.forEach(function(detail) {
            $('#orderDetailsTable tbody').append(`
                <tr>
                    <td>${detail.product.product_name}</td>
                    <td>${detail.quantity}</td>
                    <td>${detail.unitcost}</td>
                </tr>
            `);
        });
    },
    error: function() {
    alert("An error occurred while fetching order details. Please try again.");
}

});

    } else {
        // Clear the table if no order is selected
        $('#orderDetailsTable tbody').empty();
    }
}

</script>
@endsection
