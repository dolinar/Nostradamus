@extends('layouts.app')

@section('content')
<div class="row justify-content-center">

    <form class="text-center border border-light p-5" method="POST" action="{{ route('register') }}">
        @csrf
        <p class="h4 mb-4">Registracija</p>

        <!-- Username -->
        <input placeholder="Uporabniško ime" id="username" type="text" class="form-control{{ $errors->has('username') ? ' is-invalid' : '' }} mb-4" name="username" value="{{ old('username') }}" required autofocus>
        @if ($errors->has('username'))
            <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('username') }}</strong>
            </span>
        @endif

        <!-- Name and second name -->
        <div class="form-row mb-4">
            <div class="col">
                <!-- First name -->
                <input type="text" id="name" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') }}" required autofocus placeholder="Ime">
                @if ($errors->has('name'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('name') }}</strong>
                    </span>
                @endif
            </div>
            <div class="col">
                <!-- Last name -->
                <input type="text" id="second-name" class="form-control{{ $errors->has('second-name') ? ' is-invalid' : '' }}" name="second-name" value="{{ old('second-name') }}" required autofocus placeholder="Priimek">
                @if ($errors->has('second-name'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('second-name') }}</strong>
                    </span>
                @endif
            </div>
        </div>

        <input type="email" id="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }} mb-4" name="email" value="{{ old('email') }}" required placeholder="E-mail">
        @if ($errors->has('email'))
            <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('password') }}</strong>
            </span>
        @endif

        <input type="password" id="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" value="{{ old('password') }}" required placeholder="Geslo">
        <small id="defaultRegisterFormPasswordHelpBlock" class="form-text text-muted mb-4">
            Vsaj 8 znakov, 1 cifra in en poseben znak.
        </small>
        @if ($errors->has('password'))
            <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('alert') }}</strong>
            </span>
        @endif

        <input type="password" id="password-confirm" class="form-control mb-4" name="password_confirm" required placeholder="Ponovi geslo">
        @if ($errors->has('password'))
            <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('alert') }}</strong>
            </span>
        @endif



        <button type="submit" class="btn btn-outline-info btn-rounded btn-block my-4 waves-effect z-depth-0">
            {{ __('Registracija') }}
        </button>

        <hr>
    </form>
</div>
@endsection
