@extends('layouts.app')

@section('content')
    <h3>Lestvica</h3>
    <hr>
    @if ($data['participants'])
        <div class="row" style="margin-bottom:10px">
            <div class="col-lg-4 col-lg-offset-4">
                <input type="search" id="user-search" value="" class="form-control" placeholder="Išči uporabnike">
            </div>
        </div>
        <div class="table-responsive" style="border-radius:5px">
            <table class="table table-sm table-hover">
                <thead class="table-active">
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
