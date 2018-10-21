<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
<a class="navbar-brand" href="/"> <img class="logo" src="/cl_logo.png" height="50"> {{config('app.name', 'Nostradamus')}}</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar1" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbar1">
        <ul class="navbar-nav ml-auto">
            <li class="nav-item active">
                <a class="nav-link" href="/">Domov <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item"><a class="nav-link" href="/info"> Informacije </a></li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" id="dropdownMenuButton1" aria-haspopup="true" aria-expanded="false"> Tekmovanje </a>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                    <a class="dropdown-item" href="/table">Lestvica</a>
                    <a class="dropdown-item" href="/predictions">Napovedi</a>
                    <a class="dropdown-item" href="/results">Rezultati</a>
                </div>
            </li>

            <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" id="dropdownMenuButton2" aria-haspopup="true" aria-expanded="false"> Liga prvakov </a>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                        <a class="dropdown-item" href="/cl_draw">Prvenstvo</a>
                        <a class="dropdown-item" href="/cl_results">Rezultati</a>
                        <a class="dropdown-item" href="/cl_statistics">Statistika</a>
                    </div>
                </li>
            <!--<li class="nav-item">
                <a class="btn ml-2 btn-warning" href="/">Test</a>
            </li> -->
        </ul>
    </div>
</nav>