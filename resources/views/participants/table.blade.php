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
                    <th scope="col">Ime in priimek</th>
                    <th scope="col">Točke</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data['participants'] as $participant)
                    <tr>
                        <td>{{$participant['username']}}</td>
                        <td>{{$participant['name']}}</td>
                        @if ($participant['total_points'] != null)
                            <td>{{$participant['total_points']}}</td>
                        @else
                            <td>0</td>
                        @endif 
                    </tr>
                    @endforeach
                </tbody>
            </table>
            </div>

    @endif
    {{ $data['participants']->links() }}
@endsection
