@extends('layouts.app')
@section('content')
<div class="row justify-content-center mx-2">
<!-- Material form register -->
    <div class="card">

        <h5 class="card-header info-color white-text text-center py-4">
            <strong>Registracija</strong>
        </h5>
    
        <!--Card content-->
        <div class="card-body px-lg-5 pt-0">
    
            <!-- Form -->
            <form class="text-center" style="color: #757575;" method="POST" action="{{ route('register') }}">
                @csrf
                <div class="md-form">
                    <input id="username" type="text" class="form-control {{ $errors->has('username') ? ' is-invalid' : '' }} mb-0" name="username" value="{{ old('username') }}" length="20" required autofocus>
                    <label for="username">Uporabniško ime</label>
                    @if ($errors->has('username'))
                        <span class="text-danger" role="alert">
                            <strong>{{ $errors->first('username') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="form-row">
                    <div class="col">
                        <!-- First name -->
                        <div class="md-form">
                            <input type="text" id="name" class="form-control {{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') }}" required>
                            <label for="name">Ime</label>
                            @if ($errors->has('name'))
                                <span class="text-danger" role="alert">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="col">
                        <!-- Last name -->
                        <div class="md-form">
                            <input type="text" id="second-name" class="form-control {{ $errors->has('name') ? ' is-invalid' : ''  }}" name="second-name" value="{{ old('name') }}" required>
                            <label for="second-name">Priimek</label>
                            @if ($errors->has('second-name'))
                                <span class="text-danger" role="alert">
                                    <strong>{{ $errors->first('second-name') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
    
                <!-- E-mail -->
                <div class="md-form mt-0">
                    <input type="email" id="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required>
                    <label for="email">E-mail</label>
                    @if ($errors->has('email'))
                        <span class="text-danger" role="alert">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                    @endif
                </div>
    
                <!-- Password -->
                <div class="md-form">
                    <input type="password" id="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" value="{{ old('password') }}" required aria-describedby="materialRegisterFormPasswordHelpBlock">
                    <label for="password">Geslo</label>
                    <small id="defaultRegisterFormPasswordHelpBlock" class="form-text text-muted mb-4">
                        Vsaj 8 znakov, 1 cifra in en poseben znak.
                    </small>
                    @if ($errors->has('password'))
                        <span class="text-danger" role="alert">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
                    @endif
                </div>

                <!-- Confirm password -->
                <div class="md-form">
                    <input type="password" id="password-confirm" class="form-control" name="password-confirm" required>
                    <label for="password-confirm">Ponovi geslo</label>
                    @if ($errors->has('password-confirm'))
                        <span class="text-danger" role="alert">
                            <strong>{{ $errors->first('password-confirm') }}</strong>
                        </span>
                    @endif
                </div>
    
                <!-- Newsletter -->
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="send_mail" name="send_mail" checked>
                    <label class="form-check-label" for="send_mail">Obvestila o nenapovedanih tekmah</label>
                </div>

                <div class="md-form">
                    <input type="hidden" value=1 id="profile_image" name="profile_image" checked>
                    @for ($i = 1; $i < 17; $i++)
                        <img class="image-selector" id="{{$i}}" src="storage/profile_images/random/256_{{$i}}.png" style="height: 3rem; width:3rem">
                    @endfor
                </div>

    
                <!-- Sign up button -->
                <button class="btn btn-outline-info btn-rounded btn-block my-4 waves-effect z-depth-0" type="submit">Registracija</button>
    
                <!-- Social register -->
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
    
                <hr>
    
                <!-- Terms of service -->
                <p>S klikom na
                    <em>Registracija</em> se strinjate s
                    <a href="" target="_blank">pogoji uporabe.</a>
    
            </form>
            <!-- Form -->
    
        </div>
    
    </div>
    <!-- Material form register -->
</div>

@endsection
