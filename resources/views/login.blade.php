<!doctype html>
<html lang="en">
	<head>
		<!-- Required meta tags -->
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

		<!-- Meta -->
		<meta name="description" content="Responsive Bootstrap4 Dashboard Template">
		<meta name="author" content="ParkerThemes">
		<link rel="shortcut icon" href="{{asset('assets/img/fav.png')}}" />

		<!-- Title -->
		<title>Wafi Admin Template - Login</title>

		<!-- *************
			************ Common Css Files *************
		************ -->
		<!-- Bootstrap CSS -->
		<link rel="stylesheet" href="{{asset('assets/css/bootstrap.min.css')}}" />

		<!-- Master CSS -->
		<link rel="stylesheet" href="{{asset('assets/css/main.css')}}" />

	</head>

	<body class="authentication">

		<!-- Container start -->
		<div class="container">

			<form action="verificationLogIn" method="POST">
				@csrf
				<div class="row justify-content-md-center">
					<div class="col-xl-4 col-lg-5 col-md-6 col-sm-12">
						<div class="login-screen">
							<div class="login-box">
								<a href="#" class="login-logo">
									<img src="{{asset('assets/img/logo-dark.png')}}" alt="Wafi Admin Dashboard" />
								</a>
								<h5>Bienvenido,<br />Por favor, Inicie Sesión con su Cuenta.</h5>
								<div class="form-group">
									<input type="email" name="email" class="form-control" placeholder="Correo Electrónico" required/>
								</div>
								<div class="form-group">
									<input type="password" name="password" class="form-control" placeholder="Contraseña" required/>
								</div>
								<div class="actions mb-4">
									<button type="submit" class="btn btn-primary">Iniciar Sesión</button>
								</div>
								{{-- <div class="forgot-pwd">
									<a class="link" href="/forgot-pwd">¿Contraseña olvidada?</a>
								</div>
								<hr> --}}
								{{-- <div class="actions align-left">
									<span class="additional-link">New here?</span>
									<a href="signup.html" class="btn btn-dark">Create an Account</a>
								</div> --}}
							</div>
						</div>
					</div>
				</div>
			</form>

		</div>
		<!-- Container end -->

	</body>
</html>
