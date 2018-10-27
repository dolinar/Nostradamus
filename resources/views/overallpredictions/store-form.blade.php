<div class="alert alert-info" role="alert">
    S seznama izberite vašega favorita. Več o izboru končnega zmagovalca si lahko preberete <a href="/instructions">tukaj</a>.
</div>
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