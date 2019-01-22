@extends('layouts.app')

@section('content')
    <h3>Skupina {{$data['group']['name']}}</h3>
    <hr>
    @if ($data['group']['owner'] == auth()->user()->id)
        {{ Form::open([ 'method'  => 'delete', 'route' => [ 'groups.destroy', $data['group']['id'] ]]) }}
            {{ Form::hidden('id', $data['group']['id']) }}
            {{ Form::submit('Izbriši skupino', ['class' => 'btn btn-danger btn-sm', 'onclick' => 'return confirm("Res želite izbrisati skupino?")'])}}
        {{ Form::close() }}
        <hr>
    @endif


    

@endsection