@extends('backend.layouts.main')

@section('title', 'Bài viết')
@section('page-title')
Cập nhật bài viết 
@endsection
@section('breadcrumb','Bài viết')

@section('content')

<div class="card">
    <div class="card-header">
      <h3 class="card-title">Cập nhật bài viết</h3>
    </div>
    <!-- /.card-header -->
    <div class="card-body">
     <form action="{{route('post.update')}}" enctype="multipart/form-data" method="post">
    @csrf
    
    <div class="row">
        <div class="col-6">
            <div class="form-group">
                <label for="title">Tên bài viết</label>
                <input type="hidden" name="id" value="{{$post->id}}">
                <input type="text" name="title" class="form-control" value="{{old('title',$post->title)}}">
                @if($errors->has('title'))
                <span class="text-danger">{{$errors->first('title')}}</span>
            @endif
            </div>
            <div class="form-group">
                <label for="cate_id">Danh mục</label>
                <select name="cate_id" id="" class="form-control">
                    <option value="">Chọn danh mục</option>
                    @foreach ($cates as $c)
                        <option value="{{ $c->id }}" @if(old('cate_id')==$c->id||$c->id==$post->cate_id)
                            selected
                        @endif>{{ $c->name }}</option>
                    @endforeach
                </select>
                @if($errors->has('cate_id'))
                <span class="text-danger">{{$errors->first('cate_id')}}</span>
            @endif
            </div>
            <div class="form-group">
                <label for="author">Tên tác giả</label>
                <input type="text" name="author" class="form-control" value="{{old('author',$post->author)}}">
                @if($errors->has('author'))
                <span class="text-danger">{{$errors->first('author')}}</span>
            @endif
            </div>
            <div class="form-group">
                <label for="image">Ảnh bài viết</label>
                <input type="file" name="image" class="form-control" onchange="previewFile(this)">
                <img id="previewImg" src="{{asset($post->image)}}" style="max-width:130px; margin-top:20px;"/>
                @if($errors->has('image'))
                <span class="text-danger">{{$errors->first('image')}}</span>
            @endif
            </div>
        </div>
        <div class="col-6">
            <div class="form-group">
                <label for="">Mô tả ngắn</label>
                <textarea name="short_desc"  class="form-control">{{old('short_desc',$post->short_desc)}}</textarea>
                @if($errors->has('short_desc'))
                <span class="text-danger">{{$errors->first('short_desc')}}</span>
            @endif
            </div>
        </div>
    </div>
    <div class="form-group">
        <label for="">Nội dung</label>
        <textarea name="content" class="form-control">{{old('content',$post->content)}}
        </textarea>
        @if($errors->has('content'))
        <span class="text-danger">{{$errors->first('content')}}</span>
    @endif
    </div>
    <button type="submit" class="btn btn-primary">Cập nhật</button>
    </form>
    </div>
    <!-- /.card-body -->
</div>
@endsection

@section('my-script')
<script src="https://cdn.tiny.cloud/1/6fgy6zhj7h3xo9pm4dkp502s7unmk9eysfyciufaxlfjemes/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
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

    var editor_config = {
    path_absolute : "/",
    selector: 'textarea',
    relative_urls: false,
    plugins: [
      "advlist autolink lists link image charmap print preview hr anchor pagebreak",
      "searchreplace wordcount visualblocks visualchars code fullscreen",
      "insertdatetime media nonbreaking save table directionality",
      "emoticons template paste textpattern"
    ],
    toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image media",
    file_picker_callback : function(callback, value, meta) {
      var x = window.innerWidth || document.documentElement.clientWidth || document.getElementsByTagName('body')[0].clientWidth;
      var y = window.innerHeight|| document.documentElement.clientHeight|| document.getElementsByTagName('body')[0].clientHeight;

      var cmsURL = editor_config.path_absolute + 'laravel-filemanager?editor=' + meta.fieldname;
      if (meta.filetype == 'image') {
        cmsURL = cmsURL + "&type=Images";
      } else {
        cmsURL = cmsURL + "&type=Files";
      }

      tinyMCE.activeEditor.windowManager.openUrl({
        url : cmsURL,
        title : 'Filemanager',
        width : x * 0.8,
        height : y * 0.8,
        resizable : "yes",
        close_previous : "no",
        onMessage: (api, message) => {
          callback(message.content);
        }
      });
    }
  };

  tinymce.init(editor_config);
  
</script>

@endsection
