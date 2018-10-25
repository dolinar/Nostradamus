@extends('layouts.app')

@section('content')
    <div class="jumbotron">
        <h1>Ekipe</h1>
        <hr>
        @if(count($teams) > 0) 
            <div class="row">
            @foreach ($teams as $team)
                @if ($team->status == 1)
                    <div class="card col-lg-3 col-md-5 m-2">
                        <img class="card-img-top-multiple" src={{$team->logo_url}} alt="">
                        <div class="card-body">
                            <h5 class="card-title">{{$team->name}}</h5>
                            <p class="card-text text-success">V tekmovanju.</p>
                            <a href="{{route('teams.show', $team->id)}}" class="btn btn-primary">Podatki</a>
                        </div>
                    </div>
                @else
                    <div class="card col-lg-3 col-md-5 m-2">
                        <img class="card-img-top-multiple eliminated" src={{$team->logo_url}} alt="">
                        <div class="card-body">
                            <h5 class="card-title">{{$team->name}}</h5>
                            <p class="card-text text-danger">Izloceni iz tekmovanja.</p>
                            <a href="{{route('teams.show', $team->id)}}" class="btn btn-primary">Podatki</a>
                        </div>
                    </div>
                @endif
            @endforeach
            </div>
        @else
            <p>Najdena ni bila nobena ekipa.</p>
        @endif
    </div>
@endsection
