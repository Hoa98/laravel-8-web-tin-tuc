<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    
    <title>The News Paper - @yield('title')</title>
    <link rel="icon" href="{{asset('images/core-img/favicon.ico')}}">
    @include('frontend.template.style')
   
    {{-- <script type="text/javascript" src="https://gc.kis.v2.scr.kaspersky-labs.com/FD126C42-EBFA-4E12-B309-BB3FDD723AC1/main.js?attr=cxKpomkSLU3XHuYwduYMJCY_P8wPeXF4n1KPI7_ib2qx6FLLEDaQYC1th9PK8EarRPvaNFqgnMHD042I76TZag" charset="UTF-8"></script> --}}
</head>

<body>

  @include('frontend.template.navbar')

  @yield('content')

  {{-- Login  --}}
  <div class="cd-user-modal @if($errors->any() && !$errors->has('keyword') && !$errors->has('content'))  is-visible @endif"> 
    <!-- this is the entire modal form, including the background -->
    <div class="cd-user-modal-container"> 
      <!-- this is the container wrapper -->
      <ul class="cd-switcher">
        <li>
          <a href="javascript:;" @if($errors->has('email') || $errors->has('password') || $errors->has('reset_email'))
              class="selected" @endif>Đăng nhập
          </a>
         
        </li>
        <li>
          <a href="javascript:;" @if($errors->has('res_email') || $errors->has('res_name') || $errors->has('res_password') || $errors->has('res_password_confirmation')) class="selected" @endif>Đăng ký
          </a>
        </li>
      </ul>
      <div id="cd-login" @if($errors->has('email') || $errors->has('password')) class="is-selected"  @endif> 
        <!-- log in form -->
        <form class="cd-form" action="{{url('login')}}" method="POST">
          @csrf
          <p class="fieldset">
            <label class="image-replace cd-email" for="signin-email">Email
            </label>
            <input class="full-width has-padding has-border" id="signin-email" name="email" type="email"
            value="{{old('email')}}" placeholder="E-mail">
            @if($errors->has('email'))
            <div class="mb-3">
            <span class="text-danger">{{$errors->first('email')}}</span>
            </div>
        @endif
          </p>
          <p class="fieldset">
            <label class="image-replace cd-password" for="signin-password">Mật khẩu
            </label>
            <input class="full-width has-padding has-border" id="signin-password" name="password" value="{{old('password')}}" type="password"  placeholder="Mật khẩu">
            <a href="javascript:;" class="hide-password">Hiện
            </a>
            @if($errors->has('password'))
            <div class="mb-3">
            <span class="text-danger">{{$errors->first('password')}}</span>
            </div>
        @endif
          </p>
          <p class="fieldset">
            <input type="checkbox" id="remember-me" name="remember">
            <label for="remember-me">Nhớ đăng nhập
            </label>
          </p>
          <p class="fieldset">
            <input class="full-width" type="submit" value="Đăng nhập">
          </p>
          <p class="cd-form-bottom-message">
            <a href="javascript:;">Quên mật khẩu?
            </a>
          </p>

          {{-- <div class="form-group mgt8 content-social">
            <span class="d-block mb-3">Hoặc đăng nhập bằng:</span>
            <button type="button" class="btn btn-danger btn-google-plus" data-elementtype="logingoogle"></button>
            <button type="button" class="btn btn-primary btn-facebook" data-elementtype="loginfb"></button>
        </div> --}}
        </form>
       
      </div> 
      <!-- cd-login -->
      <div id="cd-signup" @if($errors->has('res_email') || $errors->has('res_name') || $errors->has('res_password') || $errors->has('res_password_confirmation')) class="is-selected" @endif> 
        <!-- sign up form -->
        <form class="cd-form" action="{{url('register')}}" method="POST">
          @csrf
          <p class="fieldset">
            <label class="image-replace cd-username" for="signup-username">Họ tên
            </label>
            <input class="full-width has-padding has-border" name="res_name" value="{{old('res_name')}}" id="signup-username" type="text" placeholder="Họ tên">
            @if($errors->has('res_name'))
            <div class="mb-3">
            <span class="text-danger">{{$errors->first('res_name')}}</span>
            </div>
        @endif
          </p>
          <p class="fieldset">
            <label class="image-replace cd-email" for="signup-email">Email
            </label>
            <input class="full-width has-padding has-border" id="signup-email" name="res_email"  value="{{old('res_email')}}" type="email" placeholder="E-mail">
            @if($errors->has('res_email'))
            <div class="mb-3">
            <span class="text-danger">{{$errors->first('res_email')}}</span>
            </div>
        @endif
          </p>
          <p class="fieldset">
            <label class="image-replace cd-password" for="signup-password">Mật khẩu
            </label>
            <input class="full-width has-padding has-border" id="signup-password" name="res_password"  value="{{old('res_password')}}" type="password"  placeholder="Mật khẩu">
            <a href="javascript:;" class="hide-password">Hiện
            </a>
            @if($errors->has('res_password'))
            <div class="mb-3">
            <span class="text-danger">{{$errors->first('res_password')}}</span>
            </div>
        @endif
          </p>
          <p class="fieldset">
            <label class="image-replace cd-password" for="signup-password">Xác nhận mật khẩu
            </label>
            <input class="full-width has-padding has-border" id="signup-password-repeat" name="res_password_confirmation"  value="{{old('res_password_confirmation')}}" type="password"  placeholder="Xác nhận mật khẩu">
            <a href="javascript:;" class="hide-password">Hiện
            </a>
            @if($errors->has('res_password_confirmation'))
            <div class="mb-3">
            <span class="text-danger">{{$errors->first('res_password_confirmation')}}</span>
            </div>
        @endif
          </p>
          <p class="fieldset">
            <input class="full-width has-padding" type="submit" value="Tạo tài khoản">
          </p>
          {{-- <div class="form-group mgt8 content-social">
            <span class="d-block mb-3">Hoặc đăng nhập bằng:</span>
            <button type="button" class="btn btn-danger btn-google-plus" data-elementtype="logingoogle"></button>
            <button type="button" class="btn btn-primary btn-facebook" data-elementtype="loginfb"></button>
        </div> --}}
        </form>
        <!-- <a href="javascript:;" class="cd-close-form">Close</a> -->
      </div> 
      <!-- cd-signup -->
      <div id="cd-reset-password" @if($errors->has('reset_email')) class="is-selected" @endif> 
        <!-- reset password form -->
        <p class="cd-form-message">Bạn quên mật khẩu? Vui lòng nhập email của bạn và chúng tôi sẽ gửi cho bạn một email có đường dẫn để thay đổi mật khẩu.
        </p>
        <form class="cd-form" method="POST" action="{{url('forgot_pass')}}">
          @csrf
          <p class="fieldset">
            <label class="image-replace cd-email" for="reset-email">Email
            </label>
            <input class="full-width has-padding has-border" id="reset-email" name="reset_email" value="{{old('reset_email')}}" type="email" placeholder="E-mail">
            @if($errors->has('reset_email'))
            <div class="mb-3">
            <span class="text-danger">{{$errors->first('reset_email')}}</span>
            </div>
        @endif
          </p>
          <p class="fieldset">
            <input class="full-width has-padding" type="submit" value="Đặt lại mật khẩU">
          </p>
          <p class="cd-form-bottom-message">
            <a href="javascript:;">Quay lại đăng nhập
            </a>
          </p>
        </form>
        
      </div> 
     
    </div> 
    <!-- cd-user-modal-container -->
  </div> 

    <footer class="footer-area">

        <div class="main-footer-area">
            <div class="container">
                <div class="row">

                    <div class="col-12 col-sm-6 col-lg-4">
                        <div class="footer-widget-area mt-80">

                            <div class="footer-logo">
                                <a href="{{url('/')}}"><img src="{{asset('images/core-img/logo.png')}}" alt=""></a>
                            </div>

                            <ul class="list">
                                <li><a href="mailto:hoactph09598@fpt.edu.vn"><span class="__cf_email__" data-cfemail="">hoactph09598@fpt.edu.vn</span></a></li>
                                <li><a href="tel:+4352782883884">+43 5278 2883 884</a></li>
                            </ul>
                        </div>
                    </div>
                    
                        <div class="col-12 col-sm-6 col-lg-2">
                            <div class="footer-widget-area mt-80">

                                <ul class="list">
                                  @for($i = 0; $i < 4; $i++)
                                  @isset($cate[$i])
                                  <li><a href="{{url($cate[$i]->cate_url)}}">{{$cate[$i]->name}}</a></li>
                                  @endisset
                                  @endfor
                                </ul>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6 col-lg-2">
                            <div class="footer-widget-area mt-80">

                                <ul class="list">
                                
                                  @for($i = 4; $i < 8; $i++)
                                  @isset($cate[$i])
                                  <li><a href="{{url($cate[$i]->cate_url)}}">{{$cate[$i]->name}}</a></li>
                                  @endisset
                                  @endfor
                                </ul>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6 col-lg-2">
                            <div class="footer-widget-area mt-80">

                                <ul class="list">
                                
                                  @for($i = 8; $i < 12; $i++)
                                  @isset($cate[$i])
                                  <li><a href="{{url($cate[$i]->cate_url)}}">{{$cate[$i]->name}}</a></li>
                                  @endisset
                                  @endfor
                                </ul>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6 col-lg-2">
                            <div class="footer-widget-area mt-80">

                                <ul class="list">
                                  @for($i = 12; $i < 16; $i++)
                                  @isset($cate[$i])
                                  <li><a href="{{url($cate[$i]->cate_url)}}">{{$cate[$i]->name}}</a></li>
                                  @endisset
                                  @endfor
                                </ul>
                            </div>
                        </div>
                </div>
            </div>
        </div>

        <div class="bottom-footer-area">
            <div class="container h-100">
                <div class="row h-100 align-items-center">
                    <div class="col-12">

                        <p>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </footer>

@include('frontend.template.script')

@yield('my-script')
@if(Session::has('user_reg'))
  <script>
  toastr.success("{!! Session::get('user_reg') !!}");
  </script>
@endif
@if(Session::has('user_log'))
  <script>
  toastr.success("{!! Session::get('user_log') !!}");
  </script>
@endif
@if(Session::has('comment_added'))
  <script>
  toastr.success("{!! Session::get('comment_added') !!}");
  </script>
@endif
@if(Session::has('message'))
  <script>
  toastr.success("{!! Session::get('message') !!}");
  </script>
@endif
</body>

</html>