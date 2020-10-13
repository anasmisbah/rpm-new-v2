@extends('layouts.master')
@section('content-header')
<div class="row mb-2">
    <div class="col-sm-6">
      <h1 class="m-0 text-dark">Agen</h1>
    </div><!-- /.col -->
    <div class="col-sm-6">
      <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="{{route('home.index')}}">Beranda</a></li>
        <li class="breadcrumb-item"><a href="{{route('agen.index')}}">Agen</a></li>
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
          <h3 class="card-title">Agen Detail</h3>
          <div class="card-tools">
            <ul class="nav nav-pills ml-auto">
              <li class="nav-item">
                <a class="nav-link btn-danger active" href="{{ route('agen.index') }}"><i class=" fas fa-times"></i></a>
              </li>
            </ul>
          </div>
        </div>
        <div class="card-body">
          <table class="table table-striped">
            <tbody>
                <tr>
                    <td style="width:15%">Logo</td>
                    <td><img class="img-thumbnail" width="150px" src="{{asset("/uploads/".$agen->logo)}}" alt=""></td>
                </tr>
                <tr>
                    <td style="width:15%">No Agen</td>
                    <td>{{$agen->no_agen}}</td>
                  </tr>
              <tr>
                <td style="width:15%">Nama</td>
                <td>{{$agen->name}}</td>
              </tr>
              <tr>
                <td style="width:15%">NPWP</td>
                <td>{{$agen->npwp}}</td>
              </tr>
              <tr>
                <td style="width:15%">Alamat</td>
                <td>{{$agen->address}}</td>
              </tr>
              <tr>
                <td style="width:15%">Nomor Telepon</td>
                <td>{{$agen->phone}}</td>
              </tr>
              <tr>
                <td style="width:15%">Website</td>
                <td>{{$agen->website}}</td>
              </tr>
              <tr>
                <td style="width:15%" class="text-bold">Akun Pengguna</td>
                <td></td>
              </tr>
              <tr>
                <td style="width:15%">Email Pengguna</td>
                <td>{{$agen->user->email}}</td>
              </tr>
              <tr>
                <td style="width:15%">Password Pengguna</td>
                <td>*********</td>
              </tr>
            </tbody>
          </table>
        </div>
        <div class="card-footer text-right">
          <span style="font-size: 14px">
            <strong>Dibuat pada: </strong>{{$agen->created_at->dayName." | ".$agen->created_at->day." ".$agen->created_at->monthName." ".$agen->created_at->year}} | {{$agen->created_at->format('H:i:s')}} / <strong>Diubah pada: </strong>{{  $agen->updated_at->dayName." | ".$agen->updated_at->day." ".$agen->updated_at->monthName." ".$agen->updated_at->year}} | {{$agen->updated_at->format('H:i:s')}}
          </span>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
