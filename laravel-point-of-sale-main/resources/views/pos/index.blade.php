@extends('dashboard.body.main')

@section('container')
<div class="container-fluid">
    <div class="row">
        <!-- Left Column: Product Display -->
        <div class="col-lg-7 col-md-12">
            <h1 class="text-center mb-2" style="font-family: 'Poppins', sans-serif;">Point of Sales</h1>
            <!-- Search Bar and Category Dropdown -->
            <div class="d-flex justify-content-between align-items-center mb-3">
                <form action="#" method="get" class="w-60 d-flex align-items-center">
                    <input type="text" id="search" class="form-control me-2" name="search" placeholder="Search product" value="{{ request('search') }}" style="width: 550px; height:45px; border-radius:0px;"> <!-- Adjust the width here -->
                    <button type="submit" class="btn btn-primary-search">Search</button>
                    <a href="{{ route('pos.index') }}" class="btn clear-btn">Clear</a>
                </form>              
            </div>
            <!-- Product Grid with Scrollable Container -->
            <div class="product-grid-container">
                <div class="row g-0"> <!-- Use 'g-0' to remove grid gap -->
                    @forelse ($products as $product)
                    <div class="col-md-4 px-2">
                        <div class="card product-card text-center">
                            <div class="position-relative">
                                <img src="{{ $product->product_image ? asset('storage/products/'.$product->product_image) : asset('assets/images/product/logo3.png') }}" 
                                    class="card-img-top" 
                                    alt="{{ $product->product_name }}" 
                                    style="object-fit: contain; width: 100%; height: 150px;">
                                <div class="position-absolute bottom-0 start-0 w-100 p-2 text-white bg-dark bg-opacity-75">
                                    <h6 class="m-0">{{ $product->product_name }}</h6>
                                    <p class="m-0">₱{{ $product->selling_price }}</p>
                                </div>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('pos.addCart') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="id" value="{{ $product->id }}">
                                    <input type="hidden" name="name" value="{{ $product->product_name }}">
                                    <input type="hidden" name="price" value="{{ $product->selling_price }}">
                                    <button class="btn">Add</button>
                                </form>
                            </div>
                        </div>                    
                    </div>
                    @empty
                    <div class="alert alert-danger" role="alert">
                        <strong>No Products Found.</strong>
                    </div>
                    @endforelse
                </div>
                {{ $products->links() }}
            </div>
        </div>

        <!-- Right Column: Cart and Invoice -->
        <div class="col-lg-5 col-md-12">
            <div class="card invoice-card">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Invoice</h5>
                </div>
                <div class="card-body" style="max-width: 100%; overflow-x: auto; padding: 15px;">
                    <form>
                        <table class="table table-bordered" style="width: 100%; table-layout: fixed; font-size:14px; border-spacing: 0 !important; padding: 5px;">
                            <thead>
                                <tr>
                                    <th>Items</th>
                                    <th>Qty</th>
                                    <th>Price</th>
                                    <th>Total</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($productItem as $item)
                                <tr>
                                    <td>{{ $item->name }}</td>
                                    <td>
                                        <form action="{{ route('pos.updateCart', $item->rowId) }}" method="POST">
                                            @csrf
                                            <input type="number" class="form-control" name="qty" required value="{{ old('qty', $item->qty) }}">
                                            <button type="submit" class="btn btn-success btn-sm">Update</button>
                                        </form>                                                                            
                                    </td>
                                    <td>₱{{ $item->price }}</td>
                                    <td>₱{{ $item->subtotal }}</td>
                                    <td>
                                        <a href="{{ route('pos.deleteCart', $item->rowId) }}" class="btn btn-danger btn-sm" >
                                            Delete
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="text-right">
                            <p><strong>Subtotal: </strong>{{ Cart::subtotal() }}</p>
                            <p><strong>Tax: </strong>{{ Cart::tax() }}</p>
                        </div>
                        <div class="text-end">
                            <p><strong>Total Amount:</strong> <span class="text-danger">₱{{ Cart::total() }}</span></p>
                        </div>   
                          <!-- Create Invoice and Payment Modal Trigger Button -->
                          <button type="button" class="btn btn-custom btn-block" data-toggle="modal" data-target="#createInvoiceModal">
                            Create Invoice
                        </button>                        
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal for Creating Invoice and Payment -->
<div class="modal fade" id="createInvoiceModal" tabindex="-1" role="dialog" aria-labelledby="createInvoiceModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content" style="background-color: #ced2d8; color: #343a40;">
            <div class="modal-header bg-primary">
                <h5 class="modal-title text-white" id="createInvoiceModalLabel">{{ $customer->name ?? 'Customer' }} Invoice</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

                    <form action="{{ route('pos.storeOrder') }}" method="post">
                    @csrf  
                <div class="modal-body">
                    <input type="hidden" name="id" value="{{ $order->id ?? '' }}">


                    <div class="form-group">
                        <label for="discount">Customer Name</label>
                        <input type="text" class="form-control" name="customer_name" placeholder="Customer Name" value="{{ old('customer_name') }}">
                        

                    <!-- Discount Section -->
                    <div class="form-group">
                       <label for="discount">Discount (PWD/Senior)</label>
                       <select class="form-control" id="discount" name="discount" onchange="applyDiscount()">
                           <option value="0">None</option>
                          <option value="5">PWD/Senior (5%)</option>
                        </select>
                   </div>

                    <!-- Payment Method -->
                    <div class="form-group">
                        <label for="payment_status">Payment</label>
                        <select class="form-control @error('payment_status') is-invalid @enderror" name="payment_status">
                            <option selected="" disabled="">-- Select Payment --</option>
                            <option value="Cash">Cash</option>
                            {{-- <option value="Cheque"></option> --}}
                        </select>
                        @error('payment_status')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                 <!-- Pay Now -->
                    <div class="form-group">
                       <label for="pay">Pay Now</label>
                        <input type="text" class="form-control @error('pay') is-invalid @enderror" id="pay" name="pay" value="{{ old('pay') }}" oninput="calculateChange()">
                      @error('pay')
                      <div class="invalid-feedback">
                          {{ $message }}
                       </div>
                       @enderror
                    </div>

                    <!-- Change Amount -->
                    <div class="form-group">
                        <label for="change">Change</label>
                        <input type="text" class="form-control" id="change" name="change" value="₱0.00" readonly>
                    </div>

                    <!-- Display Order Summary -->
                    <div class="row">
                        <div class="col-sm-12">
                            <h5 class="mb-3">Order Summary</h5>
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Item</th>
                                            <th>Quantity</th>
                                            <th>Price</th>
                                            <th>Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($productItem as $item)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $item->name }}</td>
                                            <td>{{ $item->qty }}</td>
                                            <td>{{ $item->price }}</td>
                                            <td>{{ $item->subtotal }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Total Amount After Discount -->
                    <div class="row">
                          <div class="col-sm-12">
                              <div class="text-right">
                                  <p><strong>Subtotal: </strong>₱<span id="subtotal">{{ Cart::subtotal() }}</span></p>
                                  <p><strong>Tax: </strong>₱{{ Cart::tax() }}</p>
                                  <h2><strong>Total: </strong>₱<span id="total">{{ Cart::total() }}</span></h2>
                              </div>
                          </div>
                    </div>

                <div class="modal-footer">
                    <!-- Complete Order Button -->
                    <button type="submit" class="btn btn-order mr-2" data-toggle="tooltip" data-placement="top" title="Complete">
                        Complete Order
                    </button>
                </form>

                    <!-- Cancel Button -->
                    <a class="btn btn-danger mr-2" data-toggle="tooltip" data-placement="top" title="Cancel" href="{{ route('pos.index') }}">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

<script>
    function calculateChange() {
    var payAmount = parseFloat(document.getElementById("pay").value);
    var totalAmount = parseFloat(document.getElementById("total").textContent);
    var changeAmount = payAmount - totalAmount;
    document.getElementById("change").value = "₱" + changeAmount.toFixed(2);
}


    function applyDiscount() {
        // Get the selected discount value
        var discountValue = document.getElementById("discount").value;
        
        // Get the current total amount
        var totalAmount = parseFloat("{{ Cart::total() }}");

        // Calculate discount
        var discountAmount = (discountValue / 100) * totalAmount;
        
        // Calculate the new total amount after discount
        var newTotal = totalAmount - discountAmount;
        
        // Update the total amount in the modal
        document.getElementById("total").textContent = newTotal.toFixed(2);

        // Optionally, you can update the subtotal if needed
        // document.getElementById("subtotal").textContent = (totalAmount - discountAmount).toFixed(2);
    }
</script>

<style>
.card {
    display: flex;
    flex-direction: column;
    justify-content: space-between; /* Keep the content spaced out without overlap */
    height: 80%; /* Ensure the card takes up only as much space as needed */
}

/* Ensure that the card image and overlay have their own dedicated space */
.card .position-relative {
    margin-bottom: 0; /* Remove space below image */
}

.card .card-img-top {
    object-fit: contain;
    width: 100%;
    height: 150px; /* Fix the image height to avoid overflow */
}

/* Position the overlay correctly at the bottom of the image */
.card .position-absolute {
    bottom: 0;
    start: 0;
    width: 100%;
    padding: 8px !important;
    text-align: center;
    background: rgba(42, 42, 42, 0.903) !important;
}

.row.g-0 {
    margin-left: -8px;  /* Negative margin for tight fit */
    margin-right: -8px;
}

/* Custom spacing for small gap (0.25 inches) between cards */
.col-md-4 {
    padding: 4px; /* Adds a small 4px padding around the card */
}

.product-card {
    margin-bottom: 0; /* Ensure no margin below the cards */
    height: auto; /* Allow the height to be adjusted based on content */
}

.card:hover {
    transform: scale(1.05);
}

.card img {
    border-bottom: 2px solid #ddd;
}

.table thead th {
    background-color: #f8f9fa;
}

.table tbody td {
    vertical-align: middle;
}

.btn-primary {
    background-color: #007bff;
    border: none;
}

.btn-primary:hover {
    background-color: #0056b3;
}

.text-danger {
    font-weight: bold;
    font-size: 1.2rem;
}

/* Target only the Add buttons in product cards */
.card .card-body button.btn-primary {
    position: relative; /* Ensure this only affects Add buttons */
    margin-top: 0px;   /* Add space above the button */
}

/* Add padding below the product image to ensure enough space for the button */
.card-img-top {
    margin-bottom: 0px;
}

/* Adjust the button styling to remove extra space */
.product-card .card-body button {
    background-color: #28a745; /* Green background color */
    color: white; /* White text color */
    font-size: 24px; /* Larger text size */
    font-weight: bold; /* Bold text */
    border: none; /* Remove default border */
    border-radius: 8px; /* Slightly rounded corners */
    width: 70%; /* Make the button stretch the width of the card */
    padding: 5px; /* Add some padding for height */
    text-align: center; /* Center the text */
    cursor: pointer; /* Change cursor to pointer on hover */
    margin-top: 0; /* Remove extra space below the image and above the button */
    margin-bottom: 0%;
}

/* Add hover effect for better UX */
.product-card .card-body button:hover {
    background-color: #0f6422; /* Darker green on hover */
}

/* Remove hover effect from product cards */
.card:hover {
    transform: scale(1); /* Remove transformation */
}

/* Invoice card with flexible height */
.card.invoice-card {
    height: auto; /* Make sure the height adapts to the content inside */
    min-height: 400px; /* Optional: Set a minimum height to ensure it has enough space */
    display: flex;
    flex-direction: column; /* Allow the card content to be vertically arranged */
}

/* Ensure the content within the card is aligned properly */
.card.invoice-card .card-body {
    flex-grow: 1; /* Allow the body to grow and take available space */
    display: flex;
    flex-direction: column;
    justify-content: space-between; /* Ensure content is spaced evenly */
}

/* Adjust table styling to prevent overflow */
.table-responsive {
    overflow-x: auto; /* Prevent table overflow if necessary */
}

/* Make sure the total section stays at the bottom */
.card-footer {
    margin-top: auto; /* Push the total section to the bottom of the card */
}

/* Make the product grid scrollable and keep search bar + category outside */
.product-grid-container {
    max-height: 550px; /* Limit the height of the grid */
    overflow-y: auto; /* Enable vertical scrolling */
    padding-right: 10px; /* Adjust for the scrollbar */
}

/* Customize the scrollbar to be modern */
.product-grid-container::-webkit-scrollbar {
    width: 8px; /* Narrow width */
    background-color: #f1f1f1; /* Light background for the scrollbar */
}

.product-grid-container::-webkit-scrollbar-thumb {
    background-color: #888; /* Scrollbar thumb color */
    border-radius: 4px; /* Rounded corners */
}

.product-grid-container::-webkit-scrollbar-thumb:hover {
    background-color: #555; /* Darker thumb on hover */
}

.product-grid-container::-webkit-scrollbar-track {
    background-color: #f1f1f1; /* Track background */
}

/* Optional: Add smooth scrolling */
.product-grid-container {
    scroll-behavior: smooth;
}

/* Ensure the invoice card stays in place on the right */
.col-lg-7 {
    width: 58% !important; /* Adjust width of the product grid column */
}

.col-lg-5 {
    width: 42% !important; /* Adjust width of the invoice column */
}

.btn-danger {
    background-color: #dc3545 !important;  /* Red background */
    border: none;
    font-size: 14px !important; /* Adjust font size */
    padding: 5px 8px !important; /* Adjust padding (height and width) */
    border-radius: 3px !important; /* Adjust border radius if needed */
}

.btn-danger:hover {
    background-color: #9b0c1a !important;  /* Darker red on hover */
}

.btn-order {
    background-color: #0c9e4b !important;  /* Red background */
    border: none;
    font-size: 14px !important; /* Adjust font size */
    color: white !important;
    padding: 5px 15px !important; /* Adjust padding (height and width) */
    border-radius: 3px !important; /* Adjust border radius if needed */
}

.btn-order:hover {
    background-color: #027733 !important;  /* Darker red on hover */
}

.btn-primary-search {
    background-color: #008fe8 !important;  /* Red background */
    border: none;
    font-size: 14px !important; /* Adjust font size */
    font-weight: bold !important;
    color: white !important;
    padding: 10px 10px !important; /* Adjust padding (height and width) */
    border-radius: 0px !important; /* Adjust border radius if needed */
    height: 100%;
}

.btn-primary-search:hover {
    background-color: #004bc4 !important;  /* Darker red on hover */
}

.clear-btn {
    background-color: #949494 !important;  /* Red background */
    border: none;
    font-size: 14px !important; /* Adjust font size */
    font-weight: bold !important;
    color: white !important;
    padding: 10px 10px !important; /* Adjust padding (height and width) */
    border-radius: 0px !important; /* Adjust border radius if needed */
    height: 100%;
}

.clear-btn:hover {
    background-color: #515151 !important;  /* Darker red on hover */
}

/* Style for the invoice card */
.invoice-card {
    border-radius: 8px; /* Optional: Rounded corners for the card */
    border: 1px solid #ddd; /* Optional: Border for the card */
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Optional: Add some shadow to the card */
}

/* Style for the card header */
.invoice-card .card-header {
    background-color: #f25939 !important; /* Change the background color here */
    color: white; /* Text color inside the header */
    padding: 15px; /* Adjust padding if needed */
}

/* Style for the modal header */
.modal-header.bg-primary {
    background-color: #f25939 !important; /* Change the background color here */
    color: white !important; /* Change the text color */
}

/* Optional: Hover effect for the close button */
.modal-header .close:hover {
    color: #fff; /* Color when the close button is hovered */
}

/* Optional: Change background color for modal header on hover */
.modal-header.bg-primary:hover {
    background-color: #2980b9 !important; /* Darker shade for hover effect */
}

/* Custom button style */
.btn-custom {
    background-color: #f25939 !important; /* Set background color */
    color: white !important; /* Set text color */
    font-size:18px !important;
    font-weight: bolder !important;
    border: none; /* Remove border */
    padding: 10px 10px !important; /* Adjust padding (height and width) */
}

/* Button hover effect */
.btn-custom:hover {
    background-color: #bd3e08 !important; /* Darker shade for hover effect */
    color: white; /* Keep text white on hover */
}


</style>


