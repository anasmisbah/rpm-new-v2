@extends('layouts.master')
@section('content-header')
<div class="row mb-2">
    <div class="col-sm-6">
      <h1 class="m-0 text-dark">Administrator</h1>
    </div><!-- /.col -->
    <div class="col-sm-6">
      <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="{{route('home.index')}}">Beranda</a></li>
        <li class="breadcrumb-item"><a href="{{route('admin.index')}}">Administrator</a></li>
        <li class="breadcrumb-item active">Detail</li>
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
          <h3 class="card-title">Detail Administrator</h3>
          <div class="card-tools">
            <ul class="nav nav-pills ml-auto">
              <li class="nav-item">
                <a class="nav-link btn-danger active" href="{{ route('admin.index') }}"><i class=" fas fa-times"></i></a>
              </li>
            </ul>
          </div>
        </div>
        <div class="card-body">
          <table class="table table-striped">
            <tbody>
                <tr>
                    <td style="width:15%">Avatar</td>
                    <td><img class="img-thumbnail" width="150px" src="{{asset("/uploads/".$admin->avatar)}}" alt=""></td>
                </tr>
              <tr>
                <td style="width:15%">Nama</td>
                <td>{{$admin->name}}</td>
              </tr>
              <tr>
                <td style="width:15%">Email</td>
                <td>{{$admin->user->email}}</td>
              </tr>
              <tr>
                <td style="width:15%">Role</td>
                <td>
                    <small class="badge {{$admin->user->role_id == 1?'badge-danger':'badge-info'}}">{{$admin->user->role->name}}</small>
                </td>
              </tr>
              <tr>
                <td style="width:15%">Alamat</td>
                <td>{{$admin->address}}</td>
              </tr>
              <tr>
                <td style="width:15%">Nomor Telepon</td>
                <td>{{$admin->phone}}</td>
              </tr>
            </tbody>
          </table>
        </div>
        <div class="card-footer text-right">
          <span style="font-size: 14px">
            <strong>Dibuat pada: </strong>{{$admin->created_at->dayName." | ".$admin->created_at->day." ".$admin->created_at->monthName." ".$admin->created_at->year}} | {{$admin->created_at->format('H:i:s')}} / <strong>Diubah pada: </strong>{{  $admin->updated_at->dayName." | ".$admin->updated_at->day." ".$admin->updated_at->monthName." ".$admin->updated_at->year}} | {{$admin->updated_at->format('H:i:s')}}
          </span>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
