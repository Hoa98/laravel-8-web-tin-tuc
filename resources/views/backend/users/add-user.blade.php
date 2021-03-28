@extends('backend.layouts.main')

@section('title', 'Tài khoản')
@section('page-title')
Thêm tài khoản 
@endsection
@section('breadcrumb','Tài khoản')

@section('content')

<div class="card">
    <div class="card-header">
      <h3 class="card-title">Thêm mới tài khoản</h3>
    </div>
    <!-- /.card-header -->
    <div class="card-body">
     <form action="{{route('user.saveAdd')}}" enctype="multipart/form-data" method="post">
    @csrf
   <div class="row">
       <div class="col-6">
        <div class="form-group">
            <label for="name">Họ tên</label>
            <input type="text" name="name" class="form-control" value="{{old('name')}}">
            @if($errors->has('name'))
            <span class="text-danger">{{$errors->first('name')}}</span>
            @endif
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="text" name="email" class="form-control" value="{{old('email')}}">
            @if($errors->has('email'))
            <span class="text-danger">{{$errors->first('email')}}</span>
            @endif
        </div>
        <div class="form-group">
            <label for="password">Mật khẩu</label>
            <input type="password" name="password" class="form-control" value="{{old('password')}}">
            @if($errors->has('password'))
            <span class="text-danger">{{$errors->first('password')}}</span>
            @endif
        </div>
       </div>
       <div class="col-6">
        <div class="form-group">
            <label for="role">Vai trò</label>
            <select name="role" id="" class="form-control">
                <option value="">-- Vai trò --</option>
                <option value="2" @if(old('role')== 2) selected @endif>Người dùng</option>
                <option value="1" @if(old('role')==1) selected @endif>Quản trị</option>
            </select>
            @if($errors->has('role'))
            <span class="text-danger">{{$errors->first('role')}}</span>
            @endif
        </div>
        <div class="form-group">
            <label for="avatar">Ảnh đại diện</label>
            <input type="file" name="avatar" class="form-control" onchange="previewFile(this)">
            <img id="previewImg" style="max-width:130px; margin-top:20px;"/>
            @if($errors->has('avatar'))
            <span class="text-danger">{{$errors->first('avatar')}}</span>
            @endif
        </div>
       </div>
   </div>
    <button type="submit" class="btn btn-primary">Thêm mới</button>
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

@endsection
