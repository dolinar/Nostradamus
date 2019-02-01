@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-4 col-md-4 col-sm-12" >
            <div class="row text-center profile-border">
                <div class="col-6 col-md-12 col-xs-8" style="display:block">
                    <img src="/user_default.png" width="100%">
                </div>

                <div class="col-6 col-md-12 col-xs-4 mt-3">
                    <h3>{{$data['user'][0]['username']}}
                        @if (Auth::id() != $data['user'][0]['id_user'])
                            <i class="fas fa-envelope"></i>
                        @else
                            <i class="fas fa-edit"></i>
                        @endif
                    </h3>

                    <span><b>Nazadnje viden:</b><br> {{date("d-M-y, H:i", strtotime($data['user'][0]['created_at']))}}</span>
                    <br>
                    <span><b>Skupaj točk:</b><br> {{$data['userData'][0]['points_total']}}</span>
                    <br>
                    <span><b>Mesto na lestvici:</b><br> {{$data['userData'][0]['position']}}</span>
                </div>
            </div>
        </div>
        
        <div class="col-lg-8 col-md-8 pl-4">
            <div class="predictions-dropdown active-predictions-dropdown">
                <h5 class="mt-2">Aktivne napovedi <i class="fas fa-chevron-down fa-chevron-active-predictions"></i></h5>
            </div>
            <hr>
            @forelse ($data['activePredictions'] as $prediction)
                <li class="list-group-item active-predictions mb-1" style="display: none">
                    <div class="row">
                        <div class="col-lg-5 col-md-4">
                            {{$prediction['home_team']}} 
                        </div>
                        <div class="col-lg-2 col-md-4 text-center">
                            <b>{{$prediction['prediction_home']}} - {{$prediction['prediction_away']}}</b> 
                        </div>
                        <div class="col-lg-5 col-md-4 text-right ">
                            {{$prediction['away_team']}}
                        </div>
                    </div>
                </li>
            @empty  
                <div class="alert alert-info active-predictions" style="display:none">
                    <span>Uporabnik nima nobene aktivne napovedi.</span>
                </div>
            @endforelse

            <br>

            <div class="predictions-dropdown old-predictions-dropdown">    
                <h5 class="mt-2">Pretekle napovedi <i class="fas fa-chevron-down fa-chevron-old-predictions"></i></h5>
            </div>
            <hr>
            @forelse ($data['predictions'] as $prediction)
                @if ($prediction['points'] == 3)
                    <li class="list-group-item old-predictions mb-1" style="background:#adff82; display: none">
                        <div class="row">
                            <div class="col-lg-5 col-md-4">
                                {{$prediction['home_team']}} 
                            </div>
                            <div class="col-lg-2 col-md-4 text-center">
                                <b>{{$prediction['prediction_home']}} - {{$prediction['prediction_away']}}</b>
                            </div>
                            <div class="col-lg-5 col-md-4 text-right">
                                {{$prediction['away_team']}}
                            </div>
                        </div>
                        <div class="text-center">
                            Rezultat tekme: {{$prediction['home_score']}} - {{$prediction['away_score']}} 
                        </div>
                    </li>
                @elseif ($prediction['points'] == 1)
                    <li class="list-group-item old-predictions mb-1" style="background:#fdff93; display: none">
                        <div class="row">
                            <div class="col-lg-5 col-md-4">
                                {{$prediction['home_team']}} 
                            </div>
                            <div class="col-lg-2 col-md-4 text-center">
                                    <b>{{$prediction['prediction_home']}} - {{$prediction['prediction_away']}}</b>
                            </div>
                            <div class="col-lg-5 col-md-4 text-right">
                                {{$prediction['away_team']}}
                            </div>
                        </div>
                        <div class="text-center">
                                Rezultat tekme: {{$prediction['home_score']}} - {{$prediction['away_score']}}
                        </div>
                    </li>
                @else
                    <li class="list-group-item old-predictions  mb-1" style="background:#ff897a; display: none">
                        <div class="row">
                            <div class="col-lg-5 col-md-4">
                                {{$prediction['home_team']}} 
                            </div>
                            <div  class="col-lg-2 col-md-4 text-center">
                                <b>{{$prediction['prediction_home']}} - {{$prediction['prediction_away']}}</b> 
                            </div>
                            <div class="col-lg-5 col-md-4 text-right">
                                {{$prediction['away_team']}}
                            </div>
                        </div>
                        <div class="text-center">
                                Rezultat tekme: {{$prediction['home_score']}} - {{$prediction['away_score']}}
                        </div>
                    </li>
                @endif
            @empty
                <div class="alert alert-info old-predictions" style="display:none">
                    <span>Uporabnik nima nobene pretekle napovedi.</span>
                </div> 
            @endforelse
        </div>

    </div>
@endsection
