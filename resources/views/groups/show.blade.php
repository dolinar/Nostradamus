@extends('layouts.app')

@section('content')
    <h5>Skupina {{$data['group']['name']}}</h5>
    <hr>   
    @include('groups.table')
    <hr>
    @if($data['isAdmin'] == 1)
        <div class="row px-3">
            <button id="group-add-member" class="btn btn-info btn-sm col-lg-4 col-md-5 col-sm-5">Dodaj novega člana</button>
            <div class="col-lg-4 col-md-2 col-sm-2"></div>
            <button id="group-show-inv-status" class="btn btn-info btn-sm col-lg-4 col-md-5 col-sm-5">Prikaži stanja povabil</button>
        </div>    
        @include('groups.add-user')
        <div class="row">
            <div class="col-lg-4 md-4"></div>
            @include('groups.invitations-status')
        </div>
        <hr>
    @endif
    <div class="row px-3">
        @if($data['group']['owner'] != auth()->user()->id)
            <button id="group-leave" class="btn btn-warning btn-sm col-lg-4 col-md-5 col-sm-5" value={{$data['group']['id']}}>Zapusti skupino</button>
        @else
            <button id="group-leave-disabled" title="Lastnik skupine ne more zapustiti." disabled="disabled" class="btn btn-warning btn-sm col-lg-4 col-md-5 col-sm-5">Zapusti skupino</button>
        @endif
        <div class="col-lg-4 col-md-2 col-sm-2"></div>
        <div class="col-lg-4 col-md-5 col-sm-5" style="padding:0px;">
        @if ($data['group']['owner'] == auth()->user()->id)
            {{ Form::open([ 'method'  => 'delete', 'route' => [ 'groups.destroy', $data['group']['id'] ]]) }}
                {{ Form::hidden('id', $data['group']['id']) }}
                {{ Form::submit('Izbriši skupino', ['class' => 'btn btn-danger btn-sm btn-block', 'onclick' => 'return confirm("Res želite izbrisati skupino?")'])}}
            {{ Form::close() }}
        @endif
        </div>
    </div>
    <hr>
@endsection