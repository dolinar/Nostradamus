<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
        <title>{{config('app.name', 'Nostradamus')}}</title>
        <!-- Styles -->
        <link rel="stylesheet" href="{{asset('css/app.css')}}">
        <link rel="stylesheet" href="{{asset('css/bootstrap.min.css')}}">
        <link href='https://fonts.googleapis.com/css?family=Archivo' rel='stylesheet'>

        <script src="{{asset('js/jquery.min.js')}}"></script> 
        <script src="{{asset('js/bootstrap.min.js')}}"></script> 
        <script src="{{asset('js/jquery.timeago.js')}}" type="text/javascript"></script>
    </head>
    <body>
        @include('inc.navbar')
        <div class="container">
            @yield('content')
        </div>
    </body>
</html>
