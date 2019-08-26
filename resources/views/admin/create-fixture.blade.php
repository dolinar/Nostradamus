<div class="card my-3 mt3 p-3" id="add-member-form">
    {{ Form::open(['action' => 'AdminController@createFixture', 'method' => 'POST']) }}
    <fieldset>
        <h5>Kreiraj tekmo</h5>
        <div class="form-group">
            Tekmovalni dan: {{ Form::select('matchday_select', $data['matchdays'], 0, ['class' => 'form-control']) }}
        </div>
        <div class="form-group">
            Domača ekipa: {{ Form::select('team1_select', $data['teams'], 0, ['class' => 'form-control']) }}
        </div>

        <div class="form-group">
            Gostujoča ekipa: {{ Form::select('team2_select', $data['teams'], 0, ['class' => 'form-control']) }}
        </div>
        <div class="form-group">
            Začetek tekme: {{ Form::time('start_time', null, ['class' => 'form-control']) }}
        </div>
        <div class="form-group">
            {{ Form::submit('Shrani', ['class' => 'btn btn-primary btn-sm']) }}
        </div>
    </fieldset>
    {{ Form::close() }}
</div>    
    