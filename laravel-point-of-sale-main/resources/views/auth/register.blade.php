@extends('auth.body.main')

@section('container')
<div class="full-screen-bg d-flex align-items-center justify-content-center">
    <div class="row w-100" style="max-width: 900px;">
        <!-- Logo Section -->
        <div class="col-lg-6 text-center d-flex flex-column align-items-center justify-content-center text-white" style="padding: 50px;">
            <div class="d-flex justify-content-center align-items-center gap-3"> 
                <img src="{{ asset('assets/images/ln.png') }}" alt="L&N Gas Logo" style="max-width: 215px;">
                <img src="{{ asset('assets/images/prycegas1.png') }}" alt="prycegas" style="max-width: 200px; margin-bottom: 25px; margin-left: 25px; margin-right: 25px;">
            </div>
            {{-- <h1 class="mb-3" style="font-size: 24px; font-family: 'Poppins', sans-serif;">L&N</h1> --}}
            <p style="font-size: 16px; font-family: 'Poppins', sans-serif; margin-right: 55px;  font-weight: bold;">
                <i class="fa fa-phone"></i> 09388822605 / 09171303764 <br>
                <i class="fa fa-map-marker"></i> Roxas City, Capiz
            </p>
        </div>

        <!-- Register Section -->
        {{-- <div class="col-lg-6 d-flex align-items-center justify-content-center"> --}}
            {{-- <div class="card" style="border-radius: 20px; box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2); width: 100%; padding: 30px;"> --}}
                <div class="col-lg-6 d-flex align-items-center">
                    <div class="card w-100"
                        style="border-radius: 10px; 
                        background: #e8e7e7;
                               box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2); 
                               padding: 30px; 
                               max-width: 700px; /* Adjust width */
                               min-width: 600px; /* Prevent it from being too small */
                               min-height: 350px;">
                
                <div class="card-body" style="background: #e8e7e7">
                    <h2 class="text-center mb-4" style="font-family: 'Poppins', sans-serif;">REGISTER</h2>
                    <form method="POST" action="{{ route('register') }}">
                        @csrf
                        <div class="row">
                            <div class="col-md-7 mb-3">
                                <label for="name" style="font-family: 'Poppins', sans-serif;">Full Name:</label>
                                <input type="text" id="name" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required>
                                @error('name') <div class="text-danger small">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-5 mb-3">
                                <label for="username" style="font-family: 'Poppins', sans-serif;">Username:</label>
                                <input type="text" id="username" name="username" class="form-control @error('username') is-invalid @enderror" value="{{ old('username') }}" required>
                                @error('username') <div class="text-danger small">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-7 mb-3">
                                <label for="email" style="font-family: 'Poppins', sans-serif;">Email:</label>
                                <input type="email" id="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required>
                                @error('email') <div class="text-danger small">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-5 mb-3">
                                <label for="password" style="font-family: 'Poppins', sans-serif;">Password:</label>
                                <input type="password" id="password" name="password" class="form-control @error('password') is-invalid @enderror" required>
                                @error('password') <div class="text-danger small">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="form-group mb-4">
                            <label for="password_confirmation" style="font-family: 'Poppins', sans-serif;">Confirm Password:</label>
                            <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" required>
                        </div>

                        <button type="submit" class="btn btn-primary btn-block" style="font-size: 18px; padding: 10px; font-family: 'Poppins', sans-serif; border-radius: 30px;">REGISTER</button>
                    </form>
                    <p class="text-center mt-3" style="font-family: 'Poppins', sans-serif;">
                        Already have an account? <a href="{{ route('login') }}" style="color: #007bff;">Log In</a>
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
    overflow: hidden; /* Prevents any scrollbars */
    display: flex;
    align-items: center;
    justify-content: center;
}

.full-screen-bg {
    position: fixed; /* Ensures it covers the entire viewport */
    top: 0;
    left: 0;
    width: 100vw;
    height: 100vh;
    /* background: linear-gradient(to right, #f57e20, #0066cc); */
    /* background: linear-gradient(to top, #d0aa88, #f98227); */
    background: linear-gradient(to bottom, #c08a0b, #b0450f);
    display: flex;
    align-items: center;
    justify-content: center;
}

    
z
    body {
        font-family: 'Poppins', sans-serif;
    }

    .form-control {
        border-radius: 5px;
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
