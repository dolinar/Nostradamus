@extends('layouts.app')

@section('content')


<!-- Default form login -->
<div class="row justify-content-center">
    <form class="text-center border border-light p-5" method="POST" action="{{ route('login') }}">
        @csrf
        <p class="h4 mb-4">Prijava</p>

        <!-- Username -->
        <input placeholder="Uporabniško ime" id="username" type="text" class="form-control{{ $errors->has('username') ? ' is-invalid' : '' }} mb-4" name="username" value="{{ old('username') }}" required autofocus>
        @if ($errors->has('username'))
            <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('username') }}</strong>
            </span>
        @endif

        <!-- Geslo -->
        <input placeholder="Geslo" id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }} mb-4" name="password" required>
        @if ($errors->has('password'))
            <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('password') }}</strong>
            </span>
        @endif

        <div class="d-flex justify-content-around">
            <div>
                <!-- Remember me -->
                <div class="custom-control custom-checkbox">
                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                    <label class="custom-control-label" for="defaultLoginFormRemember">Zapomni si me</label>
                </div>
            </div>
            <div>
                <!-- Forgot password -->
                <a href="{{ route('password.request') }}">
                    {{ __('Pozabljeno geslo?') }}
                </a>
            </div>
        </div>

        <!-- Sign in button -->
        <button type="submit" class="btn btn-outline-info btn-rounded btn-block my-4 waves-effect z-depth-0">
            {{ __('Prijava') }}
        </button>

        <!-- Register -->
        <p>Niste registrirani?
            <a href="{{ route('register') }}">Registracija</a>
        </p>
        <hr>
    </form>
</div>
@endsection
