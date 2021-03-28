@extends('backend.layouts.main')

@section('title', 'Tài khoản')
@section('page-title')
Cập nhật tài khoản 
@endsection
@section('breadcrumb','Tài khoản')

@section('content')

<div class="card">
    <div class="card-header">
      <h3 class="card-title">Cập nhật tài khoản</h3>
    </div>
    <!-- /.card-header -->
    <div class="card-body">
     <form action="{{route('user.update')}}" enctype="multipart/form-data" method="post">
    @csrf
   <div class="row">
       <div class="col-6">
        <div class="form-group">
            <label for="name">Họ tên</label>
            <input type="hidden" name="id" value="{{$user->id}}">
            <input type="hidden" name="password" value="password">
            <input type="text" name="name" class="form-control" value="{{old('name',$user->name)}}">
            @if($errors->has('name'))
            <span class="text-danger">{{$errors->first('name')}}</span>
            @endif
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" name="email" class="form-control" value="{{old('email',$user->email)}}">
            
            @if($errors->has('email'))
            <span class="text-danger">{{$errors->first('email')}}</span>
            @endif
        </div>
       </div>
       <div class="col-6">
        <div class="form-group">
            <label for="role">Vai trò</label>
            <select name="role" id="" class="form-control">
                <option value="">-- Vai trò --</option>
                <option value="2" @if($user->role == 2) selected @endif>Người dùng</option>
                <option value="1" @if($user->role==1) selected @endif>Quản trị</option>
            </select>
            @if($errors->has('role'))
            <span class="text-danger">{{$errors->first('role')}}</span>
            @endif
        </div>
        <div class="form-group">
            <label for="avatar">Ảnh đại diện</label>
            <input type="file" name="avatar" class="form-control" onchange="previewFile(this)">
            <img id="previewImg" src="{{asset($user->avatar)}}" style="max-width:130px; margin-top:20px;"/>
            @if($errors->has('avatar'))
            <span class="text-danger">{{$errors->first('avatar')}}</span>
            @endif
        </div>
       </div>
   </div>
    <button type="submit" class="btn btn-primary">Cập nhật</button>
     <button type="button" class="btn btn-info" data-toggle="collapse"
             data-target="#resetPass" aria-controls="resetPass">Đổi mật khẩu</button>
    </form>

    <form action="{{route('user.res-pass')}}" class="collapse form-contact mt-3 needs-validation @if($errors->has('password') || $errors->has('res_pass') || $errors->has('confirm_pass'))  show @endif" id="resetPass" method="post">
        @csrf
       <div class="row">
           <div class="col-6 ofset-6">
            <div class="form-group">
                <div class="form-group">
                    <label for="password">Mật khẩu hiện tại</label>
                    <input type="hidden" name="id" value="{{$user->id}}">
                    <input type="password" name="password" class="form-control" value="{{old('password')}}">
                    @if($errors->has('password'))
                    <span class="text-danger">{{$errors->first('password')}}</span>
                    @endif
                </div>
                <div class="form-group">
                    <label for="res_pass">Mật khẩu mới</label>
                    <input type="password" name="res_pass" class="form-control" value="{{old('res_pass')}}">
                    @if($errors->has('res_pass'))
                    <span class="text-danger">{{$errors->first('res_pass')}}</span>
                    @endif
                </div>
                <div class="form-group">
                    <label for="confirm_pass">Xác nhận mật khẩu</label>
                    <input type="password" name="confirm_pass" class="form-control" value="{{old('confirm_pass')}}">
                    @if($errors->has('confirm_pass'))
                    <span class="text-danger">{{$errors->first('confirm_pass')}}</span>
                    @endif
                </div>
            </div>
            <button type="submit" class="btn btn-primary" name="btnGui">Đổi mật khẩu</button>
            <button type="button" class="btn btn-warning ml-3" data-toggle="collapse" data-target="#resetPass" aria-controls="resetPass">Hủy
                bỏ</button>
           </div>
       </div>
    </form>
    
    
    </div>
    <!-- /.card-body -->
</div>
@endsection

@section('my-script')
<script>
    function previewFile(input){
        var file = $("input[type=file]").get(0).files[0];
        if(file){
            var reader = new FileReader();
            reader.onload = function(){
                $('#previewImg').attr("src",reader.result);
            }
            reader.readAsDataURL(file);
        }
    }
</script>
@if(Session::has('res_pass'))
<script>
toastr.success("{!! Session::get('res_pass') !!}");
</script>
@endif
@endsection
