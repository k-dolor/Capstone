@extends('dashboard.body.main')

@section('container')
<div class="container">
    <h1>Update Delivery Status</h1>
    <form action="{{ route('delivery.updateStatus', $delivery->id) }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="status">Status</label>
            <select name="status" id="status" class="form-control">
                <option value="Pending" {{ $delivery->status == 'Pending' ? 'selected' : '' }}>Pending</option>
                <option value="Out for Delivery" {{ $delivery->status == 'Out for Delivery' ? 'selected' : '' }}>Out for Delivery</option>
                <option value="Delivered" {{ $delivery->status == 'Delivered' ? 'selected' : '' }}>Delivered</option>
                <option value="Cancelled" {{ $delivery->status == 'Cancelled' ? 'selected' : '' }}>Cancelled</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Update Status</button>
    </form>
</div>
@endsection
