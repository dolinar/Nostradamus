@extends('layouts.app')

@section('content')
    <div class="jumbotron">
        <div class="text-center">
            <h1 class="display-4">Pozdravljeni na strani {{config('app.name', 'Nostradamus')}}!</h1>
            <p class="lead">Preverite svoje vizionarske sposobnosti pri napovedovanju rezultatov za Ligo prvakov 2018/2019.</p>
        </div>
        <hr>
        <div class="basic-div" id="index-content">
            <h4>Novice:</h4>
            <ul class="list-group">
            @if (count($postsArray) > 0)
                @foreach($postsArray as $post)
                    <li class="list-group-item">
                        <a target="_blank" rel="noopener noreferrer" data-toggle="tooltip" title="{{$post->summary}}" href="{{$post->link}}">
                            {{date("d-m-Y H:i", intval($post->ts)) . ": "}} <b>{{$post->title}}</b>
                        </a>
                    </li>
                @endforeach
            @endif
            </ul>

            <div class="basic-div text-center">
                <div class="btn-group">
                    <button type="button" class="btn ml-2 btn-warning">Lestvica najboljsih</button>
                    <button type="button" class="btn ml-2 btn-warning">Sony</button>
                </div>                
            </div>               
        </div>
    </div>
@endsection
