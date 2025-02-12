@extends('dashboard.body.main')

@section('container')
<div class="content">
    <h1 class="text-center mb-4" style="font-family: 'Poppins', sans-serif;">Stock-In History for {{ $product->product_name }}</h1>
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Quantity Added</th>
                            <th>Date Added</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($history as $record)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $record->quantity_added }}</td>
                                <td>{{ \Carbon\Carbon::parse($record->updated_at)->format('M d, Y h:i A') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center">No stock-in history available.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <a href="{{ route('inventory.index') }}" class="btn btn-secondary">Back to Inventory</a>
        </div>
    </div>
</div>
@endsection
