<!doctype html>
<html lang="en" class="{{ themeStyle() }}">

<head>
	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="robots" content="noindex, nofollow" />  
	<meta name="csrf-token" content="{{ csrf_token() }}" />
	<!--favicon-->
	<x-admin.style></x-admin.style>
	@yield('css')
	@php
		$title = setting()->app_title ?? config('app.name');
	@endphp
	<title>{{$title}} - @yield('title')</title>
</head>

<body>
	<!--wrapper-->
	<div class="wrapper">
		<!--sidebar wrapper -->
		<x-admin.side-bar></x-admin.side-bar>
		<!--end sidebar wrapper -->
		<!--start header -->
		<x-admin.header></x-admin.header>
		<!--end header -->
		<!--start page wrapper -->
		@section('title')
		@yield('content')
		<!--end page wrapper -->
		<!--start overlay-->
		 <div class="overlay toggle-icon"></div>
		<!--end overlay-->
		<!--Start Back To Top Button-->
		  <a href="javaScript:;" class="back-to-top"><i class='bx bxs-up-arrow-alt'></i></a>
		<!--End Back To Top Button-->
		<x-admin.footer></x-admin.footer>
	</div>
	<!--end wrapper-->
	<x-admin.script></x-admin.script>
	
	@yield('js')
</body>

</html>