<head>
    <!-- Meta -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta name="author" content="Awaiken">
    <!-- Page Title -->
    <title>@yield('title')</title>
    <!-- Favicon Icon -->
	<link rel="shortcut icon" type="image/x-icon" href="{{ asset('new_landing/images/logs.png')}}">
    <!-- Google Fonts css-->
    <link rel="preconnect" href="https://fonts.googleapis.com/">
    <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:opsz,wght@9..40,100;9..40,200;9..40,300;9..40,400;9..40,500;9..40,600;9..40,700;9..40,800;9..40,900&amp;family=Sintony:wght@400;700&amp;display=swap" rel="stylesheet">
    <!-- Bootstrap css -->
    <link href="{{ asset('new_landing/css/bootstrap.min.css')}}" rel="stylesheet" media="screen">
    <!-- SlickNav css -->
    <link href="{{ asset('new_landing/css/slicknav.min.css')}}" rel="stylesheet">
    <!-- Swiper css -->
    <link rel="stylesheet" href="{{ asset('new_landing/css/swiper-bundle.min.css')}}">
    <!-- Font Awesome icon css-->
    <link href="{{ asset('new_landing/css/all.min.css')}}" rel="stylesheet" media="screen">
    <!-- Animated css -->
    <link href="{{ asset('new_landing/css/animate.css')}}" rel="stylesheet">
    <!-- Magnific css -->
    <link href="{{ asset('new_landing/css/magnific-popup.css')}}" rel="stylesheet">
    <!-- Main custom css -->
    <link href="{{ asset('new_landing/css/custom.css')}}" rel="stylesheet" media="screen">

    @yield('stylesheets')

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
