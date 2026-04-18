<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Member Login | {{ env('APP_NAME') }}</title>

    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ asset('new_landing/images/logs.png') }}" />
    <link rel="stylesheet" href="{{ asset('dashboard/vendors/bundle.css') }}" type="text/css">
	<link rel="stylesheet" href="{{ asset('dashboard/assets/css/app.min.css') }}" type="text/css">
	<meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body class="form-membership">

    <!-- begin::preloader-->
    <div class="preloader">
        <div class="preloader-icon"></div>
    </div>
    <!-- end::preloader -->

    <div class="form-wrapper">


        <!-- logo -->
        <div id="logo">
            <img class="logo img-fluid" src="{{ asset('new_landing/images/logs.png') }}" alt="image">
            
        </div>
        <!-- ./ logo -->

        <h5>Sign in</h5>
        
        <!-- form -->
        <form  method="POST" action="{{ route('login') }}" id="member-login-form">
            <div class="form-group">
					<input type="hidden" name="_token" value="{{ csrf_token() }}">
				<input type="text" class="form-control" id="username" name="username" placeholder="Username or email" required autofocus>
            </div>
            <div class="form-group">
				<input type="password" class="form-control" id="password" name="password" placeholder="Password" required>			
            </div>
            @error('username')
		    <span class="invalid text-danger" role="alert">
		    	<strong>{{ $message }}</strong><br>
		    </span>
		    @enderror

            @error('email')
		    <span class="invalid text-danger" role="alert">
		    	<strong>{{ $message }}</strong><br>
		    </span>
		    @enderror

            @error('password')
		    <span class="invalid text-danger" role="alert">
		    	<strong>{{ $message }}</strong><br>
		    </span>
		    @enderror
            <!-- <div class="form-group d-flex justify-content-between">
                <div class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input" checked="" id="customCheck1">
                    <label class="custom-control-label" for="customCheck1">Remember me</label>
                </div>
                <a href="{{route('forgot-password')}}">Reset password</a>
            </div> -->
            <button class="btn btn-primary btn-block" type="submit">Sign in</button>
            <hr>
            <p class="text-muted">Don't have an account?</p>
            <a href="{{route('landing.application')}}" class="btn btn-outline-light btn-sm">Register now!</a>
        </form>
        <!-- ./ form -->


    </div>

    <!-- Plugin scripts -->
    <script src="{{ asset('dashboard/vendors/bundle.js') }}"></script>

    <!-- App scripts -->
    <script>
        var token = "{{ csrf_token() }}";
        var title = "{{ env('APP_NAME') }}";
    </script>
	<script src="{{ asset('dashboard/assets/js/app.min.js') }}"></script>
</body>

</html>