@extends('layouts.app')

@section('content')
    @include('pages.index.live_fixtures')
    @include('pages.index.next_matchday')
    <br>
    <div class="row row-eq-height" style="display:flex">
        @include('pages.index.chatroom')
        @include('pages.index.top_five')
    </div>
    <br>
    @include('pages.index.news')

    <script src="{{asset('js/channels/chatroom-channel.js')}}" type="text/javascript" cookie-consent="strictly-necessary"></script>
@endsection
