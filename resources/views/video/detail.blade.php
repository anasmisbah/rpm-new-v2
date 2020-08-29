@extends('layouts.master')
@section('content-header')
<div class="row mb-2">
    <div class="col-sm-6">
      <h1 class="m-0 text-dark">Video</h1>
    </div><!-- /.col -->
    <div class="col-sm-6">
      <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="{{route('home.index')}}">Beranda</a></li>
        <li class="breadcrumb-item"><a href="{{route('video.index')}}">Video</a></li>
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
          <h3 class="card-title">Video Detail</h3>
          <div class="card-tools">
            <ul class="nav nav-pills ml-auto">
              <li class="nav-item">
                <a class="nav-link btn-danger active" href="{{ route('video.index') }}"><i class=" fas fa-times"></i></a>
              </li>
            </ul>
          </div>
        </div>
        <div class="card-body">
          <table class="table table-striped">
            <tbody>
              <tr>
                <td style="width:10%">Judul</td>
                <td>{{$video->title}}</td>
              </tr>
              <tr>
                <td style="width:10%">Url</td>
                <td>{{$video->url}}</td>
              </tr>
              <tr>
                <td style="width:10%">Gambar/Sampul</td>
                <td><img class="img-thumbnail" width="500" src="{{asset("/uploads/".$video->image)}}" alt=""></td>
              </tr>
            </tbody>
          </table>
        </div>
        <div class="card-footer text-right">
          <span style="font-size: 14px">
            <strong>Dibuat pada: </strong>{{$video->created_at->dayName." | ".$video->created_at->day." ".$video->created_at->monthName." ".$video->created_at->year}} | {{$video->created_at->format('H:i:s')}} / <strong>Diubah pada: </strong>{{  $video->updated_at->dayName." | ".$video->updated_at->day." ".$video->updated_at->monthName." ".$video->updated_at->year}} | {{$video->updated_at->format('H:i:s')}}
          </span>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
