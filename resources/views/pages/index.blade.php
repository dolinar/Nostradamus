@extends('layouts.app')

@section('content')
    <script>
        jQuery(document).ready(function() {
            jQuery("time.timeago").timeago();
        });
    </script>
    <div class="container">
        @auth
            @if ($data['overallPrediction'] && Config::get('nostradamus.competition-start') > date('Y-m-d H:i:s'))
                <div class="alert alert-warning">
                    <span>Niste še izbrali končnega zmagovalca. To lahko storite <a href="/overall_prediction">tukaj</a>.</span>
                </div>
            @endif
            @if ($data['difference'] > 0)
                <div class="alert alert-warning">
                    <span>Napovejte vse rezultate <a href="/predictions">tukaj</a>.</span>
                </div>
            @endif

            @if (count($data['invitations']) > 0)

                @foreach ($data['invitations'] as $invtitation)
                    <div class="alert alert-warning">
                        <span>Uporabnik <b>{{$invtitation->user_invitator}}</b> te je povabil v skupino <b>{{$invtitation->name}}.</b>
                            <a href="store_user_to_group{{'?id=' . $invtitation->id . '&confirmed=1'}}"><span class="fas fa-check"></span></a>  
                            <a href="store_user_to_group{{'?id=' . $invtitation->id . '&confirmed=0'}}"><span class="fas fa-times"></span></a>
                    </div>
                @endforeach

            @endif
        @endauth
        @if (count($data['fixtures']) > 0)
            <h5>Naslednji tekmovalni dan: {{ strftime('%e %B, %G', strtotime($data['fixtures']['date']))}}
            <a class="float-right text-primary" href="/cl_draw">Več</a></h5>
            <hr class="no-space">
            <div class="table-responsive" style="border-radius:5px">
            <table class="table table-sm table-hover">
                <thead class="table-active">
                    <tr>
                    <th scope="col">Čas pričetka</th>
                    <th scope="col">Domača ekipa</th>
                    <th scope="col">Gostujoča ekipa</th>
                    <th scope="col">Stopnja tekmovanja</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data['fixtures']['fixtures'] as $fixture)
                        @if ($fixture['status'] == 'NS')
                            <tr>
                                <td>{{substr($fixture['time'], 0, 5)}}</td>
                                <td>{{$fixture['team_home']['name']}}</td>
                                <td>{{$fixture['team_away']['name']}}</td>
                                <td>{{$data['fixtures']['stage']}}</td>
                            </tr>
                        @endif
                    @endforeach
                </tbody>
            </table>
            </div>
        @endif

        <br>
        <h5>Najboljših 5<a class="float-right text-primary" href="/table">Več</a></h5>
        <hr class="no-space">
        <div class="table-responsive" style="border-radius:5px">
            <table class="table table-sm table-hover">
                <thead class="table-active">
                    <tr>
                    <th>#</th>
                    <th scope="col">Tekmovalec</th>
                    <th scope="col">Točke</th>
                    </tr>
                </thead>
                <tbody>
                    @php $i=1; @endphp
                    @foreach ($data['topFive'] as $participant)
                        @if (auth()->user() && $participant['username'] == auth()->user()->username)
                            <tr style="background-color:#ccd4e2">
                        @else
                            <tr>       
                        @endif
                            <td >{{$i++}}.</td>
                            <td>{{$participant['username']}}</td>
                            @if ($participant['total_points'] != null)
                                <td>{{$participant['total_points']}}</td>
                            @else
                                <td>0</td>
                            @endif
                        </tr>
                    @endforeach
                    @if ($data['user'])
                        <tr style="background-color:#ccd4e2">
                            <td >{{$data['user']['position']}}.</td>
                            <td>{{$data['user'][0]['username']}}</td>
                            @if ($data['user'][0]['total_points'] != null)
                                <td>{{$data['user'][0]['total_points']}}</td>
                            @else
                                <td>0</td>
                            @endif
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>

        <br>
        <h5>Novice</h5>
        <hr class="no-space">
        @if (count($data['posts']) > 0)
            @foreach($data['posts'] as $post)
                <li class="list-group-item" style="border-radius:5px">
                    <div class="row">
                        <div class="col-lg-2 col-md-3 col-xs-4 text-right">
                            <time class="timeago small text-muted" datetime="{{date('c', $post->ts)}}"><small></small></time>
                        </div>
                        <div class="col-lg-8 col-md-9 col-xs-8">
                            <a target="_blank" rel="noopener noreferrer" data-toggle="tooltip" title="{{$post->summary}}" href="{{$post->link}}">
                                <b>{{$post->title}}</b>
                            </a>
                        </div>
                    </div>
                </li>
            @endforeach
        @endif
        <div class="row justify-content-center mt-2">
            <a href="/info" class="btn btn-info m-2 col-lg-2">Informacije</a>
            <a href="/instructions" class="btn btn-info m-2 col-lg-2">Navodila</a>
            <a href="/cl_results" class="btn btn-info m-2 col-lg-2">Rezultati</a>
        </div>  
        <div class="text-center">
            <hr>
            <p class="small text-muted">Nostradamus 2018/19</p>
        </div>
    </div>
@endsection
