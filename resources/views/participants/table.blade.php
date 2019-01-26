@foreach ($data['participants'] as $participant)

    @if (auth()->user() && $participant['username'] === auth()->user()->username)
        <tr style="background-color:#b7d3ff">
    @else
        <tr>
    @endif
            <td class="cell-align-right">{{$participant['position']}}.</td>  
            <td class="pl-3">{{$participant['username']}}</td>
            <td class="cell-align-right">{{($participant['points_total']) == null ? 0 : ($participant['points_total'])}}</td>
            <td class="cell-align-right">{{$participant['points_matchday']}}</td>
            @if ($participant['last_position'] - $participant['position'] > 0)
                <td class="cell-align-right" style="color:green">+{{$participant['last_position'] - $participant['position']}} <i class="fas fa-arrow-up"></i></td>
            @elseif ($participant['last_position'] - $participant['position'] == 0)  
                <td class="cell-align-right">{{$participant['last_position'] - $participant['position']}} <i class="fas fa-minus"></i></td>  
            @else 
                <td class="cell-align-right" style="color:red">{{$participant['last_position'] - $participant['position']}} <i class="fas fa-arrow-down"></i></td>
            @endif
        </tr>   
@endforeach

@if (auth()->user() && ($data['user'][0]['position'] < $data['participants']->firstItem() || $data['user'][0]['position'] >= $data['participants']->firstItem() + 10))
    <tr style="background-color:#b7d3ff">
        <td class="cell-align-right">{{$data['user'][0]['position']}}.</td>
        <td class="pl-3">{{$data['user'][0]['username']}}</td>
        <td class="cell-align-right">{{($data['user'][0]['points_total']) == null ? 0 : $data['user'][0]['points_total']}}</td>
        <td class="cell-align-right">{{$data['user'][0]['points_matchday']}}</td>
        @if ($data['user'][0]['last_position'] - $data['user'][0]['position'] > 0)
            <td class="cell-align-right" style="color:green">+{{$data['user'][0]['last_position'] - $data['user'][0]['position']}} <i class="fas fa-arrow-up"></i></td>
        @elseif ($data['user'][0]['last_position'] - $data['user'][0]['position'] == 0)  
            <td class="cell-align-right">{{$data['user'][0]['last_position'] - $data['user'][0]['position']}} <i class="fas fa-minus"></i></td>  
        @else 
            <td class="cell-align-right" style="color:red">{{$data['user'][0]['last_position'] - $data['user'][0]['position']}} <i class="fas fa-arrow-down"></i></td>
        @endif
    </tr>
@endif
 