@extends('layouts.teller.login.master')

@section('title', '404 Page Not Found')

@section('contents')
<!-- Start row -->
<div class="auth-box error-box">
	<!-- Start row -->
	<div class="row no-gutters align-items-center justify-content-center">
		<!-- Start col -->
			<div class="text-center">
				<img src="{{ asset('images/logo.png') }}" class="img-fluid error-logo" alt="logo">
				
                <br>
				<img src="{{ asset('images/error/404.svg') }}" class="img-fluid error-image" alt="404">
				<h4 class="error-subtitle mb-4">Oops! Page not Found</h4>
				<p class="mb-4">We did not find the page you are looking for. Please return to previous page or visit home page. </p>
				<a href="./" class="btn btn-warning font-16"><i class="feather icon-home mr-2"></i> Go back</a>
			</div>

		<!-- End col -->
	</div>
	<!-- End row -->
</div>
<!-- End row -->
@endsection
