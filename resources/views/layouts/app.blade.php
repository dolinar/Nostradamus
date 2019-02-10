<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Nostradamus') }}</title>

    <!-- Fonts -->
    <link href='https://fonts.googleapis.com/css?family=Nunito Sans' rel='stylesheet'>

    <!-- Styles -->
    <link rel="stylesheet" href="{{asset('css/app.css')}}">
    <link rel="stylesheet" href="{{asset('css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/select2.min.css')}}"/>

    <!-- Scripts -->
    <script src="{{asset('js/jquery.min.js')}}"></script> 
    <script src="{{asset('js/bootstrap.min.js')}}"></script> 
    <script src="{{asset('js/jquery.timeago.js')}}" type="text/javascript"></script>
    <script src="{{asset('js/scripts.js')}}" type="text/javascript" cookie-consent="strictly-necessary"></script>
    <script src="{{asset('js/select2.min.js')}}"></script>
    <script src="{{asset('js/cookies.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/highcharts/6.0.6/highcharts.js" charset="utf-8"></script>
    <script src="{{asset('js/skies.js')}}"></script>
    <link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/cookieconsent2/3.1.0/cookieconsent.min.css" />
    <script src="//cdnjs.cloudflare.com/ajax/libs/cookieconsent2/3.1.0/cookieconsent.min.js"></script>



</head>
<body>
    @include('inc.navbar')
    <div class="container">
        <div class="jumbotron">
            @include('inc.messages')
            @yield('content')
        </div>
    </div>
</body>
</html>
