@extends('layouts.master')

@push('css')
    <!-- DataTables -->
    <link rel="stylesheet" href="{{asset('plugins/datatables-bs4/css/dataTables.bootstrap4.css')}}">
    <link rel="stylesheet" href="{{asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">

@endpush

@section('content-header')
<div class="row mb-2">
    <div class="col-sm-6">
      <h1 class="m-0 text-dark">Promo</h1>
    </div><!-- /.col -->
    <div class="col-sm-6">
      <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="{{route('home.index')}}">Beranda</a></li>
        <li class="breadcrumb-item active">Promo</li>
      </ol>
    </div><!-- /.col -->
  </div><!-- /.row -->
@endsection
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
              <h3 class="card-title">Data Promo</h3>
              <div class="card-tools">
                <ul class="nav nav-pills ml-auto">
                  <li class="nav-item">
                    <a class="nav-link active" href="{{route('promo.create')}}"><i class="fas fa-plus"></i></a>
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
                  <th>Nama</th>
                  <th>Poin</th>
                  <th>Total Promo</th>
                  <th>Tipe Promo</th>
                  <th>Aksi</th>
                </tr>
                </thead>
                <tbody>
                  @foreach ($promos as $promo)
                  <tr>
                    <td>{{$loop->iteration}}</td>
                    <td>{{$promo->name}}</td>
                    <td>{{$promo->point}}</td>
                    <td>{{$promo->total}}</td>
                    <td>
                        <small class="badge {{$promo->status == 'normal'?'badge-info':'badge-danger'}}">{{$promo->status}}</small>
                    </td>
                    <td>
                      <a href="{{route('promo.edit',$promo->id)}}" class="btn btn-warning btn-sm">
                        <i class="fas fa-edit"></i>
                      </a>
                      <form class="d-inline"
                          onsubmit="return confirm('Apakah anda ingin menghapus promo secara permanen?')"
                          action="{{route('promo.destroy',$promo->id)}}"
                          method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">
                                    <i class="fas fa-trash"></i>
                                </button>
                      </form>
                      <a href="{{route('promo.show',$promo->id)}}" class="btn btn-info btn-sm">
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
