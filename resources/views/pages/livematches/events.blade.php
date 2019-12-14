<div class="tab-pane fade" id="contact-classic-shadow" role="tabpanel" aria-labelledby="contact-tab-classic-shadow">
    @foreach ($data['matchEvents'] as $event)
        <div class="row border-bottom p-2"> 
            <div class="col-4">
                <span class="text-left">{{$event->time}}'</span>
                @if ($event->home_away == 'h')
                    <span class="float-right">{{ucwords(strtolower($event->player))}}</span>
                @endif
            </div>
            @if ($event->home_away == 'h')
            <div class="col-4">
            @else 
            <div class="col-4 text-right">
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
            <div class="col-4">
                @if ($event->home_away == 'a')
                    <span>{{ucwords(strtolower($event->player))}}</span>
                @endif
            </div>
        </div>
    @endforeach
    </div>
</div>