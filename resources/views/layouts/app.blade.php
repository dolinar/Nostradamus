<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Nostradamus') }}</title>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.11.2/css/all.css">


    <!-- Styles -->
    <link rel="stylesheet" href="{{asset('css/app.css')}}">
    <link rel="stylesheet" href="{{asset('css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/select2.min.css')}}"/> 
    <link rel="stylesheet" href="{{asset('css/mdb.min.css')}}"/>
    <link rel="manifest" href="{{ asset('manifest.json') }}">
    
    <!-- Scripts -->
    <script src="{{asset('js/popper.min.js')}}"></script>
    <script src="{{asset('js/app.js')}}"></script>  
    <script src="{{asset('js/jquery.timeago.js')}}" type="text/javascript"></script>
    <script src="{{asset('js/scripts.js')}}" type="text/javascript" cookie-consent="strictly-necessary"></script>
    <script src="{{asset('js/select2.min.js')}}"></script>
    <script src="{{asset('js/cookies.js')}}"></script>
    <script src="{{asset('js/mdb.min.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/highcharts/6.0.6/highcharts.js" charset="utf-8"></script>
    <script src="{{asset('js/skies.js')}}"></script>
    <link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/cookieconsent2/3.1.0/cookieconsent.min.css" />
    <script src="//cdnjs.cloudflare.com/ajax/libs/cookieconsent2/3.1.0/cookieconsent.min.js"></script>

</head>
<body>
    @include('inc.navbar') 
    <div class="jumbotron mt-n2 mb-n4">
        @include('inc.messages')
        @yield('content')
    </div>
    @include('inc.footer')
</body>

</html>
