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

        }

        @media print {
            .kotak {
                height: 30px;
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
    <div class="p-3">
        <div class="row">
            <div class="col-4" style="min-height: 50px">
                {{-- <img src="{{asset('img/logo_print.png')}}" width="200px" alt=""> --}}
            </div>
            <div class="col-6 ">
                {{-- <h3 class="mt-auto mb-auto d-block">SURAT PENGANTAR PENGIRIMAN (SPP)</h3> --}}
            </div>
        </div>

        <div class="row">
            {{-- <div class="col-4">
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
            </div> --}}
            <div class="col-7 offset-4 " style="min-height: 150px">
                <table>
                    <tr>
                        <td width="30%"></td>
                        <td>{{$delivery_order->delivery_order_number}}</td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>{{ $delivery_order->depot." ".$delivery_order->created_at->day." ".$delivery_order->created_at->monthName." ".$delivery_order->created_at->year}}</td>
                    </tr>
                    <tr>
                        <td>No.SO :</td>
                        <td>{{$sales_order->sales_order_number}}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
    <div class="">
        <div class="row">
            <div class="col-6">
                <table>
                    <tr>
                        <td width="50%"></td>
                        <td></td>
                        <td>{{$sales_order->customer->name}}</td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td>{{$delivery_order->detail_address != null ? $delivery_order->detail_address : $sales_order->customer->address}}</td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>&nbsp;</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td>{{$sales_order->customer->npwp}}</td>
                    </tr>
                </table>
            </div>
            <div class="col-6">
                <table>
                    <tr>
                        <td width="50%"></td>
                        <td></td>
                        <td>{{$agen->name}} @if ($delivery_order->transportir) {{"/ ".$delivery_order->transportir}} @endif</td>
                    </tr>
                    <tr>
                        <td class="alamat"></td>
                        <td class="alamat"></td>
                        <td>{{ $delivery_order->address_transportir != null ? $delivery_order->address_transportir : $agen->address}}</td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>&nbsp;</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td>{{$agen->npwp}}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <table class="" style="margin-bottom:0" width="100%">
                <tr class="text-center">
                    <td colspan="2" width="33.3%">&nbsp;</td>
                    <td width="33.3%">&nbsp;</td>
                    <td colspan="2" width="33.3%">&nbsp;</td>
                </tr>
                <tr class="text-center">
                    <td colspan="2" width="33.3%">{{$delivery_order->effective_date_start->day." ".$delivery_order->effective_date_start->monthName." ".$delivery_order->effective_date_start->year}} s/d {{$delivery_order->effective_date_start->day." ".$delivery_order->effective_date_start->monthName." ".$delivery_order->effective_date_start->year}}</td>
                    <td width="33.3%">{{$delivery_order->product->name}}</td>
                    <td colspan="2" width="33.3%">{{$delivery_order->quantity}} {{$delivery_order->piece}}</td>
                </tr>
                <tr>
                    <td width="16.65%"></td>
                    <td width="16.65%">{{$delivery_order->shipped_with}}</td>
                    <td rowspan="2" width="33.3%" class="pt-4">
                        <table>
                            <td width="85%"></td>
                            <td>{{$delivery_order->top_seal}}</td>
                        </table>
                        </td>
                    <td width="20%"></td>
                    <td width="14.65%"></td>
                </tr>
                <tr>
                    <td width="16.65%"></td>
                    <td width="16.65%">{{$delivery_order->no_vehicles}}</td>
                    <td width="20%"></td>
                    <td width="14.65%"></td>
                </tr>
                <tr>
                    <td width="16.65%"></td>
                    <td width="16.65%">{{$delivery_order->km_start}}</td>
                    <td rowspan="2" width="33.3%" class="pt-4"><table>
                        <td width="85%"></td>
                        <td>{{$delivery_order->bottom_seal}}</td>
                    </table>
                    </td>
                    <td width="20%"></td>
                    <td width="14.65%"></td>
                </tr>
                <tr>
                    <td width="16.65%"></td>
                    <td width="16.65%">{{$delivery_order->km_end}}</td>
                    <td width="20%"></td>
                    <td width="14.65%"></td>
                </tr>
                <tr>
                    <td width="16.65%"></td>
                    <td width="16.65%">{{$delivery_order->sg_meter}}</td>
                    <td width="33.3%" class="pt-4">
                        <table>
                            <td width="86%"></td>
                            <td>{{$delivery_order->temperature}}<sup>o</sup></td>
                        </table> </td>
                    <td width="20%"></td>
                    <td width="14.65%"></td>
                </tr>
            </table>
        </div>
    </div>
    <div class="">
        <div class="row">
            <div class="col-2 p-3 ">
                <p class="text-center">

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
    <div class="">
        <div class="row">
            <div class="col-3  text-center">
                &nbsp;
            </div>
            <div class="col-3  text-center">

            </div>
            <div class="col-3   text-center">

            </div>
            <div class="col-3   text-center">

            </div>
        </div>
        <div class="row">
            <div class="col-3  text-center">
                <br>
                <br>
                <br>
                {{$delivery_order->distribution}}
                <br>
                Administrasi Palaran
            </div>
            <div class="col-3   text-center">
                    <br>
                    <br>
                    <br>
                    {{$delivery_order->knowing}}
                    <br>
                    Site Supervisor
            </div>
            <div class="col-3 text-center">
                    <br>
                    <br>
                    <br>
                    <br>
            </div>
            <div class="col-3 ">
              

            </div>
        </div>
    </div>

    <script type="text/javascript">
        window.addEventListener("load", window.print());

    </script>
</body>

</html>
