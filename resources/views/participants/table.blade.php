@extends('layouts.app')

@section('content')
    <h3>Navodila</h3>
    <hr>
    @if (count($data['participants']) > 0)
        @foreach ($data['participants'] as $participant)
            {{$participant->name}}
        @endforeach
    @endif

@endsection
