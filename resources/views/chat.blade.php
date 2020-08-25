<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{asset('dist/css/adminlte.min.css')}}">
    <style>
        .title{
            margin: 20px;
            text-align: center;
            border-bottom: 2px solid #fff;
            padding-bottom: 3%
        }
        .img-service{
            height: 200px;
            width: auto;
            margin-top: 50px
        }
    </style>
    <title>Chat With Us</title>
</head>
<body class="bg-dark">

    <div class="container ">
        <div class="row justify-content-center">
            <h3 class="title">Customer Service</h3>
        </div>
        <div class="row justify-content-center">
            <img src="{{asset('dist/img/chat.svg')}}" class="img-service">
        </div>
    </div>

    <!--Start of Tawk.to Script-->
    <script src="{{asset('plugins/jquery/jquery.min.js')}}"></script>
<script type="text/javascript">
    var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
    (function(){
    var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
    s1.async=true;
    s1.src='https://embed.tawk.to/5e5e4f636d48ff250ad9083f/default';
    s1.charset='UTF-8';
    s1.setAttribute('crossorigin','*');
    s0.parentNode.insertBefore(s1,s0);



    })();
    </script>
    <!--End of Tawk.to Script-->
<script>
    $(document).ready(function(){
    $('#tawkchat-container').trigger('click')
});
</script>
</body>
</html>
