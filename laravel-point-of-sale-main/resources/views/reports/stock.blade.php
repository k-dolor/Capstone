@extends('dashboard.body.main')

@section('container')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <h4 class="mb-3">Stock Report</h4>
            <div class="table-responsive rounded mb-3">
                <table class="table mb-0">
                    <thead class="bg-white text-uppercase">
                        <tr class="ligth ligth-data">
                            <th>No.</th>
                            <th>Product Name</th>
                            <th>Stock Quantity</th>
                            <th>Stock Level</th>
                        </tr>
                    </thead>
                    <tbody class="ligth-body">
                        @forelse ($products as $index => $product)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $product->product_name }}</td>
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
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4">No products available</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
