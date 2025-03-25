@extends('dashboard.body.main')

@section('container')
    <div class="receipt-container" style="max-width: 550px; margin: 0 auto; padding: 20px; border: 1px solid #ddd; background-color: #fff;">
        <div class="receipt-header text-center">
            <img src="{{ asset('assets/images/ln_logo.png') }}" alt="logo" class="img-fluid" style="max-width: 80px; height: 70px;">
            <h3 style="margin-top: 10px;">L&N Gas</h3>
            <p>Lounel Jigs D Bucayan - Prop <br>
                Lawa-an, Roxas City, Capiz <br>
                VAT Reg TIN: 448-106-825-00000 <br>
                Contact # 09388822605 / 09171303764</p>
        </div>

        <hr style="border-top: 1px solid #969696; margin: 8px 0;">

        <div class="receipt-details">
            <h4><strong>Invoice No:</strong> #{{ $order->invoice_no }}</h4>
            <hr>
            <p><strong>Date:</strong> {{ $order->order_date }}</p>
            <p><strong>Sold to Customer:</strong> {{ $order->customer_name }}</p> 
            <p><strong>SC/PWD Signature:</strong>  ___________________</p> 
        </div>

        <hr style="border-top: 1px solid #969696; margin: 10px 0;">

        <table class="table table-sm receipt-table" style="width: 100%;">
            <thead>
                <tr>
                    <th>Description</th>
                    <th>Qty</th>
                    <th>Price</th>
                    <th>Amount</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($orderDetails as $item)
                <tr>
                    <td>{{ $item->product->product_name }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>₱{{ number_format($item->unitcost, 2) }}</td>
                    <td>₱{{ number_format($item->total, 2) }}</td>
                </tr>
                @endforeach
                <tr>
                    <td colspan="3"><strong>Subtotal</strong></td>
                    <td><strong>₱{{ number_format($order->sub_total, 2) }}</strong></td>
                </tr>
                <tr>
                    <td colspan="3"><strong>VAT (12%)</strong></td>
                    <td><strong>₱{{ number_format($order->vat, 2) }}</strong></td>
                </tr>
                {{-- <tr>
                    <td colspan="3"><strong>Total</strong></td>
                    <td><strong>₱{{ number_format($order->total, 2) }}</strong></td>
                </tr> --}}
                <tr>
                    <td colspan="3"><strong>Discount</strong></td>
                    <td><strong>₱{{ number_format($order->discount, 2) }}</strong></td> <!-- Display Discount -->
                </tr>
                <tr>
                    <td colspan="3"><strong>Total</strong></td>
                    <td><strong>₱{{ number_format($order->total, 2) }}</strong></td> <!-- Display Total After Discount -->
                </tr>
                
            </tbody>
        </table>
        

        <hr style="border-top: 1px solid #000; margin: 10px 0;">

        <div class="receipt-summary">
            <p><strong>Payment Type:</strong> {{ $order->payment_status }} <br>
            <strong>Paid:</strong> ₱{{ $order->pay }} <br>
            <strong>Change:</strong> ₱{{ $order->due }}</p>
        </div>

        <hr style="border-top: 1px solid #000; margin: 10px 0;">

        <div class="text-center">
            <p>Cashier/Authorized Representative <br>
                L&N Gas Prop
            </p>
        </div>

        <div class="receipt-footer text-center d-print-none" style="margin-top: 20px;">
            <button class="btn btn-primary btn-sm" onclick="window.print()">Print Receipt</button>
            <a href="{{ route('pos.index') }}" class="btn btn-secondary btn-sm">Back to POS</a>
        </div>
    </div>
@endsection
