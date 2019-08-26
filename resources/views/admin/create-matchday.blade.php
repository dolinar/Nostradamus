<div class="card my-3 mt3 p-3" id="add-member-form">
    {{ Form::open(['action' => 'AdminController@createMatchday', 'method' => 'POST']) }}
    <fieldset>
        <h5>Kreiraj tekmovalni dan</h5>

        <div class="form-group">
            Datum tekmovalnega dne:   {{ Form::date('date', null, ['class' => 'form-control']) }}
        </div>
        <div class="form-group">
            Stopnja tekmovalnega dne: {{ Form::text('stage', null, ['class' => 'form-control']) }}
        </div>
        
        <div class="form-group">
            {{ Form::submit('Shrani', ['class' => 'btn btn-primary btn-sm']) }}
        </div>
    </fieldset>
    {{ Form::close() }}
</div>    
