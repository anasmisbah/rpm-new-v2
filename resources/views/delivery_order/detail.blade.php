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
        <li class="breadcrumb-item"><a href="{{route('deliveryorder.agen.index',$sales_order->id)}}">Delivery Order</a></li>
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
                    <li class="nav-item">
                    <a class="btn btn-warning mr-1" href="{{route('deliveryorder.agen.edit',$delivery_order->id)}}"><i class="fas fa-edit"></i></a>
                    </li>
                    <li class="nav-item mr-1">
                        <a class="btn btn-info" href="{{route('deliveryorder.agen.print',$delivery_order->id)}}"><i class="fas fa-print"></i></a>
                    </li>
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
                    <td style="width:15%" class="text-bold">No Delivery Order</td>
                    <td>{{$delivery_order->delivery_order_number}}</td>
                </tr>
                <tr>
                    <td style="width:15%" class="text-bold">Tanggal SO dibuat</td>
                    <td>{{$sales_order->created_at->day." ".$sales_order->created_at->monthName." ".$sales_order->created_at->year}} </td>
                    <td style="width:15%" class="text-bold">Tanggal DO dibuat</td>
                    <td>{{$delivery_order->created_at->day." ".$delivery_order->created_at->monthName." ".$delivery_order->created_at->year."  ".$delivery_order->depot}}</td>
                </tr>
                <tr>
                    <td colspan="4" class="text-bold mt-2 text-center">Detail Delivery Order</td>
                </tr>
                <tr>
                    <td style="width:15%" class="text-bold">Diserahkan Kepada</td>
                    <td><a href="{{ route('customer.agen.show',$sales_order->customer->id) }}">{{$sales_order->customer->name}}</a></td>
                    <td style="width:15%" class="text-bold">Agen / Transportir</td>
                    <td><a href="{{ route('agen.show',$agen->id) }}">{{$agen->name}}</a></td>
                </tr>
                <tr>
                    <td style="width:15%" class="text-bold">NPWP</td>
                    <td>{{$sales_order->customer->npwp}}</td>
                    <td style="width:15%" class="text-bold">NPWP</td>
                    <td>{{$agen->npwp}}</td>
                </tr>
                <tr>
                    <td style="width:15%" class="text-bold">Alamat Serah</td>
                    <td>{{$sales_order->customer->address}}</td>
                    <td style="width:15%" class="text-bold">Alamat Agen / Transportir</td>
                    <td>{{$agen->address}}</td>
                </tr>
                <tr>
                    <td style="width:15%" class="text-bold">Detail Alamat Serah</td>
                    <td>{{$delivery_order->detail_address}}</td>
                    <td style="width:15%" class="text-bold">Transportir</td>
                    <td>{{$delivery_order->transportir}}</td>
                </tr>
                <tr>
                    <td style="width:15%" class="text-bold"></td>
                    <td></td>
                    <td style="width:15%" class="text-bold">Alamat Transportir</td>
                    <td>{{$delivery_order->address_transportir}}</td>
                </tr>
                <tr>
                    <td colspan="2" class="text-bold mt-2 text-center">Detail Product</td>
                    <td colspan="2" class="text-bold mt-2 text-center">Detail Pengiriman</td>
                </tr>
                <tr>
                    <td style="width:15%" class="text-bold">Tanggal Berlaku</td>
                    <td>{{$delivery_order->effective_date_start->day." ".$delivery_order->effective_date_start->monthName." ".$delivery_order->effective_date_start->year}} - {{$delivery_order->effective_date_start->day." ".$delivery_order->effective_date_start->monthName." ".$delivery_order->effective_date_start->year}}</td>
                    <td style="width:15%" class="text-bold">Dikirim Dengan</td>
                    <td>{{$delivery_order->shipped_with}}</td>
                </tr>
                <tr>
                    <td style="width:15%" class="text-bold">Produk</td>
                    <td>{{$delivery_order->product->name}}</td>
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
                    <td style="width:15%" class="text-bold">Kwantitas</td>
                    <td>{{$delivery_order->quantity}} {{$delivery_order->piece}} ({{$quantity_terbilang}})</td>
                    <td style="width:15%" class="text-bold">NO. Kendaraan</td>
                    <td>{{$delivery_order->no_vehicles}}</td>
                </tr>
                <tr>
                    <td style="width:15%" class="text-bold">Segel Atas</td>
                    <td>{{$delivery_order->top_seal}}</td>
                    <td style="width:15%" class="text-bold">KM. Awal</td>
                    <td>{{$delivery_order->km_start}}</td>
                </tr>
                <tr>
                    <td style="width:15%" class="text-bold">Segel Bawah</td>
                    <td>{{$delivery_order->bottom_seal}}</td>
                    <td style="width:15%" class="text-bold">KM. Akhir</td>
                    <td>{{$delivery_order->km_end}}</td>
                </tr>
                <tr>
                    <td style="width:15%" class="text-bold">Temperatur</td>
                    <td>{{$delivery_order->temperature}}</td>
                    <td style="width:15%" class="text-bold">SG Meter</td>
                    <td>{{$delivery_order->sg_meter}}</td>
                </tr>
                <tr>
                    <td style="width:15%" class="text-bold">Status</td>
                    <td>
                        @if ($delivery_order->status == 0)
                        <small class="badge badge-warning"></i> Menunggu Konfirmasi oleh agen </small>
                        @elseif($delivery_order->status == 1)
                        <small class="badge badge-info"></i> Menunggu Konfirmasi oleh Driver</small>
                        @elseif($delivery_order->status == 2)
                        <small class="badge badge-primary"></i> Dalam Pengiriman</small>
                        @else
                        <small class="badge badge-success"></i> Telah Dikirim</small>
                        @endif
                    </td>
                    <td style="width:15%" class="text-bold">Estimasi Waktu</td>
                    <td>
                        {{$estimate}}
                    </td>
                </tr>
                <tr>
                    <td style="width:15%" class="text-bold">Distribusi</td>
                    <td>{{$delivery_order->distribution}}</td>
                    <td style="width:15%" class="text-bold">Driver</td>
                    <td><a href="{{route('driver.agen.show',$delivery_order->driver->id)}}">{{$delivery_order->driver->name}}</a></td>
                </tr>
                <tr>
                    <td style="width:15%" class="text-bold">Nama Admin</td>
                    <td>{{$delivery_order->admin_name}}</td>
                    <td style="width:17%" class="text-bold">Waktu Keberangkatan</td>
                    <td>
                        @if ($delivery_order->status == 2 || $delivery_order->status == 3)
                        {{$delivery_order->departure_time->day." ".$delivery_order->departure_time->monthName." ".$delivery_order->departure_time->year}} | {{$delivery_order->departure_time->format('H:i:s')}}
                        @else
                        -
                        @endif
                    </td>
                </tr>
                <tr>
                    <td style="width:15%" class="text-bold">Mengetahui</td>
                    <td>{{$delivery_order->knowing}}</td>
                    <td style="width:17%" class="text-bold">Waktu Kedatangan</td>
                    <td>
                        @if ( $delivery_order->status == 3)
                        {{$delivery_order->arrival_time->day." ".$delivery_order->arrival_time->monthName." ".$delivery_order->arrival_time->year}} | {{$delivery_order->arrival_time->format('H:i:s')}}
                        @else
                        -
                        @endif
                    </td>
                </tr>
                <tr>
                    <td style="width:15%" class="text-bold">Kode QR</td>
                    <td><a href="{{asset("/uploads/".$delivery_order->qrcode)}}" class="foto"><img class="img-thumbnail" width="150px" src="{{asset("/uploads/".$delivery_order->qrcode)}}" alt=""></a></td>
                    <td style="width:15%" class="text-bold">&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
                @if ($delivery_order->status == 3)
                <tr>
                    <td colspan="4" class="text-bold mt-2 text-center">Berita Acara Serah Terima</td>
                </tr>
                    <tr>
                        <td colspan="4" class="text-center"><a href="{{asset("/uploads/".$delivery_order->bast)}}" class="foto"><img class="img-thumbnail" width="150px" src="{{asset("/uploads/".$delivery_order->bast)}}" alt=""></a></td>
                    </tr>
                @endif
                <tr>
                    <td style="width:15%" colspan="4" class="text-bold">
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
                                    @if ($delivery_order->critics != null)
                                        <div>
                                            <i class="fas fa-bell bg-blue"></i>
                                            <div class="timeline-item">
                                                <span class="time"><i class="fas fa-clock"></i> {{$delivery_order->critics->created_at->format('H:i:s')}}</span>
                                                <h3 class="timeline-header">{{$delivery_order->critics->created_at->dayName.", ".$delivery_order->critics->created_at->day." ".$delivery_order->critics->created_at->monthName." ".$delivery_order->critics->created_at->year}}</h3>

                                                <div class="timeline-body">
                                                    Kritik Saran dan Rating <br>
                                                    {{$delivery_order->critics->critics_suggestion}} <br>
                                                    {{$delivery_order->critics->service}}<br>

                                                    @for ($i = 0; $i < $delivery_order->critics->rating; $i++)
                                                    <i class="fa fa-star mr-1" style="color: yellow"></i>
                                                    @endfor
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                    @foreach ($delivery_order->notifs->sortByDesc('date') as $notif)
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
<script src="{{asset('plugins/terbilang.min.js')}}"></script>
<script>
    $(function() {
        const status = '{{ Session("status") }}'

        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000
        });
        if (status) {
            Toast.fire({
                type: 'success',
                title: status
            })
        }
    });
</script>
<script>
    $('.foto').magnificPopup({
        type:'image'
    })
</script>
@endpush
