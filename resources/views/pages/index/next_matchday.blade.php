@if (count($data['fixtures']) > 0 && count($data['liveFixtures']) == 0)
<div class="row border px-1 pt-3 m-1">
    <div class="col">
        <div class="row">
            <div class="col-md-11"><h5>Naslednji tekmovalni dan: {{ strftime('%e %B, %G', strtotime($data['fixtures']['date']))}}</h5></div>
            <div class="col-md-1 mt-n2"><a class="btn btn-outline-primary btn-sm float-right mr-n2" href="/cl_draw">Več</a></div>
        </div>
        <div class="table-responsive">
        <table class="table table-hover">
            <thead>
                <tr>
                @if (Auth::user() && Auth::user()->email_verified_at != null)
                <th scope="col">#</th>
                @endif
                <th scope="col">Čas pričetka</th>
                <th scope="col">Domača ekipa</th>
                <th scope="col">Gostujoča ekipa</th>
                <th scope="col">Stopnja tekmovanja</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data['fixtures']['fixtures'] as $fixture)
                    @if ($fixture['status'] == 'NOT_STARTED')
                        <tr>
                            {{-- /* za dodat ce ze ima napoved */ --}}
                            @if (Auth::user() && Auth::user()->email_verified_at != null) 
                            <td><a class="btn btn-primary btn-sm my-0 p-1" id="btn-{{$fixture['id']}}" onclick="$('#{{$fixture['id']}}').modal('show');">Napoved</a></td>
                            @endif
                            <td>{{substr(date('H:i', strtotime($fixture['time'] . ' UTC')), 0, 5)}}</td>
                            <td><img class="team-image" src="{{$fixture['team_home']['logo_url']}}"> {{$fixture['team_home']['name']}}</td>
                            <td><img class="team-image" src="{{$fixture['team_away']['logo_url']}}"> {{$fixture['team_away']['name']}}</td>
                            <td>{{$data['fixtures']['stage']}}</td>
                        </tr>
                        @include('pages.index.modal')
                    @endif

                @endforeach
            </tbody>
        </table>
        </div>
    </div>
</div>

@endif