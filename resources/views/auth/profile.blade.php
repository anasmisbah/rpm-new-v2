@extends('layouts.master')
@push('css')
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="{{asset('plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css')}}">
@endpush
@section('content-header')
<div class="row mb-2">
    <div class="col-sm-6">
      <h1 class="m-0 text-dark">Profile User</h1>
    </div><!-- /.col -->
    <div class="col-sm-6">
      <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="{{route('home.index')}}">Beranda</a></li>
        <li class="breadcrumb-item">Profile User</li>
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
          <h3 class="card-title">Profile User</h3>
        </div>
        <div class="card-body">
          <table class="table table-striped">
            <tbody>
                <tr>
                    <td style="width:15%">Foto Profil</td>
                    <td><img class="img-thumbnail" width="150px" src="{{asset("/uploads/".$user->admin->avatar)}}" alt=""></td>
                </tr>
              <tr>
                <td style="width:15%">Nama</td>
                    <td>{{$user->admin->name}}</td>
              </tr>
              <tr>
                  <td>Role</td>
                  <td><small class="badge {{$user->role->id == 1 || $user->role->id == 2 ?'badge-danger':'badge-info'}}"> {{$user->role->name}}</small></td>
              </tr>
              <tr>
                <td style="width:15%">Email</td>
                <td>{{$user->email}}</td>
              </tr>
              <tr>
                <td style="width:15%">No Telepon</td>
                <td>{{$user->admin->phone}}</td>
              </tr>
              <tr>
                <td style="width:15%">Alamat</td>
                <td>{{$user->admin->address}}</td>
              </tr>
            </tbody>
          </table>
          <a href="{{route('profile.edit')}}" class="btn mt-2 btn-primary float-right" style="width: 78px !important;"><i class="fa fa-edit"></i></a>
        </div>
        <div class="card-footer text-right">
          <span style="font-size: 14px">
            <strong>Dibuat pada: </strong>{{$user->created_at->dayName." | ".$user->created_at->day." ".$user->created_at->monthName." ".$user->created_at->year}} | {{$user->created_at->format('H:i:s')}} / <strong>Diubah pada: </strong>{{  $user->updated_at->dayName." | ".$user->updated_at->day." ".$user->updated_at->monthName." ".$user->updated_at->year}} | {{$user->updated_at->format('H:i:s')}}
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
