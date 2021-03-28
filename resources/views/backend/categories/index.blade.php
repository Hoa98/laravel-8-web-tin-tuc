@extends('backend.layouts.main')

@section('title', 'Danh mục')
@section('page-title')
Danh mục / <a href="{{route('cate.add')}}" class="btn btn-info">Thêm mới</a>
@endsection
@section('breadcrumb','Danh mục')
@section('my-style')
<!-- DataTables -->
<link rel="stylesheet" href="{{asset('adminlte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('adminlte/plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">

@endsection
@section('content')

<div class="card">
    <div class="card-header">
      <h3 class="card-title">Danh sách danh mục</h3>
    </div>
    <!-- /.card-header -->
    <div class="card-body">
    
      <table id="example1" class="table table-bordered table-striped">
        <thead>
        <tr>
          <th>Ảnh</th>
          <th>ID</th>
          <th>Tên danh mục</th>
          <th>Tổng bài viết</th>
          <th>Thao tác</th>
        </tr>
        </thead>
        <tbody>
         
       
        </tbody>
        <tfoot>
        <tr>
          <th>Ảnh</th>
          <th>ID</th>
          <th>Tên danh mục</th>
          <th>Tổng bài viết</th>
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
                url: "{!! route('cate.api') !!}",
                data: function (d) {
                      d.search = $('input[type="search"]').val()
                  }
               },
                "columns": [
                  { data: 'logo', name: 'Ảnh' },
                  { data: 'id', name: 'ID' },
                  { data: 'name', name: 'Tên danh mục' },
                  { data: 'posts', name: 'Tổng bài viết' },
                  { data: 'action', name: 'Thao tác' }
                ],
    });
 
  });

</script>
@if(Session::has('category_added'))
<script>
toastr.success("{!! Session::get('category_added') !!}");
</script>
@endif
@if(Session::has('cate_deleted'))
<script>
toastr.success("{!! Session::get('cate_deleted') !!}");
</script>
@endif
@if(Session::has('cate_updated'))
<script>
toastr.success("{!! Session::get('cate_updated') !!}");
</script>
@endif
@if(Session::has('post_added'))
<script>
toastr.success("{!! Session::get('post_added') !!}");
</script>
@endif
<script>
  $(function(){
    setTimeout(function(){
      $('.btn-delete').on('click', function(){
                Swal.fire({
                    title: 'Cảnh báo!',
                    text: "Bạn chắc chắn muốn xóa danh mục này?",
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
