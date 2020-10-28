@extends('layouts.master')

@push('css')
<!-- Tempusdominus Bbootstrap 4 -->
<link rel="stylesheet" href="{{asset('plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css')}}">
@endpush

@section('content-header')
<div class="row mb-2">
    <div class="col-sm-6">
        <h1 class="m-0 text-dark">Beranda</h1>
    </div><!-- /.col -->
    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{route('home.index')}}">Beranda</a></li>
        </ol>
    </div><!-- /.col -->
</div><!-- /.row -->
@endsection
@section('content')
<div class="row">
    <div class="col-12 col-sm-6 col-md-3">
        <div class="info-box">
            <span class="info-box-icon bg-info elevation-1"><i class="fas fa-ad"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Promo</span>
                <span class="info-box-number">
                    {{$promo}}
                </span>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </div>
    <!-- /.col -->
    <div class="col-12 col-sm-6 col-md-3">
        <div class="info-box mb-3">
            <span class="info-box-icon bg-danger elevation-1"><i class="far fa-newspaper"></i></span>

            <div class="info-box-content">
                <span class="info-box-text">Berita</span>
                <span class="info-box-number">{{$news}}</span>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </div>
    <!-- /.col -->

    <!-- fix for small devices only -->
    <div class="clearfix hidden-md-up"></div>

    <div class="col-12 col-sm-6 col-md-3">
        <div class="info-box mb-3">
            <span class="info-box-icon bg-success elevation-1"><i class="far fa-calendar"></i></span>

            <div class="info-box-content">
                <span class="info-box-text">Events</span>
                <span class="info-box-number">{{$event}}</span>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </div>
    <!-- /.col -->
    <div class="col-12 col-sm-6 col-md-3">
        <div class="info-box mb-3">
            <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-users"></i></span>

            <div class="info-box-content">
                <span class="info-box-text">Customer</span>
                <span class="info-box-number">{{$customer}}</span>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </div>
    <!-- /.col -->
</div>

@if (Auth::user()->role_id == 1)
<div class="row">
    <div class="col-md-6">
        <div class="card bg-gradient-info">
            <div class="card-header">
                <h5 class="card-title">Recap Bulanan Delivery Order</h5>

                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-tool" data-card-widget="remove">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <p class="text-center">
                            <strong id="date_monthly"></strong>
                        </p>

                        <div class="chart">
                            <!-- Sales Chart Canvas -->
                            <canvas id="salesChart" height="180" style="height: 180px;"></canvas>
                        </div>
                        <!-- /.chart-responsive -->
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </div>
        </div>
        <!-- /.card -->
    </div>
    <!-- /.col -->
    <div class="col-md-6">
        <div class="card bg-gradient-primary">
            <div class="card-header">
                <h5 class="card-title">Recap Bulanan Sales Order</h5>

                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-tool" data-card-widget="remove">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <p class="text-center">
                            <strong id="date_monthly_so"></strong>
                        </p>

                        <div class="chart">
                            <!-- Sales Chart Canvas -->
                            <canvas id="so_chart" height="180" style="height: 180px;"></canvas>
                        </div>
                        <!-- /.chart-responsive -->
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </div>
        </div>
        <!-- /.card -->
    </div>
    <!-- /.col -->
</div>
<!-- /.row -->

<!-- /.row -->
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header border-0">
                <div class="d-flex justify-content-between">
                    <h3 class="card-title">Agen Sales Transaction</h3>
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
                    <canvas id="sales-chart1" height="200"></canvas>
                </div>

                <div class="d-flex flex-row justify-content-end">
                    <span class="mr-2">
                        <i class="fas fa-square text-primary"></i> Total Transaction
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header border-0">
                <div class="d-flex justify-content-between">
                    <h3 class="card-title">Agen Sales Transaction</h3>
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
                    <canvas id="sales-chart2" height="200"></canvas>
                </div>

                <div class="d-flex flex-row justify-content-end">
                    <span class="mr-2">
                        <i class="fas fa-square text-primary"></i> Total Transaction
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Main row -->
<div class="row">
    <!-- Left col -->
    <div class="col-md-8">
        <!-- TABLE: LATEST ORDERS -->
        <div class="card">
            <div class="card-header border-transparent">
                <h3 class="card-title">Delivery Order Terbaru</h3>

                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-tool" data-card-widget="remove">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table m-0">
                        <thead>
                            <tr>
                                <th>No Deliver Order</th>
                                <th>Produk</th>
                                <th>Customer</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($new_do as $delivery_order)
                            <tr>
                                <td><a
                                        href="{{route('deliveryorder.agen.show',$delivery_order->id)}}">{{$delivery_order->delivery_order_number}}</a>
                                </td>
                                <td>{{$delivery_order->product}}</td>
                                <td><a
                                        href="{{route('customer.agen.show',$delivery_order->sales_order->customer->id)}}">{{$delivery_order->sales_order->customer->name}}</a>
                                </td>
                                <td>
                                    @if ($delivery_order->status == 0)
                                    <span class="badge badge-warning"></i> Belum Dikirim </span>
                                    @elseif($delivery_order->status == 1)
                                    <span class="badge badge-info"></i> Sedang Dikirim</span>
                                    @else
                                    <span class="badge badge-success"></i> Telah Dikirim</span>
                                    @endif
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- /.table-responsive -->
            </div>
            <!-- /.card-body -->
            <!-- /.card-footer -->
        </div>
        <div class="row">

            <div class="col-md-6">
                <div class="card bg-gradient-success">
                    <div class="card-header border-0">
                        <h3 class="card-title">
                            <i class="far fa-calendar-alt"></i>
                            Kalender
                        </h3>
                        <!-- tools card -->
                        <div class="card-tools">
                            <!-- button with a dropdown -->
                            <button type="button" class="btn btn-success btn-sm" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-success btn-sm" data-card-widget="remove">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                        <!-- /. tools -->
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body pt-0">
                        <!--The calendar -->
                        <div id="calendar" style="width: 100%"></div>
                    </div>
                    <!-- /.card-body -->
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Jalur Pengiriman Delivery Order</h3>

                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i
                                    class="fas fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-tool" data-card-widget="remove"><i
                                    class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-8">
                                <div class="chart-responsive">
                                    <canvas id="pieChart" height="150"></canvas>
                                </div>
                                <!-- ./chart-responsive -->
                            </div>
                            <!-- /.col -->
                            <div class="col-md-4">
                                <ul class="chart-legend clearfix">
                                    <li><i class="far fa-circle text-danger"></i> Jalur Darat</li>
                                    <li><i class="far fa-circle text-success"></i> Jalur Laut</li>
                                    <li><i class="far fa-circle text-warning"></i> Jalur Darat / Laut</li>
                                </ul>
                            </div>
                            <!-- /.col -->
                        </div>
                        <!-- /.row -->
                    </div>
                </div>
            </div>
            <!-- /.card -->
            <div class="col-md-12">
                <!-- USERS LIST -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Top 8 Reward Customer</h3>

                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i
                                    class="fas fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-tool" data-card-widget="remove"><i
                                    class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body p-0">
                        <ul class="users-list clearfix">
                            @foreach ($top10customer as $customer)
                            <li>
                                <img src="{{asset('uploads/'.$customer->logo)}}" alt="User Image" width="125">
                                <a class="users-list-name" href="{{route('customer.agen.show',$customer->id)}}">{{$customer->name}}</a>
                                <span class="users-list-date">{{$customer->reward}}</span>
                            </li>
                            @endforeach
                        </ul>
                        <!-- /.users-list -->
                    </div>
                    <!-- /.card-body -->
                    <!-- /.card-footer -->
                </div>
                <!--/.card -->
            </div>
            <!-- /.col -->
        </div>
    </div>
    <!-- /.col -->
    <div class="col-md-4">
        <!-- Info Boxes Style 2 -->
        <div class="info-box mb-3 bg-warning">
            <span class="info-box-icon"><i class="fas fa-store"></i></span>

            <div class="info-box-content">
                <span class="info-box-text">Agen</span>
                <span class="info-box-number">{{$agen}}</span>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
        <div class="info-box mb-3 bg-success">
            <span class="info-box-icon"><i class="fas fa-truck-pickup"></i></span>

            <div class="info-box-content">
                <span class="info-box-text">Driver</span>
                <span class="info-box-number">{{$driver}}</span>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
        <div class="info-box mb-3 bg-danger">
            <span class="info-box-icon"><i class="fas fa-shopping-cart"></i></span>

            <div class="info-box-content">
                <span class="info-box-text">Sales Order</span>
                <span class="info-box-number">{{$sales_order}}</span>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
        <div class="info-box mb-3 bg-info">
            <span class="info-box-icon"><i class="fas fa-sticky-note"></i></span>

            <div class="info-box-content">
                <span class="info-box-text">Delivery Order</span>
                <span class="info-box-number">{{$delivery_orders}}</span>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->

        <!-- PRODUCT LIST -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Promo Terbaru</h3>

                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-tool" data-card-widget="remove">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body p-0">
                <ul class="products-list product-list-in-card pl-2 pr-2">
                    <!-- /.item -->
                    @foreach ($new_promo as $promo)
                    <li class="item">
                        <div class="product-img">
                            <img src="{{asset('/uploads/'.$promo->image)}}" alt="Product Image" class="img-size-50">
                        </div>
                        <div class="product-info">
                            <a href="{{route('promo.show',$promo->id)}}" class="product-title">{{$promo->name}}
                                <span class="badge badge-success float-right">{{$promo->point}} Poin</span></a>
                            <span class="product-description">
                                {{$promo->description}}
                            </span>
                        </div>
                    </li>
                    <!-- /.item -->
                    @endforeach
                </ul>
            </div>
            <!-- /.card-body -->
            <div class="card-footer text-center">
                <a href="{{route('promo.index')}}" class="uppercase">Lihat Semua Promo</a>
            </div>
            <!-- /.card-footer -->
        </div>
        <!-- /.card -->
    </div>

    <!-- /.col -->


</div>
@endif
<!-- /.row -->
@endsection

@push('script')
<!-- ChartJS -->
<script src="{{asset('plugins/chart.js/Chart.min.js')}}"></script>
<script src="https://cdn.jsdelivr.net/npm/hammerjs@2.0.8"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-zoom@0.7.7"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="{{asset('plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js')}}"></script>
<script>
    $(function () {
        'use strict'

        var ticksStyle = {
            fontColor: '#495057',
            fontStyle: 'bold'
        }

        var mode = 'index'
        var intersect = true

        let url = "{{ route('home.chart1') }}"
        $.ajax({
            type: 'get',
            url: url,
            success: function (data) {
                var $salesChart = $('#sales-chart1')
                var salesChart = new Chart($salesChart, {
                    type: 'bar',
                    data: {
                        labels: data.label,
                        datasets: [{
                            backgroundColor: '#007bff',
                            borderColor: '#007bff',
                            data: data.transaction
                        }]
                    },
                    options: {
                        // Container for zoom options
                        zoom: {
                            // Boolean to enable zooming
                            enabled: true,

                            // Zooming directions. Remove the appropriate direction to disable
                            // Eg. 'y' would only allow zooming in the y direction
                            mode: 'x',
                        },
                        maintainAspectRatio: false,
                        tooltips: {
                            mode: mode,
                            intersect: intersect
                        },
                        hover: {
                            mode: mode,
                            intersect: intersect
                        },
                        legend: {
                            display: false
                        },
                        scales: {
                            yAxes: [{
                                // display: false,
                                gridLines: {
                                    display: true,
                                    lineWidth: '4px',
                                    color: 'rgba(0, 0, 0, .2)',
                                    zeroLineColor: 'transparent'
                                },
                                ticks: $.extend({
                                    beginAtZero: true,

                                    // Include a dollar sign in the ticks
                                    callback: function (value, index,
                                        values) {
                                        if (value >= 1000) {
                                            value /= 1000
                                            value += ' KL'
                                        }
                                        return value
                                    }
                                }, ticksStyle)
                            }],
                            xAxes: [{
                                display: true,
                                gridLines: {
                                    display: false
                                },
                                ticks: ticksStyle
                            }]
                        }
                    }
                })
            }
        });

        //-----------------------
        //- MONTHLY DO CHART -
        //-----------------------

        // Get context with jQuery - using jQuery's .get() method.
        var salesChartCanvas = $('#salesChart').get(0).getContext('2d')
        let url_monthly = "{{ route('home.chart_monthly') }}"
        $.ajax({
            type: 'get',
            url: url_monthly,
            success: function (data) {
                $('#date_monthly').html("Delivery Order: " + data.datefrom);
                var salesChartData = {
                    labels: data.label,
                    datasets: [{
                        label: 'Delivery Order',
                        fill: false,
                        borderWidth: 2,
                        lineTension: 0,
                        spanGaps: true,
                        borderColor: '#efefef',
                        pointRadius: 3,
                        pointHoverRadius: 7,
                        pointColor: '#efefef',
                        pointBackgroundColor: '#efefef',
                        data: data.transaction
                    }]
                }

                var salesChartOptions = {
                    maintainAspectRatio: false,
                    responsive: true,
                    legend: {
                        display: false,
                    },
                    scales: {
                        xAxes: [{
                            ticks: {
                                fontColor: '#efefef',
                            },
                            gridLines: {
                                display: false,
                                color: '#efefef',
                                drawBorder: false,
                            }
                        }],
                        yAxes: [{
                            ticks: {
                                stepSize: 5000,
                                fontColor: '#efefef',
                            },
                            gridLines: {
                                display: true,
                                color: '#efefef',
                                drawBorder: false,
                            }
                        }]
                    }
                }

                // This will get the first returned node in the jQuery collection.
                var salesChart = new Chart(salesChartCanvas, {
                    type: 'line',
                    data: salesChartData,
                    options: salesChartOptions
                })
            }
        });
        //---------------------------
        //- END MONTHLY DO CHART -
        //---------------------------
         //-----------------------
        //- MONTHLY SO CHART -
        //-----------------------

        // Get context with jQuery - using jQuery's .get() method.
        var salesChartCanvas_so = $('#so_chart').get(0).getContext('2d')
        let url_monthly_so = "{{ route('home.chart_so_monthly') }}"
        $.ajax({
            type: 'get',
            url: url_monthly_so,
            success: function (data) {
                $('#date_monthly_so').html("Sales Order: " + data.datefrom);
                var salesChartData = {
                    labels: data.label,
                    datasets: [{
                        label: 'Sales Order',
                        fill: false,
                        borderWidth: 2,
                        lineTension: 0,
                        spanGaps: true,
                        borderColor: '#efefef',
                        pointRadius: 3,
                        pointHoverRadius: 7,
                        pointColor: '#efefef',
                        pointBackgroundColor: '#efefef',
                        data: data.transaction
                    }]
                }

                var salesChartOptions = {
                    maintainAspectRatio: false,
                    responsive: true,
                    legend: {
                        display: false,
                    },
                    scales: {
                        xAxes: [{
                            ticks: {
                                fontColor: '#efefef',
                            },
                            gridLines: {
                                display: false,
                                color: '#efefef',
                                drawBorder: false,
                            }
                        }],
                        yAxes: [{
                            ticks: {
                                stepSize: 5000,
                                fontColor: '#efefef',
                            },
                            gridLines: {
                                display: true,
                                color: '#efefef',
                                drawBorder: false,
                            }
                        }]
                    }
                }

                // This will get the first returned node in the jQuery collection.
                var salesChart = new Chart(salesChartCanvas_so, {
                    type: 'line',
                    data: salesChartData,
                    options: salesChartOptions
                })
            }
        });
        //---------------------------
        //- END MONTHLY SALES CHART -
        //---------------------------
        // The Calender
        $('#calendar').datetimepicker({
            format: 'L',
            inline: true
        })

        //-------------
        //- PIE CHART -
        //-------------
        // Get context with jQuery - using jQuery's .get() method.
        var pieChartCanvas = $('#pieChart').get(0).getContext('2d');
        let url_route = "{{ route('home.chart_route') }}"
        $.ajax({
            type: 'get',
            url: url_route,
            success: function (data) {
                var pieData = {
                    labels: [
                        'Jalur darat',
                        'Jalur laut',
                        'Jalur darat / laut'
                    ],
                    datasets: [{
                        data: data.transaction,
                        backgroundColor: ['#f56954', '#00a65a', '#f39c12'],
                    }]
                }
                var pieOptions = {
                    legend: {
                        display: false
                    }
                }
                //Create pie or douhnut chart
                // You can switch between pie and douhnut using the method below.
                var pieChart = new Chart(pieChartCanvas, {
                    type: 'doughnut',
                    data: pieData,
                    options: pieOptions
                })
            }
        });

        //-----------------
        //- END PIE CHART -
        //-----------------

    })

    $(function () {
        'use strict'

        var ticksStyle = {
            fontColor: '#495057',
            fontStyle: 'bold'
        }

        var mode = 'index'
        var intersect = true

        let url = "{{ route('home.chart2') }}"
        $.ajax({
            type: 'get',
            url: url,
            success: function (data) {
                var $salesChart = $('#sales-chart2')
                var salesChart = new Chart($salesChart, {
                    type: 'bar',
                    data: {
                        labels: data.label,
                        datasets: [{
                            backgroundColor: '#007bff',
                            borderColor: '#007bff',
                            data: data.transaction
                        }]
                    },
                    options: {
                        // Container for zoom options
                        zoom: {
                            // Boolean to enable zooming
                            enabled: true,

                            // Zooming directions. Remove the appropriate direction to disable
                            // Eg. 'y' would only allow zooming in the y direction
                            mode: 'x',
                        },
                        maintainAspectRatio: false,
                        tooltips: {
                            mode: mode,
                            intersect: intersect
                        },
                        hover: {
                            mode: mode,
                            intersect: intersect
                        },
                        legend: {
                            display: false
                        },
                        scales: {
                            yAxes: [{
                                // display: false,
                                gridLines: {
                                    display: true,
                                    lineWidth: '4px',
                                    color: 'rgba(0, 0, 0, .2)',
                                    zeroLineColor: 'transparent'
                                },
                                ticks: $.extend({
                                    beginAtZero: true,

                                    // Include a dollar sign in the ticks
                                    callback: function (value, index,
                                        values) {
                                        if (value >= 1000) {
                                            value /= 1000
                                            value += ' KL'
                                        }
                                        return value
                                    }
                                }, ticksStyle)
                            }],
                            xAxes: [{
                                display: true,
                                gridLines: {
                                    display: false
                                },
                                ticks: ticksStyle
                            }]
                        }
                    }
                })
            }
        })

    })

</script>
@endpush
