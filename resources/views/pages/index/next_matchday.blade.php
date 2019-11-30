<div class="row border px-1 pt-3 m-1">
    <div class="col">
    @if (count($data['fixtures']) > 0)
        <div class="row">
            <div class="col-md-11"><h5>Naslednji tekmovalni dan: {{ strftime('%e %B, %G', strtotime($data['fixtures']['date']))}}</h5></div>
            <div class="col-md-1 mt-n2"><a class="btn btn-outline-primary btn-sm float-right mr-n2" href="/cl_draw">Več</a></div>
        </div>
        <div class="table-responsive">
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
                @foreach ($data['fixtures']['fixtures'] as $fixture)
                    @if ($fixture['status'] == 'NOT_STARTED')
                        <tr>
                            <td>{{substr(date('H:i', strtotime($fixture['time'] . ' UTC')), 0, 5)}}</td>
                            <td><img style="height:2em" src="{{$fixture['team_home']['logo_url']}}"> {{$fixture['team_home']['name']}}</td>
                            <td><img style="height:2em" src="{{$fixture['team_away']['logo_url']}}"> {{$fixture['team_away']['name']}}</td>
                            <td>{{$data['fixtures']['stage']}}</td>
                        </tr>
                    @endif
                @endforeach
            </tbody>
        </table>
        </div>
    @endif
    </div>
</div>