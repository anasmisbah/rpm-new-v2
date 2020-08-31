@extends('layouts.master')
@section('content-header')
<div class="row mb-2">
    <div class="col-sm-6">
      <h1 class="m-0 text-dark">Profile Perusahaan {{$company->name}}</h1>
    </div><!-- /.col -->
    <div class="col-sm-6">
      <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="{{route('home.index')}}">Beranda</a></li>
        <li class="breadcrumb-item">Profile Perusahaan</li>
      </ol>
    </div><!-- /.col -->
  </div><!-- /.row -->
@endsection
@section('content')
<div class="container-fluid">
  <div class="row">
    <!-- left column -->
    <div class="col-md-12">
      <!-- general form elements -->
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">Profile Perusahaan {{$company->name}}</h3>
          <div class="card-tools">
            <ul class="nav nav-pills ml-auto">
              <li class="nav-item">
                <a class="nav-link btn-warning active" href="{{ route('company.edit') }}"><i class=" fas fa-edit"></i></a>
              </li>
            </ul>
          </div>
        </div>
        <div class="card-body">
          <table class="table table-striped">
            <tbody>
                <tr>
                    <td style="width:10%">Nama</td>
                    <td> <strong>{{$company->name}}</strong></td>
                </tr>
                <tr>
                    <td style="width:10%">Deksripsi</td>
                    <td>{{$company->description}}</td>
                </tr>
                <tr>
                    <td style="width:10%">Email</td>
                    <td>{{$company->email}}</td>
                </tr>
                <tr>
                    <td style="width:15%">Nomor Telepon</td>
                    <td>{{$company->phone}}</td>
                </tr>
                <tr>
                    <td style="width:10%">Website</td>
                    <td>{{$company->website}}</td>
                </tr>
                <tr>
                    <td style="width:10%">Unduh</td>
                    <td><a href="{{route('company.profile.download')}}" class="btn btn-info btn-sm">Unduh Profile</a></td>
                </tr>
            </tbody>
          </table>
        </div>
        <div class="card-footer text-right">
          <span style="font-size: 14px">
            <strong>Dibuat pada: </strong>{{$company->created_at->dayName." | ".$company->created_at->day." ".$company->created_at->monthName." ".$company->created_at->year}} | {{$company->created_at->format('H:i:s')}} / <strong>Diubah pada: </strong>{{  $company->updated_at->dayName." | ".$company->updated_at->day." ".$company->updated_at->monthName." ".$company->updated_at->year}} | {{$company->updated_at->format('H:i:s')}}
          </span>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
@push('script')
<!-- SweetAlert2 -->
<script src="{{asset('plugins/sweetalert2/sweetalert2.min.js')}}"></script>
<script>
    $(function() {
        const status = '{{ session("status") }}'
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
