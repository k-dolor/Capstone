@extends('auth.body.main')

@section('container')
<div class="full-screen-bg d-flex align-items-center justify-content-center">
    <div class="row w-100" style="max-width: 900px;">
        <!-- Logo Section -->
        <div class="col-lg-6 text-center d-flex flex-column align-items-center justify-content-center text-white" style="padding: 50px;">
            <img src="{{ asset('assets/images/ln_logo.png') }}" alt="L&N Gas Logo" style="max-width: 200px; margin-bottom: 20px;">
            <h1 class="mb-3" style="font-size: 24px; font-family: 'Poppins', sans-serif;">L&N GAS</h1>
            <p style="font-size: 16px; font-family: 'Poppins', sans-serif;">
                <i class="fa fa-phone"></i> 09388822605 / 09171303764 <br>
                <i class="fa fa-map-marker"></i> Roxas City, Capiz
            </p>
        </div>

        <!-- Login Section -->
        <div class="col-lg-6 d-flex align-items-center justify-content-center">
            <div class="card" style="border-radius: 20px; box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2); width: 350px;">
                <div class="card-body">
                    <h2 class="text-center mb-4" style="font-family: 'Poppins', sans-serif;">LOGIN</h2>
                    <form action="{{ route('login') }}" method="POST">
                        @csrf
                        <div class="form-group mb-4">
                            <label for="email_username" style="font-family: 'Poppins', sans-serif;">Username/Email Address:</label>
                            <input type="text" id="email_username" name="input_type" class="form-control" placeholder="Enter your email or username" required autofocus>
                        </div>
                        <div class="form-group mb-4">
                            <label for="password" style="font-family: 'Poppins', sans-serif;">Password:</label>
                            <input type="password" id="password" name="password" class="form-control" placeholder="Enter your password" required>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block" style="font-size: 18px; padding: 10px; font-family: 'Poppins', sans-serif; border-radius: 30px;">LOGIN</button>
                    </form>
                    <p class="text-center mt-3" style="font-family: 'Poppins', sans-serif;">
                        Don't have an account? <a href="{{ route('register') }}" style="color: #007bff;">Register now</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap');

    html, body {
        height: 100%;
        margin: 0;
        padding: 0;
    }

    .full-screen-bg {
        height: 100vh; /* Full viewport height */
        width: 100vw; /* Full viewport width */
        background: linear-gradient(to right, #f57e20, #0066cc);
        overflow: hidden;
    }

    body {
        font-family: 'Poppins', sans-serif;
    }

    .form-control {
        border-radius: 10px;
        font-size: 14px;
        height: 45px;
    }

    .btn-primary {
        background-color: #0066cc;
        border: none;
        transition: background-color 0.3s ease;
    }

    .btn-primary:hover {
        background-color: #005bb5;
    }
</style>
@endsection
