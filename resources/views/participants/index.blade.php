@extends('layouts.app')

@section('content')
    <h3>Lestvica</h3>
    <hr>
    @if ($data['participants'])
        <div class="mb-3">
            <input type="search" id="user-search" value="" class="form-control text-center" placeholder="Išči uporabnike">
        </div>
        <div class="table-responsive mb-2" style="border-radius:5px">
            <table class="table table-hover">
                <thead>
                    <tr>
                    <th scope="col" class="cell-align-right">#</th>
                    <th scope="col" class="pl-3">Tekmovalec</th>
                    <th scope="col" class="cell-align-right">Skupaj točk</th>
                    <th scope="col" class="cell-align-right">Zadnji tekmovalni dan</th>
                    <th scope="col" class="cell-align-right">Napredovanje</th>
                    </tr>
                </thead>
                <tbody id="tbody-participants">
                    @include('participants.table')
                </tbody>
            </table>
        </div>
        <div id="pagination">
            {{ $data['participants']->links() }}
        </div>
    @endif
@endsection
