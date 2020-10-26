
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Login | Reward Point Management</title>
	<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="{{asset('img/favico.png')}}" type="image/x-icon">
<!--===============================================================================================-->
	<link rel="icon" type="image/png" href="images/icons/favicon.ico"/>
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{asset('asset_login/vendor/bootstrap/css/bootstrap.min.css')}}">
<!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{asset('asset_login/fonts/font-awesome-4.7.0/css/font-awesome.min.css')}}">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{asset('asset_login/vendor/animate/animate.css')}}">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{asset('asset_login/vendor/css-hamburgers/hamburgers.min.css')}}">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{asset('asset_login/css/util.css')}}">
	<link rel="stylesheet" type="text/css" href="{{asset('asset_login/css/main.css')}}">
<!--===============================================================================================-->
</head>
<body>

	<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100">
				<div class="login100-pic js-tilt" data-tilt>
					<img src="{{asset('asset_login/images/img-01.png')}}" alt="IMG">
				</div>

                <form class="login100-form validate-form" action="{{route('login')}}" method="post">
                    <div class="d-flex justify-content-center">

                        <img src="{{asset('img/favico.png')}}" alt="Logo Perusahaan" width="200px" class="align-center">
                    </div>
                    @csrf
					<span class="login100-form-title">
						Reward Point Management
					</span>

					<div class="wrap-input100 validate-input" data-validate = "Masukkan email valid : data@abc.xyz">
						<input class="input100" type="text" name="email" value="{{old('email')}}" placeholder="Email">
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-envelope" aria-hidden="true"></i>
						</span>
					</div>

					<div class="wrap-input100 validate-input" data-validate = "Password Wajib diisi">
						<input class="input100" type="password" name="password" placeholder="Password">
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-lock" aria-hidden="true"></i>
						</span>
					</div>

					<div class="container-login100-form-btn">
						<button class="login100-form-btn">
							Login
						</button>
					</div>

					<div class="text-center p-t-136">
						<a class="txt2" href="#">
							Copyright &copy; 2020
						</a>
					</div>
				</form>
			</div>
		</div>
	</div>




<!--===============================================================================================-->
    <script src="{{asset('plugins/jquery/jquery.min.js')}}"></script>
<!--===============================================================================================-->
	<script src="{{asset('asset_login/vendor/bootstrap/js/popper.js')}}"></script>
	<script src="{{asset('asset_login/vendor/bootstrap/js/bootstrap.min.js')}}"></script>
<!--===============================================================================================-->
	<script src="{{asset('asset_login/vendor/tilt/tilt.jquery.min.js')}}"></script>
	<script >
		$('.js-tilt').tilt({
			scale: 1.1
		})
	</script>
<!--===============================================================================================-->
    <script src="{{asset('asset_login/js/main.js')}}"></script>
    <script src="{{asset('plugins/sweetalert.min.js')}}"></script>
    <script>
        $(function(){
            var error = '{{ $errors->first() }}'
            if (error) {
               swal("Login Failed!", error, "error");
            }

        })
    </script>

</body>
</html>
