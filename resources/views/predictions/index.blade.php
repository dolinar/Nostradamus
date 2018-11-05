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
                        @if ($matchday['date'] . ' ' . $fixture['time'] < (new DateTime(date('Y-m-d h:i:s')))->modify('+5 minutes'))
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
                <div class="card-footer text-center p-2">
                    {{ Form::submit('Shrani', array('class' => 'btn btn-sm btn-primary')) }}
                </div>
            </div>
            {{ Form::close() }}
        @endforeach
    @endif  
@endsection
