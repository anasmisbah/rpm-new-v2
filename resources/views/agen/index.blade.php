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
      <h1 class="m-0 text-dark">Agen</h1>
    </div><!-- /.col -->
    <div class="col-sm-6">
      <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="{{route('home.index')}}">Beranda</a></li>
        <li class="breadcrumb-item active">Agen</li>
      </ol>
    </div><!-- /.col -->
  </div><!-- /.row -->
@endsection
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
              <h3 class="card-title">Data Agen</h3>
              <div class="card-tools">
                <ul class="nav nav-pills ml-auto">
                  <li class="nav-item">
                    <a class="nav-link active" href="{{route('agen.create')}}"><i class="fas fa-plus"></i></a>
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
                  <th>NPWP</th>
                  <th>Member</th>
                  <th>Logo</th>
                  <th class="text-center">Aksi</th>
                </tr>
                </thead>
                <tbody>
                  @foreach ($agens as $agen)
                  <tr>
                    <td>{{$loop->iteration}}</td>
                    <td>{{$agen->name}}</td>
                    <td>{{$agen->npwp}}</td>
                    <td><small class="badge badge-info">{{$agen->card->name}}</small></td>
                    <td><img class="img-thumbnail" width="50px" src="{{asset("/uploads/".$agen->logo)}}" alt=""></td>
                    <td class="text-center">
                        <a data-toggle="tooltip" data-placement="top" title="Customer" href="{{route('customer.agen.index',$agen->id)}}" class="btn btn-primary btn-sm">
                            <i class="fa fa-users"></i>
                        </a>
                        <a data-toggle="tooltip" data-placement="top" title="Driver" href="{{route('driver.agen.index',$agen->id)}}" class="btn btn-primary btn-sm">
                            <i class="fa fa-truck-moving"></i>
                        </a>
                        <a data-toggle="tooltip" data-placement="top" title="Sales Order" href="{{route('salesorder.agen.index',$agen->id)}}" class="btn btn-info btn-sm">
                            <i class="fas fa-chart-pie"></i>
                        </a>
                        <a data-toggle="tooltip" data-placement="top" title="Edit" href="{{route('agen.edit',$agen->id)}}" class="btn btn-warning btn-sm">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form class="d-inline"
                            onsubmit="return confirm('Apakah anda ingin menghapus agens secara permanen?')"
                            action="{{route('agen.destroy',$agen->id)}}"
                            method="POST">
                                @csrf
                                @method('DELETE')
                                <button data-toggle="tooltip" data-placement="top" title="Delete" type="submit" class="btn btn-danger btn-sm">
                                    <i class="fas fa-trash"></i></button>
                        </form>
                        <a data-toggle="tooltip" data-placement="top" title="Detail"  href="{{route('agen.show',$agen->id)}}" class="btn btn-info btn-sm">
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
