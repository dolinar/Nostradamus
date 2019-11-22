@extends('layouts.app')

@section('content')
    <!-- Card -->
    <div class="card testimonial-card">

        <!-- Background color -->
        <div class="card-up blue"></div>
        
        <!-- Avatar -->
        <div class="avatar mx-auto white">
            <img class="rounded-circle img-fluid" src="/storage/profile_images/{{$data['user'][0]['profile_image']}}">
        </div>
        
        <!-- Content -->
        <div class="card-body">
            <a class="activator waves-effect waves-light mr-4" href={{route('send_private', ['id' => $data['user'][0]['id']])}}><i class="fas fa-envelope"></i></a>
            <!-- Name -->
            <h4 class="card-title">{{$data['user'][0]['username']}}</h4>
            <hr>
            <div class="row">
                <div class="col-md-4 border-right py-2">
                    <span><b>Pridružen:</b><br> {{date("d-M-y, H:i", strtotime($data['user'][0]['user_created_at']))}}</span>
                    <br>
                    <span><b>Nazadnje viden:</b><br> {{date("d-M-y, H:i", strtotime($data['user'][0]['created_at']))}}</span>
                    <br>
                    <span><b>Skupaj točk:</b><br> {{(count($data['userData']) > 0) ? $data['userData'][0]['points_total'] : '-'}}</span>
                    <br>
                    <span><b>Mesto na lestvici:</b><br> {{(count($data['userData']) > 0) ? $data['userData'][0]['position'] : '-'}}</span>
                    <br>
                    <span><b>Točke zadnji tekmovalni dan:</b><br> {{(count($data['userData']) > 0) ? $data['userData'][0]['points_matchday'] : '-'}}</span>
                    <br>
                    <span><b>Končna napoved:</b><br> {{(count($data['overallPrediction']) > 0) ? $data['overallPrediction'][0]['name'] : '-'}}</span>
                </div>
                <div class="col-md-8">
                    <div class="predictions-dropdown previous-predictions-profile-dropdown">    
                        <button type="button" class="btn btn-primary btn-sm mt-1 w-100">Pretekle napovedi <i class="fas fa-chevron-down fa-chevron-previous-predictions-profile"></i></button>
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
                                <li class="list-group-item previous-prediction-item" id={{$matchday['id']}} style="display: none">
                                    <div class="row">
                                        <div class="col-lg-4 col-md-4 text-left">
                                            <img style="height:1.5rem" src="/{{$fixture->teamHome->logo_url}}"> {{$fixture->teamHome->name}} 
                                        </div>
                                        <div class="col-lg-4 col-md-4 text-center">
                                            <span><b>x - x</b></span>
                                        </div>
                                        <div class="col-lg-4 col-md-4 text-right">
                                            <img style="height:1.5rem" src="/{{$fixture->teamAway->logo_url}}"> {{$fixture->teamAway->name}} 
                                        </div>
                                    </div>
                                    <div class="text-center">
                                            Rezultat tekme: {{$fixture['home_score']}} - {{$fixture['away_score']}}
                                    </div>
                                </li>
                            @else
                                @if ($fixture->prediction[0]->points == 3)
                                    <li class="list-group-item rgba-green-light previous-prediction-item" id={{$matchday['id']}} style="display: none">
                                        <div class="row">
                                            <div class="col-lg-4 col-md-4 text-left">
                                                <img style="height:1.5rem" src="/{{$fixture->teamHome->logo_url}}"> {{$fixture->teamHome->name}} 
                                            </div>
                                            <div class="col-lg-4 col-md-4 text-center">
                                                <span><b>{{$fixture->prediction[0]->prediction_home}} - {{$fixture->prediction[0]->prediction_away}}</b></span>
                                            </div>
                                            <div class="col-lg-4 col-md-4 text-right">
                                                <img style="height:1.5rem" src="/{{$fixture->teamAway->logo_url}}"> {{$fixture->teamAway->name}} 
                                            </div>
                                        </div>
                                        <div class="text-center">
                                                Rezultat tekme: {{$fixture['home_score']}} - {{$fixture['away_score']}}
                                        </div>
                                    </li>
                                @elseif ($fixture->prediction[0]->points == 1)
                                    <li class="list-group-item rgba-yellow-light previous-prediction-item" id={{$matchday['id']}} style="display: none">
                                        <div class="row">
                                            <div class="col-lg-4 col-md-4 text-left">
                                                <img style="height:1.5rem" src="/{{$fixture->teamHome->logo_url}}"> {{$fixture->teamHome->name}} 
                                            </div>
                                            <div class="col-lg-4 col-md-4 text-center">
                                                <span><b>{{$fixture->prediction[0]->prediction_home}} - {{$fixture->prediction[0]->prediction_away}}</b></span>
                                            </div>
                                            <div class="col-lg-4 col-md-4 text-right">
                                                <img style="height:1.5rem" src="/{{$fixture->teamAway->logo_url}}"> {{$fixture->teamAway->name}} 
                                            </div>
                                        </div>
                                        <div class="text-center">
                                                Rezultat tekme: {{$fixture['home_score']}} - {{$fixture['away_score']}}
                                        </div>
                                    </li>
                                @else 
                                    <li class="list-group-item rgba-red-light previous-prediction-item" id={{$matchday['id']}} style="display: none">
                                        <div class="row">
                                            <div class="col-lg-4 col-md-4 text-left">
                                                <img style="height:1.5rem" src="/{{$fixture->teamHome->logo_url}}"> {{$fixture->teamHome->name}} 
                                            </div>
                                            <div class="col-lg-4 col-md-4 text-center">
                                                <span><b>{{$fixture->prediction[0]->prediction_home}} - {{$fixture->prediction[0]->prediction_away}}</b></span>
                                            </div>
                                            <div class="col-lg-4 col-md-4 text-right">
                                                <img style="height:1.5rem" src="/{{$fixture->teamAway->logo_url}}"> {{$fixture->teamAway->name}} 
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
        </div>
        
    </div>
@endsection
