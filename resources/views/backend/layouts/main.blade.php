<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Admin - @yield('title','Trang chủ')</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="icon" href="{{asset('images/core-img/favicon.ico')}}">
  @include('backend.layouts.style')
  @yield('my-style')
</head>
<body class="hold-transition sidebar-mini preloading">
  <div class="loader">
    <span class="fas fa-spinner xoay iconload"></span>
  </div>
<!-- Site wrapper -->
<div class="wrapper">
  <!-- Navbar -->
 @include('backend.layouts.navbar')
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  @include('backend.layouts.sidebar')
  <!-- Content Wrapper. Contains page content -->

  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">@yield('page-title','Dashboard')</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{route('admin')}}">Trang chủ</a></li>
              <li class="breadcrumb-item active">@yield('breadcrumb','Dashboard')</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            @yield('content')
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <footer class="main-footer">
    <div class="float-right d-none d-sm-block">
      <b>Version</b> 3.0.5
    </div>
    <strong>Copyright &copy; 2021</strong> All rights
    reserved.
  </footer>
</div>
<!-- ./wrapper -->

@include('backend.layouts.script')
@yield('my-script')
</body>
</html>
