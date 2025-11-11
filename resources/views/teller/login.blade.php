@extends('layouts.teller.login.master')

@section('title', 'Login')

@section('contents')
<!-- Start row -->
<div class="col-md-6 col-lg-5">
	<div class="auth-box-left">
		<div class="card">
			<div class="card-body">
				<h4 class="text-white">Purple Ogranic Products</h4>
				<div class="auth-box-icon">
					<img src="{{ asset('teller_assets/images/authentication/auth-box-icon.svg') }}" class="img-fluid" alt="auth-box-icon">
				</div>
				<div class="auth-box-logo">
					<img src="{{ asset('teller_assets/images/logo.png') }}" class="img-fluid " alt="logo">
				</div>
			</div>
		</div>
	</div>
</div>
<!-- Start end -->
<!-- Start col -->
<div class="col-md-6 col-lg-5">
	<!-- Start Auth Box -->
	<div class="auth-box-right">
		<div class="card">
			<div class="card-body">
				<form method="POST" action="{{ route('login') }}">
					@csrf
					<h4 class="text-primary mb-4">Log in !</h4>
					<div class="form-group">
						<input type="text" class="form-control @error('email') is-invalid @enderror" id="email" placeholder="Enter Username here" name="email" value="{{ old('email') }}" autocomplete="email" autofocus required>
						@error('email')
						<span class="invalid-feedback" role="alert">
							<strong>{{ $message }}</strong>
						</span>
						@enderror
					</div>
					<div class="form-group">
						<input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" placeholder="Enter Password here" autocomplete="current-password" required>
						@error('password')
						<span class="invalid-feedback" role="alert">
							<strong>{{ $message }}</strong>
						</span>
						@enderror
					</div>
					<div class="form-row mb-3">
						<div class="col-sm-6">
							<div class="custom-control custom-checkbox">
								<!--<input type="checkbox" class="custom-control-input" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>-->
								<input type="checkbox" class="custom-control-input" id="rememberme" {{ old('remember') ? 'checked' : '' }}>
								<label class="custom-control-label font-14" for="rememberme">{{ __('Remember Me') }}</label>
							</div>
						</div>
						<div class="col-sm-6">
							<div class="forgot-psw">
								<a id="forgot-psw" href="user-forgotpsw.html" class="font-14">Forgot Password?</a>
							</div>
						</div>
					</div>
					<button type="submit" class="btn btn-success btn-lg btn-block font-18">Log in Now</button>
					<!--<button type="button" class="btn btn-primary" onclick="location.href='{{ url('member-register') }}'">Sign Up</button>-->
				</form>
				<div class="login-or">
					<h6 class="text-muted">OR</h6>
				</div>
				<!--<div class="social-login text-center">
					<button type="submit" class="btn btn-primary-rgba btn-lg btn-block font-18"><i class="mdi mdi-facebook mr-2"></i>Log in with Facebook</button>
					<button type="submit" class="btn btn-danger-rgba btn-lg btn-block font-18"><i class="mdi mdi-google mr-2"></i>Log in with Google</button>
				</div>-->
				<p class="mb-0 mt-3">Don't have a account? <a href="{{ url('member-register') }}">Sign up</a></p>
			</div>
		</div>
	</div>
	<!-- End Auth Box -->
</div>
<!-- End row -->
@endsection
