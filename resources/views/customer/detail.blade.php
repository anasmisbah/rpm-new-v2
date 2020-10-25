@extends('layouts.master')
@section('content-header')
<div class="row mb-2">
    <div class="col-sm-6">
      <h1 class="m-0 text-dark">Agen {{$agen->name}}</h1>
    </div><!-- /.col -->
    <div class="col-sm-6">
      <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="{{route('home.index')}}">Beranda</a></li>
        <li class="breadcrumb-item"><a href="{{route('agen.index')}}">Agen</a></li>
        <li class="breadcrumb-item"><a href="{{route('customer.agen.index',$agen->id)}}">Customer</a></li>
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
          <h3 class="card-title">Detail Customer Agen {{$agen->name}}</h3>
          <div class="card-tools">
            <ul class="nav nav-pills ml-auto">
              <li class="nav-item">
                <a class="nav-link btn-danger active" href="{{ route('customer.agen.index',$agen->id) }}"><i class=" fas fa-times"></i></a>
              </li>
            </ul>
          </div>
        </div>
        <div class="card-body">
          <table class="table table-striped">
            <tbody>
                <tr>
                    <td style="width:15%">Logo</td>
                    <td><img class="img-thumbnail" width="150px" src="{{asset("/uploads/".$customer->logo)}}" alt=""></td>
                </tr>
              <tr>
                <td style="width:15%">Nama</td>
                <td>{{$customer->name}}</td>
              </tr>
              <tr>
                <td style="width:15%">Tipe Member</td>
                <td>
                    <small class="badge badge-info"><i class="fas fa-tag"></i> {{$customer->card->name}}</small>
                </td>
              </tr>
              <tr>
                <td style="width:15%">NPWP</td>
                <td>{{$customer->npwp}}</td>
              </tr>
              <tr>
                <td style="width:15%">Alamat</td>
                <td>{{$customer->address}}</td>
              </tr>
              <tr>
                <td style="width:15%">Nomor Telepon</td>
                <td>{{$customer->phone}}</td>
              </tr>
              <tr>
                <td style="width:15%">Website</td>
                <td>{{$customer->website}}</td>
              </tr>
              <tr>
                <td style="width:15%" class="text-bold">Akun Pengguna</td>
                <td></td>
              </tr>
              <tr>
                <td style="width:15%">Email Pengguna</td>
                <td>{{$customer->user->email}}</td>
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
            <strong>Dibuat pada: </strong>{{$customer->created_at->dayName." | ".$customer->created_at->day." ".$customer->created_at->monthName." ".$customer->created_at->year}} | {{$customer->created_at->format('H:i:s')}} / <strong>Diubah pada: </strong>{{  $customer->updated_at->dayName." | ".$customer->updated_at->day." ".$customer->updated_at->monthName." ".$customer->updated_at->year}} | {{$customer->updated_at->format('H:i:s')}}
          </span>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
