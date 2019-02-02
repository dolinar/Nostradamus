@extends('layouts.app')

@section('content')
    <h5>Uredi profil</h5>
    <hr>
    {{ Form::open(['action' => ['DashboardController@update', 'id' => $data['id']], 'method' => 'POST', 'enctype' => 'multipart/form-data']) }}    
        <div class="form-group text-center p-2">
            {{ Form::file('profile_image') }}
        </div>
        <div class="form-group text-center p-2">
            {{ Form::hidden('_method', 'PUT') }}
            {{ Form::submit('Posodobi', array('class' => 'btn btn-sm btn-primary')) }}
        </div>
    {{ Form::close() }}
@endsection
