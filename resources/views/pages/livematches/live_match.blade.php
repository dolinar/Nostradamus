@extends('layouts.app')

@section('content')
    <div class="row border-bottom">
        <div class="col-6">
            <span class="small">{{ strftime('%e %B, %G', strtotime($data['fixture']['matchday']['date']))}}</span><br>
            <span class="small">{{substr(date('H:i', strtotime($data['fixture']['time'] . ' UTC')), 0, 5)}}</span>            
        </div>
        <div class="col-6 text-right">
            <span class="small">{{$data['fixture']->location}}</span>
        </div>
    </div>
    <div class="row justify-content-center mt-1 text-right">
        <div class="col-4">
            <img style="height:2em" src="/{{$data['fixture']->teamHome->logo_url}}"> {{$data['fixture']->teamHome->name}}
        </div>
        <div class="col-4 text-center" style="font-size:2em">
            {{$data['fixture']->home_score}} - {{$data['fixture']->away_score}}
        </div>
        <div class="col-4 text-left">
            <img style="height:2em" src="/{{$data['fixture']->teamAway->logo_url}}"> {{$data['fixture']->teamAway->name}}
        </div>
    </div>
    @if ($data['fixture']->ht_score != null)
    <div class="row border-bottom py-2">
        <div class="col-md-12 text-center font-weight-bold">
            <span class="grey-text small">(HT: {{$data['fixture']->ht_score}})</span>
        </div>
    </div>
    @endif
    <div class="row pb-2">
        <div class="col-md-12 text-center font-weight-bold">
            <span class="text-danger">{{($data['fixture']['ht_score'] == null) ? 'Prvi polčas: ' : 'Drugi polčas: ' . $data['fixture']['minutes'] }}
                <span class="blink-text">'</span>
            </span>
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
