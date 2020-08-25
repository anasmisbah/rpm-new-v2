<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{asset('dist/css/adminlte.min.css')}}">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Print Cuopon</title>
</head>
<body>
    <div class="container mt-2">
        <div class="row justify-content-center">
            <h2>Coupon Customer {{$customer->name}}</h2>

        </div>
        <hr style="border:0.5px solid" class="mb-5">
        <div class="row justify-content-center">
            @foreach ($customer->coupons as $coupon)
            <div class="col-2 p-3 align-middle pt-4 mr-2 mb-2" style="border: 1px solid">
                <p class="text-center" style="font-size:14px">{{$coupon->code_coupon}}</p>
            </div>
            @endforeach
        </div>
    </div>
</body>
</html>
