@php
$yellowCards = preg_split('~:~', $data['matchStats']['yellow_cards']);
$yellowCards[2] = 'Rumeni kartoni';

$possesion = preg_split('~:~', $data['matchStats']['possesion']);
$possesion[2] = 'Posest žoge (%)';

$onTarget = preg_split('~:~', $data['matchStats']['shots_on_target']);
$onTarget[2] = 'Streli v okvir';

$offTarget = preg_split('~:~', $data['matchStats']['shots_off_target']);
$offTarget[2] = 'Streli zunaj okvirja';

$corners = preg_split('~:~', $data['matchStats']['corners']);
$corners[2] = 'Koti';

$fauls = preg_split('~:~', $data['matchStats']['fauls']);
$fauls[2] = 'Prekrški';

$offsides = preg_split('~:~', $data['matchStats']['offsides']);
$offsides[2] = 'Prepovedani položaji';

$statData = [$yellowCards, $possesion, $onTarget, $offTarget, $corners, $fauls, $offsides];
@endphp

<div class="tab-pane fade" id="follow-classic-shadow" role="tabpanel" aria-labelledby="follow-tab-classic-shadow">
@foreach ($statData as $item)
    <div class="row"><div class="col-12 text-center">{{$item[2]}}</div></div>
    <div class="row">
        <div class="col-6 border px-0 rounded-pill" style="max-height:1.5em">
            <span class="pl-2">{{$item[0]}}</span>
            <div class="float-right rounded-pill {{$item[0] > $item[1] ? 'primary-color' : 'blue lighten-4'}}" style="width:{{($item[0] / ($item[0] + $item[1]))*100}}%; height: 100%" ></div>
        </div>
        <div class="col-6 border px-0 rounded-pill" style="max-height:1.5em">
            <span class="float-right pr-2">{{$item[1]}}</span>
            <div class="rounded-pill {{$item[0] < $item[1] ? 'primary-color' : 'blue lighten-4'}}" style="width:{{($item[1] / ($item[0] + $item[1]))*100}}%;height: 100%"></div>
        </div>
    </div>
    <hr>
@endforeach
</div>
