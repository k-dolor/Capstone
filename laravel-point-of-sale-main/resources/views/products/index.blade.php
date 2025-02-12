@extends('dashboard.body.main')

@section('container')
<h1 class="text-center mb-4" style="font-family: 'Poppins', sans-serif;">Products Management</h1>
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            @if (session()->has('success'))
                <div class="alert text-white bg-success" role="alert">
                    <div class="iq-alert-text">{{ session('success') }}</div>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <i class="ri-close-line"></i>
                    </button>
                </div>
            @endif
            @if (session()->has('error'))
    <div class="alert text-white bg-danger" role="alert">
        <div class="iq-alert-text">{{ session('error') }}</div> <!-- Fix: Change success to error -->
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <i class="ri-close-line"></i>
        </button>
    </div>
@endif

            <div class="d-flex flex-wrap align-items-right justify-content-between mb-4">
                <div>
                    <a href="{{ route('products.importView') }}" class="btn btn-success add-list">Import</a>
                    <a href="{{ route('products.exportData') }}" class="btn btn-warning add-list">Export</a>
                    <a href="{{ route('products.create') }}" class="btn btn-primary add-list">Add Product</a>
                </div>
            </div>
        </div>

        <div class="container-fluid">
            <form action="{{ route('products.index') }}" method="get" class="mb-3">
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
                            <input type="text" id="search" class="form-control search-input" name="search" placeholder="Search Product" value="{{ request('search') }}">
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
                        <div class="form-group mb-0 d-flex">
                            <button type="submit" class="btn btn-custom-search me-2">
                                <i class="fa-solid fa-magnifying-glass"></i> Search
                            </button>
                            <a href="{{ route('products.index') }}" class="btn btn-custom-clear">
                                Clear
                            </a>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <div class="col-lg-12">
            <div class="card">
                </div>
                <div class="card-body"  style="background: white;">
                    <div class="table-responsive ">
                        <table class="table">
                            <thead class="text-uppercase">
                                <tr class="ligth ligth-data">
                                    <th>ID No.</th>
                                    <th>Photo</th>
                                    <th>Name</th>
                                    <th>Code</th>
                                    <th>Category</th>
                                    <th>@sortablelink('selling_price', 'price')</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody >
                                @forelse ($products as $product)
                                    <tr>
                                        <td>{{ $product->id}}</td>
                                        <td>
                                            {{-- <img class="crm-profile-pic rounded-circle avatar-100" id="image-preview" src="{{ $product->product_image ? asset('storage/products/'.$product->product_image) : asset('assets/images/product/default.webp') }}" alt="profile-pic"> --}}
                                            <img class="product-image" src="{{ $product->product_image ? asset('storage/products/'.$product->product_image) : asset('assets/images/product/default.jpg') }}">
                                            
                                        </td>
                                        <td>{{ $product->product_name }}</td>
                                        <td>{{ $product->product_code }}</td>
                                        <td>{{ $product->category->name ?? 'No Category' }}</td>
                                        <td>{{ $product->selling_price }}</td>
                                        <td>
                                            <form action="{{ route('products.destroy', $product->id) }}" method="POST" style="margin-bottom: 5px">
                                                @method('delete')
                                                @csrf
                                                <div class="d-flex align-items-center list-action">
                                                    <a class="btn btn-sm view-product-btn" 
                                                    style="border-radius: 0; background-color: #13982d; color: rgb(255, 255, 255); border: none;" 
                                                    data-id="{{ $product->id }}" data-toggle="modal" data-target="#productModal">
                                                     <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye" viewBox="0 0 16 16">
                                                         <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8M1.173 8a13 13 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5s3.879 1.168 5.168 2.457A13 13 0 0 1 14.828 8q-.086.13-.195.288c-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5s-3.879-1.168-5.168-2.457A13 13 0 0 1 1.172 8z"/>
                                                         <path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5M4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0"/>
                                                     </svg> View
                                                 </a>
                                                 <a class="btn btn-sm edit-product-btn"
                                                 style="border-radius: 0; background-color: #007bff; color: white; border: none;"
                                                 data-id="{{ $product->id }}" 
                                                 data-name="{{ $product->product_name }}"
                                                 data-category="{{ $product->category_id }}"
                                                 data-supplier="{{ $product->supplier_id }}"
                                                 data-buying-price="{{ $product->buying_price }}"
                                                 data-selling-price="{{ $product->selling_price }}"
                                                 data-image="{{ $product->product_image ? asset('storage/products/' . $product->product_image) : asset('assets/images/product/default.webp') }}"
                                                 data-toggle="modal" 
                                                 data-target="#editProductModal">
                                                 <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                                    <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                                    <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z"/>
                                                  </svg> Edit
                                             </a>
                                                    <button type="submit" class="btn btn-sm"style="border-radius: 0; background-color: #dc3545; color: white; border: none;"
                                                     onclick="return confirm('Are you sure you want to delete this record?')"> <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash3" viewBox="0 0 16 16">
                                                        <path d="M6.5 1h3a.5.5 0 0 1 .5.5v1H6v-1a.5.5 0 0 1 .5-.5M11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3A1.5 1.5 0 0 0 5 1.5v1H1.5a.5.5 0 0 0 0 1h.538l.853 10.66A2 2 0 0 0 4.885 16h6.23a2 2 0 0 0 1.994-1.84l.853-10.66h.538a.5.5 0 0 0 0-1zm1.958 1-.846 10.58a1 1 0 0 1-.997.92h-6.23a1 1 0 0 1-.997-.92L3.042 3.5zm-7.487 1a.5.5 0 0 1 .528.47l.5 8.5a.5.5 0 0 1-.998.06L5 5.03a.5.5 0 0 1 .47-.53Zm5.058 0a.5.5 0 0 1 .47.53l-.5 8.5a.5.5 0 1 1-.998-.06l.5-8.5a.5.5 0 0 1 .528-.47M8 4.5a.5.5 0 0 1 .5.5v8.5a.5.5 0 0 1-1 0V5a.5.5 0 0 1 .5-.5"/>
                                                      </svg> Delete</button>
                                                </div>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <div class="alert text-white bg-danger" role="alert">
                                        <div class="iq-alert-text">Product Data not Found.</div>
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <i class="ri-close-line"></i>
                                        </button>
                                    </div>
                                    @endforelse
                            </tbody>
                        </table>
                    </div>
                    {{ $products->links() }}
                </div>
            </div>
        </div>
    </div>
    
    <!-- Product Details Modal -->

    <div class="modal fade" id="productModal" tabindex="-1" role="dialog" aria-labelledby="productModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header bg-info text-white">
                    <h5 class="modal-title" id="productModalLabel">Product Details</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <!-- Product Image and Name -->
                        <div class="col-md-4 text-center">
                            <img id="modalProductImage" class="img-fluid rounded shadow mb-3" alt="Product Image">
                            <h5 id="modalProductName" class="modal-product-name"></h5>
                        </div>
                        <!-- Product Details -->
                        <div class="col-md-8">
                            <table class="table table-bordered">
                                <tr>
                                    <th class="modal-th">Product Code</th>
                                    <td id="modalProductCode"></td>
                                </tr>
                                <tr>
                                    <th class="modal-th">Category</th>
                                    <td id="modalProductCategory"></td>
                                </tr>
                                <tr>
                                    <th class="modal-th">Selling Price</th>
                                    <td id="modalSellingPrice"></td>
                                </tr>
                                <tr>
                                    <th class="modal-th">Stock Quantity</th>
                                    <td id="modalStockQuantity"></td>
                                </tr>
                                <tr>
                                    <th class="modal-th">Supplier</th>
                                    <td id="modalSupplier"></td>
                                </tr>
                                <tr>
                                    <th class="modal-th">Added On</th>
                                    <td id="modalCreatedAt"></td>
                                </tr>
                                
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Product Edit Modal  ===============================--}}
    
  <!-- Edit Product Modal ------OLD------>
  {{-- <div class="modal fade" id="editProductModal" tabindex="-1" role="dialog" aria-labelledby="editProductModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
                <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('put')
                    <input type="hidden" id="editProductId" name="product_id"> 
                <div class="modal-header">
                    <h5 class="modal-title" id="editProductModalLabel">Edit Product</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Form fields -->
                    <!-- Image Preview -->
                    <div class="form-group text-center">
                        <label>Product Image</label>
                        <div>
                            <img id="editProductImagePreview" class="crm-profile-pic rounded-circle avatar-100"
                                 src="{{ asset('assets/images/product/default.webp') }}"
                                 alt="product-image" 
                                 style="max-height: 150px; border: 1px solid #ccc; padding: 5px;">
                        </div>
                    <!-- Image Upload -->
                    <div class="form-group">
                        <label for="editProductImage">Change Image</label>
                        <input type="file" class="form-control-file" id="editProductImage" name="product_image" accept="image/*">
                    </div>
                </div>
                    <div class="form-group">
                        <label for="editProductName">Product Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('product_name') is-invalid @enderror" id="editProductName" name="product_name" required>
                    </div>
                    <!-- Category -->
                    <div class="form-group">
                        <label for="editProductCategory">Category <span class="text-danger">*</span></label>
                        <select class="form-control" id="editProductCategory" name="category_id" required>
                            <option selected disabled>-- Select Category --</option>
                            @foreach ($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>                    
                    </div>
                    <!-- Supplier -->
                    <div class="form-group">
                        <label for="editProductSupplier">Supplier <span class="text-danger">*</span></label>
                        <select class="form-control" id="editProductSupplier" name="supplier_id" required>
                            <option selected disabled>-- Select Supplier --</option>
                            @foreach ($suppliers as $supplier)
                            <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <!-- Buying Price -->
                    <div class="form-group">
                        <label for="editBuyingPrice" class="form-label">Buying Price</label>
                        <input type="number" id="editBuyingPrice" name="buying_price" class="form-control" step="0.01" required>
                    </div>
                    <!-- Selling Price -->
                    <div class="form-group">
                        <label for="editProductPrice">Selling Price</label>
                        <input type="number" class="form-control" id="editProductPrice" name="selling_price" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div> --}}

<!-- Edit Product Modal -->
<div class="modal fade" id="editProductModal" tabindex="-1" aria-labelledby="editProductModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editProductModalLabel">Edit Product</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="editProductForm" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="_method" value="PUT">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div class="modal-body">
                    <input type="hidden" id="edit_product_id" name="id">

                    <div class="form-group">
                        {{-- <label for="edit_product_image">Product Image</label> --}}
                        {{-- <img id="edit_product_preview" src="" alt="Product Image" class="img-fluid" width="100"> --}}
                        <img class="crm-profile-pic rounded-circle avatar-100" id="image-preview" src="{{ $product->product_image ? asset('storage/products/'.$product->product_image) : asset('assets/images/product/default.webp') }}" alt="product_image">
                    </div>
                    <div class="input-group mb-4 col-lg-6">
                        <div class="custom-file">
                            <input type="file" class="custom-file-input @error('product_image') is-invalid @enderror" id="product_image" name="product_image" accept="image/*" onchange="previewImage();">
                            <label class="custom-file-label" for="product_image">Choose file</label>
                        </div>
                        @error('product_image')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="edit_product_name">Product Name</label>
                        <input type="text" class="form-control" id="edit_product_name" name="product_name" required>
                    </div>

                    <div class="form-group">
                        <label for="edit_category">Category</label>
                        <select class="form-control" id="edit_category" name="category_id">
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="edit_supplier">Supplier</label>
                        <select class="form-control" id="edit_supplier" name="supplier_id">
                            @foreach($suppliers as $supplier)
                                <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="edit_buying_price">Buying Price</label>
                        <input type="number" class="form-control" id="edit_buying_price" name="buying_price" required>
                    </div>

                    <div class="form-group">
                        <label for="edit_selling_price">Selling Price</label>
                        <input type="number" class="form-control" id="edit_selling_price" name="selling_price" required>
                    </div>

                    {{-- <div class="form-group">
                        {{-- <label for="edit_product_image">Product Image</label> --}}
                        {{-- <img id="edit_product_preview" src="" alt="Product Image" class="img-fluid" width="100"> --}}
                        {{-- <img class="crm-profile-pic rounded-circle avatar-100" id="image-preview" src="{{ $product->product_image ? asset('storage/products/'.$product->product_image) : asset('assets/images/product/default.webp') }}" alt="product_image">
                    </div> --}} 
                    {{-- <div class="input-group mb-4 col-lg-6">
                        <div class="custom-file">
                            <input type="file" class="custom-file-input @error('product_image') is-invalid @enderror" id="image" name="product_image" accept="image/*" onchange="previewImage();">
                            <label class="custom-file-label" for="product_image">Choose file</label>
                        </div>
                        @error('product_image')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div> --}}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

    
                


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    $('.view-product-btn').click(function() {
        var productId = $(this).data('id');  // Get product ID
        $('#loadingSpinner').show();  // Show spinner
        $('#productDetails').addClass('d-none'); // Hide content

        $.ajax({
            url: "/products/" + productId,  // Laravel route to fetch product data
            type: "GET",
            success: function(response) {
                $('#loadingSpinner').hide();  // Hide spinner
                $('#productDetails').removeClass('d-none'); // Show content

                // Populate modal with product data
                $('#modalProductImage').attr('src', response.product_image);
                $('#modalProductName').text(response.product_name);
                $('#modalProductCode').text(response.product_code);
                $('#modalProductCategory').text(response.category_name || "No Category");
                $('#modalSellingPrice').text(response.selling_price);
                $('#modalStockQuantity').text(response.product_store);
                $('#modalSupplier').text(response.supplier_name || "No Supplier");
                $('#modalCreatedAt').text(response.created_at);
            },
            error: function() {
                alert('Failed to load product details.');
            }
        });
    });
});

//EDIT MODAL ===================


$(document).ready(function () {
    $(".edit-product-btn").click(function () {
        let id = $(this).data("id");
        let product_image = $(this).data('product_image');
        let name = $(this).data("name");
        let category = $(this).data("category");
        let supplier = $(this).data("supplier");
        let buyingPrice = $(this).data("buying-price");
        let sellingPrice = $(this).data("selling-price");
        let image = $(this).data("image");

        $("#edit_product_id").val(id);
        $("#product_image").val(product_image);
        $("#edit_product_name").val(name);
        $("#edit_category").val(category);
        $("#edit_supplier").val(supplier);
        $("#edit_selling_price").val(sellingPrice);
        $("#edit_buying_price").val(buyingPrice);
        $("#edit_product_preview").attr("src", image);

        $("#editProductForm").attr("action", "/products/update/" + id);
    });
});



</script>


<style>
    /* Product Image */
    .product-image {
        width: 53px; /* Adjust width */
        height: 53px; /* Adjust height */
        object-fit: cover; /* Maintain aspect ratio without stretching */
        object-position: center; /* Center the image */
        border-radius: 8px; /* Add rounded corners */
        border: 2px solid #ddd; /* Optional: Add a border */
    }
    
    /* Action Buttons */
    .list-action .btn {
        padding: 10px 10px; /* Adjust padding */
        font-size: 14px !important; /* Adjust font size */
        margin-right: 4px; /* Add space between buttons */
        border-radius: 2px !important; /* Rounded corners */
    }
    
    .list-action .btn i {
        font-size: 14px; /* Adjust icon size */
    }
    
    /* Status Stocks Badges */
    .badge {
        font-size: 12px; /* Adjust font size */
        padding: 5px 8px; /* Adjust padding */
        border-radius: 12px; /* Rounded corners */
        text-transform: uppercase; /* Make text uppercase */
    }
    
    .badge-danger {
        background-color: #e74c3c; /* Customize color */
        color: white;
    }
    
    .badge-warning {
        background-color: #f39c12; /* Customize color */
        color: white;
    }
    
    .badge-success {
        background-color: #27ae60; /* Customize color */
        color: white;
    }
    
    /* Table Styles */
    .table {
        background-color: #f8f9fa; /* Table background color */
        border-collapse: collapse; /* Remove gaps between borders */
        width: 100%;
    }
    
    .table th {
        background-color: #dfe3e8 !important; /* Header background color */
        color: #fff; /* Header text color */
        font-weight: bold;
        text-transform: uppercase;
        padding: 0px !important;
    }
    
    .table tr:nth-child(even) {
        background-color: #f2f2f2; /* Alternate row color */
    }
    
    .table tr:nth-child(odd) {
        background-color: #ffffff; /* Default row color */
    }
    
    .table tr:hover {
        background-color: #9cacb6; /* Row hover color */
    }
    
    .table td {
        padding: 8px; /* Cell padding */
        vertical-align: middle;
        text-align: center; /* Center align text */
        border: 1px solid #ddd; /* Cell borders */
    }
    
    /* Scrollable Table */
    .table-responsive {
        overflow-x: auto;
        border: 1px solid #ddd;
        border-radius: 8px; /* Rounded corners for table container */
    }
    
    /* Pagination Links */
    .pagination {
        justify-content: center; /* Center pagination */
        margin-top: 20px;
    }
    
    .pagination .page-link {
        color: #007bff; /* Link color */
        border-radius: 50%; /* Rounded pagination buttons */
    }
    
    .pagination .page-item.active .page-link {
        background-color: #007bff; /* Active page background color */
        border-color: #007bff;
        color: #fff; /* Active page text color */
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
#category {
    height: 40px !important;
    font-size: 14px !important;
    padding: 8px 15px !important;
}

/* Order Date Filter Styling */
#category {
    border: 1px solid #ced4da !important;
    border-radius: 0px !important;
    background-color: #f8f9fa !important;
    color: #495057 !important;
    transition: border-color 0.3s ease !important;
}

/* /// Modal Styling */

/* Modal Header */
.modal-header {
    background-color: #ff6a00 !important;
    color: #fff;
}

/* Table Styling for Modal */
.modal-content .modal-th {
    background-color: #f8f9fa !important; /* Light gray */
    color: #6c757d !important;           /* Dark gray */
    text-transform: uppercase;
    font-weight: bold;
    font-size: 14px;
    width: 30%; /* Adjust for better alignment */
}

.table td {
    font-size: 15px;
    color: #212529;
}

/* Image Styling */
#modalProductImage {
    max-width: 200px;
    max-height: 200px;
    border: 2px solid #dee2e6;
    padding: 5px;
    border-radius: 8px;
}

/* Product Name Styling (Customizable) */
.modal-product-name {
    font-size: 22px;
    color: #ff6200; /* Default color */
    text-transform: capitalize;
    margin-top: 10px;
}

/* Modal Content Spacing */
.modal-body {
    padding: 20px;
}
<



</style>
@endsection
