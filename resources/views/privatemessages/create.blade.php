@extends('layouts.app')

@section('content')
    {{ Form::open(['action' => 'PrivateMessagesController@store', 'method' => 'POST', 'id' => 'store-private-message']) }}
    {{ Form::hidden('id_receiver', $user['id'])}}
    <fieldset>
        <h5>Pošlji zasebno sporočilo uporabniku <b>{{$user['username']}}</b></h5>
        <div class="form-group">
            {{Form::label('subject', 'Zadeva')}}
            {{Form::text('subject', '', ['class' => 'form-control', 'placeholder' => 'Zadeva'])}}
        </div>
        <div class="form-group">
            {{Form::label('body', 'Sporočilo')}}
            {{Form::textarea('body', '', ['class' => 'form-control', 'placeholder' => 'Sporočilo', 'id' => 'article-ckeditor'])}}
        </div>
        <div class="form-group">
            {{ Form::submit('Pošlji', ['class' => 'btn btn-primary btn-sm']) }}
        </div>
    </fieldset>
    {{ Form::close() }}

    <script src="/vendor/unisharp/laravel-ckeditor/ckeditor.js"></script>
    <script>
        CKEDITOR.replace( 'article-ckeditor' );
    </script>
@endsection
