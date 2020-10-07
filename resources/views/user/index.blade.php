@extends('layouts.master')

@push('css')
<meta name="url_data" content="{{ route('ajax.data.user') }}">
    <!-- DataTables -->
    <link rel="stylesheet" href="{{asset('plugins/datatables-bs4/css/dataTables.bootstrap4.css')}}">
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="{{asset('plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css')}}">
    <link rel="stylesheet" href="{{asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">

@endpush

@section('content-header')
<div class="row mb-2">
    <div class="col-sm-6">
      <h1 class="m-0 text-dark">Pengguna</h1>
    </div><!-- /.col -->
    <div class="col-sm-6">
      <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="{{route('home.index')}}">Beranda</a></li>
        <li class="breadcrumb-item active">Pengguna</li>
      </ol>
    </div><!-- /.col -->
  </div><!-- /.row -->
@endsection
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
              <h3 class="card-title">Data Pengguna</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <table style="width:100%" id="example1" class="table table-bordered table-striped dt-responsive nowrap">
                <thead>
                <tr>
                  <th>No</th>
                  <th>email</th>
                  <th>role</th>
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
@endsection

@push('script')
<!-- DataTables -->
<script src="{{asset('plugins/datatables/jquery.dataTables.js')}}"></script>
<script src="{{asset('plugins/datatables-bs4/js/dataTables.bootstrap4.js')}}"></script>
<!-- SweetAlert2 -->
<script src="{{asset('plugins/sweetalert2/sweetalert2.min.js')}}"></script>
<script src="{{asset('plugins/datatables-responsive/js/dataTables.responsive.min.js')}}"></script>
<script src="{{asset('plugins/datatables-responsive/js/responsive.bootstrap4.min.js')}}"></script>

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
                {data: 'DT_RowIndex', name: 'DT_RowIndex',orderable: false,
                    searchable: false},
                {data: 'email', name: 'email'},
                {data: 'role_id', name: 'role_id'},
                {data: 'aksi', name: 'aksi', searchable: false},
            ],
            columnDefs:[

                {
                    targets: 2,
					title: 'Role',
					render: function(data, type, full, meta) {
                        var role = {
							1: {
                                'title': 'Admin',
                                'class': ' badge-danger'
                            },
							2: {
                                'title': 'Adminsub',
                                'class': ' badge-warning'
                            }
                            ,
							3: {
                                'title': 'Agen',
                                'class': ' badge-success'
                            }
                            ,
							4: {
                                'title': 'Customer',
                                'class': ' badge-info'
                            }
                            ,
							5: {
                                'title': 'Driver',
                                'class': ' badge-primary'
                            }
						};
						return '<small class="badge' + role[full.role_id].class + '">' + role[full.role_id].title + '</small>';
                    }
                },
                {
                    targets: 3,
					title: 'Aksi',
                    orderable: false,
					render: function(data, type, full, meta) {
                        var output =`
                                    <a href="${full.url_detail}" class="btn btn-info btn-sm">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    `;
                        return output;

                    }
                }
            ]
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
