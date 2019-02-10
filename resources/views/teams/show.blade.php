@extends('layouts.app')

@section('content')
    <a class="btn btn-info mb-3" href="{{route('teams.index')}}">Nazaj</a>
    <div class="card">
        <img class="mx-auto d-block" style="float:left;" width="200" src="{{$data['team']->logo_url}}" alt="">
        <div class="card-body">
            <h3 class="card-title">{{$data['team']->name}}</h3>
            <hr>
            <section>{!! $data['team']->description !!}</section>   
        </div>
    </div>

    <br><br>
    <h4>Tekme</h4>
    <hr>
    @forelse ($data['activeMatchdays'] as $matchday)
        <li class="list-group-item mt-3 rounded-top active-prediction" id={{$matchday['id']}} >
            <span>Tekmovalni dan: <b>{{date('j F, Y', strtotime($matchday['date']))}}</b>. Stopnja tekmovanja: <b>{{$matchday['stage']}}</b>. Čas: {{$matchday['time']}}
                <i class="fas fa-chevron-down fa-chevron-predictions" style="font-size:25px; float:right"></i>
            </span>
        </li>
        <li class="list-group-item" id={{$matchday['matchday_id']}}>
            <div class="row">
                <div class="col-lg-4 col-md-4">
                    {{$matchday->home_team}} 
                </div>
                <div class="col-lg-4 col-md-4 text-center">
                {{$matchday->home_score}} - {{$matchday->away_score}}
                </div>
                <div class="col-lg-4 col-md-4 text-right ">
                    {{$matchday->away_team}}
                </div>
            </div>
        </li>
    @empty
        
    @endforelse
    <div class="mt-3">
    <h4>Dosedanje tekme</h4>
    <hr>
    </div>
    @forelse ($data['matchdays'] as $matchday)
        <li class="list-group-item mt-3 rounded-top active-prediction" id={{$matchday['id']}} >
            <span>Tekmovalni dan: <b>{{date('j F, Y', strtotime($matchday['date']))}}</b>. Stopnja tekmovanja: <b>{{$matchday['stage']}}</b>
                <i class="fas fa-chevron-down fa-chevron-predictions" style="font-size:25px; float:right"></i>
            </span>
        </li>
            @if (($matchday->home_team_id == $data['id'] && $matchday->home_score > $matchday->away_score) || ($matchday->away_team_id == $data['id'] && $matchday->home_score < $matchday->away_score))
                <li class="list-group-item" id={{$matchday['matchday_id']}} style="background:#ccffc9">
            @elseif ($matchday->home_score == $matchday->away_score)
                <li class="list-group-item" id={{$matchday['matchday_id']}} style="background:#faffc6">
            @else
                <li class="list-group-item" id={{$matchday['matchday_id']}} style="background:#ffbaba">
            @endif
                <div class="row">
                    <div class="col-lg-4 col-md-4">
                        {{$matchday->home_team}} 
                    </div>
                    <div class="col-lg-4 col-md-4 text-center">
                    {{$matchday->home_score}} - {{$matchday->away_score}}
                    </div>
                    <div class="col-lg-4 col-md-4 text-right ">
                        {{$matchday->away_team}}
                    </div>
                </div>
            </li>
    @empty 
        <div class="alert alert-info active-predictions" >
            <span>Ekipa še ni igrala nobene tekme.</span>
        </div>
    @endforelse
@endsection
