<!DOCTYPE html>
<html lang="en">
<head>
	<title>Admin Login</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->
	<link rel="icon" type="image/png" href="<?php echo e(asset('backend/login')); ?>/images/icons/favicon.ico"/>
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?php echo e(asset('backend/login')); ?>/vendor/bootstrap/css/bootstrap.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?php echo e(asset('backend/login')); ?>/fonts/font-awesome-4.7.0/css/font-awesome.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?php echo e(asset('backend/login')); ?>/vendor/animate/animate.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?php echo e(asset('backend/login')); ?>/vendor/css-hamburgers/hamburgers.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?php echo e(asset('backend/login')); ?>/vendor/select2/select2.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?php echo e(asset('backend/login')); ?>/css/util.css">
	<link rel="stylesheet" type="text/css" href="<?php echo e(asset('backend/login')); ?>/css/main.css">
<!--===============================================================================================-->
<link rel="stylesheet" href="<?php echo e(asset('backend')); ?>/assets/izitost.css">
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


				<form class="login100-form validate-form" action="<?php echo e(route('admin.login')); ?>" method="post">
					<?php echo csrf_field(); ?>
					<span class="login100-form-title">
					 Login
					</span>

					<div class="wrap-input100 validate-input" data-validate = "user name is required">
						<input class="input100" type="text" name="email" placeholder="Enter Email" >
							<?php $__errorArgs = ['user_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
					    <div style="color:red"><?php echo e($message); ?></div>
							<?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-envelope" aria-hidden="true"></i>
						</span>
					</div>

					<div class="wrap-input100 validate-input" data-validate = "Password is required">
						<input class="input100" type="password" name="password" placeholder="Password" >
						<?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
						<div style="color:red"><?php echo e($message); ?></div>
						<?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
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
	<script src="<?php echo e(asset('backend/login')); ?>/vendor/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
	<script src="<?php echo e(asset('backend/login')); ?>/vendor/bootstrap/js/popper.js"></script>
	<script src="<?php echo e(asset('backend/login')); ?>/vendor/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
	<script src="<?php echo e(asset('backend/login')); ?>/vendor/select2/select2.min.js"></script>
<!--===============================================================================================-->
	<script src="<?php echo e(asset('backend/login')); ?>/vendor/tilt/tilt.jquery.min.js"></script>
	<script >
		$('.js-tilt').tilt({
			scale: 1.1
		})
	</script>

	<script src="<?php echo e(asset('backend')); ?>/assets/izitost.js"></script>
	<script>
			<?php if(Session::has('messege')): ?>
			var type = "<?php echo e(Session::get('alert-type','info')); ?>"
			switch (type) {
					case 'success':

							iziToast.success({
									message: '<?php echo e(Session::get('messege')); ?>',
									'position':'topRight'
							});
							brack;
					case 'info':
							iziToast.info({
									message: '<?php echo e(Session::get('messege')); ?>',
									'position':'topRight'
							});
							brack;
					case 'warning':
							iziToast.warning({
									message: '<?php echo e(Session::get('messege')); ?>',
									'position':'topRight'
							});
							break;
					case 'error':
							iziToast.error({
									message: '<?php echo e(Session::get('messege')); ?>',
									'position':'topRight'
							});
							break;
			}
			<?php endif; ?>
	</script>
<!--===============================================================================================-->
	<script src="<?php echo e(asset('backend/login')); ?>/js/main.js"></script>

</body>
</html>
<?php /**PATH F:\xampp\htdocs\MeritTutorsProjectUpdate\ResourceProject\resources\views/backend/login/login.blade.php ENDPATH**/ ?>