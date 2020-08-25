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
        <li class="breadcrumb-item active">Customer</li>
      </ol>
    </div><!-- /.col -->
  </div><!-- /.row -->
@endsection
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
              <h3 class="card-title">Data Customer Agen {{ $agen->name }}</h3>
              <div class="card-tools">
                <ul class="nav nav-pills ml-auto">
                  <li class="nav-item mr-1">
                    <a class="btn btn-primary" href="{{route('customer.agen.create',$agen->id)}}"><i class="fas fa-plus"></i></a>
                  </li>
                  <li class="nav-item">
                    <a class="btn btn-danger" href="{{ route('agen.index') }}"><i class=" fas fa-times"></i></a>
                  </li>
                </ul>
              </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <table style="width:100%" id="example1" class="table table-bordered table-striped dt-responsive nowrap">
                <thead>
                <tr>
                  <th>No</th>
                  <th>Nama</th>
                  <th>Tipe Member</th>
                  <th>Reward</th>
                  <th>Alamat</th>
                  <th>Logo</th>
                  <th>Aksi</th>
                </tr>
                </thead>
                <tbody>
                  @foreach ($agen->customers as $customer)
                  <tr>
                    <td>{{$loop->iteration}}</td>
                    <td>{{$customer->name}}</td>
                    <td>
                        @if ($customer->member == 'silver')
                        <small class="badge badge-info"> {{$customer->member}}</small>
                        @elseif($customer->member == 'gold')
                        <small class="badge badge-warning"> {{$customer->member}}</small>
                        @else
                        <small class="badge badge-danger"> {{$customer->member}}</small>
                        @endif
                    </td>
                    <td>{{$customer->reward}}</td>
                    <td>{{$customer->address}}</td>
                    <td><img class="img-thumbnail" width="50px" src="{{asset("/uploads/".$customer->logo)}}" alt=""></td>
                    <td>
                        <a data-toggle="tooltip" data-placement="top" title="Edit" href="{{route('customer.agen.edit',$customer->id)}}" class="btn btn-warning btn-sm">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form class="d-inline"
                            onsubmit="return confirm('Apakah anda ingin menghapus customers secara permanen?')"
                            action="{{route('customer.agen.destroy',$customer->id)}}"
                            method="POST">
                                @csrf
                                @method('DELETE')
                                <button data-toggle="tooltip" data-placement="top" title="Delete" type="submit" class="btn btn-danger btn-sm">
                                    <i class="fas fa-trash"></i></button>
                        </form>
                        <a data-toggle="tooltip" data-placement="top" title="Detail"  href="{{route('customer.agen.show',$customer->id)}}" class="btn btn-info btn-sm">
                            <i class="fas fa-eye"></i>
                        </a>
                        <a data-toggle="tooltip" data-placement="top" title="Coupon" href="{{route('customer.coupon.index',$customer->id)}}" class="btn btn-info btn-sm">
                            <i class="fas fa-credit-card"></i>
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
