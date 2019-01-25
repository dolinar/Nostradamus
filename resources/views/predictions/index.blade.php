@extends('layouts.app')

@section('content')
    <h3>Napovedi</h3>
    <hr>
    @if (count($data['predictions']) > 0)
        @foreach ($data['predictions'] as $matchday)
            {{ Form::open(array('action' => 'PredictionsController@store', 'method' => 'POST')) }}
            <div class="card mb-3">
                <div class="card-header">
                    Napovedi za tekmovalni dan <b>{{ strftime('%e %B, %G', strtotime($matchday['date']))}}</b>. Stopnja tekmovanja: <b>{{$matchday['stage']}}</b>
                </div>
                <ul class="list-group list-group-flush">
                    @foreach ($matchday['fixtures'] as $fixture)
                        {{-- {{print_r(new DateTime(date('Y-m-d H:i:s', strtotime($matchday['date'] . ' ' . $fixture['time']))))}}
                        {{print_r((new DateTime(date('Y-m-d H:i:s')))->modify('+55 minutes'))}} --}}
                        @if ((new DateTime(date('Y-m-d H:i:s', strtotime($matchday['date'] . ' ' . $fixture['time']))))->modify('-5 minutes') > (new DateTime(date('Y-m-d H:i:s')))->modify('+1 hour'))
                            @if($fixture['prediction'] == NULL)
                                @include('predictions.form-active')
                            @else 
                                @include('predictions.form-disabled')
                            @endif
                        @else
                            @include('predictions.form-disabled')
                        @endif
                    @endforeach
                </ul>
                @if ((new DateTime(date('Y-m-d H:i:s', strtotime($matchday['date'] . ' ' . $fixture['time']))))->modify('-5 minutes') > (new DateTime(date('Y-m-d H:i:s')))->modify('+1 hour'))
                    <div class="card-footer text-center p-2">
                        {{ Form::submit('Shrani', array('class' => 'btn btn-sm btn-primary')) }}
                    </div>
                @else
                    <div class="card-footer text-center p-2">
                        {{ Form::submit('Shrani', array('class' => 'btn btn-sm btn-primary disable', 'disabled' => 'disabled')) }}
                    </div>
                @endif
            </div>
            {{ Form::close() }}
        @endforeach
    @else
        <div class="alert alert-info text-center">
            <span>Trenutno ni na sporedu nobene tekme.</span>
        </div>
    @endif  
@endsection
