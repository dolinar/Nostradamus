@extends('layouts.app')

@section('content')
    <div class="jumbotron">
        <a class="btn btn-info mb-3" href="{{route('teams.index')}}">Nazaj</a>
        <div class="card">
            <img class="mx-auto d-block" style="float:left;" width="200" src="{{$team->logo_url}}" alt="">
            <div class="card-body">
                <h3 class="card-title">{{$team->name}}</h3>
                <section>{{$team->description}}</section>   
            </div>
        </div>

        <hr>
        <h4>Dosedanje tekme</h4>
    </div>
@endsection
