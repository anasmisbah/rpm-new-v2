
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Delivery Order</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Bootstrap 4 -->

  <link rel="stylesheet" href="{{asset('plugins/fontawesome-free/css/all.min.css')}}">
  <link rel="shortcut icon" href="{{asset('/img/favico.jpg')}}" type="image/x-icon">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">

  <link rel="stylesheet" href="{{asset('dist/css/adminlte.min.css')}}">

  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>
<body>
<div class="wrapper">
  <!-- Main content -->
  <section class="invoice">
    <!-- title row -->
    <div class="row">
      <div class="col-12">
        <h2 class="page-header">
            <img src="{{asset('img/logo.png')}}" class="img-circle" alt="comp pict" width="200px"> 
          <small class="float-right">{{$date->dayName.", ".$date->day." ".$date->monthName." ".$date->year}}</small>
        </h2>
      </div>
    </div>
    <div class="row invoice-info">
        <div class="col-sm-5 invoice-col">
            <address>
              <strong>{{$company->name}}</strong><br>
              Phone: {{$company->phone}}<br>
              Email: {{$company->email}}<br>
              Website: {{$company->website}}<br>
            </address>
        </div>
        <div class="col-sm-7 invoice-col">
            <b>No Sales Order {{$sales_order->sales_order_number}}</b><br>
            <br>
            <b>No Delivery Order :</b> {{$delivery_order->delivery_order_number}}<br>
            <b>Tanggal :</b> {{$delivery_order->created_at->day." ".$delivery_order->created_at->monthName." ".$delivery_order->created_at->year}}<br>
            <b>Agen : </b> {{$agen->name}}<br>
            <b>Tanggal Berlaku </b> {{$delivery_order->effective_date_start->day." ".$delivery_order->effective_date_start->monthName." ".$delivery_order->effective_date_start->year}} - {{$delivery_order->effective_date_start->day." ".$delivery_order->effective_date_start->monthName." ".$delivery_order->effective_date_start->year}}
        </div>
    </div>
    <br>
    <div class="row invoice-info">
        <div class="col-sm-5 invoice-col">
            Agen
            <address>
            <strong>{{$agen->name}}</strong><br>
            {{$agen->address}}
            N.P.W.P: {{$agen->npwp}}<br>
            Phone: {{$agen->phone}}<br>
            website: {{$agen->website}}
            </address>
        </div>
        <div class="col-sm-3 invoice-col">
            Pelaggan
            <address>
                <strong>{{$sales_order->customer->name}}</strong><br>
                {{$sales_order->customer->address}}
                N.P.W.P: {{$sales_order->customer->npwp}}<br>
                Phone: {{$sales_order->customer->phone}}<br>
                website: {{$sales_order->customer->website}}
            </address>
        </div>
    </div>
    <div class="row">
      <div class="col-12 table-responsive">
        <table class="table table-striped">
          <thead>
          <tr>
            <th>Kwantitas</th>
            <th>Produk</th>
            <th>Segel Atas</th>
            <th>Segel Bawah</th>
            <th>Temperatur</th>
          </tr>
          </thead>
          <tbody>
          <tr>
            <td>{{$delivery_order->quantity}}</td>
            <td>{{$delivery_order->product}}</td>
            <td>{{$delivery_order->top_seal}}</td>
            <td>{{$delivery_order->bottom_seal}}</td>
            <td>{{$delivery_order->temperature}}</td>
          </tr>
          </tbody>
        </table>
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->

    <div class="row">
        <div class="col-6">
            <p class="lead">Detail Pengiriman</p>
            <div class="table-responsive">
                <table class="table">
                    <tr>
                        <th style="width:50%">Dikirim Dengan:</th>
                        <td>{{$delivery_order->shipped_with}}</td>
                    </tr>
                    <tr>
                        <th>No Kendaraan:</th>
                        <td>{{$delivery_order->no_vehicles}}</td>
                    </tr>
                    <tr>
                        <th>KM Awal:</th>
                        <td>{{$delivery_order->km_start}}</td>
                    </tr>
                    <tr>
                        <th>KM Akhir:</th>
                        <td>{{$delivery_order->km_end}}</td>
                    </tr>
                    <tr>
                        <th>SG Meter:</th>
                        <td>{{$delivery_order->sg_meter}}</td>
                    </tr>
                </table>
            </div>
        </div>
        <div class="col-6">
            <p class="lead">Waktu Pengiriman</p>
            <div class="table-responsive">
                <table class="table">
                    <tr>
                        <th style="width:50%">Jam Berangkat:</th>
                        <td>{{$delivery_order->departure_time->day." ".$delivery_order->departure_time->monthName." ".$delivery_order->departure_time->year}} | {{$delivery_order->departure_time->format('H:i:s')}}</td>
                    </tr>
                    <tr>
                        <th>Jam Tiba:</th>
                        <td>{{$delivery_order->arrival_time->day." ".$delivery_order->arrival_time->monthName." ".$delivery_order->arrival_time->year}} | {{$delivery_order->arrival_time->format('H:i:s')}}</td>
                    </tr>
                    <tr>
                        <th>Jam Mulai Pembongkaran:</th>
                        <td>-</td>
                    </tr>
                    <tr>
                        <th>Jam Selesai Pembongkaran:</th>
                        <td>-</td>
                    </tr>
                    <tr>
                        <th>Jam Tiba di Depo:</th>
                        <td>-</td>
                    </tr>
                </table>
            </div>
        </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->
  </section>
  <!-- /.content -->
</div>
<!-- ./wrapper -->

<script type="text/javascript">
  window.addEventListener("load", window.print());
</script>
</body>
</html>
