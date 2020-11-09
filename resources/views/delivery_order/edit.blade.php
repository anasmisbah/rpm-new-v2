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
            <li class="breadcrumb-item"><a href="{{route('deliveryorder.agen.index',$sales_order->id)}}">Delivery Order</a></li>
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
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">

                                <label for="delivery_order_number">No Delivery Order <span class="text-danger">*</span>
                                </label>
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
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="sales_order_number">No Sales Order <span class="text-danger">*</span>
                                </label>
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

                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="customer_name">Di serahkan Kepada
                                </label>
                                <input readonly value="{{$sales_order->customer->name}}" type="text"
                                    class="text-bold form-control" id="customer_name">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="agen_name">Agen / Transportir
                                </label>
                                <input readonly value="{{$sales_order->agen->name}}" type="text"
                                    class="text-bold form-control" id="agen_name">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="customer_npwp">NPWP
                                </label>
                                <input readonly
                                    value="{{$sales_order->customer->npwp ? $sales_order->customer->npwp : '-'}}"
                                    type="text" class="text-bold form-control" id="customer_npwp">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="agen_npwp">NPWP
                                </label>
                                <input readonly value="{{$sales_order->agen->npwp ? $sales_order->agen->npwp : '-'}}"
                                    type="text" class="text-bold form-control" id="agen_npwp">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="customer_address">Alamat Serah
                                </label>
                                <input readonly
                                    value="{{$sales_order->customer->address ? $sales_order->customer->address : '-'}}"
                                    type="text" class="text-bold form-control" id="customer_address">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="agen_address">Alamat Agen / Transportir
                                </label>
                                <input readonly
                                    value="{{$sales_order->agen->address ? $sales_order->agen->address : '-'}}"
                                    type="text" class="text-bold form-control" id="agen_address">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">

                                <label for="product">Produk<span class="text-danger">*</span>
                                </label>
                                <select class="select2 @error('product') is-invalid @enderror" id="select-product"
                                    name="product" data-placeholder="Dikirim Dengan" style="width: 100%;">
                                    <option value="Patra bio diesel - PTM Stock (bio solar)" {{$delivery_order == "Patra bio diesel - PTM Stock (bio solar)"?'selected':''}}>Patra bio diesel - PTM
                                        Stock
                                        (bio solar)</option>
                                    <option value="Patra bio diesel - PTM (bio solar) A040900111" {{$delivery_order == "Patra bio diesel - PTM (bio solar) A040900111"?'selected':''}}>Patra bio diesel - PTM
                                        (bio solar) A040900111</option>
                                    <option value="MFO" {{$delivery_order == "MFO"?'selected':''}}>MFO</option>
                                </select>
                                @error('product')
                                <span class="text-sm text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">

                                <label for="effective_date_start">Tanggal Mulai Berlaku <span
                                        class="text-danger">*</span>
                                </label>
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
                        <div class="col-md-4">
                            <div class="form-group">

                                <label for="effective_date_end">Tanggal Akhir Berlaku <span class="text-danger">*</span>
                                </label>
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
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">

                                <label for="quantity">Kwantitas <span class="text-danger">*</span> </label>
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

                        <div class="col-md-4">
                            <div class="form-group">

                                <label for="driver_id">Driver <span class="text-danger">*</span> </label>
                                <select class="select2 @error('driver_id') is-invalid @enderror" id="select-driver"
                                    name="driver_id" data-placeholder="Dikirim Dengan" style="width: 100%;">
                                    @foreach ($drivers as $driver)
                                    <option value="{{$driver->id}}" {{$delivery_order->driver_id == $driver->id ? 'selected':''}}>{{$driver->name}} | Jalur {{$driver->route == 0? "Darat":"Laut"}}</option>
                                    @endforeach
                                </select>
                                @error('driver_id')
                                <span class="text-sm text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="sg_meter">SG Meter </label>
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
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">

                                <label for="kwantitas_terbilang">Kwantitas Terbilang<span class="text-danger">*</span>
                                </label>
                                <input value="{{$quantity_terbilang}}" type="text" disabled class="form-control" id="kwantitas_terbilang"
                                    name="kwantitas_terbilang" />
                            </div>

                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="shipped_with">Dikirim Dengan <span class="text-danger">*</span> </label>
                                <select class="select2 @error('shipped_with') is-invalid @enderror"
                                    id="select-shipped-with" name="shipped_with" data-placeholder="Dikirim Dengan"
                                    style="width: 100%;">
                                    <option value="Kapal" {{$delivery_order->shipped_with == "Kapal"?'selected':''}}>Kapal</option>
                                    <option value="Mobil Tangki" {{$delivery_order->shipped_with == "Mobil Tangki"?'selected':''}}>Mobil Tangki</option>
                                </select>
                                @error('shipped_with')
                                <span class="text-sm text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label for="jam">Estimasi Waktu (jam:menit)<span class="text-danger">*</span> </label></label>
                            <div class="form-group row">
                                <div class="col-md-6">
                                    <input min="0" max="24" value="{{old('jam') ? old('jam') : $estimate->hour}}" type="number"
                                    class="form-control @error('jam') is-invalid @enderror" id="jam" name="jam">
                                @error('jam')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                                </div>
                                <div class="col-md-6">

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
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">

                                <label for="top_seal">Segel Atas <span class="text-danger">*</span> </label>
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
                        <div class="col-md-4">
                            <div class="form-group">
                                <div class="form-group">

                                    <label for="no_vehicles">No Kendaraan <span class="text-danger">*</span> </label>
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
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">

                                <label for="distribution">Distribusi
                                </label>
                                <input value="{{old('distribution')?old('distribution'): $delivery_order->distribution}}" type="text"
                                    class="form-control @error('distribution') is-invalid @enderror"
                                    id="distribution" name="distribution" />
                                @error('distribution')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">

                                <label for="bottom_seal">Segel Bawah <span class="text-danger">*</span> </label>
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
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="km_start">KM Awal </label>
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
                        <div class="col-md-4">
                            <div class="form-group">

                                <label for="admin_name">Nama Admin
                                </label>
                                <input value="{{old('admin_name')?old('admin_name'): $delivery_order->admin_name}}" type="text"
                                    class="form-control @error('admin_name') is-invalid @enderror"
                                    id="admin_name" name="admin_name" />
                                @error('admin_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">

                                <label for="temperature">Temperatur <span class="text-danger">*</span> </label>
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
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="km_end">KM Akhir </label>
                                <input value="{{old('km_end')?old('km_end'): $delivery_order->km_end}}" type="number"
                                class="form-control @error('km_end') is-invalid @enderror" id="km_end" name="km_end">
                            @error('km_end')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">

                                <label for="knowing">Mengetahui
                                </label>
                                <input value="{{old('knowing')?old('knowing'): $delivery_order->knowing}}" type="text"
                                    class="form-control @error('knowing') is-invalid @enderror"
                                    id="knowing" name="knowing" />
                                @error('knowing')
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
<script src="{{asset('plugins/terbilang.min.js')}}"></script>
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
        $('#select-shipped-with').select2()
        $('#select-product').select2()
        $('#select-driver').select2()
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
        $('#quantity').change(function(){
            var qty = $('#quantity').val();
            var qty_r = terbilang(qty);
            $('#kwantitas_terbilang').val(qty_r + " Liter")
        })
    });

</script>
@endpush
