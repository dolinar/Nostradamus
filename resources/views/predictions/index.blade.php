@extends('layouts.app')

@section('content')
    <h3>Napovedi</h3>
    <hr>
    @if (count($data['predictions']) > 0)
        @foreach ($data['predictions'] as $matchday)
            {{ Form::open(array('action' => 'PredictionsController@store', 'method' => 'POST')) }}
            <div class="card">
                <div class="card-header">
                    <p>Napovedi za tekmovalni dan <b>{{$matchday['date']}}</b>. Stopnja tekmovanja: <b>{{$matchday['stage']}}</b></p>
                </div>
                <ul class="list-group list-group-flush">
                @foreach ($matchday['fixtures'] as $fixture)
                    {{-- @if ($fixture['prediction'] != NULL)
                        {{$fixture['prediction'][0]['id']}}
                    @endif --}}
                    <li class="list-group-item">
                            {{Form::label('teamHome', $fixture['team_home']['name'])}}
                            {{Form::text('teamHome')}} : 
                            {{Form::text('teamHome')}}
                            {{Form::label('teamHome', $fixture['team_away']['name'])}}
                    </li>
                @endforeach
                </ul>
                {{ Form::submit('Shrani', array('class' => 'btn btn-primary')) }}
            </div>
            {{ Form::close() }}
        @endforeach
    @endif  
@endsection
