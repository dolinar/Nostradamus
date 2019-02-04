@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Potrdite vaš elektronski naslov') }}</div>

                <div class="card-body">
                    @if (session('resent'))
                        <div class="alert alert-success" role="alert">
                            {{ ('Na vaš elektronski naslov smo ponovno poslali mail do potrditvene povezave.') }}
                        </div>
                    @endif

                    {{ __('Pred nadaljevanjem prosimo preverite vaš poštni nabiralnik in kliknite na potrditveno povezavo.') }}
                    {{ __('Če maila niste prejeli') }}, <a href="{{ route('verification.resend') }}">{{ __('kliknite tukaj za ponovno pošiljanje') }}</a>.
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
