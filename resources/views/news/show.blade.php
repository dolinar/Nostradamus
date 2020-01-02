@extends('layouts.app')

@section('content')
    <a><h6 class="font-weight-bold mb-3"><i class="fas fa-utensils pr-2"></i>{{$data['news'][0]['name']}}</h6></a>
    <h3>{{$data['news'][0]['title']}}</h3>
    <hr>
    <p>Avtor: <a><strong>{{$data['news'][0]['user']['username']}}</strong></a>, {{strftime('%e/%m/%G ob %H:%M', strtotime($data['news'][0]['created_at']))}}</p>
    @if ($data['news'][0]['updated_at'] != null)
    <p>Zadnja sprememba: {{strftime('%e/%m/%G ob %H:%M', strtotime($data['news'][0]['updated_at']))}}</p>
    @endif
    <hr>
    <h5>{{$data['news'][0]['summary']}}</h5>
    <img class="mx-auto d-block mb-3" width="50%" height="auto" src="/storage/news_images/{{$data['news'][0]['img_ref']}}"/>
    <section>{{$data['news'][0]['content']}}</section>

@endsection 
