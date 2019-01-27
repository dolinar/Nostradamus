<div class="card my-3 mt3 p-3" id="add-member-form" style="display:none;">
    {{ Form::open(['action' => 'GroupsController@sendInvitation', 'method' => 'POST', 'id' => 'store-user']) }}
    {{ Form::hidden('group_id', $data['group']['id'])}}
    <fieldset>
        <h5>Dodaj novega člana</h5>
        <div class="form-group">
            {{ Form::select('user_id_select', $data['users'], 0, ['id' => 'user-id-select']) }}
        </div>
        <div class="form-group">
            {{ Form::label('user-admin-label', 'Admin: ') }}
            {{ Form::checkbox('user_checkbox', 1, 0) }}
        </div>
        <div class="form-group">
            {{ Form::submit('Shrani', ['class' => 'btn btn-primary btn-sm']) }}
        </div>
    </fieldset>
    {{ Form::close() }}
</div>    