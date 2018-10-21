@extends('layouts.app')

@section('content')
    <div class="jumbotron">
        <div class="text-center">
            <h1 class="display-4">Pozdravljeni na strani {{config('app.name', 'Nostradamus')}}!</h1>
            <p class="lead">Preverite svoje vizionarske sposobnosti pri napovedovanju rezultatov za Ligo prvakov 2018/2019.</p>
        </div>
        <hr>
        <div class="basic-div" id="index-content">
            <h4>Prihajajoče tekme:</h4>
                    <p>test test<p>
        </div>
    </div>
@endsection
