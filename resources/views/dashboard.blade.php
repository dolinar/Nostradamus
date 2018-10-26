@extends('layouts.app')

@section('content')
<div class="jumbotron">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h4>Pozdravljeni {{Auth::user()->name}}</h4>
            <hr>

                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif
                <
            </div>
        </div>
    </div>
</div>
@endsection
