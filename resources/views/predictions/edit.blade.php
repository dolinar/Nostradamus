@extends('layouts.app')

@section('content')
    <h3>Uredi napoved</h3>
    <hr>
    {{ Form::open(['action' => ['PredictionsController@update', $prediction['id']], 'method' => 'POST']) }}
        <div class="card mb-3">
            <div class="card-header">
                Urejanje napovedi za tekmo: <b>{{$prediction['fixture']['team_home']['name'] . ' - ' . $prediction['fixture']['team_away']['name']}}  </b>
                
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-4 d-inline text-sm-left col-xs-12 text-xs-center">
                        <span>{{Form::label('teamHome', $prediction['fixture']['team_home']['name'])}}</span>
                    </div>
                    <div class="col-sm-4 d-inline text-center">
                        <span>
                        {{Form::number('home', $prediction['prediction_home'], array('class' => 'input-score', 'autocomplete' => 'off'))}} 
                        : 
                        {{Form::number('away', $prediction['prediction_away'], array('class' => 'input-score', 'autocomplete' => 'off', 'min' => 0, 'max' => 100))}}</span>
                    </div>
                    <div class="col-sm-4 d-inline text-sm-right col-xs-12 text-xs-center">  
                        <span>{{Form::label('teamHome', $prediction['fixture']['team_away']['name'])}}</span>
                    </div>
                </div>
            </div>
            <div class="card-footer text-center p-2">
                {{ Form::hidden('_method', 'PUT') }}
                {{ Form::submit('Posodobi', array('class' => 'btn btn-sm btn-primary')) }}
            </div>
        </div>
    {{ Form::close() }}
@endsection
