<!DOCTYPE html>
<html lang="en">
<head>
	<title>Admin Login</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->
	<link rel="icon" type="image/png" href="{{asset('backend/login')}}/images/icons/favicon.ico"/>
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{asset('backend/login')}}/vendor/bootstrap/css/bootstrap.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{asset('backend/login')}}/fonts/font-awesome-4.7.0/css/font-awesome.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{asset('backend/login')}}/vendor/animate/animate.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{asset('backend/login')}}/vendor/css-hamburgers/hamburgers.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{asset('backend/login')}}/vendor/select2/select2.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{asset('backend/login')}}/css/util.css">
	<link rel="stylesheet" type="text/css" href="{{asset('backend/login')}}/css/main.css">
<!--===============================================================================================-->
<link rel="stylesheet" href="{{asset('backend')}}/assets/izitost.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<style media="screen">
.login100-form {
  width: 290px;
  margin: 0 auto;
}
</style>
</head>
<body>

	<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100">


				<form class="login100-form validate-form" action="{{route('admin.login')}}" method="post">
					@csrf
					<span class="login100-form-title">
					 Login
					</span>

					<div class="wrap-input100 validate-input" data-validate = "user name is required">
						<input class="input100" type="text" name="email" placeholder="Enter Email" >
                                @error('user_name')
                            <div style="color:red">{{ $message }}</div>
                                @enderror
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-envelope" aria-hidden="true"></i>
						</span>
					</div>

					<div class="wrap-input100 validate-input" data-validate = "Password is required">
						<input class="input100" type="password" name="password" placeholder="Password" >
						@error('password')
						<div style="color:red">{{ $message }}</div>
						@enderror
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

					<div class="text-center p-t-12">

					</div>

					<div class="text-center p-t-136">
						<a class="txt2" href="#">
							<!-- Create your Account -->
							<!-- <i class="fa fa-long-arrow-right m-l-5" aria-hidden="true"></i> -->
						</a>
					</div>
				</form>
			</div>
		</div>
	</div>




<!--===============================================================================================-->
	<script src="{{asset('backend/login')}}/vendor/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
	<script src="{{asset('backend/login')}}/vendor/bootstrap/js/popper.js"></script>
	<script src="{{asset('backend/login')}}/vendor/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
	<script src="{{asset('backend/login')}}/vendor/select2/select2.min.js"></script>
<!--===============================================================================================-->
	<script src="{{asset('backend/login')}}/vendor/tilt/tilt.jquery.min.js"></script>
	<script >
		$('.js-tilt').tilt({
			scale: 1.1
		})
	</script>

	<script src="{{asset('backend')}}/assets/izitost.js"></script>
	<script>
			@if(Session::has('messege'))
			var type = "{{Session::get('alert-type','info')}}"
			switch (type) {
					case 'success':

							iziToast.success({
									message: '{{ Session::get('messege') }}',
									'position':'topRight'
							});
							brack;
					case 'info':
							iziToast.info({
									message: '{{ Session::get('messege') }}',
									'position':'topRight'
							});
							brack;
					case 'warning':
							iziToast.warning({
									message: '{{ Session::get('messege') }}',
									'position':'topRight'
							});
							break;
					case 'error':
							iziToast.error({
									message: '{{ Session::get('messege') }}',
									'position':'topRight'
							});
							break;
			}
			@endif
	</script>
<!--===============================================================================================-->
	<script src="{{asset('backend/login')}}/js/main.js"></script>

</body>
</html>
