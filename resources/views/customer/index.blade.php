@extends('layouts.master')

@push('css')
<meta name="url_data" content="{{ route('ajax.data.customer.agen',$agen->id) }}">
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
                  <th>Coupon</th>
                  <th>Logo</th>
                  <th>Aksi</th>
                </tr>
                </thead>
                <tbody>

                </tbody>
              </table>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
    </div>
</div>
<form class="d-inline" id="form-delete" style="display: none" action="" method="POST">
    @csrf
    @method('DELETE')
</form>
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
        let url = $('meta[name="url_data"]').attr('content');
      $("#example1").DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: url,
                data: function (d) {
                    d.keyword = $('input[name=keyword]').val();
                }
            },
            order:[[0,'asc']],
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex',orderable: false,searchable: false},
                {data: 'name', name: 'name'},
                {data: 'member', name: 'member'},
                {data: 'reward', name: 'reward'},
                {data: 'coupon', name: 'coupon'},
                {data: 'logo', name: 'logo',orderable: false,searchable: false},
                {data: 'aksi', name: 'aksi', searchable: false},
            ],
            columnDefs:[
                {
                    targets: 2,
					title: 'Tipe Member',
					render: function(data, type, full, meta) {
						return '<small class="badge badge-info">' + full.member + '</small>';
                    }
                },
                {
                    targets: 5,
					title: 'Logo',
					render: function(data, type, full, meta) {
                        console.log(meta);
                        return '<img class="img-thumbnail" width="100px" src="'+full.logo+'" alt="">';

                    }
                },
                {
                    targets: 6,
					title: 'Aksi',
                    orderable: false,
					render: function(data, type, full, meta) {
                        var output =`
                                    <a href="${full.url_edit}" class="btn btn-warning btn-sm" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="javascript:;" data-action="${full.url_delete}" title="Delete" class="btn btn-sm btn-danger btn-delete">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                    <a href="${full.url_detail}" title="Detail" class="btn btn-info btn-sm">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    `;
                        return output;

                    }
                }
            ],
            drawCallback: function( row, data, dataIndex ) {
                $('.btn').tooltip({ boundary: 'window' })
            }
        });

      $(document).on('click','.btn-delete',function(e){
            e.preventDefault()
            let action = $(this).data('action')

            let form = $('#form-delete')
            form.attr('action',action)

            Swal.fire({
                title: "Apakah anda yakin ingin menghapus?",
                text: "Anda tidak dapat mengembalikan data setelah dihapus",
                type: "warning",
                showCancelButton: true,
                confirmButtonText: "Iya, Hapus",
                cancelButtonText : "Tidak"
            }).then(function(result) {
                if (result.value) {
                    form.submit()
                }
            });
        });
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
