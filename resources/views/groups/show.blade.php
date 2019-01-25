@extends('layouts.app')

@section('content')
    <h3>Skupina {{$data['group']['name']}}</h3>
    <hr>
        <button id="group-add-member" class="btn btn-info btn-sm">Dodaj novega člana</button>
        <div class="card my-3 mt3 p-3" id="add-member-form" style="display:none;">
            {{ Form::open(['action' => 'GroupsController@sendInvitation', 'method' => 'POST', 'id' => 'store-user']) }}
            {{ Form::hidden('group_id', $data['group']['id'])}}
            <fieldset>
                <h5>Dodaj novega člana</h5>
                <div class="form-group">
                    {{ Form::select('user_id_select', $data['users'], 1, array('id' => 'user-id-select')) }}
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
    <hr>

    @if ($data['group']['owner'] == auth()->user()->id)
        {{ Form::open([ 'method'  => 'delete', 'route' => [ 'groups.destroy', $data['group']['id'] ]]) }}
            {{ Form::hidden('id', $data['group']['id']) }}
            {{ Form::submit('Izbriši skupino', ['class' => 'btn btn-danger btn-sm', 'onclick' => 'return confirm("Res želite izbrisati skupino?")'])}}
        {{ Form::close() }}
        <hr>
    @endif



    

@endsection