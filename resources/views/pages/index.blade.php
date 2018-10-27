@extends('layouts.app')

@section('content')
    <script>
        jQuery(document).ready(function() {
            jQuery("time.timeago").timeago();
        });
    </script>
    <div class="text-center">
        <!--<h3 class="display-5">Pozdravljeni na strani {{config('app.name', 'Nostradamus')}}!</h3> -->
        <p class="lead">Preverite svoje vizionarske sposobnosti pri napovedovanju rezultatov za Ligo prvakov 2018/2019.</p>
    </div>
    <hr>
    <div class="container">
        @auth
            @if (count($data['overallPrediction']) == 0)
                <div class="alert alert-danger">
                    <span>Niste še izbrali končnega zmagovalca. To lahko storite <a href="/overall_prediction">tukaj</a>.</span>
                </div>
                <hr>
            @endif
 
        @endauth
        <h5>Novice:</h4>
        @if (count($data['posts']) > 0)
            @foreach($data['posts'] as $post)
                <li class="list-group-item">
                    <div class="row">
                        <div class="col-lg-2 col-md-3 col-xs-4 text-right">
                            <time class="timeago small text-muted" datetime="{{date('c', $post->ts)}}"><small></small></time>
                        </div>
                        <div class="col-lg-8 col-md-9 col-xs-8">
                            <a target="_blank" rel="noopener noreferrer" data-toggle="tooltip" title="{{$post->summary}}" href="{{$post->link}}">
                                <b>{{$post->title}}</b>
                            </a>
                        </div>
                    </div>
                </li>
            @endforeach
        @endif
        <div class="row justify-content-center mt-2">
            <a href="/info" class="btn btn-info m-2 col-lg-2">Informacije</a>
            <a href="/login" class="btn btn-info m-2 col-lg-2">Prijava</a>
            <a href="/register" class="btn btn-info m-2 col-lg-2">Registracija</a>
        </div>  
        <div class="text-center">
            <hr>
            <p class="small text-muted">Nostradamus 2018/19</p>
        </div>
    </div>
@endsection
