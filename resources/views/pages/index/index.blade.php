@extends('layouts.app')

@section('content')
    <script>
        jQuery(document).ready(function() { //TODO: move this to .js file
            jQuery("time.timeago").timeago();
        });
    </script>
    <div class="container">
        @include('pages.index.next_matchday')
        <br>
        <div class="row">
            @include('pages.index.chatroom')
            @include('pages.index.top_five')
        </div>
        <br>
        @include('pages.index.news')
        @include('pages.index.footer')
    </div>
@endsection
