@extends('layouts.app')

@section('content')
    <div class="jumbotron">
        <h3>Napoved končnega zmagovalca</h3>
        <hr>
        @if (count($teams) > 0)
            @foreach ($teams as $team)
                c
            @endforeach
        @else
        @endif
    </div>
@endsection
