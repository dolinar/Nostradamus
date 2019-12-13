@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-12 text-center font-weight-bold">
            <span class="text-danger" style="font-size:25px">{{$data['fixture']['minutes']}}<span class="blink-text" style="font-size:25px">'</span></span>
        </div>
    </div>

    <div class="row justify-content-center border p-2 mx-2 my-1">
        <div class="col-3">
            <img style="height:2em" src="/{{$data['fixture']->teamHome->logo_url}}"> {{$data['fixture']->teamHome->name}}
        </div>
        <div class="col-2 text-center">
            {{$data['fixture']->home_score}} - {{$data['fixture']->away_score}}
        </div>
        <div class="col-3 text-right">
            <img style="height:2em" src="/{{$data['fixture']->teamAway->logo_url}}"> {{$data['fixture']->teamAway->name}}
        </div>
    </div>
    @if ($data['fixture']->ht_score != null)
        <div class="row">
            <div class="col-md-12 text-center font-weight-bold">
                <span style="font-size:20px">Polčas: {{$data['fixture']->ht_score}}</span>
            </div>
        </div>
    @endif

    <div class="row">
        <div class="col-md-12 text-center font-weight-bold">
            <span class="text-info" style="font-size:20px">{{$data['fixture']->location}}</span>
        </div>
    </div>
    <div class="classic-tabs my-2">
        <ul class="nav tabs-primary" id="myClassicTabShadow" role="tablist">
            <li class="nav-item">
                <a class="nav-link  waves-light active show" id="profile-tab-classic-shadow" data-toggle="tab" href="#profile-classic-shadow"
                role="tab" aria-controls="profile-classic-shadow" aria-selected="true">Klepet</a>
            </li>
            <li class="nav-item">
                <a class="nav-link waves-light" id="follow-tab-classic-shadow" data-toggle="tab" href="#follow-classic-shadow"
                role="tab" aria-controls="follow-classic-shadow" aria-selected="false">Statistika</a>
            </li>
            <li class="nav-item">
                <a class="nav-link waves-light" id="contact-tab-classic-shadow" data-toggle="tab" href="#contact-classic-shadow"
                role="tab" aria-controls="contact-classic-shadow" aria-selected="false">Dogodki</a>
            </li>
        </ul>
        
        <div class="tab-content card" id="myClassicTabContentShadow">
            <div class="tab-pane fade active show" id="profile-classic-shadow" role="tabpanel" aria-labelledby="profile-tab-classic-shadow">
            <p>.</p>
            </div>
            @include('pages.livematches.stats')
            @include('pages.livematches.events')
        </div>
    </div>
@endsection
