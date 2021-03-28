<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>AdminLTE 3 | Forgot Password</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{asset('adminlte/plugins/fontawesome-free/css/all.min.css')}}">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="{{asset('adminlte/plugins/icheck-bootstrap/icheck-bootstrap.min.css')}}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{asset('adminlte/dist/css/adminlte.min.css')}}">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>
<body class="hold-transition login-page">
<div class="login-box" style="width:500px;">
  <div class="login-logo">
    <a href=""><img src="{{asset('images/core-img/logo.png')}}" alt=""></a>
  </div>
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">
      <p class="login-box-msg">ĐẶT LẠI MẬT KHẨU</p>
      @if(Session::has('error'))
      <div class="alert alert-danger" role="alert">
          {{Session::get('error')}}
      </div>
      @endif
      <form action="{{route('password.update')}}" method="post">
        @csrf
            <input type="hidden" name="token" value="{{ $token }}">
            <div class="form-group row">
                <label for="email" class="col-md-5 col-form-label text-md-right">Địa chỉ email</label>
              <div class="col-md-7">
                    <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" autocomplete="email" autofocus>
                    @if($errors->has('email'))
                    <div class="mb-3">
                    <span class="text-danger">{{$errors->first('email')}}</span>
                    </div>  
                  @endif
                 
                </div>
            </div>

            <div class="form-group row">
                <label for="password" class="col-md-5 col-form-label text-md-right">Mật khẩu</label>
                <div class="col-md-7">
                    <input id="password" type="password" class="form-control" name="password" autocomplete="new-password">
                    @if($errors->has('password'))
                    <div class="mb-3">
                    <span class="text-danger">{{$errors->first('password')}}</span>
                    </div>  
                  @endif
                </div>

            </div>

          <div class="form-group row">
                <label for="password-confirm" class="col-md-5 col-form-label text-md-right">Xác nhận mật khẩu</label>
                <div class="col-md-7">
                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" autocomplete="new-password">
                    @if($errors->has('password_confirmation'))
                    <div class="mb-3">
                    <span class="text-danger">{{$errors->first('password_confirmation')}}</span>
                    </div>  
                  @endif
                  </div>
            </div>

          <div class="form-group row mb-0">
                <div class="col-md-7 offset-md-5">
                    <button type="submit" class="btn btn-primary">
                        Đặt lại mật khẩu
                    </button>
                </div>
            </div>
      </form>
    </div>
    <!-- /.login-card-body -->
  </div>
</div>
<!-- /.login-box -->

<!-- jQuery -->
<script src="{{asset('adminlte/plugins/jquery/jquery.min.js')}}"></script>
<!-- Bootstrap 4 -->
<script src="{{asset('adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{asset('adminlte/dist/js/adminlte.min.js')}}"></script>

</body>
</html>
