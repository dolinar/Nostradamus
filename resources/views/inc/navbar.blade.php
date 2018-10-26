<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand" href="/"> <img class="logo" src="/cl_logo.png" height="50"> {{config('app.name', 'Nostradamus')}}</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar1" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbar1">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item"><a class="nav-link" href="/info"> Informacije </a></li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" id="dropdownMenuButton1" aria-haspopup="true" aria-expanded="false"> Tekmovanje </a>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                        <a class="dropdown-item" href="/predictions">Napovedi</a>
                        <a class="dropdown-item" href="/overall_predictions">Napoved zmagovalca</a>
                        <a class="dropdown-item" href="/table">Lestvica</a>
                    </div>
                </li>
    
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" id="dropdownMenuButton2" aria-haspopup="true" aria-expanded="false"> Liga prvakov </a>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                        <a class="dropdown-item" href="/cl_draw">Prvenstvo</a>
                        <a class="dropdown-item" href="/cl_results">Rezultati</a>
                        <a class="dropdown-item" href="/cl_statistics">Statistika</a>
                        <a class="dropdown-item" href="/teams">Ekipe</a>
                    </div>
                </li>
                @guest
                <div class="btn-group">
                    <a class="btn btn-default" href="{{ route('login') }}">{{ __('Prijava') }}</a>
                    @if (Route::has('register'))
                        <a class="btn btn-default" href="{{ route('register') }}">{{ __('Registracija') }}</a>
                    @endif
                </div>
                @else
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            {{ Auth::user()->name }} <span class="caret"></span>
                        </a>

                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
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
    