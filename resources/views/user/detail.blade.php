@extends('layouts.master')
@section('content-header')
<div class="row mb-2">
    <div class="col-sm-6">
      <h1 class="m-0 text-dark">Pengguna</h1>
    </div><!-- /.col -->
    <div class="col-sm-6">
      <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="{{route('home.index')}}">Beranda</a></li>
        <li class="breadcrumb-item">Pengguna</li>
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
          <h3 class="card-title">Detail Pengguna</h3>
          <div class="card-tools">
            <ul class="nav nav-pills ml-auto">
              <li class="nav-item">
                <a class="nav-link btn-danger active" href="{{ route('user.index') }}"><i class=" fas fa-times"></i></a>
              </li>
            </ul>
          </div>
        </div>
        <div class="card-body">
          <table class="table table-striped">
            <tbody>
                <tr>
                    <td style="width:15%">Avatar</td>
                    @if ($user->customer)
                        <td><img class="img-thumbnail" width="150px" src="{{asset("/uploads/".$user->customer->logo)}}" alt=""></td>
                    @elseif ($user->driver)
                        <td><img class="img-thumbnail" width="150px" src="{{asset("/uploads/".$user->driver->avatar)}}" alt=""></td>
                    @elseif ($user->agen)
                    <td><img class="img-thumbnail" width="150px" src="{{asset("/uploads/".$user->driver->logo)}}" alt=""></td>
                    @else
                        <td><img class="img-thumbnail" width="150px" src="{{asset("/uploads/".$user->admin->avatar)}}" alt=""></td>
                    @endif
                </tr>
              <tr>
                <td style="width:15%">Nama</td>
                @if ($user->customer)
                    <td>{{$user->customer->name}}</td>
                @elseif ($user->driver)
                    <td>{{$user->driver->name}}</td>
                @elseif ($user->agen)
                <td>{{$user->agen->name}}</td>
                @else
                    <td>{{$user->admin->name}}</td>
                @endif
              </tr>
              <tr>
                  <td>Role</td>
                  <td><small class="badge {{$user->role->id == 1 || $user->role->id == 2 ?'badge-danger':'badge-info'}}"> {{$user->role->name}}</small></td>
              </tr>
              <tr>
                <td style="width:15%">Email</td>
                <td>{{$user->email}}</td>
              </tr>
                @if ($user->customer)
                <tr>
                    <td style="width:15%">Agen</td>
                    <td><a href="{{route('agen.show',$user->customer->agen->id)}}">{{$user->customer->agen->name}}</a></td>
                </tr>
                @elseif ($user->driver)
                <tr>
                    <td style="width:15%">Agen</td>
                    <td><a href="{{route('agen.show',$user->driver->agen->id)}}">{{$user->driver->agen->name}}</a></td>
                </tr>
                @elseif ($user->agen)
                <tr>
                    <td style="width:15%">Agen</td>
                    <td><a href="{{route('agen.show',$user->agen->id)}}">{{$user->agen->name}}</a></td>
                </tr>
              @endif

            </tbody>
          </table>
        </div>
        <div class="card-footer text-right">
          <span style="font-size: 14px">
            <strong>Created At: </strong>{{$user->created_at->format('l | d F Y')}} | {{$user->created_at->format('h:i:s A')}}/ <strong>Updated At: </strong>{{$user->updated_at->format('l | d F Y')}} | {{$user->updated_at->format('h:i:s A')}}
          </span>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
