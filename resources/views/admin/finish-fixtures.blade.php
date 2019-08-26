<div class="card my-3 mt3 p-3" id="add-member-form">
    {{ Form::open(['action' => 'AdminController@finishFixtures', 'method' => 'POST']) }}
    <fieldset>
        <h5>Zaključi tekmovalni dan</h5>


        <div class="form-group">
            {{ Form::submit('Shrani', ['class' => 'btn btn-primary btn-sm']) }}
        </div>
    </fieldset>
    {{ Form::close() }}
</div>    
    