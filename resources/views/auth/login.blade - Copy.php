<!DOCTYPE html>
<html>


<head>
    <title>Multi Level Marketing</title>
    <meta charset="utf-8">
    <meta content="ie=edge" http-equiv="x-ua-compatible">
    <meta content="template language" name="keywords">
    <meta content="Tamerlan Soziev" name="author">
    <meta content="Admin dashboard html template" name="description">
    <meta content="width=device-width, initial-scale=1" name="viewport">
    <link href="css/favicon.ico" rel="shortcut icon">
    <link href="css/apple-touch-icon.png" rel="apple-touch-icon">
    <link href="css/test.css" rel="stylesheet" type="text/css">
    <link href="css/bower_components/select2/dist/css/select2.min.css" rel="stylesheet">
    <link href="css/bower_components/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">
    <link href="css/bower_components/dropzone/dist/dropzone.css" rel="stylesheet">
    <link href="css/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css" rel="stylesheet">
    <link href="css/bower_components/fullcalendar/dist/fullcalendar.min.css" rel="stylesheet">
    <link href="css/bower_components/perfect-scrollbar/css/perfect-scrollbar.min.css" rel="stylesheet">
    <link href="css/bower_components/slick-carousel/slick/slick.css" rel="stylesheet">
    <link href="css/css/maince5a.css?version=4.4.1" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body class="auth-wrapper">
    <div class="all-wrapper menu-side with-pattern">
        <div class="auth-box-w">
            <div class="logo-w">
                <a href="{{ route('landing.home') }}"><img alt="" src="css/img/logo-big.png"></a>
            </div>
            <h4 class="auth-header">Members Login</h4>
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="form-group">
                    <label for="">Username</label>
                    <input id="email" type="text" placeholder="Enter your username"
                        class="form-control @error('email') is-invalid @enderror" name="email"
                        value="{{ old('email') }}" required autocomplete="email" autofocus>

                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                    <div class="pre-icon os-icon os-icon-user-male-circle"></div>
                </div>
                <div class="form-group">
                    <label for="">Password</label>

                    <input id="password" placeholder="Enter your password" type="password"
                        class="form-control @error('password') is-invalid @enderror" name="password" required
                        autocomplete="current-password">

                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                    <div class="pre-icon os-icon os-icon-fingerprint"></div>
                </div>
                <div class="form-check-inline">
                    <input class="form-check-input" type="checkbox" name="remember" id="remember"
                        {{ old('remember') ? 'checked' : '' }}>

                    <label class="form-check-label" for="remember">
                        {{ __('Remember Me') }}
                    </label>
                </div>
                <div class="buttons-w">
                    <button class="btn btn-primary">Log In</button>
                    <button type="button" class="btn btn-primary"
                        onclick="location.href='{{ url('member-register') }}'">Sign Up</button>

                </div>
            </form>
        </div>
    </div>
</body>


</html>
