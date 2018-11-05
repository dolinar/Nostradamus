<li class="list-group-item">
    <div class="row">
        <div class="col-sm-4 d-inline text-sm-left col-xs-12 text-xs-center text-muted">
            <span>{{Form::label('teamHome', $fixture['team_home']['name'])}}</span>
        </div>
        <div class="col-md-4 d-inline text-center text-muted">
            {{Form::text('teamHome', null, array('class' => 'input-score', 'disabled' => 'disabled'))}} 
            : 
            {{Form::text('teamAway', null, array('class' => 'input-score', 'disabled' => 'disabled'))}}
        </div>
        <div class="col-sm-4 d-inline text-sm-right col-xs-12 text-xs-center text-muted">  
            <span>{{Form::label('teamHome', $fixture['team_away']['name'])}}</span>
        </div>
    </div>
    @if($fixture['prediction'] != NULL)
        <div class="text-center text-muted">
            Trenutna napoved: <b>{{$fixture['prediction'][0]['prediction_home'] . ':' .$fixture['prediction'][0]['prediction_away']}}</b>
            <a href="{{route('predictions.edit', $fixture['prediction'][0]['id'])}}" class="btn btn-sm btn-default">Uredi</a>
        </div>    
    @endif
</li>