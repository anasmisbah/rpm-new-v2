@extends('layouts.master')

@section('content-header')
<div class="row mb-2">
    <div class="col-sm-6">
      <h1 class="m-0 text-dark">History Delivery Order</h1>
    </div><!-- /.col -->
    <div class="col-sm-6">
      <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="{{route('home.index')}}">Beranda</a></li>
        <li class="breadcrumb-item active">Delivery Order</li>
      </ol>
    </div><!-- /.col -->
  </div><!-- /.row -->
@endsection
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
              <h3 class="card-title">Pengantaran Jalur Laut</h3>
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
                      <a href="{{route('driver.agen.show',$delivery->driver->id)}}" class="product-title">{{$delivery->driver->name}}</a>
                      <span class="product-description">
                        Driver Telah Menyelesaikan Pengantaran <a href="{{route('deliveryorder.agen.show',$delivery->id)}}">{{$delivery->delivery_order_number}}</a> kepada customer <a href="{{route('customer.agen.show',$delivery->customer->id)}}">{{$delivery->customer->name}}</a>
                      </span>
                      <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i>{{$delivery->arrival_time->format('d F Y')}} {{$delivery->arrival_time->format('H:i:s')}}</p>
                    </div>
                  </li>
                  @endforeach
                <!-- /.item -->
              </ul>
            </div>
            <!-- /.card-body -->
            <div class="card-footer text-center">
                {{ $deliveries->links() }}
            </div>
            <!-- /.card-footer -->
          </div>
          <!-- /.card -->
    </div>
</div>
@endsection
