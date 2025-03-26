@extends('dashboard.body.main')

@section('container')
<div class="container-fluid">
    <div class="row">
        <!-- Left Column: Product Display -->
        <div class="col-lg-7 col-md-12">
            <h1 class="text-center mb-2" style="font-family: 'Poppins', sans-serif; color: rgb(42, 23, 5)">Point of Sales</h1>
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
                            <div class="card product-card text-center clickable-card" data-id="{{ $product->id }}" data-name="{{ $product->product_name }}" data-price="{{ $product->selling_price }}">
                                <div class="position-relative">
                                    <img src="{{ $product->product_image ? asset('storage/products/'.$product->product_image) : asset('assets/images/product/logo3.png') }}" 
                                        class="card-img-top" 
                                        alt="{{ $product->product_name }}" 
                                        style="object-fit: contain; width: 100%; height: 150px;">
                                    <div class="position-absolute bottom-0 start-0 w-100 p-2 text-white bg-dark bg-opacity-75">
                                        <h6 class="m-0">{{ $product->product_name }}</h6>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <h4>₱ {{ $product->selling_price }}</h4>
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
            <div class="card invoice-card" style="height: 620px; display: flex; flex-direction: column; ">
                <div class="card-header">
                    <h5 class="mb-0">Invoice</h5>
                </div>
                <div class="card-body p-3" style="flex-grow: 1; overflow-y: auto;">
                    <form>
                        <table class="table table-hover table-sm align-middle text-center">
                              <thead style="background-color: #86919d; color: black;"> <!-- Light gray background, black text -->
                <tr>
                                    <th style="width: 40%;">Items</th>
                                    <th style="width: 20%;">Qty</th>
                                    <th style="width: 15%;">Price</th>
                                    <th style="width: 15%;">Total</th>
                                    <th style="width: 10%;">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr id="loading-spinner" style="display: none;">
                                    <td colspan="5" class="text-center">
                                        <img src="{{ asset('assets/images/loading.gif') }}" width="30" alt="Loading...">
                                    </td>
                                </tr>
                                
                                @foreach ($productItem as $item)
                                <tr>
                                    <td class="text-start">{{ $item->name }}</td>
                                    <td>
                                        <div class="input-group input-group-sm">
                                            <button type="button" class="btn btn-outline-secondary decrease-qty" data-rowid="{{ $item->rowId }}">
                                                <i class="fas fa-minus"></i>
                                            </button>
                                            <input type="number" class="form-control text-center qty-input" data-rowid="{{ $item->rowId }}" value="{{ $item->qty }}" min="1">
                                            <button type="button" class="btn btn-outline-secondary increase-qty" data-rowid="{{ $item->rowId }}">
                                                <i class="fas fa-plus"></i>
                                            </button>
                                        </div>
                                    </td>
                                    <td>₱{{ number_format($item->price, 2) }}</td>
                                    <td class="subtotal" data-rowid="{{ $item->rowId }}">₱{{ number_format($item->subtotal, 2) }}</td>
                                    <td>
                                        <a href="{{ route('pos.deleteCart', $item->rowId) }}" class="btn btn-danger btn-sm">
                                            <i class="fas fa-trash-alt text-white"></i>
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </form>
                </div>
                
                
                {{-- <div class="card-footer" style="background-color: #343a40; color: white; padding: 10px;">
                    <div class="text-right">
                        <p><strong>Subtotal: </strong>₱<span id="cart-subtotal">{{ number_format(Cart::subtotal(), 2) }}</span></p>
                        <p><strong>Tax: </strong>₱<span id="cart-tax">{{ number_format(Cart::tax(), 2) }}</span></p>
                    </div>
                    <div class="text-end">
                        <p><strong>Total Amount: </strong> 
                            <span id="cart-total" style="color: #ffcc00; font-size: 25px;">₱ {{ number_format(Cart::total(), 2) }}</span>
                        </p>
                    </div>
                    
                    <button type="button" class="btn btn-custom btn-block" data-toggle="modal" data-target="#createInvoiceModal">
                        Create Invoice
                    </button>  
                </div> --}}
                @php
                    $subtotal = Cart::subtotal(); // Initialize subtotal
                    $vatRate = 12; // VAT percentage
                    $vatAmount = $subtotal * ($vatRate / (100 + $vatRate)); // Extract VAT from subtotal
                    $subtotalWithoutVAT = $subtotal - $vatAmount;
                @endphp

            
            <div class="card-footer" style="background-color: #343a40; color: white; padding: 10px;">
                <div class="text-right">
                    <p><strong>Subtotal (Without VAT): </strong>₱<span id="cart-subtotal">{{ number_format($subtotalWithoutVAT, 2) }}</span></p>
                    <p><strong>Tax ({{ $vatRate }}%): </strong>₱<span id="cart-tax">{{ number_format($vatAmount, 2) }}</span></p>
                </div>
                <div class="text-end">
                    <p><strong>Total Amount: </strong> 
                        <span id="cart-total" style="color: #ffcc00; font-size: 25px;">₱ {{ number_format($subtotal, 2) }}</span>
                    </p>
                </div>
                
                <button type="button" class="btn btn-custom btn-block" data-toggle="modal" data-target="#createInvoiceModal">
                    Create Invoice
                </button>  
            </div>
            


            </div>
        </div>
        

<!-- Modal for Creating Invoice and Payment -->
<div class="modal fade" id="createInvoiceModal" tabindex="-1" role="dialog" aria-labelledby="createInvoiceModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content" style="background-color: #c9d1d9; color: #343a40; border-radius: 10px;">
            <!-- Modal Header -->
            <div class="modal-header bg-primary text-white" style="border-top-left-radius: 10px; border-top-right-radius: 10px;">
                <h5 class="modal-title" id="createInvoiceModalLabel">{{ $customer->name ?? 'Customer' }} Invoice</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <!-- Form -->
            <form action="{{ route('pos.storeOrder') }}" method="post">
                @csrf  
                {{-- <div class="modal-body">
                    <input type="hidden" name="id" value="{{ $order->id ?? '' }}"> --}}
                    <div class="modal-body">
                        <!-- Error Message for Insufficient Payment -->
                        @if(session('error'))
                            <div class="alert alert-danger" id="paymentError">
                                {{ session('error') }}
                            </div>
                        @endif
                    
                        <input type="hidden" name="id" value="{{ $order->id ?? '' }}">
                    

                    <!-- Customer Name & Discount in One Row -->
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="customer_name">Customer Name</label>
                                <input type="text" class="form-control" name="customer_name" placeholder="Customer Name" value="{{ old('customer_name') }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="discount">Discount (PWD/Senior)</label>
                                    <select class="form-control" id="discount" name="discount" onchange="applyDiscount()">
                                    <option value="0">None</option>
                                    <option value="5">PWD/Senior (5%)</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Payment Method -->
                    <div class="form-group">
                        <label for="payment_status">Payment</label>
                        <select class="form-control @error('payment_status') is-invalid @enderror" name="payment_status">
                            <option selected="" disabled="">-- Select Payment --</option>
                            <option value="Cash">Cash</option>
                        </select>
                        @error('payment_status')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Pay Now & Change in One Row -->
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="pay">Pay Now</label>
                                <input type="number" class="form-control @error('pay') is-invalid @enderror" id="pay" name="pay" value="{{ old('pay') }}" oninput="calculateChange()">
                                @error('pay')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="change">Change</label>
                                <input type="text" class="form-control" id="change" name="change" value="₱0.00" readonly>
                            </div>
                        </div>
                    </div>

                    <!-- Order Summary Table -->
                    <div class="row">
                        <div class="col-sm-12">
                            <h5 class="mb-3">Order Summary</h5>
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead class="thead-dark">
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
                    @php
                        // Use the raw numeric value of the total, without formatting
                        $rawTotal = floatval(Cart::subtotal(2, '.', '')); // Should be 1225 if that's the correct price
                        $vatRate = 12;
                        $vatAmount = $rawTotal * ($vatRate / (100 + $vatRate)); // Extract VAT
                        $subtotalWithoutVAT = $rawTotal - $vatAmount;
                    @endphp
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="text-right">
                                <p><strong>Subtotal (Without VAT): </strong>₱<span id="subtotal">{{ number_format($subtotalWithoutVAT, 2) }}</span></p>
                                <p><strong>VAT ({{ $vatRate }}%): </strong>₱<span id="vatAmount">{{ number_format($vatAmount, 2) }}</span></p>
                                <h2><strong>Total: </strong>₱<span id="total">{{ number_format($rawTotal, 2) }}</span></h2>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal Footer -->
                <div class="modal-footer">
                    <!-- Complete Order Button -->
                    <button type="submit" class="btn btn-order mr-2" data-toggle="tooltip" data-placement="top" title="Complete">
                        Complete Order
                    </button>

                    <!-- Cancel Button -->
                    <a class="btn btn-danger mr-2" data-toggle="tooltip" data-placement="top" title="Cancel" href="{{ route('pos.index') }}">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
        function calculateChange() {
        var payAmount = parseFloat(document.getElementById("pay").value);
        var totalAmount = parseFloat(document.getElementById("total").textContent);
        var changeAmount = payAmount - totalAmount;
        document.getElementById("change").value = "₱" + changeAmount.toFixed(2);
        }

    // NEWWW --------------------

    document.addEventListener("DOMContentLoaded", function() {
            document.querySelectorAll(".clickable-card").forEach(card => {
                card.addEventListener("click", function() {
                // Create a form dynamically
                let form = document.createElement("form");
                form.method = "POST";
                form.action = "{{ route('pos.addCart') }}";

                // CSRF Token
                let csrfInput = document.createElement("input");
                csrfInput.type = "hidden";
                csrfInput.name = "_token";
                csrfInput.value = "{{ csrf_token() }}";
                form.appendChild(csrfInput);

                // Product ID
                let idInput = document.createElement("input");
                idInput.type = "hidden";
                idInput.name = "id";
                idInput.value = this.getAttribute("data-id");
                form.appendChild(idInput);

                // Product Name
                let nameInput = document.createElement("input");
                nameInput.type = "hidden";
                nameInput.name = "name";
                nameInput.value = this.getAttribute("data-name");
                form.appendChild(nameInput);

                // Product Price
                let priceInput = document.createElement("input");
                priceInput.type = "hidden";
                priceInput.name = "price";
                priceInput.value = this.getAttribute("data-price");
                form.appendChild(priceInput);

                // Append form to body and submit
                document.body.appendChild(form);
                form.submit();
            });
        });
        
        // Check if error message exists and show modal automatically
        if (document.getElementById("paymentError")) {
            var myModal = new bootstrap.Modal(document.getElementById("createInvoiceModal"));
            myModal.show(); // Show the modal automatically if an error occurs
        }
    });

    // ======================================================


    function applyDiscount() {
    // Get the selected discount value as a number (e.g., 5 for 5%)
    var discountValue = parseFloat(document.getElementById("discount").value);
    
      // Use the same raw total that you expect
      var totalAmount = parseFloat("{{ Cart::subtotal(2, '.', '') }}");
    
    // Calculate the discount amount (should be subtracted)
    var discountAmount = (discountValue / 100) * totalAmount;
    
    // Calculate the new total after subtracting the discount
    var newTotal = totalAmount - discountAmount;
    
    // Update the total amount in the modal (formatted to 2 decimals)
    document.getElementById("total").textContent = newTotal.toFixed(2);
}




    // Increase Quantity ==================
    
    $(document).ready(function() {
    console.log("JavaScript Loaded");

    $(".increase-qty, .decrease-qty").click(function() {
        var rowId = $(this).data("rowid");
        var input = $(".qty-input[data-rowid='" + rowId + "']");
        var currentQty = parseInt(input.val());
        var newQty = $(this).hasClass("increase-qty") ? currentQty + 1 : Math.max(1, currentQty - 1);

        input.val(newQty); // Update input field instantly
        updateCart(rowId, newQty);
    });

    $(".qty-input").on("change", function() {
        var rowId = $(this).data("rowid");
        var newQty = parseInt($(this).val());

        if (newQty < 1 || isNaN(newQty)) {
            newQty = 1;
            $(this).val(newQty);
        }

        updateCart(rowId, newQty);
    });

    function updateCart(rowId, qty) {
        $.ajax({
            url: "{{ route('pos.updateCart', ':rowId') }}".replace(':rowId', rowId),
            type: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                qty: qty
            },
            beforeSend: function() {
                console.log("Updating cart...");
                $("#loading-spinner").show();
            },
            success: function(response) {
                console.log("Cart updated!", response);

                // Update subtotal for the product
                $(".subtotal[data-rowid='" + rowId + "']").text("₱" + response.subtotal);

                // ✅ Update cart totals in real-time
                $("#cart-subtotal").text(response.cartSubtotal);
                $("#cart-tax").text(response.cartTax);
                $("#cart-total").text(response.cartTotal);

                $("#loading-spinner").hide();
            },
            error: function(xhr, status, error) {
                console.error("Error updating cart:", xhr.responseText);
                alert("Error updating cart.");
                $("#loading-spinner").hide();
            }
        });
    }
});

    //*PAY NOW LESS THAN TOTAL --------//
    function calculateChange() {
            let total = parseFloat(document.getElementById('total').textContent.replace(/[^0-9.]/g, '')) || 0;
            let pay = parseFloat(document.getElementById('pay').value) || 0;
            let change = pay - total;

            document.getElementById('change').value = change >= 0 ? `₱${change.toFixed(2)}` : "₱0.00";
        }

        document.getElementById("paymentForm").addEventListener("submit", function(event) {
            let total = parseFloat(document.getElementById('total').textContent.replace(/[^0-9.]/g, '')) || 0;
            let pay = parseFloat(document.getElementById('pay').value) || 0;

            if (pay < total) {
                event.preventDefault();  // Prevent form submission
                alert("Payment must be equal to or greater than the total amount!");
            }
        });

   
</script>
@endsection

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
            max-height: 500px; /* Limit the height of the grid */
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
            padding: 5px 10px !important; /* Adjust padding (height and width) */
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
            background-color: #626262 !important;  /* Red background */
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
            color: rgb(255, 255, 255); /* Text color inside the header */
            padding: 15px !important; /* Adjust padding if needed */
            border-radius: 8px 8px 0 0 !important;

            
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


