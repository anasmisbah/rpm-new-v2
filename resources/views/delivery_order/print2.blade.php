<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <link rel="stylesheet" href="{{asset('plugins/fontawesome-free/css/all.min.css')}}">
    <link rel="shortcut icon" href="{{asset('/img/favico.png')}}" type="image/x-icon">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">

    <link rel="stylesheet" href="{{asset('dist/css/adminlte.min.css')}}">

    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
    <title>Document</title>
    <style>
        table.table-bordered>tbody>tr>td {
            border: 1px solid black !important;
        }

        @media print {
            .kotak {
                border: 1px solid black;
                height: 30px;
                background-color: #c0c0c0 !important;
                -webkit-print-color-adjust: exact;
            }
        }
        table td.alamat{
            display: table-cell;
  vertical-align: top;
        }

    </style>
</head>

<body>
    <div class="border border-dark p-3">
        <div class="row">
            <div class="col-4">
                <img src="{{asset('img/logo_print.png')}}" width="200px" alt="">
            </div>
            <div class="col-6 ">
                <h3 class="mt-auto mb-auto d-block">SURAT PENGANTAR PENGIRIMAN (SPP)</h3>
            </div>
        </div>

        <div class="row">
            <div class="col-4">
                <p>Gd. Wisma Tugu III Lt.2
                    <br>
                    Jl. HR Rasuna Said Kav. C 7-9 Kuningan
                    <br>
                    Jakarta 12920
                    <br>
                    Telp: (021)520 9009 Fax: (021)520 9005
                    <br>
                    NPWP Np: 01.061.157.2.051.000
                </p>
            </div>
            <div class="col-7">
                No.DO : &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{$delivery_order->delivery_order_number}}
                <br>
                Tgl. DO : &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{$delivery_order->created_at->day." ".$delivery_order->created_at->monthName." ".$delivery_order->created_at->year}}
                <br>
                No.SO : &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{$sales_order->sales_order_number}}
            </div>
        </div>
    </div>
    <div class="border border-dark border-bottom-0">
        <div class="row">
            <div class="col-6 border border-top-0 border-bottom-0 border-dark">
                <table>
                    <tr>
                        <td><strong>Diserahkan Kepada</strong> </td>
                        <td>:&nbsp;</td>
                        <td>{{$sales_order->customer->name}}</td>
                    </tr>
                    <tr>
                        <td><strong>Alamat</strong></td>
                        <td>:&nbsp;</td>
                        <td>{{$sales_order->customer->address}}</td>
                    </tr>
                    <tr>
                        <td><strong>ID</strong></td>
                        <td>:&nbsp;</td>
                        <td>{{$sales_order->customer->id}}</td>
                    </tr>
                    <tr>
                        <td><strong>N.P.W.P</strong></td>
                        <td>:&nbsp;</td>
                        <td>{{$sales_order->customer->npwp}}</td>
                    </tr>
                </table>
            </div>
            <div class="col-6 border border-dark border-bottom-0 border-left-0 border-top-0">
                <table>
                    <tr>
                        <td><strong>Agen / Transportir</strong></td>
                        <td>:</td>
                        <td>{{$agen->name}}</td>
                    </tr>
                    <tr>
                        <td class="alamat"><strong>Alamat</strong> </td>
                        <td class="alamat">:</td>
                        <td>{{$agen->address}}</td>
                    </tr>
                    <tr>
                        <td><strong>ID</strong> </td>
                        <td>:</td>
                        <td>{{$agen->id}}</td>
                    </tr>
                    <tr>
                        <td><strong>N.P.W.P</strong> </td>
                        <td>:</td>
                        <td>{{$agen->npwp}}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <table class="table table-bordered" style="margin-bottom:0" width="100%">
                <tr class="text-center">
                    <td colspan="2" width="33.3%">Tanggal Berlaku</td>
                    <td width="33.3%">Produk</td>
                    <td colspan="2" width="33.3%">Kwantitas</td>
                </tr>
                <tr class="text-center">
                    <td colspan="2" width="33.3%">{{$delivery_order->effective_date_start->day." ".$delivery_order->effective_date_start->monthName." ".$delivery_order->effective_date_start->year}} s/d {{$delivery_order->effective_date_start->day." ".$delivery_order->effective_date_start->monthName." ".$delivery_order->effective_date_start->year}}</td>
                    <td width="33.3%">{{$delivery_order->product->name}}</td>
                    <td colspan="2" width="33.3%">{{$delivery_order->quantity}} {{$delivery_order->piece}}</td>
                </tr>
                <tr>
                    <td width="16.65%">Dikirim Dengan</td>
                    <td width="16.65%">{{$delivery_order->shipped_with}}</td>
                    <td rowspan="2" width="33.3%" class="pt-4">Segel Atas : {{$delivery_order->top_seal}}</td>
                    <td width="20%">Jam Berangkat</td>
                    <td width="14.65%">{{$delivery_order->departure_time?$delivery_order->departure_time->day." ".$delivery_order->departure_time->monthName." ".$delivery_order->departure_time->year.' '.$delivery_order->departure_time->format('H:i:s'):'-'}}</td>
                </tr>
                <tr>
                    <td width="16.65%">No. Kendaraan</td>
                    <td width="16.65%">{{$delivery_order->no_vehicles}}</td>
                    <td width="20%">Jam Tiba</td>
                    <td width="14.65%">{{$delivery_order->arrival_time?$delivery_order->arrival_time->day." ".$delivery_order->arrival_time->monthName." ".$delivery_order->arrival_time->year.' '.$delivery_order->arrival_time->format('H:i:s'):'-'}}</td>
                </tr>
                <tr>
                    <td width="16.65%">Km. Awal</td>
                    <td width="16.65%">{{$delivery_order->km_start}}</td>
                    <td rowspan="2" width="33.3%" class="pt-4">Segel Bawah : {{$delivery_order->bottom_seal}}</td>
                    <td width="20%">Jam Mulai Pembongkaran</td>
                    <td width="14.65%">-</td>
                </tr>
                <tr>
                    <td width="16.65%">Km. Akhir</td>
                    <td width="16.65%">{{$delivery_order->km_end}}</td>
                    <td width="20%">Jam Selesai Pembongkaran</td>
                    <td width="14.65%">-</td>
                </tr>
                <tr>
                    <td width="16.65%">SG Meter</td>
                    <td width="16.65%">{{$delivery_order->sg_meter}}</td>
                    <td width="33.3%" class="pt-4">Temperatur : {{$delivery_order->temperature}}<sup>o</sup> </td>
                    <td width="20%">Jam Tiba di Depo</td>
                    <td width="14.65%">-</td>
                </tr>
            </table>
        </div>
    </div>
    <div class="border border-dark border-top-0">
        <div class="row">
            <div class="col-2 p-3 ">
                <p class="text-center">
                    Jumlah
                    <br>
                    (Liter)
                </p>
            </div>
            <div class="col-9 p-3">
                <div class="kotak pl-3">
                    {{$quantity_terbilang}}
                </div>
                <div class="kotak mt-2">

                </div>
            </div>
        </div>
    </div>
    <div class="border border-dark border-top-0">
        <div class="row">
            <div class="col-3 border border-dark  border-top-0 border-bottom-0 text-center">
                Distribusi
            </div>
            <div class="col-3  border border-dark border-right-0 border-top-0 border-bottom-0 text-center">
                Mengetahui
            </div>
            <div class="col-3  border border-dark  border-top-0 border-bottom-0 text-center">
                Penerima
            </div>
            <div class="col-3  border border-dark  border-top-0 border-bottom-0 text-center">
                Pengemudi
            </div>
        </div>
        <div class="row">
            <div class="col-3 border border-dark border-bottom-0 text-center">
                <br>
                <br>
                <br>
                <br>
                {{$delivery_order->distribution}}
            </div>
            <div class="col-3  border border-dark border-right-0 border-bottom-0 text-center">
                    <br>
                    <br>
                    <br>
                    <br>
                    {{$delivery_order->knowing}}
            </div>
            <div class="col-3  border border-dark  border-bottom-0 text-center">
                    <br>
                    <br>
                    <br>
                    <br>
            </div>
            <div class="col-3  border border-dark  border-bottom-0 ">
                <p>1.Sopir :
                    <br>
                    <br>
                    <br>
                    2.Kernet:</p>

            </div>
        </div>
    </div>

    <script type="text/javascript">
        window.addEventListener("load", window.print());

    </script>
</body>

</html>
