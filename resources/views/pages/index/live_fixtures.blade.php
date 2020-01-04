@if (count($data['liveFixtures']) > 0)
    <div class="row border px-1 pt-3 m-1">
        <div class="col">
            <div class="col-md-11"><h5 class='text-danger'>V živo</h5></div>
            {{-- <div class="row">
                <div class="col-md-1 mt-n2"><a class="btn btn-outline-primary btn-sm float-right mr-n2" href="/cl_draw">Več</a></div>
            </div> --}}
            <div class="table-responsive">
            <table class="table table-hover">
                {{-- <thead>
                    <tr>
                    <th scope="col">Čas</th>
                    <th scope="col">Domača ekipa</th>
                    <th scope="col">Rezultat</th>
                    <th scope="col">Gostujoča ekipa</th>
                    </tr>
                </thead> --}}
                <tbody>
                    @foreach ($data['liveFixtures'] as $fixture)
                        <tr>
                            <td class="text-danger font-weight-bold" style="width:12.5%">{{$fixture->minutes}} <span class="blink-text">'</span></td>
                            <td style="width:25%"><img class="team-image" src="{{$fixture->teamHome->logo_url}}"> {{$fixture->teamHome->name}}</td>
                            <td style="width:25%" class="text-center">{{$fixture['home_score']}} - {{$fixture['away_score']}}</td>
                            <td style="width:25%" class="text-right">{{$fixture->teamAway->name}} <img class="team-image" src="{{$fixture->teamAway->logo_url}}"></td>
                            <td style="width:12.5%"><a class="btn btn-outline-primary btn-sm float-right mr-n2" href="{{route('live_match', $fixture['id'])}}">Več</a></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            </div>
        </div>
    </div>
@endif