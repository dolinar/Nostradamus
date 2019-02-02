@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-4 col-md-4 col-sm-12" >
            <div class="row text-center profile-border py-2">
                <div class="col-6 col-md-12 col-xs-8" style="display:block">
                    <img src="../storage/profile_images/{{$data['user'][0]['profile_image']}}" width="100%">
                </div>
                <div class="col-6 col-md-12 col-xs-4">
                    <h3>{{$data['user'][0]['username']}}

                        <a href={{route('send_private', ['id' => $data['user'][0]['id']])}}><i class="fas fa-envelope"></i></a>
                    </h3>
                    <span><b>Pridružen:</b><br> {{date("d-M-y, H:i", strtotime($data['user'][0]['user_created_at']))}}</span>
                    <br>
                    <span><b>Nazadnje viden:</b><br> {{date("d-M-y, H:i", strtotime($data['user'][0]['created_at']))}}</span>
                    <br>
                    <span><b>Skupaj točk:</b><br> {{$data['userData'][0]['points_total']}}</span>
                    <br>
                    <span><b>Mesto na lestvici:</b><br> {{$data['userData'][0]['position']}}</span>
                    <br>
                    <span><b>Točke zadnji tekmovalni dan:</b><br> {{$data['userData'][0]['points_matchday']}}</span>
                </div>
            </div>
        </div>
        
        <div class="col-lg-8 col-md-8 pl-4">
            <div class="predictions-dropdown active-predictions-profile-dropdown">
                <h5 class="mt-2">Aktivne napovedi <i class="fas fa-chevron-down fa-chevron-active-predictions"></i></h5>
            </div>
            <hr>
            @forelse ($data['activePredictions'] as $matchday)
                <li class="list-group-item mt-1 rounded-top active-prediction" id={{$matchday['id']}} style="display:none">
                    <span>Tekmovalni dan: <b>{{date('j F, Y', strtotime($matchday['date']))}}</b>. Stopnja tekmovanja: <b>{{$matchday['stage']}}</b>
                        <i class="fas fa-chevron-down fa-chevron-predictions" style="font-size:25px; float:right"></i>
                    </span>
                </li>
                @foreach ($matchday['fixtures'] as $fixture)
                    <li class="list-group-item" id={{$matchday['id']}} style="display:none">
                        <div class="row">
                            <div class="col-lg-4 col-md-4">
                                {{$fixture->teamHome->name}} 
                            </div>
                            <div class="col-lg-4 col-md-4 text-center">
                                {{(count($fixture->prediction) == 0) ? 'Ni napovedi' : $fixture->prediction[0]->prediction_home . ' - ' . $fixture->prediction[0]->prediction_away}}
                            </div>
                            <div class="col-lg-4 col-md-4 text-right ">
                                {{$fixture->teamAway->name}}
                            </div>
                        </div>
                    </li>
                @endforeach

            @empty 
                <div class="alert alert-info active-predictions" style="display:none">
                    <span>Uporabnik nima nobene aktivne napovedi.</span>
                </div>
            @endforelse

            <br>

            <div class="predictions-dropdown previous-predictions-profile-dropdown">    
                <h5 class="mt-2">Pretekle napovedi <i class="fas fa-chevron-down fa-chevron-previous-predictions-profile"></i></h5>
            </div>
            <hr>
            @forelse ($data['predictions'] as $matchday)
                <li class="list-group-item mt-1 rounded-top previous-prediction" id={{$matchday['id']}} style="display:none">
                    <span>Tekmovalni dan: <b>{{date('j F, Y', strtotime($matchday['date']))}}</b>. Stopnja tekmovanja: <b>{{$matchday['stage']}}</b>
                        <i class="fas fa-chevron-down fa-chevron-results" style="font-size:25px; float:right"></i>
                    </span>
                </li>
                @foreach ($matchday['fixtures'] as $fixture)
                    @if (count($fixture->prediction) == 0)
                        <li class="list-group-item" id={{$matchday['id']}} style="display: none">
                            <div class="row">
                                <div class="col-lg-4 col-md-4">
                                    {{$fixture->teamHome->name}} 
                                </div>
                                <div class="col-lg-4 col-md-4 text-center">
                                    <span><b>x - x</b></span>
                                </div>
                                <div class="col-lg-4 col-md-4 text-right">
                                    {{$fixture->teamAway->name}} 
                                </div>
                            </div>
                            <div class="text-center">
                                    Rezultat tekme: {{$fixture['home_score']}} - {{$fixture['away_score']}}
                            </div>
                        </li>
                    @else
                        @if ($fixture->prediction[0]->points == 3)
                            <li class="list-group-item" id={{$matchday['id']}} style="background:#adff82; display: none">
                                <div class="row">
                                    <div class="col-lg-4 col-md-4">
                                        {{$fixture->teamHome->name}} 
                                    </div>
                                    <div class="col-lg-4 col-md-4 text-center">
                                        <span><b>{{$fixture->prediction[0]->prediction_home}} - {{$fixture->prediction[0]->prediction_away}}</b></span>
                                    </div>
                                    <div class="col-lg-4 col-md-4 text-right">
                                        {{$fixture->teamAway->name}} 
                                    </div>
                                </div>
                                <div class="text-center">
                                        Rezultat tekme: {{$fixture['home_score']}} - {{$fixture['away_score']}}
                                </div>
                            </li>
                        @elseif ($fixture->prediction[0]->points == 1)
                            <li class="list-group-item" id={{$matchday['id']}} style="background:#fdff93; display: none">
                                <div class="row">
                                    <div class="col-lg-4 col-md-4">
                                        {{$fixture->teamHome->name}} 
                                    </div>
                                    <div class="col-lg-4 col-md-4 text-center">
                                        <span><b>{{$fixture->prediction[0]->prediction_home}} - {{$fixture->prediction[0]->prediction_away}}</b></span>
                                    </div>
                                    <div class="col-lg-4 col-md-4 text-right">
                                        {{$fixture->teamAway->name}} 
                                    </div>
                                </div>
                                <div class="text-center">
                                        Rezultat tekme: {{$fixture['home_score']}} - {{$fixture['away_score']}}
                                </div>
                            </li>
                        @else 
                            <li class="list-group-item" id={{$matchday['id']}} style="background:#ff897a; display: none">
                                <div class="row">
                                    <div class="col-lg-4 col-md-4">
                                        {{$fixture->teamHome->name}} 
                                    </div>
                                    <div class="col-lg-4 col-md-4 text-center">
                                        <span><b>{{$fixture->prediction[0]->prediction_home}} - {{$fixture->prediction[0]->prediction_away}}</b></span>
                                    </div>
                                    <div class="col-lg-4 col-md-4 text-right">
                                        {{$fixture->teamAway->name}} 
                                    </div>
                                </div>
                                <div class="text-center">
                                        Rezultat tekme: {{$fixture['home_score']}} - {{$fixture['away_score']}}
                                </div>
                            </li>
                        @endif
                    @endif
                @endforeach
            @empty
                <div class="alert alert-info old-predictions" style="display:none">
                    <span>Uporabnik nima nobene pretekle napovedi.</span>
                </div> 
            @endforelse
        </div>

    </div>
@endsection
