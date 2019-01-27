@extends('layouts.app')

@section('content')
    <h4>Pozdravljeni {{Auth::user()->name}}</h4>
    <hr>
    @if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
    @endif

    @if (!$data['overallPrediction'] && Config::get('nostradamus.competition-start') > date('Y-m-d H:i:s'))
        <div class="alert alert-warning">
            <span>Niste še izbrali končnega zmagovalca. To lahko storite <a href="/overall_prediction">tukaj</a>.</span>
        </div>
    @endif

    @if ($data['difference'] > 0)
        <div class="alert alert-warning">
            <span>Napovejte vse rezultate <a href="/predictions">tukaj</a>.</span>
        </div>
    @else
        <div class="alert alert-success">
            <span>Trenutno ni na sporedu nobene tekme, ki je še niste napovedali!</span>
        </div>
    @endif

    @if (count($data['invitations']) > 0)

        @foreach ($data['invitations'] as $invtitation)
            <div class="alert alert-warning">
                <span>Uporabnik <b>{{$invtitation->user_invitator}}</b> te je povabil v skupino <b>{{$invtitation->name}}.</b>
                    <a href="#" name={{$invtitation->id}} value="1" id="store-accept"><span class="fas fa-check"></span></a>  
                    <a href="#" name={{$invtitation->id}} value="0" id="store-reject"><span class="fas fa-times"></span></a>  
                </span>
            </div>
        @endforeach
    @endif
@endsection
