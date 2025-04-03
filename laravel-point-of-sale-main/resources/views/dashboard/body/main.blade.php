<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>L&N GAS MS</title>

        <!-- Favicon -->
        <link rel="shortcut icon" href="{{ asset('assets/images/favicon.ico') }}"/>
        <link rel="stylesheet" href="{{ asset('assets/css/backend-plugin.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/backend.css?v=1.0.0') }}">

        <link rel="stylesheet" href="{{ asset('assets/vendor/line-awesome/dist/line-awesome/css/line-awesome.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/bootstrap/bootstrap-icons.css') }}">

        <link rel="stylesheet" href="{{ asset('assets/vendor/remixicon/fonts/remixicon.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/bootstrap/bootstrap-icons.css') }}">
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
             {{-- <link rel="stylesheet" href="{{ asset('assets/css/style/backupdb.css') }}"> --}}
             @yield('styles')
             <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
             @yield('scripts') <!-- This allows Blade child pages to insert their own JavaScript -->



        <style>
            body {

                font-family: 'Poppins', sans-serif;
                /* font-family: 'Inter', sans-serif; */
                /* font-family: 'Montserrat', sans-serif; */
                /* background-color: #c5d1db;  */
                
                /* background-color: #0e0f10;  */
                background-color: #d7d7d7; 
                /* background-color: #f7f4f0;  */
                
                /* background-color: #ebeff3;  */
            }
        </style>


        @yield('specificpagestyles')
    </head>
<body>

    <!-- Wrapper Start -->
    <div class="wrapper">
        @include('dashboard.body.sidebar')

        @include('dashboard.body.navbar')

        <div class="content-page">
            @yield('container') 
        </div>
    </div>
    
    
    
    
    
    
        


<!--------------------------------------------------------------------------------->
{{-- // $lowStockThreshold = 10; // Customize the threshold as needed

// // Fetch low-stock products
// $lowStockProducts = Product::where('product_store', '<=', $lowStockThreshold)->get();

// // Create notifications for low-stock products (if not already created for this session)
// foreach ($lowStockProducts as $product) {
//     if (!Notification::where('product_id', $product->id)->where('is_read', false)->exists()) {
//         Notification::create([
//             'product_id' => $product->id,
//             'user_id' => auth()->id(), // Current user
//             'message' => "Low stock alert: {$product->product_name} ({$product->product_store} left)",
//             'is_read' => false
//         ]);
//     }
// }

// // Fetch unread notifications
// $notifications = Notification::where('user_id', auth()->id())->where('is_read', false)->get(); --}}






        
    
    <!-- Wrapper End-->

    {{-- @include('dashboard.body.footer') --}}

    <!-- Backend Bundle JavaScript -->
    <script src="{{ asset('assets/js/backend-bundle.min.js') }}"></script>
    <script src="https://kit.fontawesome.com/4c897dc313.js" crossorigin="anonymous"></script>
<!-- Bootstrap JavaScript Bundle (includes Popper.js) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    @yield('specificpagescripts')

    <!-- App JavaScript -->
    <script src="{{ asset('assets/js/app.js') }}"></script>
</body>
</html>


