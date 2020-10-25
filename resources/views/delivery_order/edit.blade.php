@extends('layouts.master')

@push('css')
<!-- Select2 -->
<link rel="stylesheet" href="{{asset('plugins/select2/css/select2.min.css')}}">
<link rel="stylesheet" href="{{asset('plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css')}}">
<link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.0.0-alpha14/css/tempusdominus-bootstrap-4.min.css" />
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
            <li class="breadcrumb-item"><a href="{{route('deliveryorder.agen.show',$sales_order->id)}}">Delivery Order</a></li>
            <li class="breadcrumb-item active">Ubah</li>
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
                <h3 class="card-title">Mengubah Sales Order Agen {{$agen->name}}</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form class="form-horizontal" action="{{route('deliveryorder.agen.update',$delivery_order->id)}}"
                method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="card-body">
                    <div class="form-group row">
                        <label for="sales_order_number" class="col-sm-2 col-form-label">Nomor Sales Order <span
                                class="text-danger">*</span> </label>
                        <div class="col-sm-6 col-lg-6 col-md-6">
                            <input readonly value="{{$sales_order->sales_order_number}}" type="text"
                                class="text-bold form-control @error('sales_order_number') is-invalid @enderror"
                                id="sales_order_number" name="sales_order_number">
                            @error('sales_order_number')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row mt-2">
                        <div class="offset-sm-2 col-sm-10">
                            <label class="form-check-label text-bold" for="exampleCheck2">Form Delivery Order</label>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="delivery_order_number" class="col-sm-2 col-form-label">Nomor Delivery Order <span
                                class="text-danger">*</span> </label>
                        <div class="col-sm-6 col-lg-6 col-md-6">
                            <input
                                value="{{old('delivery_order_number')?old('delivery_order_number'): $delivery_order->delivery_order_number  }}"
                                type="text" class="form-control @error('delivery_order_number') is-invalid @enderror"
                                id="delivery_order_number" name="delivery_order_number">
                            @error('delivery_order_number')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="effective_date_start" class="col-sm-2 col-form-label">Tanggal Mulai Berlaku <span
                                class="text-danger">*</span> </label>
                        <div class="col-sm-6 col-lg-6 col-md-6 ">
                            <div class="input-group date " id="effective_date_start" data-target-input="nearest">
                                <input
                                    value="{{old('effective_date_start')?old('effective_date_start'): $delivery_order->effective_date_start->format('Y-m-d')}}"
                                    type="text"
                                    class="form-control @error('effective_date_start') is-invalid @enderror  datetimepicker-input"
                                    data-target="#effective_date_start" name="effective_date_start" />
                                <div class="input-group-append" data-target="#effective_date_start"
                                    data-toggle="datetimepicker">
                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                </div>
                                @error('effective_date_start')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="effective_date_end" class="col-sm-2 col-form-label">Tanggal Akhir Berlaku <span
                                class="text-danger">*</span> </label>
                        <div class="col-sm-6 col-lg-6 col-md-6">
                            <div class="input-group date" id="effective_date_end" data-target-input="nearest">
                                <input
                                    value="{{old('effective_date_end')?old('effective_date_end'): $delivery_order->effective_date_end->format('Y-m-d')}}"
                                    type="text"
                                    class="form-control @error('effective_date_end') is-invalid @enderror datetimepicker-input"
                                    data-target="#effective_date_end" name="effective_date_end" />
                                <div class="input-group-append" data-target="#effective_date_end"
                                    data-toggle="datetimepicker">
                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                </div>
                                @error('effective_date_end')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="product" class="col-sm-2 col-form-label">Produk<span class="text-danger">*</span>
                        </label>
                        <div class="col-sm-6 col-lg-6 col-md-6">
                            <input value="{{old('product')?old('product'): $delivery_order->product}}" type="text"
                                class="form-control @error('product') is-invalid @enderror" id="product" name="product">
                            @error('product')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="quantity" class="col-sm-2 col-form-label">Kwantitas <span
                                class="text-danger">*</span> </label>
                        <div class="col-sm-6 col-lg-6 col-md-6">
                            <input value="{{old('quantity')?old('quantity'): $delivery_order->quantity}}" type="number"
                                class="form-control @error('quantity') is-invalid @enderror" id="quantity"
                                name="quantity">
                            @error('quantity')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="top_seal" class="col-sm-2 col-form-label">Segel Atas <span
                                class="text-danger">*</span> </label>
                        <div class="col-sm-6 col-lg-6 col-md-6">
                            <input value="{{old('top_seal')?old('top_seal'): $delivery_order->top_seal}}" type="text"
                                class="form-control @error('top_seal') is-invalid @enderror" id="top_seal"
                                name="top_seal">
                            @error('top_seal')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="bottom_seal" class="col-sm-2 col-form-label">Segel Bawah <span
                                class="text-danger">*</span> </label>
                        <div class="col-sm-6 col-lg-6 col-md-6">
                            <input value="{{old('bottom_seal')?old('bottom_seal'): $delivery_order->bottom_seal}}"
                                type="text" class="form-control @error('bottom_seal') is-invalid @enderror"
                                id="bottom_seal" name="bottom_seal">
                            @error('bottom_seal')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="temperature" class="col-sm-2 col-form-label">Temperatur <span
                                class="text-danger">*</span> </label>
                        <div class="col-sm-6 col-lg-6 col-md-6">
                            <input value="{{old('temperature')?old('temperature'): $delivery_order->temperature}}"
                                type="number" class="form-control @error('temperature') is-invalid @enderror"
                                id="temperature" name="temperature">
                            @error('temperature')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="delivery_order_number" class="col-sm-2 col-form-label">Driver <span
                                class="text-danger">*</span> </label>
                        <div class="col-sm-6 col-lg-6 col-md-6">
                            <div class="custom-control custom-checkbox">
                                <input class="custom-control-input" type="checkbox"
                                    {{$delivery_order->shipped_via == 0 || $delivery_order->shipped_via == 2 ?'checked':''}}
                                    id="jalurdarat" name="shipped_via[]" value="0">
                                <label for="jalurdarat" class="custom-control-label">Jalur Darat</label>
                            </div>
                            <div class="custom-control custom-checkbox">
                                <input class="custom-control-input" type="checkbox"
                                    {{$delivery_order->shipped_via == 1 || $delivery_order->shipped_via == 2?'checked':''}}
                                    id="jalurlaut" name="shipped_via[]" value="1">
                                <label for="jalurlaut" class="custom-control-label">Jalur Laut</label>
                            </div>
                            @error('delivery_order_number')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="shipped_with" class="col-sm-2 col-form-label">Dikirim Dengan <span
                                class="text-danger">*</span> </label>
                        <div class="col-sm-6 col-lg-6 col-md-6">
                            <input value="{{old('shipped_with')?old('shipped_with'): $delivery_order->shipped_with}}"
                                type="text" class="form-control @error('shipped_with') is-invalid @enderror"
                                id="shipped_with" name="shipped_with">
                            @error('shipped_with')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="no_vehicles" class="col-sm-2 col-form-label">No Kendaraan <span
                                class="text-danger">*</span> </label>
                        <div class="col-sm-6 col-lg-6 col-md-6">
                            <input value="{{old('no_vehicles')?old('no_vehicles'): $delivery_order->no_vehicles}}"
                                type="text" class="form-control @error('no_vehicles') is-invalid @enderror"
                                id="no_vehicles" name="no_vehicles">
                            @error('no_vehicles')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="km_start" class="col-sm-2 col-form-label">KM Awal </label>
                        <div class="col-sm-6 col-lg-6 col-md-6">
                            <input value="{{old('km_start')?old('km_start'): $delivery_order->km_start}}" type="number"
                                class="form-control @error('km_start') is-invalid @enderror" id="km_start"
                                name="km_start">
                            @error('km_start')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="km_end" class="col-sm-2 col-form-label">KM Akhir </label>
                        <div class="col-sm-6 col-lg-6 col-md-6">
                            <input value="{{old('km_end')?old('km_end'): $delivery_order->km_end}}" type="number"
                                class="form-control @error('km_end') is-invalid @enderror" id="km_end" name="km_end">
                            @error('km_end')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="sg_meter" class="col-sm-2 col-form-label">SG Meter </label>
                        <div class="col-sm-6 col-lg-6 col-md-6">
                            <input value="{{old('sg_meter')?old('sg_meter'): $delivery_order->sg_meter}}" type="number"
                                class="form-control @error('sg_meter') is-invalid @enderror" id="sg_meter"
                                name="sg_meter">
                            @error('sg_meter')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="jam" class="col-sm-2 col-form-label">Estimasi Waktu (jam:menit)</label>
                        <div class="col-sm-1 col-lg-1 col-md-1">
                            <input min="0" max="24" value="{{old('jam') ? old('jam') : $estimate->hour}}" type="number"
                                class="form-control @error('jam') is-invalid @enderror" id="jam" name="jam">
                            @error('jam')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <h3 class="text-bold">:</h3>
                        <div class="col-sm-1 col-lg-1 col-md-1">
                            <input min="0" max="60" value="{{old('menit')? old('menit') : $estimate->minute}}" type="number"
                                class="form-control @error('menit') is-invalid @enderror" id="menit" name="menit">
                            @error('menit')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                </div>
        </div>

        <!-- /.card-body -->
        <div class="card-footer">
            <button type="submit" class="btn btn-info">Simpan</button>
            <a href="{{route('deliveryorder.agen.index',$sales_order->id)}}" class="btn btn-default">Kembali</a>
        </div>
        <!-- /.card-footer -->
        </form>
    </div>
    <!-- /.card -->
</div>
</div>
@endsection

@push('script')
<!-- Select2 -->
<script src="{{asset('plugins/select2/js/select2.full.min.js')}}"></script>
<script src="{{asset('plugins/sweetalert2/sweetalert2.min.js')}}"></script>
<script src="{{asset('plugins/moment/moment.min.js')}}"></script>
<script type="text/javascript"
    src="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.0.0-alpha14/js/tempusdominus-bootstrap-4.min.js">
</script>
<script>
    //menampilkan foto setiap ada perubahan pada modal tambah
    $('#image').on('change', function () {
        readURL(this);
    });

    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#image_con').attr('src', e.target.result);
            };

            reader.readAsDataURL(input.files[0]);
        }
    }

</script>
<script>
    $(function (){
        $('#effective_date_start').datetimepicker({
            format: 'L',
            format: 'YYYY-MM-D',
        });
        $('#effective_date_end').datetimepicker({
            format: 'L',
            format: 'YYYY-MM-D',
        });

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

        const error = '{{ $errors->first() }}'
        if (error) {
            Toast.fire({
                type: 'error',
                title: 'Sales Order update failed'
            })
        }
    });

</script>
@endpush
