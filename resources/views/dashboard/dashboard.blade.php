@extends('layouts.app')

@section('content')
    <!-- Card -->
    <div class="card testimonial-card">

        <!-- Background color -->
        <div class="card-up blue"></div>
        
        <!-- Avatar -->
        <div class="avatar mx-auto white">
            <img class="rounded-circle img-fluid" src="/storage/profile_images/{{$data['user'][0]['profile_image']}}">
        </div>
        
        <!-- Content -->
        <div class="card-body">
            <a class="activator waves-effect waves-light mr-4" href={{route('dashboard.edit', ['id' => $data['user'][0]['id_user']])}}><i class="fas fa-edit"></i> Uredi profil</a>
            <!-- Name -->
            <h4 class="card-title">{{$data['user'][0]['username']}}</h4>
            <hr>
            <div class="row">
                <div class="col-md-4 border-right py-2">
                    <span><b>Skupaj točk:</b><br> {{(count($data['userData']) > 0) ? $data['userData'][0]['points_total'] : '-'}}</span>
                    <br>
                    <span><b>Mesto na lestvici:</b><br> {{(count($data['userData']) > 0) ? $data['userData'][0]['position'] : '-'}}</span>
                    <br>
                    <span><b>Točke zadnji tekmovalni dan:</b><br> {{(count($data['userData']) > 0) ? $data['userData'][0]['points_matchday'] : '-'}}</span>
                    <br>
                    <span><b>Končna napoved:</b><br> {{(count($data['overallPrediction']) > 0) ? $data['overallPrediction'][0]['name'] : '-'}}</span>
                </div>
                <div class="col-md-8">
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
                    @if (count($data['overallPrediction']) == 0 && Config::get('nostradamus.competition-start') > date('Y-m-d H:i:s'))
                        <div class="alert alert-danger active-predictions">
                            <span>Niste še napovedali končnega zmagovalca.<a class="ml-3" href={{route('overall_prediction.index')}}>Več</a></span>
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
                        <div class="alert alert-warning group-invitations-dropdown">
                            <span>Imate nova zasebna sporočila.</span>
                        </div>
                    @else
                        <div class="alert alert-info group-invitations-dropdown">
                            <span>Nimate novih zasebnih sporočil.</span>
                        </div>
                    @endif
        
                </div>
            </div>
        </div>
        
    </div>
@endsection
