@extends('layouts.app')

@section('content')
    @include('pages.index.next_matchday')
    <br>
    <div class="row row-eq-height" style="display:flex">
        @include('pages.index.chatroom')
        @include('pages.index.top_five')
    </div>
    <br>
    @include('pages.index.news')
    @include('pages.index.footer')
@endsection
