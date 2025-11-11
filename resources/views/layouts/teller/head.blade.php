<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="Purple Organics">
    <meta name="keywords" content="Purple Organics">
    <meta name="author" content="Intracode IT Solutions">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <title>@yield('title') | {{ env('APP_NAME') }}</title>
    <!-- Fevicon -->
    <link rel="shortcut icon" href="{{ asset('teller_assets/images/fav.png') }}">
    <!-- Start css -->

    <!-- Switchery css -->
    <link href="{{ asset('teller_assets/plugins/switchery/switchery.min.css') }}" rel="stylesheet">
    <!-- jvectormap css -->
    <link href="{{ asset('teller_assets/plugins/jvectormap/jquery-jvectormap-2.0.2.css') }}" rel="stylesheet">
    <!-- Datepicker css -->
    <link href="{{ asset('teller_assets/plugins/datepicker/datepicker.min.css') }}" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css"
        integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <link href="{{ asset('teller_assets/css/icons.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('teller_assets/css/flag-icon.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('teller_assets/css/style.css') }}" rel="stylesheet" type="text/css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/css/select2.min.css" rel="stylesheet" />
    <!-- swal -->
    <link rel="stylesheet" type="text/css" href="{{ asset('teller_assets/plugins/sweet-alert2/sweetalert2.min.css') }}">

    <!-- loader -->
    <link rel="stylesheet" type="text/css" href="{{ asset('teller_assets/css/loader.css') }}">

    <style>
        .border-red {
            border: 1px solid red !important;
        }

        .capitalized {
            text-transform: capitalize;
        }

        .loading {
            background: lightgrey;
            padding: 15px;
            position: fixed;
            border-radius: 4px;
            left: 50%;
            top: 50%;
            text-align: center;
            margin: -40px 0 0 -50px;
            z-index: 2000;
            display: none;
        }
    </style>
    @yield('stylesheets')
    <!-- End css -->
</head>
