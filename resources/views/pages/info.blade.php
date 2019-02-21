@extends('layouts.app')

@section('content')
    {!! $data['chart']->script() !!}
    {!! $data['users']->script() !!}
    {!! $data['registrations']->script() !!}
    {!! $data['predictions']->script() !!}
    <h3>Informacije</h3>
    <hr>
    {!! $data['chart']->container() !!}
    <hr>
    {!! $data['predictions']->container() !!}
    <hr>
    {!! $data['users']->container() !!}
    <hr>
    {!! $data['registrations']->container() !!}
@endsection
