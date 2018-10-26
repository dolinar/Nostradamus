@extends('layouts.app')

@section('content')
    <h4>Pozdravljeni {{Auth::user()->name}}</h4>
    <hr>
    @if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
    @endif
@endsection
