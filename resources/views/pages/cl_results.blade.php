@extends('layouts.app')

@section('content')
    <h3>Rezultati</h3>
    <hr class="no-space">
    @if (count($data['matchdays']) > 0)
        @foreach ($data['matchdays'] as $matchday)
            <p>Tekmovalni dan: <b>{{date('j F, Y', strtotime($matchday->date))}}</b>. Stopnja tekmovanja: <b>{{$matchday->stage}}</b></p>
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
                @foreach ($data['results'] as $result)
                    @if ($result->id_matchday == $matchday->id)
                        <tr>
                            <td>{{substr($result->time, 0, 5)}}</td>
                            <td>{{$result->home_team}}</td>
                            <td>{{$result->away_team}}</td>
                            <td>{{$result->home_score}} - {{$result->away_score}}</td>
                        </tr>
                    @endif
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
