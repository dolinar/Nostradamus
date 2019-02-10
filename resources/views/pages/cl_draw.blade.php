@extends('layouts.app')

@section('content')
    <h3>Tekmovalni dnevi</h3>
    <hr>
    <div class="text-center">
        <img src="draw.png" class="img-fluid" alt="Responsive image">
    </div>
    <hr>
    @if (count($data['draw']) > 0)
        @foreach ($data['draw'] as $matchday)
            <li class="list-group-item mt-3 rounded-top li-results" id="{{$matchday['id']}}">
                <span>Tekmovalni dan: <b>{{date('j F, Y', strtotime($matchday['date']))}}</b>. Stopnja tekmovanja: <b>{{$matchday['stage']}}</b>.</span>
                <i class="fas fa-chevron-down fa-chevron-results"  style="font-size:25px; float:right"></i></span>
            </li>
            <div class="table-responsive" style="display:none;" id="tb-{{$matchday['id']}}">
                <table class="table table-hover">
                    <thead>
                        <tr>
                        <th scope="col">Čas pričetka</th>
                        <th scope="col">Domača ekipa</th>
                        <th scope="col">Gostujoča ekipa</th>
                        <th scope="col">Stopnja tekmovanja</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach ($matchday['fixtures'] as $result)
                        <tr>
                            <td>{{substr($result['time'], 0, 5)}}</td>
                            <td>{{$result['team_home']['name']}}</td>
                            <td>{{$result['team_away']['name']}}</td>
                            <td>{{$matchday['stage']}}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        @endforeach
        
    @else
        <div class="alert alert-info text-center" role="alert">
            <span>Trenutno ni na sporedu nobene tekme!</span>
        </div>
    @endif
@endsection
