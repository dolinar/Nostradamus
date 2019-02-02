@extends('layouts.app')

@section('content')
    <div class="row px-2">
        <div class="col-lg-4 col-md-4 col-sm-12" >
            <div class="row text-center profile-border py-2">
                <div class="col-6 col-md-12 col-xs-8" style="display:block">
                    <img src="storage/profile_images/{{$data['user'][0]['profile_image']}}" width="100%">
                </div>

                <div class="col-6 col-md-12 col-xs-4">
                    <h3>{{$data['user'][0]['username']}}
                        <a href={{route('dashboard.edit', ['id' => $data['user'][0]['id_user']])}}><i class="fas fa-edit"></i> Uredi profil</a>
                    </h3>
                    <span><b>Skupaj točk:</b><br> {{$data['userData'][0]['points_total']}}</span>
                    <br>
                    <span><b>Mesto na lestvici:</b><br> {{$data['userData'][0]['position']}}</span>
                </div>
            </div>
        </div>
        
        <div class="col-lg-8 col-md-8 pl-4">
            <h5 class="mt-2">Napovedi <a class="ml-3" href={{route('predictions.index')}}>Več</a></h5>
            <hr>
            @if ($data['difference'] > 0)
                <div class="alert alert-danger">
                    <span>Imate nenapovedane tekme!</span>
                </div>
            @else  
                <div class="alert alert-info active-predictions">
                    <span>Vaše napovedi za prihajajoče tekme so shranjene.</span>
                </div>
            @endif

            <br>
            
            <div class="group-dropdown">    
                <h5 class="mt-2">Skupine<a class="ml-3" href={{route('groups.index')}}>Več</a></h5>
            </div>
            <hr>
            @forelse ($data['invitations'] as $invtitation)
                <div class="alert alert-warning">
                    <span>Uporabnik <b>{{$invtitation->user_invitator}}</b> te je povabil v skupino <b>{{$invtitation->name}}.</b>
                        <a href="#" name={{$invtitation->id}} value="1" id="store-accept"><span class="fas fa-check"></span></a>  
                        <a href="#" name={{$invtitation->id}} value="0" id="store-reject"><span class="fas fa-times"></span></a>  
                    </span>
                </div>
            @empty
                <div class="alert alert-info group-invitations-dropdown">
                    <span>Trenutno nimate nobenega novega povabila v skupino.</span>
                </div>
            @endforelse

            <br>
            
            <div class="message-dropdown">    
                <h5 class="mt-2">Zasebna sporočila<a class="ml-3" href={{route('private_message.index')}}>Več</a></h5></h5>
            </div>
            <hr>
            @if (count($data['receivedMessages']) > 0)
                <div class="alert alert-info group-invitations-dropdown">
                    <span>Imate nova zasebna sporočila.</span>
                </div>
            @else
                <div class="alert alert-info group-invitations-dropdown">
                    <span>Nimate novih zasebnih sporočil.</span>
                </div>
            @endif

        </div>

    </div>
@endsection

