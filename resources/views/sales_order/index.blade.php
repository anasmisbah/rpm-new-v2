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
        <li class="breadcrumb-item active">Sales Order</li>
      </ol>
    </div><!-- /.col -->
  </div><!-- /.row -->
@endsection
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
              <h3 class="card-title">Data Sales Order Agen {{ $agen->name }}</h3>
              <div class="card-tools">
                <ul class="nav nav-pills ml-auto">
                  <li class="nav-item">
                    <a class="btn btn-primary mr-1" href="{{route('salesorder.agen.create',$agen->id)}}"><i class="fas fa-plus"></i></a>
                  </li>
                  <li class="nav-item">
                    <a class="btn btn-danger" href="{{ route('agen.index') }}"><i class=" fas fa-times"></i></a>
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
                  <th>Nomor Sales Order</th>
                  <th>Dibuat Pada</th>
                  <th>Aksi</th>
                </tr>
                </thead>
                <tbody>
                  @foreach ($agen->sales_orders as $sales_order)
                  <tr>
                    <td>{{$loop->iteration}}</td>
                    <td>{{$sales_order->sales_order_number}}</td>
                    <td>{{$sales_order->created_at->format('l, d F Y')}}  {{$agen->created_at->format('h:i:s A')}}</td>
                    <td>
                        <a href="{{route('salesorder.agen.edit',$sales_order->id)}}" data-placement="top" title="Edit" class="btn btn-warning btn-sm">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form class="d-inline"
                            onsubmit="return confirm('Apakah anda ingin menghapus sales orders secara permanen?')"
                            action="{{route('salesorder.agen.destroy',$sales_order->id)}}"
                            method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" data-placement="top" title="Delete" class="btn btn-danger btn-sm">
                                    <i class="fas fa-trash"></i></button>
                        </form>
                        <a href="{{route('salesorder.agen.show',$sales_order->id)}}" data-placement="top" title="Detail" class="btn btn-info btn-sm">
                            <i class="fas fa-eye"></i>
                        </a>
                        <a href="{{route('deliveryorder.agen.index',$sales_order->id)}}" data-placement="top" title="Delivery Order" class="btn btn-success btn-sm">
                            <i class="fas fa-notes-medical"></i>
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
