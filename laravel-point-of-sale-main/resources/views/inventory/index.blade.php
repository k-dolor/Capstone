@extends('dashboard.body.main')

@section('container')
<div class="content">
    <div class="card">
        <div class="card-header">
            <h4>Inventory Management</h4>
            {{-- <a href="#" class="btn btn-primary">Add New Product</a> --}}
            <a href="{{ route('products.create') }}" class="btn btn-primary">Add New Product</a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Product ID</th>
                            <th>Product Name</th>
                            <th>Category</th>
                            <th>Supplier</th>
                            <th>Quantity in Stock</th>
                            <th>Stock Status</th>
                            {{-- <th>Reorder Level</th> --}}
                            <th>Price per Unit</th>
                            <th>Total Value</th>
                            {{-- <th>Last Refill Date</th> --}}
                            {{-- <th>Next Inspection Due</th> --}}
                            {{-- <th>Maintenance Date</th> --}}
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($products as $product)
                        <tr>
                            <td>{{ $product->id }}</td>
                            <td>{{ $product->product_name }}</td>
                            <td>{{ $product->category ? $product->category->name : 'N/A' }}</td> <!-- Display category name -->
                            {{-- <td>{{ $product->supplier_id }}</td> --}}
                            <td>{{ $product->product_store }}</td>
                            <td>
                                @if ((int)$product->product_store <= 0)
                                <span class="badge badge-danger">No Stock</span>
                            @elseif ((int)$product->product_store > 0 && (int)$product->product_store < 20)
                                <span class="badge badge-warning">Low Stock</span>
                            @else
                                <span class="badge badge-success">In Stock</span>
                            @endif
                            </td>
                            
                            {{-- <td>
                                <span class="badge {{ $product->quantity <= $product->reorder_level ? 'badge-warning' : 'badge-success' }}">
                                    {{ $product->quantity <= $product->reorder_level ? 'Low Stock' : 'In Stock' }}
                                </span>
                            </td> --}}
                            {{-- <td>{{ $product->reorder_level }}</td> --}}
                            <td>₱{{ number_format($product->buying_price, 2) }}</td>
                            <td>₱{{ number_format($product->selling_price * $product->product_store, 2) }}</td>
                            {{-- <td>{{ $product->last_refill_date->format('Y-m-d') }}</td> --}}
                            {{-- <td>{{ $product->next_inspection_due->format('Y-m-d') }}</td> --}}
                            {{-- <td>{{ $product->maintenance_date->format('Y-m-d') }}</td> --}}
                            <td>
                                {{-- <a href="{{ route('inventory.edit', $product) }}" class="btn btn-sm btn-info">Edit</a> --}}
                                <a href="{{ route('products.edit', $product->id) }}" class="btn btn-sm btn-info">Edit</a>
                                <form action="#" method="POST" style="display:inline;">
                                {{-- <form action="{{ route('inventory.destroy', $product) }}" method="POST" style="display:inline;"> --}}
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
