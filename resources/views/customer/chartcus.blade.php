@extends('layouts.chart')

@push('css')
<meta name="url_data" content="{{ route('data.customer.chart',$id) }}">
@endpush
@section('content')
<div class="card-header border-0">
    <div class="d-flex justify-content-between">
    <h3 class="card-title">Transaksi Customer</h3>
    </div>
</div>
<div class="card-body">
    <div class="d-flex">
    <p class="d-flex flex-column">
        <span>Total Transaksi (KL)</span>
    </p>
    </div>
    <!-- /.d-flex -->

    <div class="position-relative mb-4">
    <canvas id="sales-chart" height="200"></canvas>
    </div>

    <div class="d-flex flex-row justify-content-end">
    <span class="mr-2">
        <i class="fas fa-square text-primary"></i> Tahun ini
    </span>
    </div>
</div>
@endsection

@push('script')
<!-- ChartJS -->
<script src="{{asset('plugins/chart.js/Chart.min.js')}}"></script>
<script>
    $(function () {
  'use strict'

  var ticksStyle = {
    fontColor: '#495057',
    fontStyle: 'bold'
  }

  var mode      = 'index'
  var intersect = true

    let url = $('meta[name="url_data"]').attr('content');
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
