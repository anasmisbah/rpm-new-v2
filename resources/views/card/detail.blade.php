@extends('layouts.master')
@section('content-header')
<div class="row mb-2">
    <div class="col-sm-6">
      <h1 class="m-0 text-dark">Kartu Loyalti</h1>
    </div><!-- /.col -->
    <div class="col-sm-6">
      <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="{{route('home.index')}}">Beranda</a></li>
        <li class="breadcrumb-item"><a href="{{route('card.index')}}">Kartu Loyalti</a></li>
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
          <h3 class="card-title">Detail Kartu Loyalti</h3>
          <div class="card-tools">
            <ul class="nav nav-pills ml-auto">
              <li class="nav-item">
                <a class="nav-link btn-danger active" href="{{ route('card.index') }}"><i class=" fas fa-times"></i></a>
              </li>
            </ul>
          </div>
        </div>
        <div class="card-body">
          <table class="table table-striped">
            <tbody>
              <tr>
                <td style="width:10%">Nama</td>
                <td>{{$card->name}}</td>
              </tr>
              <tr>
                <td style="width:10%">Gambar Kartu</td>
                <td><img class="img-thumbnail" width="100px" src="{{asset('uploads/'.$card->image)}}" alt=""></td>
              </tr>
            </tbody>
          </table>
        </div>
        <div class="card-footer text-right">
          <span style="font-size: 14px">
            <strong>Dibuat pada: </strong>{{$card->created_at->dayName." | ".$card->created_at->day." ".$card->created_at->monthName." ".$card->created_at->year}} | {{$card->created_at->format('H:i:s')}} / <strong>Diubah pada: </strong>{{  $card->updated_at->dayName." | ".$card->updated_at->day." ".$card->updated_at->monthName." ".$card->updated_at->year}} | {{$card->updated_at->format('H:i:s')}}
          </span>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
