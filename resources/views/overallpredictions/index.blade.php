@extends('layouts.app')

@section('content')
    <div class="jumbotron">
        @include('inc.messages')
        <h3>Napoved končnega zmagovalca</h3>
        <hr>
        @if (count($data['overallPrediction']) == 0)
            <p>S seznama izberite vašega favorita. Več o izboru končnega zmagovalca si lahko preberete <a href="/instructions">tukaj</a>.</p>
            @if (count($data['teams']) > 0)
                {{ Form::open(['action' => 'OverallPredictionsController@store', 'method' => 'POST']) }}
                    <div class="form-group">
                        <ul class="list-group">
                            @foreach ($data['teams'] as $team)
                                <li class="list-group-item pl-4">
                                    {{Form::checkbox($team->id, $team->id, false, ['class' => 'form-check-overall-prediction'])}}
                                        {{$team->name}}</li>
                            @endforeach
                        </ul>
                        {{ Form::hidden('ekipa', '', array('id' => 'team-id')) }}
                    </div>
                    {{Form::submit('Shrani', ['class' => 'btn btn-primary'])}}
                {{ Form::close() }}
            @endif
        @else

            <p>Vaša trenutna izbira je: <b>{{$data['overallPrediction'][0]->name}}</b>.</p>
            @if (count($data['teams']) > 0)
                {{ Form::open(['action' => ['OverallPredictionsController@update', $data['overallPrediction'][0]->id], 'method' => 'POST']) }}
                    <div class="form-group">
                        <ul class="list-group">
                            @foreach ($data['teams'] as $team)
                                <li class="list-group-item pl-4">
                                    {{Form::checkbox($team->id, $team->id, false, ['class' => 'form-check-overall-prediction'])}}
                                        {{$team->name}}</li>
                            @endforeach
                        </ul>
                        {{ Form::hidden('ekipa', '', array('id' => 'team-id')) }}
                    </div>
                    {{Form::hidden('_method', 'PUT')}}
                    {{Form::submit('Posodobi', ['class' => 'btn btn-primary'])}}
                {{ Form::close() }}
            @endif
        @endif
    </div>
@endsection
