@extends('layouts.master')

@push('css')
<link href="{{asset('dist/css/magnific-popup.css')}}" rel="stylesheet" type="text/css" />
@endpush
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
        <li class="breadcrumb-item">Delivery Order</li>
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
          <h3 class="card-title">Detail Delivery Order </h3>
          <div class="card-tools">
            <ul class="nav nav-pills ml-auto">
                @if ($delivery_order->status == 0)
                    <li class="nav-item">
                    <a class="btn btn-warning mr-1" href="{{route('deliveryorder.agen.edit',$delivery_order->id)}}"><i class="fas fa-edit"></i></a>
                    </li>
                @elseif ($delivery_order->status == 2)
                    <li class="nav-item mr-1">
                        <a class="btn btn-info" href="{{route('deliveryorder.agen.print',$delivery_order->id)}}"><i class="fas fa-print"></i></a>
                    </li>
                @endif
              <li class="nav-item">
                <a class="btn btn-danger" href="{{ route('deliveryorder.agen.index',$sales_order->id) }}"><i class=" fas fa-times"></i></a>
              </li>
            </ul>
          </div>
        </div>
        <div class="card-body">
          <table class="table table-striped">
            <tbody>
                <tr>
                    <td style="width:15%" class="text-bold">No Sales Order</td>
                    <td>{{$sales_order->sales_order_number}}</td>
                </tr>
                <tr>
                    <td style="width:15%" class="text-bold">Tanggal SO dibuat</td>
                    <td>{{$sales_order->created_at->day." ".$sales_order->created_at->monthName." ".$sales_order->created_at->year}} </td>
                </tr>
                <tr>
                    <td style="width:15%" class="text-bold mt-2">Detail Delivery Order</td>
                    <td></td>
                </tr>
                <tr>
                    <td style="width:15%" class="text-bold">No Delivery Order</td>
                    <td>{{$delivery_order->delivery_order_number}}</td>
                </tr>
                <tr>
                    <td style="width:15%" class="text-bold">Tanggal DO dibuat</td>
                    <td>{{$delivery_order->created_at->day." ".$delivery_order->created_at->monthName." ".$delivery_order->created_at->year}}</td>
                </tr>
                <tr>
                    <td style="width:15%" class="text-bold">Agen</td>
                    <td><a href="{{ route('agen.show',$agen->id) }}">{{$agen->name}}</a></td>
                </tr>
                <tr>
                    <td style="width:15%" class="text-bold">Customer</td>
                    <td><a href="{{ route('customer.agen.show',$delivery_order->customer->id) }}">{{$delivery_order->customer->name}}</a></td>
                </tr>
                <tr>
                    <td style="width:15%" class="text-bold">Tanggal Berlaku</td>
                    <td>{{$delivery_order->effective_date_start->day." ".$delivery_order->effective_date_start->monthName." ".$delivery_order->effective_date_start->year}} - {{$delivery_order->effective_date_start->day." ".$delivery_order->effective_date_start->monthName." ".$delivery_order->effective_date_start->year}}</td>
                </tr>
                <tr>
                    <td style="width:15%" class="text-bold">Produk</td>
                    <td>{{$delivery_order->product}}</td>
                </tr>
                <tr>
                    <td style="width:15%" class="text-bold">Kwantitas</td>
                    <td>{{$delivery_order->quantity}} Liter</td>
                </tr>
                <tr>
                    <td style="width:15%" class="text-bold">Segel Atas</td>
                    <td>{{$delivery_order->top_seal}}</td>
                </tr>
                <tr>
                    <td style="width:15%" class="text-bold">Segel Bawah</td>
                    <td>{{$delivery_order->bottom_seal}}</td>
                </tr>
                <tr>
                    <td style="width:15%" class="text-bold">Temperatur</td>
                    <td>{{$delivery_order->temperature}}</td>
                </tr>
                <tr>
                    <td style="width:15%" class="text-bold">Dikirim Dengan</td>
                    <td>{{$delivery_order->shipped_with}}</td>
                </tr>
                <tr>
                    <td style="width:15%" class="text-bold">Dikirim Via</td>
                    <td>
                        @if ($delivery_order->shipped_via == 0)
                        <small class="badge badge-warning"></i> Jalur Darat </small>
                        @elseif($delivery_order->shipped_via == 1)
                        <small class="badge badge-info"></i> Jalur Laut</small>
                        @else
                        <small class="badge badge-success"></i> Jalur Darat Atau Jalur Laut</small>
                        @endif
                    </td>
                </tr>
                <tr>
                    <td style="width:15%" class="text-bold">NO. Kendaraan</td>
                    <td>{{$delivery_order->no_vehicles}}</td>
                </tr>
                <tr>
                    <td style="width:15%" class="text-bold">KM. Awal</td>
                    <td>{{$delivery_order->km_start}}</td>
                </tr>
                <tr>
                    <td style="width:15%" class="text-bold">KM. Akhir</td>
                    <td>{{$delivery_order->km_end}}</td>
                </tr>
                <tr>
                    <td style="width:15%" class="text-bold">SG Meter</td>
                    <td>{{$delivery_order->sg_meter}}</td>
                </tr>
                <tr>
                    <td style="width:15%" class="text-bold">Status</td>
                    <td>
                        @if ($delivery_order->status == 0)
                        <small class="badge badge-warning"></i> Belum Dikirim </small>
                        @elseif($delivery_order->status == 1)
                        <small class="badge badge-info"></i> Sedang Dikirim</small>
                        @else
                        <small class="badge badge-success"></i> Telah Dikirim</small>
                        @endif
                    </td>
                </tr>
                <tr>
                    <td style="width:15%" class="text-bold">Estimasi Waktu</td>
                    <td>
                        {{$estimate}}
                    </td>
                </tr>
                @if ($delivery_order->status == 1 || $delivery_order->status == 2)
                    <tr>
                        <td style="width:15%" class="text-bold">Driver</td>
                        <td><a href="{{route('driver.agen.show',$delivery_order->driver->id)}}">{{$delivery_order->driver->name}}</a></td>
                    </tr>
                    <tr>
                        <td style="width:17%" class="text-bold">Waktu Keberangkatan</td>
                        <td>
                        {{$delivery_order->departure_time->day." ".$delivery_order->departure_time->monthName." ".$delivery_order->departure_time->year}} | {{$delivery_order->departure_time->format('H:i:s')}}
                        </td>
                    </tr>
                @endif
                @if ($delivery_order->status == 2)
                    <tr>
                        <td style="width:17%" class="text-bold">Waktu Kedatangan</td>
                        <td>
                            {{$delivery_order->arrival_time->day." ".$delivery_order->arrival_time->monthName." ".$delivery_order->arrival_time->year}} | {{$delivery_order->arrival_time->format('H:i:s')}}
                        </td>
                    </tr>
                    <tr>
                        <td style="width:15%" class="text-bold">BAST</td>
                        <td><a href="{{asset("/uploads/".$delivery_order->bast)}}" class="foto"><img class="img-thumbnail" width="150px" src="{{asset("/uploads/".$delivery_order->bast)}}" alt=""></a></td>
                    </tr>
                @endif
                <tr>
                    <td style="width:15%" colspan="2" class="text-bold">
                        <!-- Timelime example  -->
                        <div class="row">
                            <div class="col-md-12">
                            <!-- The time line -->
                                <div class="timeline">
                                    <!-- timeline time label -->
                                    <div class="time-label">
                                        <span class="bg-green">Timeline</span>
                                    </div>
                                    <!-- /.timeline-label -->
                                    <!-- timeline item -->
                                    @foreach ($delivery_order->notifs->sortByDesc('id') as $notif)
                                        <div>
                                            <i class="fas fa-bell bg-blue"></i>
                                            <div class="timeline-item">
                                                <span class="time"><i class="fas fa-clock"></i> {{$notif->date->format('H:i:s')}}</span>
                                                <h3 class="timeline-header">{{$notif->date->dayName.", ".$notif->date->day." ".$notif->date->monthName." ".$notif->date->year}}</h3>

                                                <div class="timeline-body">{{$notif->description}}</div>
                                            </div>
                                        </div>
                                    @endforeach
                                    <!-- END timeline item -->
                                    <div>
                                        <i class="fas fa-clock bg-gray"></i>
                                    </div>
                                </div>
                            </div>
                            <!-- /.col -->
                        </div>
                    </td>
                </tr>
            </tbody>
          </table>
        </div>
        <div class="card-footer text-right">
          <span style="font-size: 14px">
            <strong>Dibuat pada: </strong>{{$delivery_order->created_at->dayName." | ".$delivery_order->created_at->day." ".$delivery_order->created_at->monthName." ".$delivery_order->created_at->year}} | {{$delivery_order->created_at->format('H:i:s')}} / <strong>Diubah pada: </strong>{{  $delivery_order->updated_at->dayName." | ".$delivery_order->updated_at->day." ".$delivery_order->updated_at->monthName." ".$delivery_order->updated_at->year}} | {{$delivery_order->updated_at->format('H:i:s')}}
          </span>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@push('script')
<script src="{{asset('dist/js/jquery.magnific-popup.min.js')}}"></script>
<script>
    $('.foto').magnificPopup({
        type:'image'
    })
</script>
@endpush
