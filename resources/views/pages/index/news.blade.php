<h5>Novice</h5>
<hr class="no-space">
@if (count($data['posts']) > 0)
    <div class="row">
        @foreach($data['posts'] as $post)
        <div class="col-xl-3 col-lg-6 col-md-6">

        <!--Card group-->
            <div class="card-group">
        
                <!--Card-->
                <div class="card card-personal mb-4">
            
                    <!--Card image-->
                    <div class="view">
                        <img class="card-img-top" src="storage/news_images/{{$post['img_ref']}}" alt="{{$post['title']}}">
                        <a href="#!">
                        </a>
                    </div>
                    <!--Card image-->
                    <a href="{{route('news.show', ['id' => $post['id']]) }}" class="btn-floating btn-action ml-auto mr-4 mdb-color lighten-3"><i class="fas fa-chevron-right pl-1"></i></a>
                    <!--Card content-->
                    <div class="card-body">
                        <!--Title-->
                        <a>
                        <h4 class="card-title">{{$post['title']}}</h4>
                        </a>
                        <a class="card-meta">{{$post['name']}}</a>
            
                        <!--Text-->
                        <p class="card-text">{{$post['summary']}}</p>
                        <hr>

                        <span class="card-meta small text-muted float-right w-100"><i class="fas fa-calendar"></i>{{$post['username'] . ': '}}<time class="timeago" datetime="{{$post['created_at']}}"><small></small></time></span>
                        {{-- <div class="container"><span id="rate-{{$post['id']}}" class="card-meta rate-stars empty-stars float-right"></span></div> --}}
                        
                    </div>
                    <!--Card content-->
                </div>
            <!--Card-->
            </div>
        </div>
        @endforeach
    </div>

    {{-- @foreach($data['posts'] as $post)
        <li class="list-group-item">
            <div class="row">
                <div class="col-lg-2 col-md-3 col-xs-4 text-right">
                    <time class="timeago small text-muted" datetime="{{date('c', $post->ts)}}"><small></small></time>
                </div>
                <div class="col-lg-8 col-md-9 col-xs-8">
                    <a target="_blank" rel="noopener noreferrer" data-toggle="tooltip" title="{{$post->summary}}" href="{{$post->link}}">
                        <b>{{$post->title}}</b>
                    </a>
                </div>
            </div>
        </li>
    @endforeach --}}


@endif
