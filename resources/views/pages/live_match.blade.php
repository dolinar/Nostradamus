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
    <div class="classic-tabs my-2 mx-4">
        <ul class="nav tabs-cyan" id="myClassicTabShadow" role="tablist">
            <li class="nav-item">
                <a class="nav-link  waves-light active show" id="profile-tab-classic-shadow" data-toggle="tab" href="#profile-classic-shadow"
                role="tab" aria-controls="profile-classic-shadow" aria-selected="true">Klepetalnica</a>
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
            <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium,
                totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta
                sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia
                consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui
                dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora
                incidunt ut labore et dolore magnam aliquam quaerat voluptatem.</p>
            </div>
            <div class="tab-pane fade" id="follow-classic-shadow" role="tabpanel" aria-labelledby="follow-tab-classic-shadow">
            <p>Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut
                aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse
                quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur?</p>
            </div>
            <div class="tab-pane fade" id="contact-classic-shadow" role="tabpanel" aria-labelledby="contact-tab-classic-shadow">
                @foreach ($data['matchEvents'] as $event)
                    <div class="row border-bottom p-2"> 
                        <div class="col-md-4">
                            <span class="text-left">{{$event->time}}'</span>
                            @if ($event->home_away == 'h')
                                <span class="float-right">{{ucwords(strtolower($event->player))}}</span>
                            @endif
                        </div>
                        @if ($event->home_away == 'h')
                        <div class="col-md-4 px-4">
                        @else 
                        <div class="col-md-4 px-4 text-right">
                        @endif
                            @if ($event->event == 'YELLOW_CARD')
                                <img style="height:1em" src="/helper_images/yellow_card.png">
                            @elseif ($event->event == 'RED_CARD')
                                <img style="height:1em" src="/helper_images/red_card.png">
                            @elseif ($event->event == 'YELLOW_RED_CARD')
                                <img style="height:1em" src="/helper_images/yellow_red_card.png">
                            @elseif ($event->event == 'GOAL')
                                <img style="height:1em" src="/helper_images/goal.png">
                            @elseif ($event->event == 'GOAL_PENALTY')
                                <img style="height:1em" src="/helper_images/goal.png"> (11m)
                            @endif
                        </div>
                        <div class="col-md-4">
                            @if ($event->home_away == 'a')
                                <span>{{ucwords(strtolower($event->player))}}</span>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
