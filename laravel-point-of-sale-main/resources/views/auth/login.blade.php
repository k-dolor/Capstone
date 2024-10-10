@extends('auth.body.main')

@section('container')
<div class="row align-items-center justify-content-center height-self-center min-vh-100">
    <div class="col-lg-8">
        <div class="card auth-card shadow-lg border-0 rounded-lg">
            <!-- Updated Background Color with Transparency -->
            <div class="card-body p-0" style="background-color: rgba(234, 148, 27);">
                <div class="d-flex flex-column align-items-center auth-content p-4">
                    
                    <!-- Centered Logos Inside the Card -->
                    <div class="d-flex justify-content-center align-items-center mb-4">
                        <img src="{{ asset('assets/images/logo1.png') }}" class="img-fluid mx-3" alt="First Logo" style="height: 120px; object-fit: contain;">
                        <img src="{{ asset('assets/images/logo3.png') }}" class="img-fluid mx-3" alt="Second Logo" style="height: 120px; object-fit: contain;">
                    </div>

                    <!-- Enhanced Labels and Fields -->
                    <h2 class="mb-3 text-white text-center" style="font-family: 'Poppins', sans-serif; font-weight: 600;">Log In</h2>
                    <p class="text-muted text-center mb-4" style="font-family: 'Poppins', sans-serif;">Login to stay connected.</p>

                    <form action="{{ route('login') }}" method="POST" class="w-100">
                        @csrf
                        <div class="form-group mb-4">
                            <label class="text-white form-label" for="email_username" style="font-family: 'Poppins', sans-serif; font-weight: 500;">Email/Username</label>
                            <input id="email_username" class="form-control modern-input @error('email') is-invalid @enderror @error('username') is-invalid @enderror" type="text" name="input_type" placeholder="Enter your email or username" value="{{ old('input_type') }}" autocomplete="off" required autofocus>
                            @error('username')
                            <div class="text-danger small mt-2">Incorrect username or password.</div>
                            @enderror
                            @error('email')
                            <div class="text-danger small mt-2">Incorrect username or password.</div>
                            @enderror
                        </div>

                        <div class="form-group mb-4">
                            <label class="text-white form-label" for="password" style="font-family: 'Poppins', sans-serif; font-weight: 500;">Password</label>
                            <input id="password" class="form-control modern-input @error('password') is-invalid @enderror" type="password" name="password" placeholder="Enter your password" required>
                        </div>

                        <div class="row mb-4">
                            <div class="col-lg-6">
                                <p class="text-white mb-0" style="font-family: 'Poppins', sans-serif;">
                                    Not a Member yet? <a href="{{ route('register') }}" class="text-white">Register</a>
                                </p>
                            </div>
                            <div class="col-lg-6 text-right">
                                <a href="#" class="text-white" style="font-family: 'Poppins', sans-serif;">Forgot Password?</a>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-warning w-100" style="font-family: 'Poppins', sans-serif;">Login</button>
                    </form>
                    
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap');

    body {
        background: linear-gradient(135deg, #042e7b, #9eb1ed);
        font-family: 'Poppins', sans-serif;
        color: #fff;
    }

    .form-control {
        border-radius: 5px;
        height: 45px;
        font-family: 'Poppins', sans-serif;
        font-size: 14px;
        background-color: #2b2b2b;
        border: 1px solid #444;
        color: #fff;
        padding-left: 15px;
    }

    .form-control:focus {
        border-color: #ffcc00;
        box-shadow: 0 0 5px rgba(255, 204, 0, 0.5);
        background-color: #3c3c3c;
    }

    .modern-input {
        padding-left: 10px;
        border-radius: 30px;
        transition: all 0.3s ease-in-out;
    }

    .modern-input:hover {
        background-color: #3c3c3c;
    }

    .btn-warning {
        background-color: #ffcc00;
        border-color: #ffcc00;
        color: #1b1b1b;
        border-radius: 30px;
        transition: background-color 0.3s ease;
    }

    .btn-warning:hover {
        background-color: #ffd633;
        border-color: #ffd633;
    }

    .text-warning {
        color: #ffcc00;
    }

    .text-warning:hover {
        color: #ffd633;
    }

    .form-label {
        font-size: 16px;
        font-weight: 500;
        margin-bottom: 8px;
    }
</style>
@endsection
