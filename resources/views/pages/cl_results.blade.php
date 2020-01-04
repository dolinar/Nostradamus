@extends('layouts.app')

@section('content')
    <h3>Rezultati</h3>
    <hr class="no-space">
    @if (count($data['results']) > 0)
        @foreach ($data['results'] as $matchday)
            <li class="list-group-item mt-3 rounded-top li-results"  id="{{$matchday['id']}}">
                <span>Tekmovalni dan: <b>{{date('j F, Y', strtotime($matchday['date']))}}</b>. Stopnja tekmovanja: <b>{{$matchday['stage']}}</b>
                    <i class="fas fa-chevron-down fa-chevron-results" style="font-size:25px; float:right"></i></span>
            </li>
            <div class="table-responsive" style="display:none;" id="tb-{{$matchday['id']}}">
                <table class="table table-hover">
                    <thead>
                        <tr>
                        <th scope="col">Čas pričetka</th>
                        <th scope="col">Domača ekipa</th>
                        <th scope="col">Gostujoča ekipa</th>
                        <th scope="col">Rezultat</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach ($matchday['fixtures'] as $result)
                        <tr>
                            <td>{{substr($result['time'], 0, 5)}}</td>
                            <td><img style="width:2em" src="{{$result['team_home']['logo_url']}}"> {{$result['team_home']['name']}}</td>
                            <td><img style="width:2em" src="{{$result['team_away']['logo_url']}}"> {{$result['team_away']['name']}}</td>
                            <td>{{$result['home_score']}} - {{$result['away_score']}}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        @endforeach
        
    @else
        <div class="alert alert-info" role="alert">
            Za to tekmovanje še ni rezultatov.
        </div>
    @endif
@endsection
