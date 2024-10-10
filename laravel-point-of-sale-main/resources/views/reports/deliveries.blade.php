@extends('dashboard.body.main')

@section('container')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <div class="d-flex flex-wrap align-items-center justify-content-between mb-4">
                <div>
                    <h4 class="mb-3">Deliveries Report</h4>
                    <p class="mb-0">View and analyze the deliveries data.</p>
                </div>
                <div>
                    <!-- Date Range Picker -->
                    <form action="#" method="GET" class="form-inline">
                        <div class="form-group mr-3">
                            <label for="start_date" class="sr-only">Start Date:</label>
                            <input type="date" id="start_date" name="start_date" class="form-control" placeholder="Start Date">
                        </div>
                        <div class="form-group mr-3">
                            <label for="end_date" class="sr-only">End Date:</label>
                            <input type="date" id="end_date" name="end_date" class="form-control" placeholder="End Date">
                        </div>
                        <button type="submit" class="btn btn-primary">Filter</button>
                    </form>
                </div>
                <div>
                    <!-- Export Button -->
                    <a href="#" class="btn btn-secondary"><i class="fa-solid fa-file-export mr-2"></i>Export</a>
                    <!-- Print Button -->
                    <button class="btn btn-secondary" onclick="window.print()"><i class="fa-solid fa-print mr-2"></i>Print</button>
                </div>
            </div>
        </div>
        <div class="table-responsive rounded mb-3">
            <table class="table mb-0">
                <thead class="bg-white text-uppercase">
                    <tr class="ligth ligth-data">
                    <th>Delivery ID</th>
                    <th>Date</th>
                    <th>Customer Name</th>
                    <th>Address</th>
                    {{-- <th>Contact Number</th> --}}
                    <th>Order Id</th>
                    {{-- <th>Quantity</th> --}}
                    <th>Delivery Status</th>
                </tr>
            </thead>
            <tbody class="ligth-body">
                @foreach($deliveries as $delivery)
                <tr>
                    <td>{{ $delivery->id }}</td>
                    <td>{{ $delivery->delivery_date }}</td>
                    <td>{{ $delivery->customer_name }}</td>
                    <td>{{ $delivery->delivery_address }}</td>
                    {{-- <td>{{ $delivery->contact_number }}</td> --}}
                    <td>{{ $delivery->order_id }}</td>
                    {{-- <td>{{ $delivery->quantity }}</td> --}}
                    <td>{{ $delivery->status }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
