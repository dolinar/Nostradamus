@extends('layouts.app')

@section('content')
    <script>
        jQuery(document).ready(function() {
            jQuery("time.timeago").timeago();
        });
    </script>
    <div class="jumbotron">
        <div class="text-center">
            <h3 class="display-5">Pozdravljeni na strani {{config('app.name', 'Nostradamus')}}!</h3>
            <p class="lead">Preverite svoje vizionarske sposobnosti pri napovedovanju rezultatov za Ligo prvakov 2018/2019.</p>
        </div>
        <hr>
        <div class="basic-div" id="index-content">
            <h5>Novice:</h4>
            <ul class="list-group">
            @if (count($postsArray) > 0)
                @foreach($postsArray as $post)
                    <li class="list-group-item">
                    <time class="timeago small" datetime="{{date('c', $post->ts)}}"><small></small></time>
                        <a target="_blank" rel="noopener noreferrer" data-toggle="tooltip" title="{{$post->summary}}" href="{{$post->link}}">
                            <b>{{$post->title}}</b>
                        </a>
                    </li>
                @endforeach
            @endif
 
            <div class="row justify-content-center mt-2">
                <a href="/predictions" class="btn btn-info m-2 col-lg-2">Navodila</a>
                <a href="/cl_statistics" class="btn btn-info m-2 col-lg-2">Prijava</a>
                <a href="/table" class="btn btn-info m-2 col-lg-2">Lestvica najboljših</a>
            </div>  
        </div>
    </div>

@endsection
