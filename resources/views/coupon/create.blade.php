@extends('layouts.master')

@section('content-header')
<div class="row mb-2">
    <div class="col-sm-6">
      <h1 class="m-0 text-dark">Customer {{$customer->name}}</h1>
    </div><!-- /.col -->
    <div class="col-sm-6">
      <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="{{route('home.index')}}">Beranda</a></li>
        <li class="breadcrumb-item"><a href="{{route('agen.index')}}">Agen</a></li>
        <li class="breadcrumb-item"><a href="{{route('customer.agen.index',$customer->agen->id)}}">Customer</a></li>
        <li class="breadcrumb-item"><a href="{{route('customer.coupon.index',$customer->id)}}">Coupon</a></li>
        <li class="breadcrumb-item active">Tambah</li>
      </ol>
    </div><!-- /.col -->
  </div><!-- /.row -->
@endsection
@section('content')
<div class="row">
    <div class="col-md-12">
            <!-- Horizontal Form -->
            <div class="card card-info">
                <div class="card-header">
                  <h3 class="card-title">Tambah Coupon Untuk Customer {{$customer->name}}</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form class="form-horizontal" action="{{route('customer.coupon.store')}}" method="POST">
                    @csrf
                  <div class="card-body">
                    <div class="form-group row">
                        <label for="coupon" class="col-sm-2 col-form-label">Jumlah Coupon <span class="text-danger">*</span> </label>
                        <div class="col-sm-6 col-lg-6 col-md-6">
                            <input value="{{old('coupon')}}" type="number" class="form-control  @error('coupon') is-invalid @enderror" id="coupon" name="coupon" placeholder="coupon">
                            @error('coupon')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                  </div>

                  <!-- /.card-body -->
                  <div class="card-footer">
                      <input type="hidden" name="customer_id" value="{{$customer->id}}">
                    <button type="submit" class="btn btn-info">Simpan</button>
                    <a href="{{route('customer.coupon.index',$customer->id)}}" class="btn btn-default">Kembali</a>
                  </div>
                  <!-- /.card-footer -->
                </form>
              </div>
              <!-- /.card -->
        </div>
</div>
@endsection
