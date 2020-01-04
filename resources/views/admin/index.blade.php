@extends('layouts.app')

@section('content')
    <h3>Nadzorna plošča</h3>
    <hr>
    @include('admin.create-news')
    <hr>
    @include('admin.create-matchday')
    @include('admin.create-fixture')
    @include('admin.finish-fixtures')
@endsection
