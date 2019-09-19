@extends('layouts.app')

@section('content')
    <script>
        jQuery(document).ready(function() { //TODO: move this to .js file
            jQuery("time.timeago").timeago();
        });
    </script>
    <div class="container">
        <div class="row border px-3 pt-3">
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
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-md-6 col-margin">
                <div class="border p-3" style="height:100%">
                    <h5>Klepetalnica</h5>
                </div>
            </div>
            <div class="col-md-6">
                <div class="border p-3">
                    <div class="row">
                        <div class="col-10"><h5>Najboljših 5</h5></div>
                        <div class="col-2 mt-n2"><a class="float-right btn btn-outline-primary btn-sm" href="/table">Več</a></div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table table-hover">
                            <thead>
                                <tr>
                                <th scope="col" class="cell-align-right">#</th>
                                <th scope="col" class="pl-3">Tekmovalec</th>
                                <th scope="col" class="cell-align-right">Točke</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($data['topFive'] as $participant)
                                    @if (auth()->user() && $participant['username'] == auth()->user()->username)
                                        <tr style="background-color:#f2f2f2">
                                    @else
                                        <tr>       
                                    @endif
                                        <td class="cell-align-right">{{$participant['position']}}.</td>
                                        @if (Auth::id() == $participant['id']) 
                                            <td class="pl-3"><a href={{route('dashboard.index')}}>{{$participant['username']}}</a></td>
                                        @else
                                            <td class="pl-3"><a href={{route('user_profile.show', ['id' => $participant['id']])}}>{{$participant['username']}}</a></td>
                                        @endif
                                        <td class="cell-align-right">{{($participant['points_total']) == null ? 0 : $participant['points_total']}}</td>
                                    </tr>
                                @empty
                                    
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <br>
        <h5>Novice</h5>
        <hr class="no-space">
        @if (count($data['posts']) > 0)
            @foreach($data['posts'] as $post)
                <li class="list-group-item">
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
            <a href="/info" class="btn btn-outline-primary waves-effect m-2 col-lg-3">Informacije</a>
            <a href="/instructions" class="btn btn-outline-primary waves-effect col-lg-3">Navodila</a>
            <a href="/cl_results" class="btn btn-outline-primary waves-effect m-2 col-lg-3">Rezultati</a>
        </div>
        <div class="text-center">
            <hr>
            <p class="small text-muted">Nostradamus 2019/20</p>
        </div>
    </div>
@endsection
