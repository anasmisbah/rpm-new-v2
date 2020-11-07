@extends('layouts.master')
@section('content-header')
<div class="row mb-2">
    <div class="col-sm-6">
      <h1 class="m-0 text-dark">Agen {{$agen->name}}</h1>
    </div><!-- /.col -->
    <div class="col-sm-6">
      <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="{{route('home.index')}}">Beranda</a></li>
        <li class="breadcrumb-item"><a href="{{route('agen.index')}}">Agen</a></li>
        <li class="breadcrumb-item"><a href="{{route('salesorder.agen.index',$agen->id)}}">Sales Order</a></li>
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
          <h3 class="card-title">Detail Sales Order Agen {{$agen->name}}</h3>
          <div class="card-tools">
            <ul class="nav nav-pills ml-auto">
              <li class="nav-item">
                <a class="nav-link btn-danger active" href="{{ route('salesorder.agen.index',$agen->id) }}"><i class=" fas fa-times"></i></a>
              </li>
            </ul>
          </div>
        </div>
        <div class="card-body">
          <table class="table table-striped">
            <tbody>
              <tr>
                <td style="width:15%">Nomor Sales Order</td>
                <td>{{$sales_order->sales_order_number}}</td>
              </tr>
              <tr>
                <td style="width:15%">Nomor SH</td>
                <td>{{$sales_order->no_sh}}</td>
              </tr>
              <tr>
                <td style="width:15%">Customer</td>
                <td><a href="{{route('customer.agen.show',$sales_order->customer->id)}}">{{$sales_order->customer->name}}</a></td>
              </tr>
            </tbody>
          </table>
        </div>
        <div class="card-footer text-right">
          <span style="font-size: 14px">
            <strong>Dibuat pada: </strong>{{$sales_order->created_at->dayName." | ".$sales_order->created_at->day." ".$sales_order->created_at->monthName." ".$sales_order->created_at->year}} | {{$sales_order->created_at->format('H:i:s')}} / <strong>Diubah pada: </strong>{{  $sales_order->updated_at->dayName." | ".$sales_order->updated_at->day." ".$sales_order->updated_at->monthName." ".$sales_order->updated_at->year}} | {{$sales_order->updated_at->format('H:i:s')}}
          </span>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
