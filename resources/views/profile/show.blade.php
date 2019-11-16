@extends('layouts.app')

@section('content')
    <!-- Card -->
    <div class="card testimonial-card mx-4">

        <!-- Background color -->
        <div class="card-up aqua-gradient"></div>
        
        <!-- Avatar -->
        <div class="avatar mx-auto white">
            <img class="rounded-circle img-fluid" src="../storage/profile_images/{{$data['user'][0]['profile_image']}}">
        </div>
        
        <!-- Content -->
        <div class="card-body">
            <a class="activator waves-effect waves-light mr-4" href={{route('send_private', ['id' => $data['user'][0]['id']])}}><i class="fas fa-envelope"></i></a>
            <!-- Name -->
            <h4 class="card-title">{{$data['user'][0]['username']}}</h4>
            <hr>
            <div class="row">
                <div class="col-6 col-md-12 col-xs-4">
                    <span><b>Pridružen:</b><br> {{date("d-M-y, H:i", strtotime($data['user'][0]['user_created_at']))}}</span>
                    <br>
                    <span><b>Nazadnje viden:</b><br> {{date("d-M-y, H:i", strtotime($data['user'][0]['created_at']))}}</span>
                    <br>
                    <span><b>Skupaj točk:</b><br> {{(count($data['userData']) > 0) ? $data['userData'][0]['points_total'] : '-'}}</span>
                    <br>
                    <span><b>Mesto na lestvici:</b><br> {{(count($data['userData']) > 0) ? $data['userData'][0]['position'] : '-'}}</span>
                    <br>
                    <span><b>Točke zadnji tekmovalni dan:</b><br> {{(count($data['userData']) > 0) ? $data['userData'][0]['points_matchday'] : '-'}}</span>
                    <br>
                    <span><b>Končna napoved:</b><br> {{(count($data['overallPrediction']) > 0) ? $data['overallPrediction'][0]['name'] : '-'}}</span>
                </div>
                <div class="">
                    hello
                </div>
            </div>
        </div>
        
    </div>
    <!-- Card -->
@endsection
