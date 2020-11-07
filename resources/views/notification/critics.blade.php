@extends('layouts.master')

@section('content-header')
<div class="row mb-2">
    <div class="col-sm-6">
      <h1 class="m-0 text-dark">History Kritik dan Rating</h1>
    </div><!-- /.col -->
    <div class="col-sm-6">
      <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="{{route('home.index')}}">Beranda</a></li>
        <li class="breadcrumb-item active">Kritik dan Rating</li>
      </ol>
    </div><!-- /.col -->
  </div><!-- /.row -->
@endsection
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
              <h3 class="card-title">Kritik Saran dan Rating</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body p-0">
              <ul class="products-list product-list-in-card pl-2 pr-2">
                  @foreach ($critics as $critic)
                  <!-- /.item -->
                  <li class="item">
                    <div class="product-img">
                      <img src="{{asset('/uploads/'.$critic->delivery_order->sales_order->customer->logo)}}" alt="Customer Image" class="img-size-50">
                    </div>
                    <div class="product-info">
                      <a href="{{route('customer.agen.show',$critic->delivery_order->sales_order->customer->id)}}" class="product-title">{{$critic->delivery_order->sales_order->customer->name}}</a>&nbsp;&nbsp;
                      <a href="{{route('deliveryorder.agen.show',$critic->delivery_order->id)}}" class="product-title">DO {{$critic->delivery_order->delivery_order_number}}</a>
                      <span class="product-description">
                        {{$critic->critics_suggestion}} <br>
                        {{$critic->service}}<br>

                        @for ($i = 0; $i < $critic->rating; $i++)
                        <i class="fa fa-star mr-1" style="color: yellow"></i>
                        @endfor

                      </span>
                      <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i>{{$critic->created_at->format('d F Y')}} {{$critic->created_at->format('H:i:s')}}</p>
                    </div>
                  </li>
                  @endforeach
                <!-- /.item -->
              </ul>
            </div>
            <!-- /.card-body -->
            <div class="card-footer text-center">
                {{ $critics->links() }}
            </div>
            <!-- /.card-footer -->
          </div>
          <!-- /.card -->
    </div>
</div>
@endsection
