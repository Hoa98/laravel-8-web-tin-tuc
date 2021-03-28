<header class="header-area">

    <div class="top-header-area">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="top-header-content d-flex align-items-center justify-content-between">

                        <div class="logo">
                            <a href="{{asset('/')}}"><img src="{{asset('images/core-img/logo.png')}}" alt=""></a>
                        </div>

                        <div class="login-search-area d-flex align-items-center">

                        
                            @if (Auth::check())
                                <div class="login d-flex">
                                    <a href="{{route('logout')}}">
                                        <img src="{{asset(Auth::user()->avatar)}}" alt="Logo" class="rounded-circle mr-2" width="30" height="30">
                                        {{Auth::user()->name}}
                                    </a>
                                    @if(Auth::user()->role == 1)
                                        <a href="{{route('admin')}}" style="line-height: 27px;">
                                            Quản trị
                                        </a>
                                    @endif
                                </div>
                            @else
                                <div class="login d-flex main-nav">
                                    <a class="cd-signin" href="javascript:;">Đăng nhập
                                    </a>
                                    <a class="cd-signup" href="javascript:;">Đăng ký
                                    </a>
                                </div>
                            @endif

                            <div class="search-form">
                                <form action="{{url('search-post')}}" method="get">
                                    <input type="search" name="keyword" value="{{old('keyword')}}" class="form-control" placeholder="Tìm kiếm">
                                    @if($errors->has('keyword'))
                                    <div class="mb-3">
                                    <span class="text-white">{{$errors->first('keyword')}}</span>
                                    </div>
                                @endif
                                    <button type="submit"><i class="fa fa-search" aria-hidden="true"></i></button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="newspaper-main-menu" id="stickyMenu">
        <div class="classy-nav-container breakpoint-off">
            <div class="container">

                <nav class="classy-navbar justify-content-between" id="newspaperNav">

                    <div class="logo">
                        <a href="{{url('/')}}"><img src="{{asset('images/core-img/logo.png')}}" alt=""></a>
                    </div>

                    <div class="classy-navbar-toggler">
                        <span class="navbarToggler"><span></span><span></span><span></span></span>
                    </div>

                    <div class="classy-menu">

                        <div class="classycloseIcon">
                            <div class="cross-wrap"><span class="top"></span><span class="bottom"></span></div>
                        </div>

                        <div class="classynav">
                            <ul>
                                <li class="active"><a href="{{url('/')}}">Home</a></li>
                                @foreach($cate as $c)
                                <li><a href="{{url($c->cate_url)}}">{{$c->name}}</a></li>
                                @endforeach
                            </ul>
                        </div>

                    </div>
                </nav>
            </div>
        </div>
    </div>
</header>