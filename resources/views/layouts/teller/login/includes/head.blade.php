<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="Purple Life Organics.">
    <meta name="keywords" content="networking, purple, life, organics">
    <meta name="author" content="Purple Life Organics">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <title>@yield('title') | - {{ env('APP_NAME') }}</title>
    <!-- Fevicon -->
    <link rel="shortcut icon" href="{{ asset('teller_assets/images/fav.png') }}">
    <!-- Start css -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css"
        integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <link href="{{ asset('teller_assets/css/icons.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('teller_assets/css/style.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('css/sweetalert.css') }}" rel="stylesheet" type="text/css">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- End css -->
    <style>
        .send-loading {
            position: fixed;
            left: 0px;
            top: 0px;
            width: 100%;
            height: 100vh;
            z-index: 9999;
            background: url("https://purplelife.ph/img/net-sendloader.gif") center no-repeat rgba(255, 255, 255, 0.5);
            overflow: hidden;
            display: none;
        }

        .pre-loading {
            position: fixed;
            left: 0px;
            top: 0px;
            width: 100%;
            height: 100%;
            z-index: 9999;
            background: url("https://purplelife.ph/img/net-sendloader.gif") center no-repeat #fff;
        }
    </style>
</head>
