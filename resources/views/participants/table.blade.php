@extends('layouts.app')

@section('content')
    <h3>Lestvica</h3>
    <hr>
    @if (count($data['participants']) > 0)
    <div class="table-responsive">
            <table class="table table-sm table-striped">
                <thead class="table-info">
                    <tr>
                    <th scope="col">Tekmovalec</th>
                    <th scope="col">Točke skupaj</th>
                    <th scope="col">Točke zadnji tekmovalni dan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data['participants'] as $participant)
                    <tr>
                        <td>{{$participant['username']}}</td>
                        @if ($participant['total_points'] != null)
                            <td>{{$participant['total_points']}}</td>
                        @else
                            <td>0</td>
                        @endif 
                        <td>1</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            </div>

    @endif
    {{ $data['participants']->links() }}
@endsection
