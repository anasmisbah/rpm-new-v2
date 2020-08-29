@extends('layouts.master')
@section('content-header')
<div class="row mb-2">
    <div class="col-sm-6">
      <h1 class="m-0 text-dark">Berita</h1>
    </div><!-- /.col -->
    <div class="col-sm-6">
      <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="{{route('home.index')}}">Beranda</a></li>
        <li class="breadcrumb-item"><a href="{{route('news.index')}}">Berita</a></li>
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
          <h3 class="card-title">Detail Berita</h3>
          <div class="card-tools">
            <ul class="nav nav-pills ml-auto">
              <li class="nav-item">
                <a class="nav-link btn-danger active" href="{{ route('news.index') }}"><i class=" fas fa-times"></i></a>
              </li>
            </ul>
          </div>
        </div>
        <div class="card-body">
          <table class="table table-striped">
            <tbody>
              <tr>
                <td style="width:10%">Judul</td>
                <td>{{$news->title}}</td>
              </tr>
              <tr>
                <td style="width:10%">Gambar/Sampul</td>
                <td><img class="img-thumbnail" width="150px" src="{{asset("/uploads/".$news->image)}}" alt=""></td>
              </tr>
              <tr>
                <td style="width:10%">Kategori</td>
                <td>
                    @foreach ($news->category as $item)
                        <small class="badge badge-info"><i class="fas fa-tag"></i> {{$item->name}}</small>
                    @endforeach
                </td>
              </tr>
              <tr>
                <td style="width:10%">Deskripsi</td>
                <td>{!!$news->description!!}</td>
              </tr>

            </tbody>
          </table>
        </div>
        <div class="card-footer text-right">
          <span style="font-size: 14px">
            <strong>Dibuat pada: </strong>{{$news->created_at->dayName." | ".$news->created_at->day." ".$news->created_at->monthName." ".$news->created_at->year}} | {{$news->created_at->format('H:i:s')}} / <strong>Diubah pada: </strong>{{  $news->updated_at->dayName." | ".$news->updated_at->day." ".$news->updated_at->monthName." ".$news->updated_at->year}} | {{$news->updated_at->format('H:i:s')}}
          </span>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
