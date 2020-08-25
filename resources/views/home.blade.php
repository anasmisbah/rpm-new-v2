@extends('layouts.master')

@push('css')

@endpush

@section('content-header')
<div class="row mb-2">
    <div class="col-sm-6">
      <h1 class="m-0 text-dark">Dashboard</h1>
    </div><!-- /.col -->
    <div class="col-sm-6">
      <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="#">Home</a></li>
        <li class="breadcrumb-item active">Dashboard</li>
      </ol>
    </div><!-- /.col -->
  </div><!-- /.row -->
@endsection
@section('content')
<div class="row">
    @if (auth()->user()->role_id ==1 )
    <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-info">
          <div class="inner">
            <h3>{{$promo}}</h3>

            <p>Promos</p>
          </div>
          <div class="icon">
            <i class="ion ion-bag"></i>
          </div>
        </div>
      </div>
      <!-- ./col -->
      <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-success">
          <div class="inner">
            <h3>{{$news}}</h3>

            <p>News</p>
          </div>
          <div class="icon">
            <i class="ion ion-ios-paper"></i>
          </div>
        </div>
      </div>
      <!-- ./col -->
      <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-warning">
          <div class="inner">
            <h3>{{$event}}</h3>

            <p>Events</p>
          </div>
          <div class="icon">
            <i class="ion ion-android-calendar"></i>
          </div>
        </div>
      </div>
      <!-- ./col -->
      <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-danger">
          <div class="inner">
            <h3>{{$agen}}</h3>

            <p>Agen</p>
          </div>
          <div class="icon">
            <i class="ion ion-android-person"></i>
          </div>
        </div>
      </div>
      <!-- ./col -->
      <div class="col-lg-3 col-6">
          <!-- small box -->
          <div class="small-box bg-info">
            <div class="inner">
              <h3>{{$customer}}</h3>

              <p>Customer</p>
            </div>
            <div class="icon">
              <i class="ion ion-ios-people"></i>
            </div>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-6">
          <!-- small box -->
          <div class="small-box bg-success">
            <div class="inner">
              <h3>{{$sales_order}}</h3>

              <p>Sales Order</p>
            </div>
            <div class="icon">
                <i class="ion ion-ios-pricetag"></i>
            </div>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-6">
          <!-- small box -->
          <div class="small-box bg-warning">
            <div class="inner">
              <h3>{{$delivery_orders}}</h3>

              <p>Delivery Order</p>
            </div>
            <div class="icon">
              <i class="ion ion-stats-bars"></i>
            </div>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-6">
          <!-- small box -->
          <div class="small-box bg-danger">
            <div class="inner">
              <h3>{{$driver}}</h3>

              <p>Driver</p>
            </div>
            <div class="icon">
              <i class="ion ion-card"></i>
            </div>
          </div>
        </div>
    @else
    <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-success">
          <div class="inner">
            <h3>{{$news}}</h3>

            <p>News</p>
          </div>
          <div class="icon">
            <i class="ion ion-ios-paper"></i>
          </div>
        </div>
      </div>
      <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-warning">
          <div class="inner">
            <h3>{{$event}}</h3>

            <p>Events</p>
          </div>
          <div class="icon">
            <i class="ion ion-android-calendar"></i>
          </div>
        </div>
      </div>
    @endif

      <!-- ./col -->
  </div>

  @if (auth()->user()->role_id == 1)
    <div class="row">
        <div class="col-md-12">
            <div class="card">
            <div class="card-header border-0">
                <div class="d-flex justify-content-between">
                <h3 class="card-title">Sales Transaction</h3>
                </div>
            </div>
            <div class="card-body">
                <div class="d-flex">
                <p class="d-flex flex-column">
                    <span class="text-bold text-lg">{{$total}} KL</span>
                    <span>Total Transaction</span>
                </p>
                </div>
                <!-- /.d-flex -->

                <div class="position-relative mb-4">
                <canvas id="sales-chart" height="200"></canvas>
                </div>

                <div class="d-flex flex-row justify-content-end">
                <span class="mr-2">
                    <i class="fas fa-square text-primary"></i> This year
                </span>
                </div>
            </div>
            </div>
        </div>
    </div>
  @endif
@endsection

@push('script')
<!-- ChartJS -->
<script src="/plugins/chart.js/Chart.min.js"></script>
<script>
    $(function () {
  'use strict'

  var ticksStyle = {
    fontColor: '#495057',
    fontStyle: 'bold'
  }

  var mode      = 'index'
  var intersect = true

    let url = "{{ route('home.chart') }}"
    $.ajax({
        type: 'get',
        url: url,
        success: function(data) {
            var $salesChart = $('#sales-chart')
            var salesChart  = new Chart($salesChart, {
              type   : 'bar',
              data   : {
                labels  : data.label,
                datasets: [
                  {
                    backgroundColor: '#007bff',
                    borderColor    : '#007bff',
                    data           : data.transaction
                  }
                ]
              },
              options: {
                maintainAspectRatio: false,
                tooltips           : {
                  mode     : mode,
                  intersect: intersect
                },
                hover              : {
                  mode     : mode,
                  intersect: intersect
                },
                legend             : {
                  display: false
                },
                scales             : {
                  yAxes: [{
                    // display: false,
                    gridLines: {
                      display      : true,
                      lineWidth    : '4px',
                      color        : 'rgba(0, 0, 0, .2)',
                      zeroLineColor: 'transparent'
                    },
                    ticks    : $.extend({
                      beginAtZero: true,

                      // Include a dollar sign in the ticks
                      callback: function (value, index, values) {
                        if (value >= 1000) {
                          value /= 1000
                          value += 'KL'
                        }
                        return value
                      }
                    }, ticksStyle)
                  }],
                  xAxes: [{
                    display  : true,
                    gridLines: {
                      display: false
                    },
                    ticks    : ticksStyle
                  }]
                }
              }
            })
        }
    })

})

</script>
@endpush
