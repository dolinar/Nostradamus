@if ($data['nextFixture'])
    <div class="card my-3 mt3 p-3" id="add-member-form">
        {{ Form::open(['action' => 'AdminController@finishFixture', 'method' => 'POST']) }}
        {{ Form::hidden('id', $data['nextFixture']->id) }}
        <fieldset>
            <h5>Zaključi tekmovalni dan</h5>
            {{ Form::label($data['nextFixture']->teamHome->name) }}
            {{ Form::number('home_score', null, ['class' => 'form-control'])}}
            <div style="text-align: center">-</div>
            {{ Form::number('away_score', null, ['class' => 'form-control'])}}
            {{ Form::label($data['nextFixture']->teamAway->name) }}
            <div class="form-group">
                {{ Form::submit('Shrani', ['class' => 'btn btn-primary btn-sm']) }}
            </div>
        </fieldset>
        {{ Form::close() }}
    </div>    
@endif