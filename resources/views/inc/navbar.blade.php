<nav class="mb-1 navbar navbar-expand-lg blue darken-2">
    <a class="navbar-brand" href="/"> {{config('app.name', 'Nostradamus')}}</a>   
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar1" aria-controls="navbar1" aria-expanded="false" aria-label="Toggle navigation">
            <span>
                    <i class="fas fa-bars"></i>
                </span>
    </button>
    <div class="collapse navbar-collapse" id="navbar1">
        <ul class="navbar-nav ml-auto">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" aria-haspopup="true" aria-expanded="false">
                    {{ Config::get('languages')[App::getLocale()] }}
                </a>
                <ul class="dropdown-menu" role="menu">
                    @foreach (Config::get('languages') as $lang => $language)
                        @if ($lang != App::getLocale())
                            <a class="dropdown-item" href="{{ route('lang.switch', $lang) }}">{{$language}}</a>
                        @endif
                    @endforeach
                </ul>
            </li>

            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" id="dropdownMenuButton1" aria-haspopup="true" aria-expanded="false"> Tekmovanje </a>
                <div class="dropdown-menu dropdown-secondary" role="menu" aria-labelledby="dropdownMenuLink">
                    <a class="dropdown-item" href="/info">Informacije</a>
                    <a class="dropdown-item" href="/instructions">Navodila</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="/table">Lestvica</a>
                </div>
            </li>

            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" id="dropdownMenuButton2" aria-haspopup="true" aria-expanded="false"> Liga prvakov </a>
                <div class="dropdown-menu" role="menu" aria-labelledby="dropdownMenuLink">
                    <a class="dropdown-item" href="/cl_draw">Prvenstvo</a>
                    <a class="dropdown-item" href="/cl_results">Rezultati</a>
                    <!--<a class="dropdown-item" href="/cl_statistics">Statistika</a>-->
                    <a class="dropdown-item" href="/teams">Ekipe</a>
                </div>
            </li>
            @guest
            <form class="form-inline">
                <a class="btn btn-outline-white btn-sm my-0" href="{{ route('login') }}">{{ __('Prijava') }}</a>
                @if (Route::has('register'))
                    <a class="btn btn-outline-white btn-sm my-0" href="{{ route('register') }}">{{ __('Registracija') }}</a>
                @endif
            </form>
            @else
                <li class="nav-item dropdown">
                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                        {{ Auth::user()->username }} <span class="caret"></span>
                        <img src="{{ Session::get('profile_image') }}" class="rounded-circle z-depth-0 mt-n3 mb-n3" style="height: 2rem; width:2rem"
                        alt="">
                    </a>

                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                        @if (Auth::user()->status == 0)
                            <a class="dropdown-item" href="{{route('admin')}}">Nadzorna plošča</a>
                        @endif
                        <a class="dropdown-item" href="{{route('dashboard.index')}}">Profil</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="/overall_prediction">Končna napoved</a>
                        <a class="dropdown-item" href="/predictions">Napovedi</a>  
                        <a class="dropdown-item" href="/groups">Skupine</a>    
                        <a class="dropdown-item" href="/private_message">Zasebna sporočila</a>                     
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="{{ route('logout') }}"
                        onclick="event.preventDefault();
                                        document.getElementById('logout-form').submit();">
                            {{ __('Odjava') }}
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </div>
                </li>
            @endguest

        </ul>
    </div>
</nav>
