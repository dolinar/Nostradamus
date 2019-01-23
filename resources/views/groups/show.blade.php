@extends('layouts.app')

@section('content')
    <h3>Skupina {{$data['group']['name']}}</h3>
    <hr>
        <div class="card mb-3 mt3 p-3">
            {{ Form::open(['action' => 'GroupsController@sendInvitation', 'method' => 'POST', 'id' => 'store-user']) }}
            {{ Form::hidden('group_id', $data['group']['id'])}}
            <fieldset>
                <legend>Dodaj novega člana</legend>
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

    @if ($data['group']['owner'] == auth()->user()->id)
        {{ Form::open([ 'method'  => 'delete', 'route' => [ 'groups.destroy', $data['group']['id'] ]]) }}
            {{ Form::hidden('id', $data['group']['id']) }}
            {{ Form::submit('Izbriši skupino', ['class' => 'btn btn-danger btn-sm', 'onclick' => 'return confirm("Res želite izbrisati skupino?")'])}}
        {{ Form::close() }}
        <hr>
    @endif



    

@endsection