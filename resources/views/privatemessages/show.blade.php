@extends('layouts.app')

@section('content')

    <div class="card" style="100%">
        <div class="card-header">
            <a href={{route('send_private', ['id' => $data['sender']->id])}} class="btn btn-info btn-sm">Odgovori</a>
        </div>
        <ul class="list-group list-group-flush">
            <li class="list-group-item">Pošiljatelj: <b>{{ $data['sender']['username'] }}</b></li>
            <li class="list-group-item">Zadeva: <b>{{ $data['privateMessage']->subject }}</b></li>
            <li class="list-group-item">Prejeto: <b>{{date("d-M-y, H:i", strtotime($data['privateMessage']->created_at))}}</b></li>
            <li class="list-group-item">Sporočilo: <br><br> {!! $data['privateMessage']->message !!}</li>
        </ul>
    </div>
    <br>
    <a href={{route('private_message.index')}} class="btn btn-info btn-sm">Nazaj</a>
@endsection
