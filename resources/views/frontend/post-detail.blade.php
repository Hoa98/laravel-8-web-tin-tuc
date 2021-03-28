@extends('frontend.template.main')

@section('title', $post->title)


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

<div class="blog-area section-padding-0-80">
    <div class="container">
        <div class="row">
            <div class="col-12 col-md-6 col-lg-8">
                    <div class="blog-posts-area">
                        <div class="single-blog-post featured-post single-post">
                            <div class="post-thumb">
                                <a href="{{url($post->post_url.'.'.$post->id.'.html')}}"><img src="{{asset($post->image)}}" style="width:730px;height:353px;" alt=""></a>
                            </div>
                            <div class="post-data">
                                <a href="{{url($post->category->cate_url)}}" class="post-catagory">{{$post->category->name}}</a>
                                <a href="{{url($post->post_url.'.'.$post->id.'.html')}}" class="post-title">
                                    <h6>{{$post->title}}</h6>
                                </a>
                                <div class="post-meta">
                                    <p class="post-author">By {{$post->author}}</p>
                                    <p class="post-excerp">{!!$post->short_desc!!}</p>
                                    <p class="post-excerp">{!!$post->content!!}</p>

                                    <div class="d-flex align-items-center">
                                        <a href="#" class="post-like">{{$post->created_at->isoFormat('l')}}</a>
                                        <a href="#" class="post-comment post-view"><img src="{{asset('images/core-img/view.png')}}" alt=""> <span>{{$post->view->sum('views')}}</span></a>
                                        <a href="#" class="post-comment"><img src="{{asset('images/core-img/chat.png')}}" alt=""> <span>{{count($post->comments)}}</span></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                   
                  
                    <div class="section-heading">
                    <h6>Bài viết liên quan</h6>
                    </div>
                    <div class="row">
                        @foreach($postRelate as $related)
                            <div class="col-12 col-md-6">
                                <div class="single-blog-post style-3 mb-80">
                                    <div class="post-thumb">
                                    <a href="{{url($related->post_url.'.'.$related->id.'.html')}}"><img src="{{asset($related->image)}}" alt=""  style="width:350px;height:307px;"></a>
                                    </div>
                                    <div class="post-data">
                                    <a href="{{url($related->category->cate_url)}}" class="post-catagory">{{$related->category->name}}</a>
                                    <a href="{{url($related->post_url.'.'.$related->id.'.html')}}" class="post-title">
                                    <h6>{{$related->title}}</h6>
                                    </a>
                                    <div class="post-meta d-flex align-items-center">
                                    <a href="#" class="post-like">{{$related->created_at->isoFormat('l')}}</a>
                                    <a href="#" class="post-comment"><img src="{{asset('images/core-img/view.png')}}" alt=""> <span>{{$related->view->sum('views')}}</span></a>
                                    <a href="#" class="post-comment"><img src="{{asset('images/core-img/chat.png')}}" alt=""> <span>{{count($related->comments)}}</span></a>
                                    </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        
                    </div>
                    {{-- Bình luận  --}}
                    <div class="comment_area clearfix">
                        <h5 class="title">{{count($comments)}} Bình luận</h5>
                        <ol>
                           @foreach($comments as $com)
                                <li class="single_comment_area">
                                    
                                    <div class="comment-content d-flex">
                                    
                                        <div class="comment-author">
                                            <img src="{{asset($com->avatar)}}" alt="author">
                                        </div>
                                        <div class="comment-meta">
                                            <a href="#" class="post-author">{{$com->name}}</a>
                                            <a href="#" class="post-date">{{$com->created_at->toDayDateTimeString()}}</a>
                                            <p>{{$com->content}}</p>
                                        </div>
                                    </div>
                                </li>
                           @endforeach
                        </ol>
                    </div>
                    {{-- Form comment --}}
                    <div class="post-a-comment-area pt-5">
                       @if(Auth::check())
                            <h4>Để lại bình luận</h4>
                            <div class="contact-form-area">
                                <form action="{{route('post.comment')}}" method="post">
                                    @csrf
                                    <div class="row">
                                        <div class="col-12">
                                            <input type="hidden" name="post_id" value="{{$post->id}}">
                                            <input type="hidden" name="user_id" value="{{Auth::id()}}">
                                        <textarea name="content" class="form-control" id="content" cols="30" rows="6" placeholder="Nhập nội dung"></textarea>
                                        @if($errors->has('content'))
                                            <div class="mb-3">
                                            <span class="text-danger">{{$errors->first('content')}}</span>
                                            </div>
                                        @endif
                                        </div>
                                        <div class="col-12 text-center">
                                        <button class="btn newspaper-btn mt-30 w-100" type="submit">Gửi bình luận</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        @else
                        <p>Đăng nhập để có thể bình luận</p>
                       @endif
                    </div>
            </div>
                                   
            <div class="col-12 col-md-6 col-lg-4">
                <div class="blog-sidebar-area">

                    <div class="latest-posts-widget mb-50">
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
                    </div>
                    <div class="popular-news-widget mb-50">
                        <h3>Tin tức mới nhất</h3>
                        @foreach($postNews as $key => $n)
                        <div class="single-popular-post">
                            <a href="{{url($n->post_url.'.'.$n->id.'.html')}}">
                                <h6><span>{{$key+1}}.</span>{{$n->title}}</h6>
                            </a>
                            <p>{{$n->created_at}}
                                <img src="{{asset('images/core-img/view.png')}}" alt="" class="ml-3"> <span>{{$n->view->sum('views')}}</span>
                            </p>
                        </div>
    
                        @endforeach
    
                    </div>
    
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
@section('my-script')
<script>
    let increaseViewUrl = "{{route('post.tangView')}}";
    const data = {
        id: {{$post->id}},
        _token: "{{csrf_token()}}"
    };
    setTimeout(() => {
        fetch(increaseViewUrl, {
            method: "POST",
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(data)
        })
        .then(responseData => responseData.json())
        .then(postObj => {
            document.querySelector(".post-view span").innerHTML = postObj;
            // console.log(postObj);
        })
    }, 3000);
</script>
@endsection
