@extends('backend.layouts.main')

@section('title', 'Bài viết')
@section('page-title')
Bài viết / <a href="{{route('post.add')}}" class="btn btn-info">Thêm mới</a>
 / <a href="{{route('scrape')}}" class="btn btn-warning">Lấy dữ liệu </a>
@endsection
@section('breadcrumb','Bài viết')
@section('my-style')
<!-- DataTables -->
<link rel="stylesheet" href="{{asset('adminlte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('adminlte/plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">

@endsection
@section('content')

<div class="card">
    <div class="card-header">
      <h3 class="card-title">Danh sách bài viết</h3>
    </div>
    <!-- /.card-header -->
    <div class="card-body">
     
      <table id="example1" class="table table-bordered table-striped">
        <thead>
        <tr>
          <th>ID</th>
          <th>Ảnh</th>
          <th>Tiêu đề</th>
          <th>Tên danh mục</th>
          <th>Lượt xem</th>
          <th>Tổng bình luận</th>
          <th>Tác giả</th>
          <th>Thao tác</th>
        </tr>
        </thead>
        <tbody>
         
        </tbody>
        <tfoot>
        <tr>
          <th>ID</th>
          <th>Ảnh</th>
          <th>Tiêu đề</th>
          <th>Tên danh mục</th>
          <th>Lượt xem</th>
          <th>Tổng bình luận</th>
          <th>Tác giả</th>
          <th>Thao tác</th>
        </tr>
        </tfoot>
      </table>
    </div>
    <!-- /.card-body -->
</div>
@endsection
@section('my-script')
<!-- DataTables -->

<script src="{{asset('adminlte/plugins/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('adminlte/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{asset('adminlte/plugins/datatables-responsive/js/dataTables.responsive.min.js')}}"></script>
<script src="{{asset('adminlte/plugins/datatables-responsive/js/responsive.bootstrap4.min.js')}}"></script>

<!-- page script -->
<script>
  $(function () {
    $("#example1").DataTable({ 
              "oLanguage": {
                  "sLengthMenu": "Hiện _MENU_ Dòng",
                  "sSearch": "Tìm kiếm",
                  "sEmptyTable": "Không có dữ liệu",
                  "sProcessing": '',
                  "sZeroRecords": "Không tìm thấy dòng nào phù hợp",
                  "sInfo": "Đang xem _START_ đến _END_ trong tổng số _TOTAL_ mục",
                  "sInfoEmpty": "Đang xem 0 đến 0 trong tổng số 0 mục",
                  "sInfoFiltered": "(được lọc từ _MAX_ mục)",
                  "sInfoPostFix": "",
                  "sUrl": ""
              },
              // "processing": true,
              "serverSide": true,
              "autoWidth": false,
              "responsive": true,
              "searching": true,
              "ordering": false, 
              ajax: {
                url: "{!! route('post.api') !!}",
                data: function (d) {
                      d.search = $('input[type="search"]').val()
                  }
               },
                "columns": [
                  { data: 'id', name: 'ID' },
                  { data: 'image', name: 'Ảnh' },
                  { data: 'title', name: 'Tiêu đề' },
                  { data: 'cate_id', name: 'Tên danh mục' },
                  { data: 'view', name: 'Lượt xem' },
                  { data: 'comments', name: 'Tổng bình luận' },
                  { data: 'author', name: 'Tác giả' },
                  { data: 'action', name: 'Thao tác' }
                ],
    });

  });

</script>
@if(Session::has('post_added'))
<script>
toastr.success("{!! Session::get('post_added') !!}");
</script>
@endif
@if(Session::has('post_deleted'))
<script>
toastr.success("{!! Session::get('post_deleted') !!}");
</script>
@endif
@if(Session::has('post_updated'))
<script>
toastr.success("{!! Session::get('post_updated') !!}");
</script>
@endif

<script>
 $(function(){
    setTimeout(function(){
      $('.btn-delete').on('click', function(){
                Swal.fire({
                    title: 'Cảnh báo!',
                    text: "Bạn chắc chắn muốn bài viết này?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Đồng ý!'
                }).then((result) => {
                    if (result.value) {
                        var url = $(this).attr('href');
                        window.location.href = url;
                    }
                })
                return false;
      });
    },1000)
  })
</script>
@endsection
