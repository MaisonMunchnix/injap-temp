@extends('layouts.teller.login.master')

@section('title', '500 Internal Server Error')

@section('contents')
<!-- Start row -->
<div class="auth-box error-box">
	<!-- Start row -->
	<div class="row no-gutters align-items-center justify-content-center">
		<!-- Start col -->
			<div class="text-center">
				<img src="{{ asset('images/logo.png') }}" class="img-fluid error-logo" alt="logo">
				<img src="{{ asset('teller_assets/images/error/internal-server.svg') }}" class="img-fluid error-image" alt="505">
				<h4 class="error-subtitle mb-4">500 Internal Server Error</h4>
				<p class="mb-4">The server encountered an internal error or misconfiguration and was unable to complete your request.</p>
				<a href="./" class="btn btn-primary font-16"><i class="feather icon-home mr-2"></i> Go back</a>
			</div>

		<!-- End col -->
	</div>
	<!-- End row -->
</div>
<!-- End row -->
@endsection
