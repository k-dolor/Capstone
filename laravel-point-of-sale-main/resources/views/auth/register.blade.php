@extends('auth.body.main')

@section('container')
<div class="container">
    <div class="row align-items-center justify-content-center height-self-center">
        <div class="col-lg-8">
            <div class="card auth-card shadow-lg border-0 rounded-lg">
                <div class="card-body p-0" style="background-color: rgba(234, 148, 27);">
                    <div class="d-flex align-items-center auth-content p-4">
                        <div class="col-lg-7 align-self-center">
                            <div class="p-3">

                                <h2 class="mb-3 text-white text-center" style="font-family: 'Poppins', sans-serif; font-weight: 600;">Register</h2>
                                <p class="text-muted text-center mb-4" style="font-family: 'Poppins', sans-serif;">Create your account.</p>

                                <form method="POST" action="{{ route('register') }}">
                                    @csrf
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="floating-label form-group">
                                                <input class="floating-input form-control modern-input @error('name') is-invalid @enderror" type="text" placeholder=" " name="name" autocomplete="off" value="{{ old('name') }}" required>
                                                <label>Full Name</label>
                                            </div>
                                            @error('name')
                                            <div class="mb-4" style="margin-top: -20px">
                                                <div class="text-danger small">{{ $message }}</div>
                                            </div>
                                            @enderror
                                        </div>

                                        <div class="col-lg-12">
                                            <div class="floating-label form-group">
                                                <input class="floating-input form-control modern-input @error('username') is-invalid @enderror" type="text" placeholder=" " name="username" autocomplete="off" value="{{ old('username') }}"  required>
                                                <label class="mb-1">Username</label>
                                            </div>
                                            @error('username')
                                            <div class="mb-4" style="margin-top: -20px">
                                                <div class="text-danger small">{{ $message }}</div>
                                            </div>
                                            @enderror
                                        </div>

                                        <div class="col-lg-12">
                                            <div class="floating-label form-group">
                                                <input class="floating-input form-control modern-input @error('email') is-invalid @enderror" type="email" placeholder=" " name="email" autocomplete="off" value="{{ old('email') }}" required>
                                                <label>Email</label>
                                            </div>
                                            @error('email')
                                            <div class="mb-4" style="margin-top: -20px">
                                                <div class="text-danger small">{{ $message }}</div>
                                            </div>
                                            @enderror
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="floating-label form-group">
                                                <input class="floating-input form-control modern-input @error('password') is-invalid @enderror" type="password" placeholder=" "  name="password" autocomplete="off" required>
                                                <label>Password</label>
                                            </div>
                                            @error('password')
                                            <div class="mb-4" style="margin-top: -20px">
                                                <div class="text-danger small">{{ $message }}</div>
                                            </div>
                                            @enderror
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="floating-label form-group">
                                                <input class="floating-input form-control modern-input" type="password" placeholder=" " name="password_confirmation" autocomplete="off" required>
                                                <label>Confirm Password</label>
                                            </div>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-warning w-100" style="font-family: 'Poppins', sans-serif;">Register</button>
                                    <p class="mt-3 text-white" style="font-family: 'Poppins', sans-serif;">
                                        Already have an Account? <a href="{{ route('login') }}" class="text-white">Log In</a>
                                    </p>
                                </form>
                            </div>
                        </div>

                        {{-- <div class="col-lg-5 content-right">
                            <img src="{{ asset('assets/images/logo3.png') }}" class="img-fluid image-right" alt="">
                        </div> --}}
                         <!-- Centered Logos Inside the Card -->
                    <div class="d-flex justify-content-center align-items-center mb-4">
                        <img src="{{ asset('assets/images/logo1.png') }}" class="img-fluid mx-3" alt="First Logo" style="height: 120px; object-fit: contain;">
                        <img src="{{ asset('assets/images/logo3.png') }}" class="img-fluid mx-3" alt="Second Logo" style="height: 120px; object-fit: contain;">
                    </div>
                    </div>
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
