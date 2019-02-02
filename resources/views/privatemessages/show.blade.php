@extends('layouts.app')

@section('content')
    <div class="card" style="100%">
        <div class="card-header">
            Sporočilo
        </div>
        <ul class="list-group list-group-flush">
            <li class="list-group-item">Pošiljatelj: <b>{{ $data['sender']['username'] }}</b></li>
            <li class="list-group-item">Zadeva: <b>{{ $data['privateMessage']->subject }}</b></li>
            <li class="list-group-item">Prejeto: <b>{{date("d-M-y, H:i", strtotime($data['privateMessage']->created_at))}}</b></li>
            <li class="list-group-item">Sporočilo: <br><br> {!! $data['privateMessage']->subject !!}</li>
        </ul>
    </div>
@endsection
