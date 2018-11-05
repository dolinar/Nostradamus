<li class="list-group-item">
    <div class="row">
        <div class="col-sm-4 d-inline text-sm-left col-xs-12 text-xs-center">
            <span>{{Form::label('teamHome', $fixture['team_home']['name'])}}</span>
        </div>
        <div class="col-sm-4 d-inline text-center">
            <span>
            {{Form::text('prediction[' . $fixture['id'] . '][home]', null, array('class' => 'input-score', 'autocomplete' => 'off'))}} 
            : 
            {{Form::text('prediction[' . $fixture['id'] . '][away]', null, array('class' => 'input-score', 'autocomplete' => 'off'))}}</span>
        </div>
        <div class="col-sm-4 d-inline text-sm-right col-xs-12 text-xs-center">  
            <span>{{Form::label('teamHome', $fixture['team_away']['name'])}}</span>
        </div>
    </div>
</li>