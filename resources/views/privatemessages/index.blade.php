@extends('layouts.app')

@section('content')
    <h5>Nova sporočila:</h5>
    <hr>
    @forelse ($data['newMessages'] as $newMessage)
        <li class="list-group-item">
            <div class="row">
                <div class="col-lg-3 text-center">
                    Prejeto: <b>{{date("d-M-y, H:i", strtotime($newMessage->created_at))}}</b> 
                </div>
                <div class="col-lg-3 text-center">
                    Zadeva: <b>{{$newMessage->subject}}</b> 
                </div>
                <div class="col-lg-3 text-center">
                    Pošiljatelj: <b>{{$newMessage->username}}</b> 
                </div>
                <div class="col-lg-2 text-right">
                    <a href={{route('private_message.show', ['id' => $newMessage->id])}}>Odpri</a>
                </div>
                <div class="col-lg-1 text-right">
                    {{ Form::open(['action' => ['PrivateMessagesController@destroy', $newMessage->id],  'method' => 'POST']) }}
                        {{ Form::hidden('_method', 'DELETE') }}
                        {{ Form::button('<i class="fa fa-times" aria-hidden="true"></i>', ['class' => 'btn btn-danger btn-sm', 'type' => 'submit']) }}
                    {{ Form::close() }}
                </div>
            </div>
        </li>   
    @empty
        <div class="alert alert-info group-invitations-dropdown">
            <span>Nimate nobenega novega zasebnega sporočila.</span>
        </div>
    @endforelse
        
    <br>
    <h5>Stara sporočila</h5>
    <hr>
    @forelse ($data['readMessages'] as $readMessage)
        <li class="list-group-item">
            <div class="row">
                <div class="col-lg-3 text-center">
                    Prejeto: <b>{{date("d-M-y, H:i", strtotime($readMessage->created_at))}}</b> 
                </div>
                <div class="col-lg-3 text-center">
                    Zadeva: <b>{{$readMessage->subject}}</b> 
                </div>
                <div class="col-lg-3 text-center">
                    Pošiljatelj: <b>{{$readMessage->username}}</b> 
                </div>
                <div class="col-lg-2 text-right">
                    <a href={{route('private_message.show', ['id' => $readMessage->id])}}>Odpri</a>
                </div>
                <div class="col-lg-1 text-right">
                    {{ Form::open(['action' => ['PrivateMessagesController@destroy', $readMessage->id],  'method' => 'POST']) }}
                        {{ Form::hidden('_method', 'DELETE') }}
                        {{ Form::button('<i class="fa fa-times" aria-hidden="true"></i>', ['class' => 'btn btn-danger btn-sm', 'type' => 'submit']) }}
                    {{ Form::close() }}
                </div>
            </div>
        </li>   
    @empty
        <div class="alert alert-info group-invitations-dropdown">
            <span>Nimate nobenih sporočil.</span>
        </div>
    @endforelse
    
    <br>
    <h5>Poslana sporočila</h5>
    <hr>
    @forelse ($data['sentMessages'] as $sentMessage)
        <li class="list-group-item">
            <div class="row">
                <div class="col-lg-3 text-center">
                    Prejeto: <b>{{date("d-M-y, H:i", strtotime($sentMessage->created_at))}}</b> 
                </div>
                <div class="col-lg-3 text-center">
                    Zadeva: <b>{{$sentMessage->subject}}</b> 
                </div>
                <div class="col-lg-3 text-center">
                    Prejemnik: <b>{{$sentMessage->username}}</b> 
                </div>
                <div class="col-lg-2 text-right">
                    <a href={{route('private_message.show', ['id' => $sentMessage->id])}}>Odpri</a>
                </div>
                <div class="col-lg-1 text-right">
                    {{ Form::open(['action' => ['PrivateMessagesController@destroy', $sentMessage->id],  'method' => 'POST']) }}
                        {{ Form::hidden('_method', 'DELETE') }}
                        {{ Form::button('<i class="fa fa-times" aria-hidden="true"></i>', ['class' => 'btn btn-danger btn-sm', 'type' => 'submit']) }}
                    {{ Form::close() }}
                </div>
            </div>
        </li>   
    @empty
        <div class="alert alert-info group-invitations-dropdown">
            <span>Nimate nobenih sporočil.</span>
        </div>
    @endforelse

@endsection
