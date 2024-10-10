@extends('dashboard.body.main')

@section('container')
<div class="container-fluid">
    <h4 class="mb-4">Sales Report</h4>

    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Invoice No</th>
                    <th>Customer Name</th>
                    <th>Order Date</th>
                    <th>Total Amount</th>
                    <th>Payment Type</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($sales as $sale)
                <tr>
                    <td>{{ $sale->invoice_no }}</td>
                    <td>{{ $sale->customer->name ?? 'N/A' }}</td>
                    <td>{{ $sale->order_date }}</td>
                    <td>₱{{ $sale->total }}</td>
                    <td>{{ $sale->payment_status }}</td>
                    <td>
                        @if ($sale->order_status == 'pending')
                            <span class="badge badge-warning">Pending</span>
                        @elseif ($sale->order_status == 'complete')
                            <span class="badge badge-success">Complete</span>
                        @else
                            <span class="badge badge-secondary">{{ ucfirst($sale->order_status) }}</span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
