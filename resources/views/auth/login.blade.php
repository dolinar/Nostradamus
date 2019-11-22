@extends('layouts.app')

@section('content')

<div class="row justify-content-center">
<!-- Material form login -->
    <div class="card">

        <h5 class="card-header info-color white-text text-center py-4">
        <strong>Prijava</strong>
        </h5>
    
        <!--Card content-->
        <div class="card-body px-lg-5 pt-0">
    
        <!-- Form -->
        <form class="text-center" style="color: #757575;" method="POST" action="{{ route('login') }}">
            @csrf
            <!-- Email -->
            <div class="md-form">
                <input id="email" type="text" class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required autofocus>
                <label for="email">E-mail</label>
            </div>
    
            <!-- Password -->
            <div class="md-form">
                <input id="password" type="password" class="form-control {{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>
                <label for="password">Geslo</label>

                @if ($errors->has('email'))
                    <span class="text-danger" role="alert">
                        Napačna prijava.
                    </span>
                @endif
            </div>
    
            <div class="d-flex justify-content-around">
            <div>
                <!-- Remember me -->
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                <label class="form-check-label" for="remember">Zapomni si me</label>
                </div>
            </div>
            <div class="ml-2">
                <!-- Forgot password -->
                <a href="{{ route('password.request') }}">
                        {{ __('Pozabljeno geslo?') }}
                    </a>
            </div>
            </div>
    
            <!-- Sign in button -->
            <button class="btn btn-outline-info btn-rounded btn-block my-4 waves-effect z-depth-0" type="submit">Prijava</button>
    
            <!-- Register -->
            <p>Niste registrirani?
                <a href="{{ route('register') }}">Registracija</a>
            </p>
    
            <!-- Social login -->
            <hr>
            <a type="button" class="btn-floating btn-fb btn-sm">
            <i class="fab fa-facebook-f"></i>
            </a>
            <a type="button" class="btn-floating btn-tw btn-sm">
            <i class="fab fa-twitter"></i>
            </a>
            <a type="button" class="btn-floating btn-li btn-sm">
            <i class="fab fa-linkedin-in"></i>
            </a>
            <a type="button" class="btn-floating btn-git btn-sm">
            <i class="fab fa-github"></i>
            </a>
    
        </form>
        <!-- Form -->
    
        </div>
    
    </div>
    <!-- Material form login -->
</div>
@endsection
