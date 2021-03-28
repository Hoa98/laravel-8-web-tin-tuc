@extends('backend.layouts.main')

@section('title', 'Tổng quan')
@section('page-title')
Tổng quan
@endsection
@section('breadcrumb','Tổng quan')

@section('content')

<div class="card">
    <div class="card-header">
      <h3 class="card-title">Tổng quan</h3>
    </div>
    <!-- /.card-header -->
    <div class="card-body">
      <div class="row">
        <div class="col-lg-3 col-6">
          <!-- small box -->
          <div class="small-box bg-info">
            <div class="inner">
              <h3>{{$comments}}</h3>

              <p>Bình luận</p>
            </div>
            <div class="icon">
              <i class="fas fa-comments"></i>
            </div>
            <a href="{{route('comment.index')}}" class="small-box-footer">Xem thêm <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-6">
          <!-- small box -->
          <div class="small-box bg-success">
            <div class="inner">
              <h3>{{$blogs}}</h3>

              <p>Bài viết</p>
            </div>
            <div class="icon">
              <i class="fas fa-blog"></i>
            </div>
            <a href="{{route('post.index')}}" class="small-box-footer">Xem thêm <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-6">
          <!-- small box -->
          <div class="small-box bg-warning">
            <div class="inner">
              <h3>{{$users}}</h3>

              <p>Tài khoản</p>
            </div>
            <div class="icon">
              <i class="fas fa-users"></i>
            </div>
            <a href="{{route('user.index')}}" class="small-box-footer">Xem thêm <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-6">
          <!-- small box -->
          <div class="small-box bg-danger">
            <div class="inner">
              <h3>{{$categories}}</h3>

              <p>Danh mục</p>
            </div>
            <div class="icon">
              <i class="fas fa-wallet"></i>
            </div>
            <a href="{{route('cate.index')}}" class="small-box-footer">Xem thêm <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
      </div>
      <div class="row mt-3">
       <nav class="nav">
        <ul class="nav nav-tabs" id="myTab" role="tablist">
          <li class="nav-item" role="presentation">
            <a class="nav-link active" id="chart-day-tab" data-toggle="tab" href="#chart-day" role="tab" aria-controls="chart-day" aria-selected="true">Ngày</a>
          </li>
          <li class="nav-item" role="presentation">
            <a class="nav-link" id="chart-month-tab" data-toggle="tab" href="#chart-month" role="tab" aria-controls="chart-month" aria-selected="false">Tháng</a>
          </li>
          <li class="nav-item" role="presentation">
            <a class="nav-link" id="chart-year-tab" data-toggle="tab" href="#chart-year" role="tab" aria-controls="chart-year" aria-selected="false">Năm</a>
          </li>
        </ul>
       </nav>
        <div class="tab-content" id="myTabContent">
          <div class="tab-pane fade show active" id="chart-day" role="tabpanel" aria-labelledby="chart-day-tab"></div>
          <div class="tab-pane fade" id="chart-month" role="tabpanel" aria-labelledby="chart-month-tab"></div>
          <div class="tab-pane fade" id="chart-year" role="tabpanel" aria-labelledby="chart-year-tab"></div>
        </div>
        
      </div>
    </div>
    <!-- /.card-body -->
</div>
@endsection
@section('my-script')
<script src="https://code.highcharts.com/highcharts.js"></script>
<script>
  var datas = <?php echo json_encode($datas)?>;
  var viewDay =  <?php echo json_encode($dataDay)?>;
  var viewYear =  <?php echo json_encode($dataYear)?>;
  var cateYear =  <?php echo json_encode($cateYear)?>;

  Highcharts.chart('chart-day', {
    chart: {
      type: 'spline',
        width: 1200,
        style: {
            fontFamily: 'sans-serif'
        }
    },
      title: {
          text: 'Thống kê lượt xem trong tháng'
      },
      subtitle: {
          text: 'Nguồn: thenewpaper.com'
      },
      xAxis: {
          categories: ['1', '2', '3', '4', '5', '6', '7', '8', '9',
              '10', '11', '12','13','14','15','16', '17', '18', '19',
              '20', '21', '22','23','24','25','26','27', '28', '29','30','31'
          ]
      },
      yAxis: {
          title: {
              text: 'Tổng lượt xem'
          }
      },
      legend: {
          layout: 'vertical',
          align: 'right',
          verticalAlign: 'middle'
      },
      plotOptions: {
          series: {
              allowPointSelect: true
          }
      },
      series: [{
          name: 'Lượt xem',
          data: viewDay
      }],
      responsive: {
          rules: [{
              condition: {
                maxWidth: 1200
              },
              chartOptions: {
                  legend: {
                      layout: 'horizontal',
                      align: 'center',
                      verticalAlign: 'bottom'
                  }
              }
          }]
      }
  });

  Highcharts.chart('chart-month', {
    chart: {
      type: 'spline',
        width: 1200,
        style: {
            fontFamily: 'sans-serif'
        }
    },
      title: {
          text: 'Thống kê lượt xem trong năm'
      },
      subtitle: {
          text: 'Nguồn: thenewpaper.com'
      },
      xAxis: {
          categories: ['Tháng 1', 'Tháng 2', 'Tháng 3', 'Tháng 4', 'Tháng 5', 'Tháng 6', 'Tháng 7', 'Tháng 8', 'Tháng 9',
              'Tháng 10', 'Tháng 11', 'Tháng 12'
          ]
      },
      yAxis: {
          title: {
              text: 'Tổng lượt xem'
          }
      },
      legend: {
          layout: 'vertical',
          align: 'right',
          verticalAlign: 'middle'
      },
      plotOptions: {
          series: {
              allowPointSelect: true
          }
      },
      series: [{
          name: 'Lượt xem',
          data: datas
      }],
      responsive: {
          rules: [{
              condition: {
                maxWidth: 1200
              },
              chartOptions: {
                  legend: {
                      layout: 'horizontal',
                      align: 'center',
                      verticalAlign: 'bottom'
                  }
              }
          }]
      }
  });
  Highcharts.chart('chart-year', {
    chart: {
      type: 'spline',
        width: 1200,
        style: {
            fontFamily: 'sans-serif'
        }
    },
      title: {
          text: 'Thống kê lượt xem theo năm'
      },
      subtitle: {
          text: 'Nguồn: thenewpaper.com'
      },
      xAxis: {
          categories: cateYear
      },
      yAxis: {
          title: {
              text: 'Tổng lượt xem'
          }
      },
      legend: {
          layout: 'vertical',
          align: 'right',
          verticalAlign: 'middle'
      },
      plotOptions: {
          series: {
              allowPointSelect: true
          }
      },
      series: [{
          name: 'Lượt xem',
          data: viewYear
      }],
      responsive: {
          rules: [{
              condition: {
                maxWidth: 1200
              },
              chartOptions: {
                  legend: {
                      layout: 'horizontal',
                      align: 'center',
                      verticalAlign: 'bottom'
                  }
              }
          }]
      }
  });

</script>

@endsection

