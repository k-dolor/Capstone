@extends('dashboard.body.main')

@section('container')
    <div class="receipt-container" style="max-width: 380px; margin: 0 auto; padding: 20px; border: 1px solid #ddd; background-color: #fff;">
        <div class="receipt-header text-center">
            <img src="{{ asset('assets/images/ln_logo.png') }}" alt="logo" class="img-fluid" style="max-width: 50px; height: 50px;">
            <h4 style="margin-top: 10px;">L&N Gas</h4>
            <p>Roxas City, Capiz, Philippines</p>
            <p>lngas@gmail.com</p>
            <p>+63 912 345 6789</p> <!-- Add phone number if needed -->
        </div>

        <hr style="border-top: 1px solid #000; margin: 10px 0;">

        <div class="receipt-details">
            <p><strong>Invoice No:</strong> #{{ $order->invoice_no }}</p>
            <p><strong>Date:</strong> {{ $order->order_date }}</p>
        </div>

        <hr style="border-top: 1px solid #000; margin: 10px 0;">

        <table class="table table-sm receipt-table" style="width: 100%;">
            <thead>
                <tr>
                    <th>Description</th>
                    <th>Qty</th>
                    <th>Price</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($orderDetails as $item)
                <tr>
                    <td>{{ $item->product->product_name }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>₱{{ $item->unitcost }}</td>
                    <td>₱{{ $item->total }}</td>
                </tr>
                @endforeach
                <tr>
                    <td colspan="3"><strong>Subtotal</strong></td>
                    <td><strong>₱{{ $order->sub_total }}</strong></td> <!-- Assuming you have a subtotal field -->
                </tr>
                <tr>
                    <td colspan="3"><strong>VAT (12%)</strong></td>
                    <td><strong>₱{{ $order->vat }}</strong></td> <!-- VAT Amount -->
                </tr>
                <tr>
                    <td colspan="3"><strong>Total</strong></td>
                    <td><strong>₱{{ $order->total }}</strong></td>
                </tr>
            </tbody>
        </table>

        <hr style="border-top: 1px solid #000; margin: 10px 0;">

        <div class="receipt-summary">
            <p><strong>Payment Status:</strong> {{ $order->payment_status }}</p>
            <p><strong>Paid:</strong> ₱{{ $order->pay }}</p>
            <p><strong>Due:</strong> ₱{{ $order->due }}</p>
        </div>

        <hr style="border-top: 1px solid #000; margin: 10px 0;">

        <div class="text-center">
            <p>Thank you for your business!</p>
        </div>

        <div class="receipt-footer text-center d-print-none" style="margin-top: 20px;">
            <button class="btn btn-primary btn-sm" onclick="window.print()">Print Receipt</button>
            <a href="{{ route('pos.index') }}" class="btn btn-secondary btn-sm">Back to POS</a>
        </div>
    </div>
@endsection
