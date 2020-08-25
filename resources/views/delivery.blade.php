@extends('layouts.master')

@section('content-header')
<div class="row mb-2">
    <div class="col-sm-6">
      <h1 class="m-0 text-dark">History Deliveries</h1>
    </div><!-- /.col -->
    <div class="col-sm-6">
      <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="#">Home</a></li>
        <li class="breadcrumb-item active">Deliveries</li>
      </ol>
    </div><!-- /.col -->
  </div><!-- /.row -->
@endsection
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
              <h3 class="card-title">Recently Deliveries</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body p-0">
              <ul class="products-list product-list-in-card pl-2 pr-2">
                  @foreach ($deliveries as $delivery)
                  <!-- /.item -->
                  <li class="item">
                    <div class="product-img">
                      <img src="{{asset('/uploads/'.$delivery->driver->avatar)}}" alt="Avatar Driver" class="img-size-50">
                    </div>
                    <div class="product-info">
                      <a href="{{route('driver.show',$delivery->driver->id)}}" class="product-title">{{$delivery->driver->name}}
                      <span class="product-description">
                        The driver has delivered to {{$delivery->distributor->name}}
                      </span>
                    </div>
                  </li>
                  @endforeach
                <!-- /.item -->
              </ul>
            </div>
            <!-- /.card-body -->
            <div class="card-footer text-center">
              <a href="javascript:void(0)" class="uppercase">All Deliveries</a>
            </div>
            <!-- /.card-footer -->
          </div>
          <!-- /.card -->
    </div>
</div>
@endsection
