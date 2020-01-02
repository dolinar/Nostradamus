@extends('layouts.app')

@section('content')
<section>

    <!-- Section heading -->
    <h2 class="h1-responsive font-weight-bold text-center mb-5">Novice</h2>

@foreach ($data['news'] as $news)
    <div class="row">

        <!-- Grid column -->
        <div class="col-lg-5">

        <!-- Featured image -->
            <div class="view overlay rounded z-depth-2 mb-lg-0 mb-4">
                <img class="img-fluid" src="/storage/news_images/{{$news['img_ref']}}">
                <a>
                    <div class="mask rgba-white-slight"></div>
                </a>
            </div>

        </div>
        <!-- Grid column -->

        <!-- Grid column -->
        <div class="col-lg-7">

            <!-- Category -->
            <a href="#!" class="green-text">
                <h6 class="font-weight-bold mb-3"><i class="fas fa-utensils pr-2"></i>{{$news['name']}}</h6>
            </a>
            <!-- Post title -->
            <h3 class="font-weight-bold mb-3"><strong>{{$news['title']}}</strong></h3>
            <!-- Excerpt -->
            <p>{{$news['summary']}}</p>
            <!-- Post data -->
            <p>Avtor: <a><strong>{{$news['user']['username']}}</strong></a>, {{strftime('%e/%m/%G ob %H:%M', strtotime($news['created_at']))}}</p>
            <!-- Read more button -->
            <a class="btn btn-success btn-md" href="{{route('news.show', ['id' => $news['id']]) }}">Več</a>

        </div>
        <!-- Grid column -->

    </div>
    <!-- Grid row -->

    <hr class="my-5">
@endforeach
</section>
<div id="pagination">
    {{ $data['news']->links() }}
</div>
@endsection 
