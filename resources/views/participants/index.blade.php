@extends('layouts.app')

@section('content')
    <h3>Lestvica</h3>
    <hr>
    @if ($data['participants'])
        <div class="row" style="margin-bottom:10px">
            <div class="col-lg-4 col-lg-offset-4">
                <input type="search" id="user-search" value="" class="form-control" placeholder="Išči uporabnike">
            </div>
        </div>
        <div id="table-div">
            @include('participants.table')
        </div>
    @endif

@endsection
