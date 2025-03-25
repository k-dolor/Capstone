@extends('dashboard.body.main')

@section('container')
<div class="content">
    <h1 class="text-center mb-4" style="font-family: 'Poppins', sans-serif;">Inventory</h1>
    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

    <div class="container-fluid">
        <form action="{{ route('inventory.index') }}" method="get" class="mb-3">
            <div class="row">
                <div class="col-md-1 mb-0">
                    <label for="row" class="form-label-rows">Page Rows:</label>
                    <select class="form-control form-control-sm page-rows" name="row">
                        <option value="10" @if(request('row') == '10') selected @endif>10</option>
                        <option value="25" @if(request('row') == '25') selected @endif>25</option>
                        <option value="50" @if(request('row') == '50') selected @endif>50</option>
                        <option value="100" @if(request('row') == '100') selected @endif>100</option>
                    </select>
                </div>
                <div class="col-md-12 d-flex justify-content-end align-items-end filter-container">
                    <div class="form-group mb-0 flex-grow-1 me-2">
                        <input type="text" id="search" class="form-control search-input" name="search" placeholder="Search Product / Product Code" value="{{ request('search') }}">
                    </div>
                    <div class="form-group mb-0">
                        <label for="category" class="form-label">Filter Category:</label>
                        <select id="category" class="form-control" name="category">
                            <option value="">All Categories</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}" @if(request('category') == $category->id) selected @endif>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group mb-0">
                        <label for="stock_status" class="form-label">Stock Status:</label>
                        <select id="stock_status" class="form-control" name="stock_status">
                            <option value="">All Stock Status</option>
                            <option value="in_stock" @if(request('stock_status') == 'in_stock') selected @endif>In Stock</option>
                            <option value="low_stock" @if(request('stock_status') == 'low_stock') selected @endif>Low Stock</option>
                            <option value="out_of_stock" @if(request('stock_status') == 'out_of_stock') selected @endif>Out of Stock</option>
                        </select>
                    </div>
                    <div class="form-group mb-0 d-flex">
                        <button type="submit" class="btn btn-custom-search me-2">
                            <i class="fa-solid fa-magnifying-glass"></i> Search
                        </button>
                        <a href="{{ route('inventory.index') }}" class="btn btn-custom-clear">
                            Clear
                        </a>
                    </div>
                </div>
            </div>
        </form>

        @if($noProducts)
        <div class="alert alert-warning mt-4">
            <strong>No products found for the selected filter.</strong>
        </div>
        @endif
    </div>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead style="background-color: #dfe3e8;">
                        <tr>
                            <th>Code</th>
                            <th>Product Name</th>
                            <th>Image</th>
                            <th>Category</th>
                            <th>Quantity</th>
                            <th>Stock Status</th>
                            <th>Price per Unit</th>
                            <th>Total Value</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($products as $product)
                        <tr style="background-color: #f9f9f9;">
                            <td>{{ $product->product_code }}</td>
                            <td>{{ $product->product_name }}</td>
                            <td>
                                <img class="product-image" 
                                     src="{{ $product->product_image ? asset('storage/products/'.$product->product_image) : asset('assets/images/product/default.jpg') }}" 
                                     style="width: 50px; height: 50px; object-fit: cover; border-radius: 10px; border: 2px solid #ccc;">
                            </td>
                            
                            <td>{{ $product->category->name }}</td>
                            <td>{{ $product->product_store }}</td>
                            <td>
                                @if ((int)$product->product_store <= 0)
                                    <span style="color: #ff0000; font-weight: bold; background-color: #f8d7da; padding: 8px 8px; border-radius: 5px;">No Stock</span>
                                @elseif ((int)$product->product_store > 0 && (int)$product->product_store < 10)
                                    <span style="color: #f5f4f3; font-weight: bold; background-color: #d33707; padding: 8px 8px; border-radius: 5px;">LowStock</span>
                                @else
                                    <span style="color: #002d13; font-weight: bold; background-color: #25d952a2; padding: 8px 8px; border-radius: 5px;">In Stock</span>
                                @endif
                            </td>
                            <td style="background-color: #f4f6f9;">₱{{ number_format($product->buying_price, 2) }}</td>
                            <td style="background-color: #f4f6f9;">₱{{ number_format($product->selling_price * $product->product_store, 2) }}</td>
                            <td>
                                 <!-- Stock In Button -->
                            <button type="button" class="btn btn-primary btn-sm stock-in-btn" style="border-radius: 3px; font-size:14px; padding: 7px 10px; background-color: #13982d; color: white; border: none;"
                                data-bs-toggle="modal" data-bs-target="#stockInModal" data-product-id="{{ $product->id }}" 
                                data-product-name="{{ $product->product_name }}">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus-circle" viewBox="0 0 16 16">
                                        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
                                <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4"/>
                              </svg> Stock In
                            </button>
                              <!-- History Icon -->
                                <a href="{{ route('products.stock-in-history', $product->id) }}" class="btn btn-sm" title="History" style="border-radius: 3px; font-size:14px; padding: 7px 10px; background-color: #fbe91fc7; color: white; border: none;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="dark" class="bi bi-clock-history" viewBox="0 0 16 16">
                                    <path d="M8.515 1.019A7 7 0 0 0 8 1V0a8 8 0 0 1 .589.022zm2.004.45a7 7 0 0 0-.985-.299l.219-.976q.576.129 1.126.342zm1.37.71a7 7 0 0 0-.439-.27l.493-.87a8 8 0 0 1 .979.654l-.615.789a7 7 0 0 0-.418-.302zm1.834 1.79a7 7 0 0 0-.653-.796l.724-.69q.406.429.747.91zm.744 1.352a7 7 0 0 0-.214-.468l.893-.45a8 8 0 0 1 .45 1.088l-.95.313a7 7 0 0 0-.179-.483m.53 2.507a7 7 0 0 0-.1-1.025l.985-.17q.1.58.116 1.17zm-.131 1.538q.05-.254.081-.51l.993.123a8 8 0 0 1-.23 1.155l-.964-.267q.069-.247.12-.501m-.952 2.379q.276-.436.486-.908l.914.405q-.24.54-.555 1.038zm-.964 1.205q.183-.183.35-.378l.758.653a8 8 0 0 1-.401.432z"/>
                                    <path d="M8 1a7 7 0 1 0 4.95 11.95l.707.707A8.001 8.001 0 1 1 8 0z"/>
                                    <path d="M7.5 3a.5.5 0 0 1 .5.5v5.21l3.248 1.856a.5.5 0 0 1-.496.868l-3.5-2A.5.5 0 0 1 7 9V3.5a.5.5 0 0 1 .5-.5"/>
                                </svg> <span style="color: rgb(97, 83, 0);">History</span> 
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Stock In Modal -->
<div class="modal fade" id="stockInModal" tabindex="-1" aria-labelledby="stockInModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="stockInForm" method="POST" action="{{ route('inventory.stock-in') }}">
                @csrf
                <div class="modal-header bg-primary">
                    <h5 class="modal-title" id="stockInModalLabel">Stock In</h5>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="product_id" id="productId">
                    <div class="mb-3">
                        <label for="productName" class="form-label">Product Name</label>
                        <input type="text" id="productName" class="form-control" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="quantity" class="form-label">Quantity</label>
                        <input type="number" name="quantity_added" id="quantity_added" class="form-control" min="1" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Add Stock</button>
                </div>
            </form>
        </div>
    </div>
</div>


<script>
    document.addEventListener('DOMContentLoaded', function () {
        const stockInModal = document.getElementById('stockInModal');
        const productIdInput = document.getElementById('productId');
        const productNameInput = document.getElementById('productName');

        stockInModal.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget;
            const productId = button.getAttribute('data-product-id');
            const productName = button.getAttribute('data-product-name');

            productIdInput.value = productId;
            productNameInput.value = productName;
        });
    });
</script>


<style>
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
    border-radius: 0% !important;
    padding: 5px 10px !important;
    transition: background-color 0.3s ease !important;
}

.btn-custom-actions:hover {
    background-color:  #003df4 !important;
}

.search-input {
    width: 105% !important; /* Longer search input */
    height: 40px !important;
    font-size: 14px !important;
    padding: 8px 15px !important;
    border-radius: 0px !important;
}
.search-input, 
#category,
#stock_status {
    height: 40px !important;
    font-size: 14px !important;
    padding: 8px 15px !important;
}

/* Order Date Filter Styling */
#category,
#stock_status {
    border: 1px solid #ced4da !important;
    border-radius: 0px !important;
    background-color: #f8f9fa !important;
    color: #495057 !important;
    transition: border-color 0.3s ease !important;
}


</style>
@endsection
