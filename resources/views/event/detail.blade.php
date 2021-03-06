@extends('layouts.master')
@section('content-header')
<div class="row mb-2">
    <div class="col-sm-6">
      <h1 class="m-0 text-dark">Event</h1>
    </div><!-- /.col -->
    <div class="col-sm-6">
      <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="{{route('home.index')}}">Beranda</a></li>
        <li class="breadcrumb-item"><a href="{{route('event.index')}}">Event</a></li>
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
          <h3 class="card-title">Detail Event</h3>
          <div class="card-tools">
            <ul class="nav nav-pills ml-auto">
              <li class="nav-item">
                <a class="nav-link btn-danger active" href="{{ route('event.index') }}"><i class=" fas fa-times"></i></a>
              </li>
            </ul>
          </div>
        </div>
        <div class="card-body">
          <table class="table table-striped">
            <tbody>
              <tr>
                <td style="width:10%">Nama</td>
                <td>{{$event->title}}</td>
              </tr>
              <tr>
                <td style="width:10%">Gambar/Sampul</td>
                <td><img class="img-thumbnail" width="150px" src="{{asset("/uploads/".$event->image)}}" alt=""></td>
              </tr>
              <tr>
                <td style="width:10%">Kategori</td>
                <td>
                    @foreach ($event->category as $item)
                        <small class="badge badge-info"><i class="fas fa-tag"></i> {{$item->name}}</small>
                    @endforeach
                </td>
              </tr>
              <tr>
                <td style="width:10%">Tanggal Mulai</td>
                <td>{{$event->startdate->dayName.", ".$event->startdate->day." ".$event->startdate->monthName." ".$event->startdate->year}}</td>
              </tr>
              <tr>
                <td style="width:15%">Tanggal Berakhir</td>
                <td>{{$event->enddate->dayName.", ".$event->enddate->day." ".$event->enddate->monthName." ".$event->enddate->year}}</td>
              </tr>
              <tr>
                <td style="width:10%">Deskripsi</td>
                <td>{!!$event->description!!}</td>
              </tr>

            </tbody>
          </table>
        </div>
        <div class="card-footer text-right">
          <span style="font-size: 14px">
            <strong>Dibuat pada: </strong>{{$event->created_at->dayName." | ".$event->created_at->day." ".$event->created_at->monthName." ".$event->created_at->year}} | {{$event->created_at->format('H:i:s')}} / <strong>Diubah pada: </strong>{{  $event->updated_at->dayName." | ".$event->updated_at->day." ".$event->updated_at->monthName." ".$event->updated_at->year}} | {{$event->updated_at->format('H:i:s')}}
          </span>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
