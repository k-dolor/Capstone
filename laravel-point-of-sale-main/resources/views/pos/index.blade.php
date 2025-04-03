@extends('dashboard.body.main')
<link rel="stylesheet" href="{{ asset('assets/css/style/pos.css') }}">
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



