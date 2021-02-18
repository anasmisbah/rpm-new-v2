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
                height: 30px;
                -webkit-print-color-adjust: exact;
            }
        }
        table td.alamat{
            display: table-cell;
  vertical-align: top;
        }
        body{
            font: 1em sans-serif;
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

        <div class="row mt-4">
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
            <div class="col-6 offset-3" >
                <table width="100%">
                    <tr>
                        <td width="35%"></td>
                        <td class="text-left" style="padding-left: 20px">{{$delivery_order->delivery_order_number}}</td>
                    </tr>
                    <tr>
                        <td></td>
                        <td class="text-left" style="padding-left: 20px">&nbsp;</td>
                    </tr>
                    <tr>
                        <td></td>
                        <td class="text-left" style="padding-left: 20px">{{ $delivery_order->depot." ".$delivery_order->created_at->day." ".$delivery_order->created_at->monthName." ".$delivery_order->created_at->year}}</td>
                    </tr>
                    <tr>
                        <td class="text-right" style="padding-right: 55px">No.SO :</td>
                        <td class="text-left" style="padding-left: 20px">{{$sales_order->sales_order_number}}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
    <div class="" style="margin-top: 18.5px">
        <div class="row offset-1">
            <div class="col-5" style="padding-left: 80px">
                    {{$sales_order->customer->name}}&nbsp;
                    <br>
                    <br>
                    {{$delivery_order->detail_address != null ? $delivery_order->detail_address : $sales_order->customer->address}}&nbsp;
                    <br><br><br>
                    {{$sales_order->customer->npwp}}&nbsp;
            </div>
            <div class="col-5 offset-1" style="padding-left: 50px">
                    {{$agen->name}}  @if ($delivery_order->transportir) <br> {{"(".$delivery_order->transportir.")"}} @endif &nbsp;
                    <br>
                    <br>
                    {{ $delivery_order->address_transportir != null ? $delivery_order->address_transportir : $agen->address}} &nbsp;
                    <br><br><br>
                    {{$agen->npwp}}&nbsp;
            </div>
        </div>
    </div>
    <div class="row" style="margin-top: 30px">
        <div class="col-12">
            <table class="table-borderless" style="margin-bottom:0" width="100%">
                <tr class="text-left" height="38px">
                    <td style="padding-left: 80px" width="28.3%">{{$delivery_order->effective_date_start->day}} - {{$delivery_order->effective_date_end->day." ".$delivery_order->effective_date_end->monthName." ".$delivery_order->effective_date_end->year}}</td>
                    <td width="36.3%" style="padding-left: 30px">{{$delivery_order->product->name}}</td>
                    <td  width="36.3%" style="padding-left: 80px"> <span class="amount">{{$delivery_order->quantity}}</span> {{$delivery_order->piece}}</td>
                </tr>
                <tr>
                    <td style="padding-left: 141px;">
                        <div class="height:200px">
                            <div style="margin-top: 13px !important">{{$delivery_order->shipped_with}}</div>
                            <div style="margin-top: 18px !important">{{$delivery_order->no_vehicles}}</div>
                            <div style="margin-top: 18px !important">{{$delivery_order->km_start}}</div>
                            <div style="margin-top: 18px !important">{{$delivery_order->km_end}}</div>
                            <div style="margin-top: 18px !important;margin-bottom: 18px !important">{{$delivery_order->sg_meter}}</div>
                        </div>
                    </td>
                    <td style="padding-left: 125px;vertical-align:text-top;">
                        <div class="height:200px">
                            <div style="margin-top: 30px !important">{{$delivery_order->top_seal}}</div>
                            <div style="margin-top: 40px !important">{{$delivery_order->bottom_seal}}</div>
                            <div style="margin-top: 40px !important">{{$delivery_order->temperature}} <sup>o</sup>C</div>
                        </div>
                    </td>
                </tr>
                <tr></tr>
                <tr height="30px" class="text-left">
                    <td style="padding-left: 111px;padding-top: 23px;">
                        <i># {{$quantity_terbilang}} #</i>
                    </td>
                </tr>
            </table>
        </div>
    </div>
    {{-- <div class="">
        <div class="row">
            <div class=" offset-1 col-11  ">
                    <i># {{$quantity_terbilang}} Lorem ipsum, dolor sit amet consectetur adipisicing elit. Commodi, beatae. #</i>
            </div>
            <div class="col-9 p-3">
                <div class="kotak pl-3">
                    # {{$quantity_terbilang}} #
                </div>
                <div class="kotak mt-2">

                </div>
            </div>
        </div>
    </div> --}}
    <div class="" style="margin-top: 70px !important">
        <div class="row">
            <div class="col-3 text-left" style="padding-left: 80px">
                Administrasi
                <div style="height: 60px"></div>
                {{$delivery_order->admin_name}}
            </div>
            <div class="col-3 text-left" style="padding-left: 10px">
                Site Supervisor
                <div style="height: 60px"></div>
                    {{$delivery_order->knowing}}
            </div>
            <div class="col-2 text-left">
                <div style="height: 60px"></div>
            </div>
            <div class="col-3 text-left" style="padding-left:50px">
                {{$delivery_order->driver->name}}
            </div>
        </div>
    </div>
    <script src="{{asset('plugins/jquery/jquery.min.js')}}"></script>
    <script src="{{asset('dist/js/number-divider.min.js')}}"></script>
    <script>
        $(function () {
            // Number Divide
            $(".amount").divide({
                delimiter:'.',
                divideThousand:true
            });
        });
    </script>
    <script type="text/javascript">
        window.addEventListener("load", window.print());

    </script>
</body>

</html>
