@extends('backend.layouts.main')

@section('title', 'Danh mục')
@section('page-title')
Thêm danh mục 
@endsection
@section('breadcrumb','Danh mục')

@section('content')

<div class="card">
    <div class="card-header">
      <h3 class="card-title">Thêm mới danh mục</h3>
    </div>
    <!-- /.card-header -->
    <div class="card-body">
        
     <form action="{{route('cate.saveAdd')}}" enctype="multipart/form-data" method="post">
    @csrf
    <div class="form-group">
        <label for="name">Tên danh mục</label>
        <input type="text" name="name" class="form-control" value="{{old('name')}}">
        @if($errors->has('name'))
        <span class="text-danger">{{$errors->first('name')}}</span>
    @endif
    </div>
    <div class="form-group">
        <label for="logo">Ảnh danh mục</label>
        <input type="file" name="logo" class="form-control" onchange="previewFile(this)">
        <img id="previewImg" style="max-width:130px; margin-top:20px;"/>
        @if($errors->has('logo'))
        <span class="text-danger">{{$errors->first('logo')}}</span>
    @endif
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
