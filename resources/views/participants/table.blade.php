@foreach ($data['participants'] as $participant)

    @if (auth()->user() && $participant['username'] === auth()->user()->username)
        <tr style="background-color:#f2f2f2">
    @else
        <tr>
    @endif
            <td class="cell-align-right">{{($participant['position']) == null ? 0 : ($participant['position'])}}.</td>  
            @if (Auth::id() == $participant['id']) 
                <td class="pl-3"><a href={{route('dashboard')}}>{{$participant['username']}}</a></td>
            @else
                <td class="pl-3"><a href={{route('user_profile.show', ['id' => $participant['id']])}}>{{$participant['username']}}</a></td>
            @endif
            <td class="cell-align-right">{{($participant['points_total']) == null ? 0 : ($participant['points_total'])}}</td>
            <td class="cell-align-right">{{($participant['points_matchday']) == null ? 0 : ($participant['points_matchday'])}}</td>
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
    <tr style="background-color:#f2f2f2">
        <td class="cell-align-right">{{$data['user'][0]['position']}}.</td>
        <td class="pl-3"><a href={{route('user_profile.show', ['id' => $participant['id']])}}>{{$data['user'][0]['username']}}</a></td>
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
 