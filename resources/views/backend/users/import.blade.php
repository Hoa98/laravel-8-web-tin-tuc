<!DOCTYPE html>
<html>
<head>
    <title>Nhập, xuất dữ liệu người dùng</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css" />
</head>
<body>
   
<div class="container">
    <div class="card bg-light mt-3">
        <div class="card-header">
            Nhập, xuất dữ liệu tài khoản
        </div>
        <div class="card-body">
            <form action="{{ route('user.import') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @if (isset($failures))
                <div class="alert alert-danger" role="alert">
                    <strong>Errors:</strong>
                    
                    <ul>
                        @foreach ($failures as $failure)
                            @foreach ($failure->errors() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        @endforeach
                    </ul>
                </div>
                @endif
                <div class="form-group">
                    <input type="file" name="file" class="form-control">
                <br>
                @if($errors->has('file'))
                <span class="text-danger">{{$errors->first('file')}}</span>
            @endif
                </div>
                <button class="btn btn-success">Nhập dữ liệu</button>
                <a class="btn btn-warning" href="{{ route('user.export') }}">Xuất dữ liệu</a>
            </form>
        </div>
    </div>
</div>
   
</body>
</html>