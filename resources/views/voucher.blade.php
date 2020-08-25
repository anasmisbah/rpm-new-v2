@extends('layouts.master')

@section('content-header')
<div class="row mb-2">
    <div class="col-sm-6">
      <h1 class="m-0 text-dark">History Pengambilan Promo</h1>
    </div><!-- /.col -->
    <div class="col-sm-6">
      <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="{{route('home.index')}}">Beranda</a></li>
        <li class="breadcrumb-item active">Pengambilan Promo</li>
      </ol>
    </div><!-- /.col -->
  </div><!-- /.row -->
@endsection
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
              <h3 class="card-title">Promo</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body p-0">
              <ul class="products-list product-list-in-card pl-2 pr-2">
                  @foreach ($vouchers as $voucher)
                  <!-- /.item -->
                  <li class="item">
                    <div class="product-img">
                      <img src="{{asset('/uploads/'.$voucher->promo->image)}}" alt="Product Image" class="img-size-50">
                    </div>
                    <div class="product-info">
                      <a href="{{route('promo.show',$voucher->promo->id)}}" class="product-title">{{$voucher->promo->name}}
                        <span class="badge badge-success float-right">{{$voucher->promo->point}} points</span></a>
                      <span class="product-description">
                        {{$voucher->customer->name}} has taken this promo
                      </span>
                    </div>
                  </li>
                  @endforeach
                <!-- /.item -->
              </ul>
            </div>
            <!-- /.card-body -->
            <div class="card-footer text-center">
              <a href="javascript:void(0)" class="uppercase">All Products</a>
            </div>
            <!-- /.card-footer -->
          </div>
          <!-- /.card -->
    </div>
</div>
@endsection
