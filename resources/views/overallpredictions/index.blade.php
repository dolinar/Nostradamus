@extends('layouts.app')

@section('content')
    <h3>Napoved končnega zmagovalca</h3>
    <hr>
    <!-- TODO change copmpetition start! -->
    @if (Config::get('nostradamus.competition-start') > date('Y-m-d H:i:s'))
        @if ($data['overallPrediction'])
            <div class="alert alert-info" role="alert">
                Čas za izbiro končnega zmagovalca je potekel. Vaša izbira: <b>{{$data['overallPredictionTeam']->name}}</b>.
            </div>
        @else
            <div class="alert alert-info" role="alert">
                Čas za izbiro končnega zmagovalca je potekel. Končnega zmagovalca niste napovedali.
            </div>
        @endif
        @include('overallpredictions.disabled-form')

    @elseif (!$data['overallPrediction'])
        @include('overallpredictions.store-form')

    @else
        @include('overallpredictions.update-form')
    @endif
@endsection 
