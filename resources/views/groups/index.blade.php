@extends('layouts.app')

@section('content')
    <h3>Skupine</h3>
    <hr>
    @if (count($data['groups']) > 0)
        @foreach($data['groups'] as $group)
        <li class="list-group-item" style="border-radius:5px;">
            <div class="row">
                <div class="col-lg-3 col-md-3 col-xs-3 text-right">
                    Ekipa: <a href="{{route('groups.show', $group->id)}}"><b>{{$group->name}}</b></a>
                </div>
                <div class="col-lg-3 col-md-3 col-xs-3 text-right">
                    # članov: <b>{{$data['info'][$group->id][0]}}</b>
                </div>
                <div class="col-lg-3 col-md-3 col-xs-3 text-right">
                    Lasntik: <b>{{$data['info'][$group->id][1]}}</b>
                </div>
                <div class="col-lg-3 col-md-3 col-xs-3 text-right">
                    <button type="button" id="{{$group->id}}" class="btn btn-info btn-sm btn-click">Top 5 
                            <i class="fas fa-chevron-down"></i>
                    </button>
                </div>
            </div>
            <div class="row" style="display: none; margin-top:10px" id="div-{{$group->id}}">
                <div class="table-responsive" style="border-radius:5px">
                    <table class="table table-sm table-hover">
                        <thead class="table-active">
                            <tr>
                                <th scope="col" class="cell-align-right">#</th>
                                <th scope="col" class="pl-3">Uporabniško ime</th>
                                <th scope="col" class="cell-align-right">Točke</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $i=1; @endphp
                            @foreach ($data['info'][$group->id][2] as $user)
                                @if (auth()->user() && $user['username'] == auth()->user()->username)
                                    <tr style="background-color:#b7d3ff">
                                @else
                                    <tr>       
                                @endif
                                    <td class="cell-align-right">{{$i++}}.</td>
                                    <td class="pl-3">{{$user['username']}}</td>
                                    <td class="cell-align-right">{{($user['points_total'] == null) ? 0 : $user['points_total']}}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </li>
        @endforeach
    @else
        <div class="alert alert-info" role="alert">
            Trenutno niste član nobene skupine.
        </div>
    @endif
    <br>
    <button class="btn btn-info btn-sm" id="show-group-form">Ustvari novo skupino</button>
    <br><br>

    {{ Form::open(['action' => 'GroupsController@store', 'method' => 'POST', 'style' => 'display:none', 'id' => 'group-store']) }}
    <div class="form-group">
        {{Form::label('name_label', 'Ime skupine: ')}}
        {{Form::text('group_name', null, ['class' => 'form-control']) }}
    </div>
    {{Form::submit('Shrani', ['class' => 'btn btn-primary btn-sm'])}}
    {{ Form::close() }}
@endsection