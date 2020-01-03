<!-- Footer -->
<footer class="page-footer font-small blue-grey lighten-5">

    <div class="blue lighten-1">
      <div class="container">
  
        <!-- Grid row-->
        <div class="row py-4 d-flex align-items-center">
  
          <!-- Grid column -->
          <div class="col-md-6 col-lg-5 text-center text-md-left mb-4 mb-md-0">
            <h6 class="mb-0">Obiščite naša socialna omrežja!</h6>
          </div>
          <!-- Grid column -->
  
          <!-- Grid column -->
          <div class="col-md-6 col-lg-7 text-center text-md-right">
  
            <!-- Facebook -->
            <a class="fb-ic">
              <i class="fab fa-facebook-f white-text mr-4"> </i>
            </a>
            <!-- Twitter -->
            <a class="tw-ic">
              <i class="fab fa-twitter white-text mr-4"> </i>
            </a>
            <!-- Google +-->
            <a class="gplus-ic">
              <i class="fab fa-google-plus-g white-text mr-4"> </i>
            </a>
            <!--Linkedin -->
            <a href="https://github.com/dolinar/" target="_blank" class="li-ic">
              <i class="fab fa-linkedin-in white-text mr-4"> </i>
            </a>
            <!--Instagram-->
            <a class="ins-ic">
              <i class="fab fa-instagram white-text"> </i>
            </a>
  
          </div>
          <!-- Grid column -->
  
        </div>
        <!-- Grid row-->
  
      </div>
    </div>
  
    <!-- Footer Links -->
    <div class="container text-center text-md-left mt-5">
  
      <!-- Grid row -->
      <div class="row mt-3 dark-grey-text">
  
        <!-- Grid column -->
        <div class="col-md-3 col-lg-4 col-xl-3 mb-4">
  
          <!-- Content -->
          <h6 class="text-uppercase font-weight-bold">Nogometni navdušenci</h6>
          <hr class="teal accent-3 mb-4 mt-0 d-inline-block mx-auto" style="width: 60px;">
          <p>Ekipa Nogometnih navdušencev predstavlja drugo izvedbo tekmovanja Nostradamus Lige Prvakov.</p>
  
        </div>

        <!-- Grid column -->
        <div class="col-md-3 col-lg-2 col-xl-2 mx-auto mb-4">
  
          <!-- Links -->
          <h6 class="text-uppercase font-weight-bold">Povezave</h6>
          <hr class="teal accent-3 mb-4 mt-0 d-inline-block mx-auto" style="width: 60px;">
          @auth
            <p>
                <a class="dark-grey-text" href="{{route('dashboard.index')}}">Profil</a>
            </p>  
          @endauth
          @guest
            <p>
              <a class="dark-grey-text" href="{{route('login')}}">Prijava</a>
            </p>
            <p>
                <a class="dark-grey-text" href="{{route('register')}}">Registracija</a>
            </p>
          @endguest
          <p>
          <a class="dark-grey-text" href="{{route('info')}}">Informacije</a>
          </p>
          <p>
            <a class="dark-grey-text" href="{{route('news.index')}}">Novice</a>
          </p>
  
        </div>
        <!-- Grid column -->
  
        <!-- Grid column -->
        <div class="col-md-4 col-lg-3 col-xl-3 mx-auto mb-md-0 mb-4">
  
          <!-- Links -->
          <h6 class="text-uppercase font-weight-bold">Kontakt</h6>
          <hr class="teal accent-3 mb-4 mt-0 d-inline-block mx-auto" style="width: 60px;">
          <p>
            <i class="fas fa-home mr-3"></i> Ljubljana, Slovenija</p>
          <p>
            <i class="fas fa-envelope mr-3"></i> support@nostradamus.si</p>
          <p>
            <i class="fas fa-phone mr-3"></i> +368 41 580 199</p>
  
        </div>
        <!-- Grid column -->
  
      </div>
      <!-- Grid row -->
  
    </div>
    <!-- Footer Links -->
  