@extends('layouts.master')

@push('css')
    <!-- DataTables -->
    <link rel="stylesheet" href="{{asset('plugins/datatables-bs4/css/dataTables.bootstrap4.css')}}">
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="{{asset('plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css')}}">
    <link rel="stylesheet" href="{{asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">

@endpush

@section('content-header')
<div class="row mb-2">
    <div class="col-sm-6">
      <h1 class="m-0 text-dark">Agen {{ $agen->name }}</h1>
    </div><!-- /.col -->
    <div class="col-sm-6">
      <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="{{route('home.index')}}">Beranda</a></li>
        <li class="breadcrumb-item"><a href="{{route('agen.index')}}">Agen</a></li>
        <li class="breadcrumb-item"><a href="{{route('salesorder.agen.index',$agen->id)}}">Sales Order</a></li>
        <li class="breadcrumb-item">Delivery Order</li>
      </ol>
    </div><!-- /.col -->
  </div><!-- /.row -->
@endsection
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
              <h3 class="card-title">Data Delivery Order Agen {{ $agen->name }}</h3>
              <div class="card-tools">
                <ul class="nav nav-pills ml-auto">
                  <li class="nav-item">
                    <a class="btn btn-primary mr-1" href="{{route('deliveryorder.agen.create',$agen->id)}}"><i class="fas fa-plus"></i></a>
                  </li>
                  <li class="nav-item">
                    <a class="btn btn-danger" href="{{ route('salesorder.agen.index',$agen->id) }}"><i class=" fas fa-times"></i></a>
                  </li>
                </ul>
              </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <table style="width:100%"  id="example1" class="table table-bordered table-striped dt-responsive nowrap">
                <thead>
                <tr>
                  <th>No</th>
                  <th>Nomor Delivery Order</th>
                  <th>Tanggal Berlaku</th>
                  <th>Dikirim via</th>
                  <th>Status</th>
                  <th>Aksi</th>
                </tr>
                </thead>
                <tbody>
                  @foreach ($sales_order->delivery_orders as $delivery_order)
                  <tr>
                    <td>{{$loop->iteration}}</td>
                    <td>{{$delivery_order->delivery_order_number}}</td>
                    <td>{{$delivery_order->effective_date_start->day." ".$delivery_order->effective_date_start->monthName." ".$delivery_order->effective_date_start->year}} - {{$delivery_order->effective_date_start->day." ".$delivery_order->effective_date_start->monthName." ".$delivery_order->effective_date_start->year}}</td>
                    <td>
                        @if ($delivery_order->shipped_via == 0)
                        <small class="badge badge-warning"></i> Jalur Darat </small>
                        @elseif($delivery_order->shipped_via == 1)
                        <small class="badge badge-info"></i> Jalur Laut</small>
                        @else
                        <small class="badge badge-success"></i> Jalur Darat Atau Jalur Laut</small>
                        @endif
                    </td>
                    <td>
                        @if ($delivery_order->status == 0)
                        <small class="badge badge-warning"></i> Belum Dikirim </small>
                        @elseif($delivery_order->status == 1)
                        <small class="badge badge-info"></i> Sedang Dikirim</small>
                        @else
                        <small class="badge badge-success"></i> Telah Dikirim</small>
                        @endif
                    </td>
                    <td>
                        @if ($delivery_order->status == 0)
                        <a href="{{route('deliveryorder.agen.edit',$delivery_order->id)}}" data-placement="top" title="Edit" class="btn btn-warning btn-sm">
                            <i class="fas fa-edit"></i>
                        </a>
                        @elseif ($delivery_order->status == 2)
                        <a class="btn btn-info btn-sm" href="{{route('deliveryorder.agen.print',$delivery_order->id)}}" data-placement="top" title="Print"><i class="fas fa-print"></i></a>
                        @endif

                        {{-- <form class="d-inline"
                            onsubmit="return confirm('Apakah anda ingin menghapus sales orders secara permanen?')"
                            action="{{route('deliveryorder.agen.destroy',$delivery_order->id)}}"
                            method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" data-placement="top" title="Delete" class="btn btn-danger btn-sm">
                                    <i class="fas fa-trash"></i></button>
                        </form>
                        --}}
                        <a href="{{route('deliveryorder.agen.show',$delivery_order->id)}}" data-placement="top" title="Detail" class="btn btn-info btn-sm">
                            <i class="fas fa-eye"></i>
                        </a>
                    </td>
                  </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
    </div>
</div>
@endsection

@push('script')
<!-- DataTables -->
<script src="{{asset('plugins/datatables/jquery.dataTables.js')}}"></script>
<script src="{{asset('plugins/datatables-bs4/js/dataTables.bootstrap4.js')}}"></script>
<script src="{{asset('plugins/datatables-responsive/js/dataTables.responsive.min.js')}}"></script>
<script src="{{asset('plugins/datatables-responsive/js/responsive.bootstrap4.min.js')}}"></script>

<!-- SweetAlert2 -->
<script src="{{asset('plugins/sweetalert2/sweetalert2.min.js')}}"></script>
<script>
    $(function () {
      $("#example1").DataTable();
      $('.btn').tooltip({ boundary: 'window' })
    });
  </script>
<script>
    $(function() {
        const status = '{{ Session("status") }}'

        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000
        });
        if (status) {
            Toast.fire({
                type: 'success',
                title: status
            })
        }
    });
</script>
@endpush
