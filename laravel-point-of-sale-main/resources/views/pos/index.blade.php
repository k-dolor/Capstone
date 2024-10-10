@extends('dashboard.body.main')

@section('container')
<div class="container-fluid">
    <div class="row">
        <!-- Left Column: Product Display -->
        <div class="col-lg-7 col-md-12">
            <div class="d-flex justify-content-between mb-3">
                <h4 class="mb-3">Point of Sale</h4>
                <form action="#" method="get">
                    <div class="input-group">
                        <input type="text" id="search" class="form-control" name="search" placeholder="Search product" value="{{ request('search') }}">
                        <div class="input-group-append">
                            <button type="submit" class="input-group-text bg-primary"><i class="fa-solid fa-magnifying-glass"></i></button>
                            <a href="{{ route('products.index') }}" class="input-group-text bg-danger"><i class="fa-solid fa-trash"></i></a>
                        </div>
                    </div>
                </form>
            </div>
            
            <!-- Product Grid -->
            <div class="row">
                @forelse ($products as $product)
                <div class="col-md-4 mb-3">
                    <div class="card text-center">
                        <img src="{{ $product->product_image ? asset('storage/products/'.$product->product_image) : asset('assets/images/product/default.webp') }}" class="card-img-top" alt="{{ $product->product_name }}" style="height: 150px;">
                        <div class="card-body">
                            <h5 class="card-title">{{ $product->product_name }}</h5>
                            <p class="card-text">{{ $product->selling_price }}</p>
                            <form action="{{ route('pos.addCart') }}" method="POST">
                                @csrf
                                <input type="hidden" name="id" value="{{ $product->id }}">
                                <input type="hidden" name="name" value="{{ $product->product_name }}">
                                <input type="hidden" name="price" value="{{ $product->selling_price }}">
                                <button type="submit" class="btn btn-primary btn-sm">Add to Cart</button>
                            </form>
                        </div>
                    </div>
                </div>
                @empty
                <div class="alert text-white bg-danger" role="alert">
                    <div class="iq-alert-text">No Products Found.</div>
                </div>
                @endforelse
            </div>
            {{ $products->links() }}
        </div>

        <!-- Right Column: Cart and Checkout -->
        <div class="col-lg-5 col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5>Checkout</h5>
                </div>
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>QTY</th>
                                <th>Price</th>
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
                                <td>{{ $item->price }}</td>
                                <td>
                                    <a href="{{ route('pos.deleteCart', $item->rowId) }}" class="btn btn-danger btn-sm">Remove</a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div class="text-right">
                        <p><strong>Subtotal: </strong>{{ Cart::subtotal() }}</p>
                        <p><strong>Tax: </strong>{{ Cart::tax() }}</p>
                        <p><strong>Total: </strong>{{ Cart::total() }}</p>
                    </div>

                    <!-- Create Invoice and Payment Modal Trigger Button -->
                    <button type="button" class="btn btn-success btn-block" data-toggle="modal" data-target="#createInvoiceModal">
                        Create Invoice
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal for Creating Invoice and Payment -->
<div class="modal fade" id="createInvoiceModal" tabindex="-1" role="dialog" aria-labelledby="createInvoiceModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title text-white" id="createInvoiceModalLabel">Invoice for {{ $customer->name ?? 'Customer' }}</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
                    <form action="{{ route('pos.storeOrder') }}" method="post">
                    @csrf  
                <div class="modal-body">
                    <input type="hidden" name="id" value="{{ $order->id ?? '' }}">
                    
                    <!-- Payment Method -->
                    <div class="form-group">
                        <label for="payment_status">Payment</label>
                        <select class="form-control @error('payment_status') is-invalid @enderror" name="payment_status">
                            <option selected="" disabled="">-- Select Payment --</option>
                            <option value="HandCash">HandCash</option>
                            <option value="Cheque">Cheque</option>
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

                    <!-- Total Amount -->
<div class="row">
    <div class="col-sm-12">
        <div class="text-right">
            <p><strong>Subtotal: </strong>₱{{ Cart::subtotal() }}</p>
            <p><strong>Tax: </strong>₱{{ Cart::tax() }}</p>
            <p><strong>Total: </strong>₱{{ Cart::total() }}</p>
        </div>
    </div>
</div>

                <div class="modal-footer">
                    <!-- Complete Order Button -->
                    <button type="submit" class="btn btn-success mr-2 border-none" data-toggle="tooltip" data-placement="top" title="Complete">Complete Order</button>
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

<script>
    function calculateChange() {
        const total = parseFloat('{{ Cart::total() }}'); // Get the total amount from cart
        const pay = parseFloat(document.getElementById('pay').value) || 0; // Get the amount user is paying
        const change = pay - total; // Calculate change amount

        // Display change amount, ensuring it doesn't go negative
        document.getElementById('change').value = '₱' + (change < 0 ? 0 : change.toFixed(2));
    }
</script>
@endsection
