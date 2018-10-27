@extends('layouts.app')

@section('content')
    <h3>Napoved končnega zmagovalca</h3>
    <hr>
    <!-- TODO-->
    @if (Config::get('competition-start') > date('Y-m-d H:i:s'))
        @if (count($data['overallPrediction']) > 0)
            <div class="alert alert-info" role="alert">
                Čas za izbiro končnega zmagovalca je potekel. Vaša izbira: <b>{{$data['overallPrediction'][0]->name}}</b>.
            </div>
        @else
            <div class="alert alert-info" role="alert">
                Čas za izbiro končnega zmagovalca je potekel. Končnega zmagovalca niste napovedali.
            </div>
        @endif
        @include('overallpredictions.disabled-form')

    @elseif (count($data['overallPrediction']) == 0)
        @include('overallpredictions.store-form');

    @else
        @include('overallpredictions.update-form')
    @endif
@endsection
