@extends('dashboard.body.main')

@section('container')
<div class="container-fluid">
    <div class="row">

        <div class="col-lg-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <div class="header-title">
                        <h4 class="card-title">Information Order Details</h4>
                    </div>
                </div>

                <div class="card-body">
                    <!-- begin: Show Data -->
                    <div class="form-group row align-items-center">
                        <div class="col-md-12">
                    </div>

                    <div class="row align-items-center">
                        <div class="form-group col-md-12">
                            <label>Customer Name</label>
                            <input type="text" class="form-control bg-white" value="{{ $order->customer->name }}" readonly>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Order Date</label>
                            <input type="text" class="form-control bg-white" value="{{ $order->order_date }}" readonly>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Order Invoice</label>
                            <input class="form-control bg-white" id="buying_date" value="{{ $order->invoice_no }}" readonly/>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Payment Status</label>
                            <input class="form-control bg-white" id="expire_date" value="{{ $order->payment_status }}" readonly />
                        </div>
                        <div class="form-group col-md-6">
                            <label>Paid Amount</label>
                            <input type="text" class="form-control bg-white" value="{{ $order->pay }}" readonly>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Due Amount</label>
                            <input type="text" class="form-control bg-white" value="{{ $order->due }}" readonly>
                        </div>
                    </div>
                    <!-- end: Show Data -->

                    @if ($order->order_status == 'pending')
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="d-flex align-items-center list-action">
                                    <form action="{{ route('order.updateStatus') }}" method="POST" style="margin-bottom: 5px">
                                        @method('put')
                                        @csrf
                                        <input type="hidden" name="id" value="{{ $order->id }}">
                                        <button type="submit" class="btn btn-success mr-2 border-none" data-toggle="tooltip" data-placement="top" title="" data-original-title="Complete">Complete Order</button>

                                        <a class="btn btn-danger mr-2" data-toggle="tooltip" data-placement="top" title="" data-original-title="Cancel" href="{{ route('order.pendingOrders') }}">Cancel</a>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>


        <!-- end: Show Data -->
        <div class="col-lg-12">
            <div class="table-responsive rounded mb-3">
                <table class="table mb-0">
                    <thead class="bg-white text-uppercase">
                        <tr class="ligth ligth-data">
                            <th>No.</th>
                            <th>Photo</th>
                            <th>Product Name</th>
                            <th>Product Code</th>
                            <th>Quantity</th>
                            <th>Price</th>
                            <th>Total(+vat)</th>
                        </tr>
                    </thead>
                    <tbody class="ligth-body">
                        @foreach ($orderDetails as $item)
                        <tr>
                            <td>{{ $loop->iteration  }}</td>
                            <td>
                                <img class="avatar-60 rounded" src="{{ $item->product->product_image ? asset('storage/products/'.$item->product_image) : asset('storage/products/default.jpg') }}">
                            </td>
                            <td>{{ $item->product->product_name }}</td>
                            <td>{{ $item->product->product_code }}</td>
                            <td>{{ $item->quantity }}</td>
                            <td>{{ $item->unitcost }}</td>
                            <td>{{ $item->total }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- Page end  -->
</div>

@include('components.preview-img-form')

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const modal = document.getElementById('actionModal');
        const modalContent = document.getElementById('modalContent');

        modal.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget; // Button that triggered the modal
            const action = button.getAttribute('data-action');
            const url = button.getAttribute('data-url');
            const id = button.getAttribute('data-id');

            modalContent.innerHTML = `<p>Loading ${action} for Order #${id}...</p>`;

            // Simulate content loading (you can replace this with an AJAX call if needed)
            setTimeout(() => {
                if (action === 'details') {
                    modalContent.innerHTML = `<p>Here are the details for Order #${id}. <a href="${url}" target="_blank">View Full Details</a></p>`;
                } else if (action === 'print') {
                    modalContent.innerHTML = `<p>Preparing to print Invoice for Order #${id}. <a href="${url}" target="_blank">Download Invoice</a></p>`;
                }
            }, 500); // Simulated delay
        });
    });
</script>

@endsection
