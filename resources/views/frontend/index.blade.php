@extends('frontend.template.main')

@section('title', 'Trang chủ')


@section('content')


<div class="hero-area">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-12 col-lg-8">

                <div class="breaking-news-area d-flex align-items-center">
                    <div class="news-title">
                        <p>Tin mới nhất</p>
                    </div>
                    <div id="breakingNewsTicker" class="ticker">
                        <ul>
                           @foreach($postNews as $new)
                           <li><a href="{{url($new->post_url.'.'.$new->id.'.html')}}">{{$new->title}}</a></li>
                           @endforeach
                           
                        </ul>
                    </div>
                </div>

                <div class="breaking-news-area d-flex align-items-center mt-15">
                    @if(count($postWorld)>0)
                    <div class="news-title title2">
                        <a href="{{url($postWorld[0]->category->cate_url)}}"><p>{{$postWorld[0]->category->name}}</p></a>

                    </div>
                    <div id="internationalTicker" class="ticker">
                        <ul>
                            @foreach($postWorld as $w)
                           <li><a href="{{url($w->post_url.'.'.$w->id.'.html')}}">{{$w->title}}</a></li>
                           @endforeach
                        </ul>
                    </div>
                    @endif
                </div>
            </div>

            <div class="col-12 col-lg-4">
                <div class="hero-add">
                    <a href="http://dulichsummertrip.com/"><img src="{{asset('images/bg-img/hero-add.gif')}}" alt=""></a>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="featured-post-area">
    <div class="container">
        <div class="row">
            <div class="col-12 col-md-6 col-lg-8">
                @if(count($comingPost)>0)
                <div class="row">
                        <div class="col-12 col-lg-7">
                            <div class="single-blog-post featured-post">
                                <div class="post-thumb">
                                    <a href="{{url($comingPost[0]->post_url.'.'.$comingPost[0]->id.'.html')}}"><img src="{{asset($comingPost[0]->image)}}" style="width:413px;height:328px;" alt=""></a>
                                </div>
                                <div class="post-data">
                                    <a href="{{url($comingPost[0]->category->cate_url)}}" class="post-catagory">{{$comingPost[0]->category->name}}</a>
                                    <a href="{{url($comingPost[0]->post_url.'.'.$comingPost[0]->id.'.html')}}" class="post-title">
                                        <h6>{{$comingPost[0]->title}}</h6>
                                    </a>
                                    <div class="post-meta">
                                        <p class="post-author">By {{$comingPost[0]->author}}</p>
                                        <p class="post-excerp">{!!$comingPost[0]->short_desc!!}</p>

                                        <div class="d-flex align-items-center">
                                            <a href="#" class="post-like">{{$comingPost[0]->created_at->diffForHumans()}}
                                            </a>
                                            <a href="#" class="post-comment"><img src="{{asset('images/core-img/view.png')}}" alt=""> <span>{{$comingPost[0]->view->sum('views')}}</span></a>
                                            <a href="#" class="post-comment"><img src="{{asset('images/core-img/chat.png')}}" alt=""> <span>{{count($comingPost[0]->comments)}}</span></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-lg-5">
                            @for($i = 1; $i < 3; $i++)
                            <div class="single-blog-post featured-post-2">
                                <div class="post-thumb">
                                    <a href="{{url($comingPost[$i]->post_url.'.'.$comingPost[$i]->id.'.html')}}"><img src="{{asset($comingPost[$i]->image)}}" style="width:287px;height:199px;" alt=""></a>
                                </div>
                                <div class="post-data">
                                    <a href="{{url($comingPost[$i]->category->cate_url)}}" class="post-catagory">{{$comingPost[$i]->category->name}}</a>
                                    <div class="post-meta">
                                        <a href="{{url($comingPost[$i]->post_url.'.'.$comingPost[$i]->id.'.html')}}" class="post-title">
                                            <h6>{{$comingPost[$i]->title}}</h6>
                                        </a>
        
                                        <div class="d-flex align-items-center">
                                            <a href="#" class="post-like">{{$comingPost[$i]->created_at->diffForHumans()}}</a>
                                            <a href="#" class="post-comment"><img src="{{asset('images/core-img/view.png')}}" alt=""> <span>{{$comingPost[$i]->view->sum('views')}}</span></a>
                                            <a href="#" class="post-comment"><img src="{{asset('images/core-img/chat.png')}}" alt=""> <span>{{count($comingPost[$i]->comments)}}</span></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endfor
                        </div>
                @endif
            </div>
               
                @if(count($postEconomy)>0)
                <div class="popular-news-area section-padding-80-50">
                    <div class="section-heading">
                        <a href="{{url($postEconomy[0]->category->cate_url)}}"><h6>{{$postEconomy[0]->category->name}}</h6></a>
                    </div>
                    <div class="row">
                                    
                        @foreach($postEconomy as $economy)
                        <div class="col-12 col-md-6">
                            <div class="single-blog-post style-3">
                                <div class="post-thumb">
                                    <a href="{{url($economy->post_url.'.'.$economy->id.'.html')}}"><img src="{{asset($economy->image)}}" style="width:350px;height:307px;" alt=""></a>
                                </div>
                                <div class="post-data">
                                    <a href="{{url($economy->post_url.'.'.$economy->id.'.html')}}" class="post-title">
                                        <h6>{{$economy->title}}</h6>
                                    </a>
                                    <div class="post-meta d-flex align-items-center">
                                        <a href="#" class="post-like">{{$economy->created_at->isoFormat('l')}}</a>
                                        <a href="#" class="post-comment"><img src="{{asset('images/core-img/view.png')}}" alt=""> <span>{{$economy->view->sum('views')}}</span></a>
                                        <a href="#" class="post-comment"><img src="{{asset('images/core-img/chat.png')}}" alt=""> <span>{{count($economy->comments)}}</span></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
    
                    </div>
                </div>
                @endif
            </div>
            <div class="col-12 col-md-6 col-lg-4">
                <h3>Tin phổ biến</h3>
                @foreach($postView as $view)
                    <div class="single-blog-post small-featured-post d-flex">
                        <div class="post-thumb">
                            <a href="{{url($view->post_url.'.'.$view->id.'.html')}}"><img src="{{asset($view->image)}}" style="width:90px;height:90px;" alt=""></a>
                        </div>
                        <div class="post-data">
                            <a href="{{url($view->category->cate_url)}}" class="post-catagory">{{$view->category->name}}</a>
                            <div class="post-meta">
                                <a href="{{url($view->post_url.'.'.$view->id.'.html')}}" class="post-title">
                                    <h6>{{$view->title}}</h6>
                                </a>
                                <p class="post-date">
                                    <span>{{$view->created_at->toTimeString()}}</span> | 
                                    <span>{{$view->created_at->toFormattedDateString()}}</span>
                                    <img src="{{asset('images/core-img/view.png')}}" class="ml-3 pr-2" alt=""> <span>{{$view->view}}</span>
                                </p>
                            </div>
                        </div>
                    </div>
                @endforeach
                
                <div class="popular-news-widget mt-50 mb-50">
                    <h3>Tin tức mới nhất</h3>
                    @foreach($postNews as $key => $n)
                    <div class="single-popular-post">
                        <a href="{{url($n->post_url.'.'.$n->id.'.html')}}">
                            <h6><span>{{$key+1}}.</span>{{$n->title}}</h6>
                        </a>
                        <p>{{$n->created_at}} <img src="{{asset('images/core-img/view.png')}}" alt="" class="ml-3"> <span>{{$n->view->sum('views')}}</span></p>
                    </div>

                    @endforeach

                </div>

            </div>
        </div>
    </div>
</div>


<div class="editors-pick-post-area mt-50 section-padding-80-50">
    <div class="container">
        <div class="row mb-5">

           @if(count($postWorld) >0)
           <div class="col-12 col-md-7 col-lg-9">
            <div class="section-heading">
                <a href="{{url($postWorld[0]->category->cate_url)}}"><h6>{{$postWorld[0]->category->name}}</h6></a>
            </div>
            <div class="row">

                @foreach($postWorld as $world)
                <div class="col-12 col-lg-4">
                    <div class="single-blog-post">
                        <div class="post-thumb">
                            <a href="{{url($world->post_url.'.'.$world->id.'.html')}}"><img src="{{asset($world->image)}}" alt="" style="width:255px;height:312px;"></a>
                        </div>
                        <div class="post-data">
                            <a href="{{url($world->post_url.'.'.$world->id.'.html')}}" class="post-title">
                                <h6>{{$world->title}}</h6>
                            </a>
                            <div class="post-meta">
                                <div class="post-date">{{$world->created_at->toDayDateTimeString()}}
                                    <img src="{{asset('images/core-img/view.png')}}" alt="" class="ml-3"> <span>{{$world->view->sum('views')}}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach

            </div>
        </div>
           @endif

        @if(count($postHealth) > 0)
        <div class="col-12 col-md-5 col-lg-3">
            <div class="section-heading">
                <a href="{{url($postHealth[0]->category->cate_url)}}"><h6>{{$postHealth[0]->category->name}}</h6></a>
            </div>

           @foreach($postHealth as $health)
           <div class="single-blog-post style-2">
            <div class="post-thumb">
                <a href="{{url($health->post_url.'.'.$health->id.'.html')}}"><img src="{{asset($health->image)}}" alt="" style="width:255px;height:101px;"></a>
            </div>
            <div class="post-data">
                <a href="{{url($health->post_url.'.'.$health->id.'.html')}}" class="post-title">
                    <h6>{{$health->title}}</h6>
                </a>
                <div class="post-meta">
                    <div class="post-date">{{$health->created_at->toDayDateTimeString()}}
                        <img src="{{asset('images/core-img/view.png')}}" alt="" class="ml-3"> <span>{{$health->view->sum('views')}}</span>
                    </div>
                </div>
            </div>
        </div>
           @endforeach

        </div>
        @endif
        </div>
    </div>
</div>

@endsection
