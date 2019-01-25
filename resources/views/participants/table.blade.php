@foreach ($data['participants'] as $key => $participant)
    @if (auth()->user() && $participant['username'] === auth()->user()->username)
        <tr style="background-color:#b7d3ff">
    @else
        <tr>
    @endif
            <td>{{$data['participants']->firstItem() + $key}}</td>  
            <td>{{$participant['username']}}</td>
            @if ($participant['total_points'] != null)
                <td>{{$participant['total_points']}}</td>
            @else
                <td>0</td>
            @endif 
            <td>{{$data['lastWeek'][$participant['username']]}}</td>
        </tr>
@endforeach
@if (auth()->user() && ($data['user']['position'] < $data['participants']->firstItem() || $data['user']['position'] >= $data['participants']->firstItem() + 10))
    <tr style="background-color:#b7d3ff">
        <td >{{$data['user']['position']}}.</td>
        <td>{{$data['user'][0]['username']}}</td>
        @if ($data['user'][0]['total_points'] != null)
            <td>{{$data['user'][0]['total_points']}}</td>
        @else
            <td>0</td>
        @endif
        <td>1</td>
    </tr>
@endif
 