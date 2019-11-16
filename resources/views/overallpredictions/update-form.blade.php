<div class="alert alert-info" role="alert">
    Vaša trenutna izbira je: <b>{{$data['overallPredictionTeam']->name}}</b>.
</div>
{{ Form::open(['action' => ['OverallPredictionsController@update', $data['overallPrediction']->id], 'method' => 'POST']) }}
    <div class="form-group">
        <ul class="list-group">
            @foreach ($data['teams'] as $team)
                <li class="list-group-item pl-4">
                    {{Form::checkbox($team->id, $team->id, false, ['class' => 'form-check-overall-prediction'])}}
                    <img class="ml-2" style="height:2em" src="{{$team->logo_url}}"> {{$team->name}}</li>
            @endforeach
        </ul>
        {{ Form::hidden('ekipa', '', array('id' => 'team-id')) }}
    </div>
    {{Form::hidden('_method', 'PUT')}}
    {{Form::submit('Posodobi', ['class' => 'btn btn-primary'])}}
{{ Form::close() }}