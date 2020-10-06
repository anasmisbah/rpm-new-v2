@extends('layouts.master')

@push('css')
<meta name="url_data" content="{{ route('ajax.data.promo') }}">
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
                {data: 'id', name: 'id'},
                {data: 'name', name: 'name'},
                {data: 'point', name: 'point'},
                {data: 'total', name: 'total'},
                {data: 'status', name: 'status'},
                {data: 'aksi', name: 'aksi', searchable: false},
            ],
            columnDefs:[
                {
                    targets: 4,
					title: 'Status',
					render: function(data, type, full, meta) {
                        var status = {
							'hot': {
                                'title': 'Hot',
                                'class': ' badge-danger'
                            },
							'normal': {
                                'title': 'Normal',
                                'class': ' badge-info'
                            }
						};
						return '<small class="badge' + status[full.status].class + '">' + status[full.status].title + '</small>';
                    }
                },
                {
                    targets: 5,
					title: 'Aksi',
                    orderable: false,
					render: function(data, type, full, meta) {
                        var output =`
                                    <a href="${full.url_edit}" class="btn btn-warning btn-sm">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="javascript:;" data-action="${full.url_delete}" class="btn btn-sm btn-danger btn-delete">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                    <a href="${full.url_detail}" class="btn btn-info btn-sm">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    `;
                        return output;

                    }
                }
            ]
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
