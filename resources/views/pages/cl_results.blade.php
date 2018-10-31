@extends('layouts.app')

@section('content')
    <h3>Rezultati</h3>
    <hr class="no-space">
    @if (count($data['results']) > 0)
        @foreach ($data['results'] as $matchday)
            <p>Tekmovalni dan: <b>{{date('j F, Y', strtotime($matchday['date']))}}</b>. Stopnja tekmovanja: <b>{{$matchday['stage']}}</b></p>
            <div class="table-responsive">
            <table class="table table-sm table-striped">
                <thead class="table-info">
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
                        <td>{{$result['team_home']['name']}}</td>
                        <td>{{$result['team_away']['name']}}</td>
                        <td>{{$result['home_score']}} - {{$result['away_score']}}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            </div>
            <hr>
        @endforeach
        
    @else
        <div class="alert alert-info" role="alert">
            Za to tekmovanje še ni rezultatov.
        </div>
    @endif
@endsection
