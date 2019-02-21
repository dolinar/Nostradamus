@extends('layouts.app')

@section('content')
    <h5>Napovedi</h5>
    <hr>
    @if (count($data['predictions']) > 0)
        @foreach ($data['predictions'] as $matchday)
            {{ Form::open(array('action' => 'PredictionsController@store', 'method' => 'POST')) }}
            <div class="card mb-3">
                <div class="card-header">
                    Napovedi za tekmovalni dan <b>{{ strftime('%e %B, %G', strtotime($matchday['date']))}}</b>. Stopnja tekmovanja: <b>{{$matchday['stage']}}</b>
                </div>
                <ul class="list-group list-group-flush">
                    @foreach ($matchday['fixtures'] as $fixture)
                        {{-- {{print_r(new DateTime(date('Y-m-d H:i:s', strtotime($matchday['date'] . ' ' . $fixture['time']))))}}
                        {{print_r((new DateTime(date('Y-m-d H:i:s')))->modify('+55 minutes'))}} --}}
                        @if ((new DateTime(date('Y-m-d H:i:s', strtotime($matchday['date'] . ' ' . $fixture['time']))))->modify('-5 minutes') > (new DateTime(date('Y-m-d H:i:s')))->modify('+1 hour'))
                            @if($fixture['prediction'] == NULL)
                                @include('predictions.form-active')
                            @else 
                                @include('predictions.form-disabled')
                            @endif
                        @else
                            @include('predictions.form-disabled')
                        @endif
                    @endforeach
                </ul>
                @if ((new DateTime(date('Y-m-d H:i:s', strtotime($matchday['date'] . ' ' . $fixture['time']))))->modify('-5 minutes') > (new DateTime(date('Y-m-d H:i:s')))->modify('+1 hour') && $fixture['prediction'] == NULL)
                    <div class="card-footer text-center p-2">
                        {{ Form::submit('Shrani', array('class' => 'btn btn-sm btn-primary')) }}
                    </div>
                @else
                    <div class="card-footer text-center p-2">
                        {{ Form::submit('Shrani', array('class' => 'btn btn-sm btn-primary disable', 'disabled' => 'disabled')) }}
                    </div>
                @endif
            </div>
            {{ Form::close() }}
        @endforeach
    @else
        <div class="alert alert-info text-center">
            <span>Trenutno ni na sporedu nobene tekme.</span>
        </div>
    @endif  
    <br>
    <h5>Pretekle napovedi</h5>
    <hr>
    @forelse ($data['previousPredictions'] as $matchday)
        <div class="card mb-3">
            <div class="card-header previous-predictions-dropdown">
                Tekmovalni dan <b>{{ strftime('%e %B, %G', strtotime($matchday['date']))}}</b>. Stopnja tekmovanja: <b>{{$matchday['stage']}}</b>
                <i class="fas fa-chevron-down fa-chevron-previous-predictions float-right"></i>
            </div>
            <ul class="list-group list-group-flush">
                @foreach ($matchday['fixtures'] as $fixture)
                    @if (count($fixture->prediction) == 0)
                        <li class="list-group-item previous-prediction" style="display: none">
                            <div class="row">
                                <div class="col-lg-4 col-md-4">
                                    {{$fixture->teamHome->name}} 
                                </div>
                                <div class="col-lg-4 col-md-4 text-center">
                                    <span><b>x - x</b></span>
                                </div>
                                <div class="col-lg-4 col-md-4 text-right">
                                    {{$fixture->teamAway->name}} 
                                </div>
                            </div>
                            <div class="text-center">
                                    Rezultat tekme: {{$fixture['home_score']}} - {{$fixture['away_score']}}
                            </div>
                        </li>
                    @else
                        @if ($fixture->prediction[0]->points == 3)
                            <li class="list-group-item previous-prediction" style="background:#adff82; display: none">
                                <div class="row">
                                    <div class="col-lg-4 col-md-4">
                                        {{$fixture->teamHome->name}} 
                                    </div>
                                    <div class="col-lg-4 col-md-4 text-center">
                                        <span><b>{{$fixture->prediction[0]->prediction_home}} - {{$fixture->prediction[0]->prediction_away}}</b></span>
                                    </div>
                                    <div class="col-lg-4 col-md-4 text-right">
                                        {{$fixture->teamAway->name}} 
                                    </div>
                                </div>
                                <div class="text-center">
                                        Rezultat tekme: {{$fixture['home_score']}} - {{$fixture['away_score']}}
                                </div>
                            </li>
                        @elseif ($fixture->prediction[0]->points == 1)
                            <li class="list-group-item previous-prediction" style="background:#fdff93; display: none">
                                <div class="row">
                                    <div class="col-lg-4 col-md-4">
                                        {{$fixture->teamHome->name}} 
                                    </div>
                                    <div class="col-lg-4 col-md-4 text-center">
                                        <span><b>{{$fixture->prediction[0]->prediction_home}} - {{$fixture->prediction[0]->prediction_away}}</b></span>
                                    </div>
                                    <div class="col-lg-4 col-md-4 text-right">
                                        {{$fixture->teamAway->name}} 
                                    </div>
                                </div>
                                <div class="text-center">
                                        Rezultat tekme: {{$fixture['home_score']}} - {{$fixture['away_score']}}
                                </div>
                            </li>
                        @else 
                            <li class="list-group-item previous-prediction" style="background:#ff897a; display: none">
                                <div class="row">
                                    <div class="col-lg-4 col-md-4">
                                        {{$fixture->teamHome->name}} 
                                    </div>
                                    <div class="col-lg-4 col-md-4 text-center">
                                        <span><b>{{$fixture->prediction[0]->prediction_home}} - {{$fixture->prediction[0]->prediction_away}}</b></span>
                                    </div>
                                    <div class="col-lg-4 col-md-4 text-right">
                                        {{$fixture->teamAway->name}} 
                                    </div>
                                </div>
                                <div class="text-center">
                                        Rezultat tekme: {{$fixture['home_score']}} - {{$fixture['away_score']}}
                                </div>
                            </li>
                        @endif
                    @endif
                @endforeach
            </ul>
        </div>
    @empty
        
    @endforelse
@endsection
