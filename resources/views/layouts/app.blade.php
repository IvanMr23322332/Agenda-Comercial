<!doctype html>

<?php
	if(!isset($_SESSION))
		session_start()
?>

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
		<title>Wafi Admin Template - Admin Dashboard</title>


		<!-- *************
			************ Common Css Files *************
		************ -->
		<!-- Bootstrap css -->
		<link rel="stylesheet" href="{{asset('assets/css/bootstrap.min.css')}}">

		<!-- Icomoon Font Icons css -->
		<link rel="stylesheet" href="{{asset('assets/fonts/style.css')}}">

		<!-- Main css -->
		<link rel="stylesheet" href="{{asset('assets/css/main.css')}}">


		<!-- *************
			************ Vendor Css Files *************
		************ -->
		<!-- DateRange css -->
		<link rel="stylesheet" href="{{asset('assets/vendor/daterange/daterange.css')}}" />

		<!-- Chartist css -->
		<link rel="stylesheet" href="{{asset('assets/vendor/chartist/css/chartist.min.css')}}" />
		<link rel="stylesheet" href="{{asset('assets/vendor/chartist/css/chartist-custom.css')}}" />

		<!-- Steps Wizard CSS -->
		<link rel="stylesheet" href="{{asset('assets/vendor/wizard/jquery.steps.css')}}" />

		<!-- Bootstrap Select CSS -->
		<link rel="stylesheet" href="{{asset('assets/vendor/bs-select/bs-select.css')}}" />

	</head>
	<body>

		<!-- *************
			************ Header section start *************
		************* -->

		<!-- Header start -->
		<header class="header">
			<a href="{{url('home')}}" class="logo" >
				<h3 style="left:50%; padding-top:7px; color:lightgrey; font-size:25px">{{$_SESSION['id_name']}}</h3>
			</a>

			<div class="header-items">

				<!-- Header actions start -->
				<ul class="header-actions">
					<li class="dropdown">
						<a href="{{url('/cerrar_sesion')}}" title="cerrar sesión">
							<i class="icon-log-out"></i>
						</a>
					</li>
				</ul>
				<!-- Header actions end -->
			</div>
		</header>
		<!-- Header end -->







		<!-- *************
			************ Header section end *************
		************* -->

		@yield('section')

	  @yield('script')

	</body>
</html>
