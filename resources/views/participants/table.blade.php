@extends('layouts.app')

@section('content')
    <h3>Lestvica</h3>
    <hr>
    @if (count($data['participants']) > 0)
    <div class="table-responsive">
            <table class="table table-sm table-striped">
                <thead class="table-info">
                    <tr>
                    <th scope="col">Uporabniško ime</th>
                    <th scope="col">Ime in priimek</th>
                    <th scope="col">Točke</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data['participants'] as $participant)
                        <td>{{$participant->username}}</td>
                        <td>{{$participant->name}}</td>
                        <td>12</td>
                    @endforeach
                </tbody>
            </table>
            </div>

    @endif
    {{ $data['participants']->links() }}
@endsection
