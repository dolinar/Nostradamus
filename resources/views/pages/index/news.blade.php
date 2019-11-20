<h5>Novice</h5>
<hr class="no-space">
@if (count($data['posts']) > 0)
    <div class="row">
        @foreach($data['posts'] as $post)
        <div class="col-md-4">

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
                        <a class="card-meta"><span><i class="fas fa-star"></i>Rating</span></a>
                        <p class="card-meta small text-muted float-right"><i class="fas fa-calendar"></i>{{$post['username'] . ': ' . date('d F o, H:i', strtotime(date($post['created_at'])))}}</p>
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
