<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Tcon Cost | Log in</title>
	<!-- Tell the browser to be responsive to screen width -->
	<meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="{{ asset('/icon.jpg') }}">

	<!-- Font Awesome -->
	<link rel="stylesheet" href="/admin/plugins/fontawesome-free/css/all.min.css">
	<!-- Ionicons -->
	<link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
	<!-- icheck bootstrap -->
	<link rel="stylesheet" href="/admin/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
	<!-- Theme style -->
	<link rel="stylesheet" href="/admin/dist/css/adminlte.min.css">
	<!-- Google Font: Source Sans Pro -->
	<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>

<body class="hold-transition login-page">
	<div class="login-box">
	<div class="login-logo">
			<img class="profile-user-img img-fluid img-circle" src="/logo.jpg" alt="User profile picture">
		</div>
		<!-- /.login-logo -->


				<form method="POST" action="{{ route('login') }}">
					@csrf
					<div class="input-group mb-3">
						<input type="email" class="form-control" placeholder="Email" id="email" type="email" class="form-control " name="email" value="{{ old('email') }}" required>
						<div class="input-group-append">
							<div class="input-group-text">
								<span class="fas fa-envelope"></span>
							</div>
						</div>

					</div>

					<div class="input-group mb-3">
						<input type="password" class="form-control" placeholder="Password" id="remember" id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required>
						<div class="input-group-append">
							<div class="input-group-text">
								<span class="fas fa-lock"></span>
							</div>
						</div>
					</div>

					<div class="row">
						<!-- /.col -->
							<button type="submit" class="btn btn-block btn-outline-success btn-lg">Sign In</button>
						<!-- /.col -->
					</div>
				</form>

	</div>
	<!-- /.login-box -->

	<!-- jQuery -->
	<script src="/admin/plugins/jquery/jquery.min.js"></script>
	<!-- Bootstrap 4 -->
	<script src="/admin/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
	<!-- AdminLTE App -->
	<script src="/admin/dist/js/adminlte.min.js"></script>

</body>

</html>