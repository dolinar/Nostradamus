@extends('layouts.app')

@section('content')
    <h3>Napoved končnega zmagovalca</h3>
    <hr>
    <!-- TODO-->
    @if (Config::get('competition-start') < date('Y-m-d H:i:s'))
        @if (count($data['overallPrediction']) > 0)
            <p>Čas za izbiro končnega zmagovalca je potekel. Vaša izbira: <b>{{$data['overallPrediction'][0]->name}}</b>.</p>
        @else
            <p>Čas za izbiro končnega zmagovalca je potekel. Končnega zmagovalca niste napovedali.</p>
        @endif
        @include('overallpredictions.disabled-form')

    @elseif (count($data['overallPrediction']) == 0)
        @include('overallpredictions.store-form');

    @else
        @include('overallpredictions.update-form')
    @endif

@endsection
