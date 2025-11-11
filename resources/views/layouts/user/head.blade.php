<title>@yield('title')</title>
<meta charset="utf-8">
<meta content="ie=edge" http-equiv="x-ua-compatible">
<meta content="Purple Organics" name="keywords">
<meta content="Intracode IT Solutions" name="author">
<meta content="Purple Life Organics Inc." name="description">
<meta content="width=device-width, initial-scale=1" name="viewport">
<link href="{{ asset('css/favicon.ico') }}" rel="shortcut icon">
<link href="apple-touch-icon.png" rel="apple-touch-icon">
<link href="https://fast.fonts.net/cssapi/487b73f1-c2d1-43db-8526-db577e4c822b.css" rel="stylesheet" type="text/css">
<link href="{{ asset('css/bower_components/select2/dist/css/select2.min.css') }}" rel="stylesheet">
<link href="{{ asset('css/bower_components/bootstrap-daterangepicker/daterangepicker.css') }}" rel="stylesheet">
<link href="{{ asset('css/bower_components/dropzone/dist/dropzone.css') }}" rel="stylesheet">
<link href="{{ asset('css/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css') }}" rel="stylesheet">
<link href="{{ asset('css/bower_components/fullcalendar/dist/fullcalendar.min.css') }}" rel="stylesheet">
<link href="{{ asset('css/bower_components/perfect-scrollbar/css/perfect-scrollbar.min.css') }}" rel="stylesheet">
<link href="{{ asset('css/bower_components/slick-carousel/slick/slick.css') }}" rel="stylesheet">
<link href="{{ asset('css/css/maince5a.css?version=4.4.1') }}" rel="stylesheet">
<script src="{{ asset('js/js/jq.js') }}"></script>
<link href="{{ asset('css/tab.min.css') }}" rel="stylesheet" id="bootstrap-css">
<script src="{{ asset('js/js/tab.min.js') }}"></script>
<link href="{{ asset('css/bower_components/dragula.js/dist/dragula.min.css') }}" rel="stylesheet">
<link href="{{ asset('css/sweetalert.css') }}" rel="stylesheet">

<style>
    .panel.with-nav-tabs .panel-heading {
        padding: 5px 5px 0 5px;
    }

    .panel.with-nav-tabs .nav-tabs {
        border-bottom: none;
    }

    .panel.with-nav-tabs .nav-justified {
        margin-bottom: -1px;
    }

    /********************************************************************/
    /*** PANEL DEFAULT ***/
    .with-nav-tabs.panel-default .nav-tabs>li>a,
    .with-nav-tabs.panel-default .nav-tabs>li>a:hover,
    .with-nav-tabs.panel-default .nav-tabs>li>a:focus {
        color: #777;
    }

    .with-nav-tabs.panel-default .nav-tabs>.open>a,
    .with-nav-tabs.panel-default .nav-tabs>.open>a:hover,
    .with-nav-tabs.panel-default .nav-tabs>.open>a:focus,
    .with-nav-tabs.panel-default .nav-tabs>li>a:hover,
    .with-nav-tabs.panel-default .nav-tabs>li>a:focus {
        color: #777;
        background-color: #ddd;
        border-color: transparent;
    }

    .with-nav-tabs.panel-default .nav-tabs>li.active>a,
    .with-nav-tabs.panel-default .nav-tabs>li.active>a:hover,
    .with-nav-tabs.panel-default .nav-tabs>li.active>a:focus {
        color: #555;
        background-color: #fff;
        border-color: #ddd;
        border-bottom-color: transparent;
    }

    .with-nav-tabs.panel-default .nav-tabs>li.dropdown .dropdown-menu {
        background-color: #f5f5f5;
        border-color: #ddd;
    }

    .with-nav-tabs.panel-default .nav-tabs>li.dropdown .dropdown-menu>li>a {
        color: #777;
    }

    .with-nav-tabs.panel-default .nav-tabs>li.dropdown .dropdown-menu>li>a:hover,
    .with-nav-tabs.panel-default .nav-tabs>li.dropdown .dropdown-menu>li>a:focus {
        background-color: #ddd;
    }

    .with-nav-tabs.panel-default .nav-tabs>li.dropdown .dropdown-menu>.active>a,
    .with-nav-tabs.panel-default .nav-tabs>li.dropdown .dropdown-menu>.active>a:hover,
    .with-nav-tabs.panel-default .nav-tabs>li.dropdown .dropdown-menu>.active>a:focus {
        color: #fff;
        background-color: #555;
    }

    /********************************************************************/
    /*** PANEL PRIMARY ***/
    .with-nav-tabs.panel-primary .nav-tabs>li>a,
    .with-nav-tabs.panel-primary .nav-tabs>li>a:hover,
    .with-nav-tabs.panel-primary .nav-tabs>li>a:focus {
        color: #fff;
    }

    .with-nav-tabs.panel-primary .nav-tabs>.open>a,
    .with-nav-tabs.panel-primary .nav-tabs>.open>a:hover,
    .with-nav-tabs.panel-primary .nav-tabs>.open>a:focus,
    .with-nav-tabs.panel-primary .nav-tabs>li>a:hover,
    .with-nav-tabs.panel-primary .nav-tabs>li>a:focus {
        color: #fff;
        background-color: #3071a9;
        border-color: transparent;
    }

    .with-nav-tabs.panel-primary .nav-tabs>li.active>a,
    .with-nav-tabs.panel-primary .nav-tabs>li.active>a:hover,
    .with-nav-tabs.panel-primary .nav-tabs>li.active>a:focus {
        color: #428bca;
        background-color: #fff;
        border-color: #428bca;
        border-bottom-color: transparent;
    }

    .with-nav-tabs.panel-primary .nav-tabs>li.dropdown .dropdown-menu {
        background-color: #428bca;
        border-color: #3071a9;
    }

    .with-nav-tabs.panel-primary .nav-tabs>li.dropdown .dropdown-menu>li>a {
        color: #fff;
    }

    .with-nav-tabs.panel-primary .nav-tabs>li.dropdown .dropdown-menu>li>a:hover,
    .with-nav-tabs.panel-primary .nav-tabs>li.dropdown .dropdown-menu>li>a:focus {
        background-color: #3071a9;
    }

    .with-nav-tabs.panel-primary .nav-tabs>li.dropdown .dropdown-menu>.active>a,
    .with-nav-tabs.panel-primary .nav-tabs>li.dropdown .dropdown-menu>.active>a:hover,
    .with-nav-tabs.panel-primary .nav-tabs>li.dropdown .dropdown-menu>.active>a:focus {
        background-color: #4a9fe9;
    }

    /********************************************************************/
    /*** PANEL SUCCESS ***/
    .with-nav-tabs.panel-success .nav-tabs>li>a,
    .with-nav-tabs.panel-success .nav-tabs>li>a:hover,
    .with-nav-tabs.panel-success .nav-tabs>li>a:focus {
        color: #3c763d;
    }

    .with-nav-tabs.panel-success .nav-tabs>.open>a,
    .with-nav-tabs.panel-success .nav-tabs>.open>a:hover,
    .with-nav-tabs.panel-success .nav-tabs>.open>a:focus,
    .with-nav-tabs.panel-success .nav-tabs>li>a:hover,
    .with-nav-tabs.panel-success .nav-tabs>li>a:focus {
        color: #3c763d;
        background-color: #d6e9c6;
        border-color: transparent;
    }

    .with-nav-tabs.panel-success .nav-tabs>li.active>a,
    .with-nav-tabs.panel-success .nav-tabs>li.active>a:hover,
    .with-nav-tabs.panel-success .nav-tabs>li.active>a:focus {
        color: #3c763d;
        background-color: #fff;
        border-color: #d6e9c6;
        border-bottom-color: transparent;
    }

    .with-nav-tabs.panel-success .nav-tabs>li.dropdown .dropdown-menu {
        background-color: #dff0d8;
        border-color: #d6e9c6;
    }

    .with-nav-tabs.panel-success .nav-tabs>li.dropdown .dropdown-menu>li>a {
        color: #3c763d;
    }

    .with-nav-tabs.panel-success .nav-tabs>li.dropdown .dropdown-menu>li>a:hover,
    .with-nav-tabs.panel-success .nav-tabs>li.dropdown .dropdown-menu>li>a:focus {
        background-color: #d6e9c6;
    }

    .with-nav-tabs.panel-success .nav-tabs>li.dropdown .dropdown-menu>.active>a,
    .with-nav-tabs.panel-success .nav-tabs>li.dropdown .dropdown-menu>.active>a:hover,
    .with-nav-tabs.panel-success .nav-tabs>li.dropdown .dropdown-menu>.active>a:focus {
        color: #fff;
        background-color: #3c763d;
    }

    /********************************************************************/
    /*** PANEL INFO ***/
    .with-nav-tabs.panel-info .nav-tabs>li>a,
    .with-nav-tabs.panel-info .nav-tabs>li>a:hover,
    .with-nav-tabs.panel-info .nav-tabs>li>a:focus {
        color: #31708f;
    }

    .with-nav-tabs.panel-info .nav-tabs>.open>a,
    .with-nav-tabs.panel-info .nav-tabs>.open>a:hover,
    .with-nav-tabs.panel-info .nav-tabs>.open>a:focus,
    .with-nav-tabs.panel-info .nav-tabs>li>a:hover,
    .with-nav-tabs.panel-info .nav-tabs>li>a:focus {
        color: #31708f;
        background-color: #bce8f1;
        border-color: transparent;
    }

    .with-nav-tabs.panel-info .nav-tabs>li.active>a,
    .with-nav-tabs.panel-info .nav-tabs>li.active>a:hover,
    .with-nav-tabs.panel-info .nav-tabs>li.active>a:focus {
        color: #31708f;
        background-color: #fff;
        border-color: #bce8f1;
        border-bottom-color: transparent;
    }

    .with-nav-tabs.panel-info .nav-tabs>li.dropdown .dropdown-menu {
        background-color: #d9edf7;
        border-color: #bce8f1;
    }

    .with-nav-tabs.panel-info .nav-tabs>li.dropdown .dropdown-menu>li>a {
        color: #31708f;
    }

    .with-nav-tabs.panel-info .nav-tabs>li.dropdown .dropdown-menu>li>a:hover,
    .with-nav-tabs.panel-info .nav-tabs>li.dropdown .dropdown-menu>li>a:focus {
        background-color: #bce8f1;
    }

    .with-nav-tabs.panel-info .nav-tabs>li.dropdown .dropdown-menu>.active>a,
    .with-nav-tabs.panel-info .nav-tabs>li.dropdown .dropdown-menu>.active>a:hover,
    .with-nav-tabs.panel-info .nav-tabs>li.dropdown .dropdown-menu>.active>a:focus {
        color: #fff;
        background-color: #31708f;
    }

    /********************************************************************/
    /*** PANEL WARNING ***/
    .with-nav-tabs.panel-warning .nav-tabs>li>a,
    .with-nav-tabs.panel-warning .nav-tabs>li>a:hover,
    .with-nav-tabs.panel-warning .nav-tabs>li>a:focus {
        color: #8a6d3b;
    }

    .with-nav-tabs.panel-warning .nav-tabs>.open>a,
    .with-nav-tabs.panel-warning .nav-tabs>.open>a:hover,
    .with-nav-tabs.panel-warning .nav-tabs>.open>a:focus,
    .with-nav-tabs.panel-warning .nav-tabs>li>a:hover,
    .with-nav-tabs.panel-warning .nav-tabs>li>a:focus {
        color: #8a6d3b;
        background-color: #faebcc;
        border-color: transparent;
    }

    .with-nav-tabs.panel-warning .nav-tabs>li.active>a,
    .with-nav-tabs.panel-warning .nav-tabs>li.active>a:hover,
    .with-nav-tabs.panel-warning .nav-tabs>li.active>a:focus {
        color: #8a6d3b;
        background-color: #fff;
        border-color: #faebcc;
        border-bottom-color: transparent;
    }

    .with-nav-tabs.panel-warning .nav-tabs>li.dropdown .dropdown-menu {
        background-color: #fcf8e3;
        border-color: #faebcc;
    }

    .with-nav-tabs.panel-warning .nav-tabs>li.dropdown .dropdown-menu>li>a {
        color: #8a6d3b;
    }

    .with-nav-tabs.panel-warning .nav-tabs>li.dropdown .dropdown-menu>li>a:hover,
    .with-nav-tabs.panel-warning .nav-tabs>li.dropdown .dropdown-menu>li>a:focus {
        background-color: #faebcc;
    }

    .with-nav-tabs.panel-warning .nav-tabs>li.dropdown .dropdown-menu>.active>a,
    .with-nav-tabs.panel-warning .nav-tabs>li.dropdown .dropdown-menu>.active>a:hover,
    .with-nav-tabs.panel-warning .nav-tabs>li.dropdown .dropdown-menu>.active>a:focus {
        color: #fff;
        background-color: #8a6d3b;
    }

    /********************************************************************/
    /*** PANEL DANGER ***/
    .with-nav-tabs.panel-danger .nav-tabs>li>a,
    .with-nav-tabs.panel-danger .nav-tabs>li>a:hover,
    .with-nav-tabs.panel-danger .nav-tabs>li>a:focus {
        color: #a94442;
    }

    .with-nav-tabs.panel-danger .nav-tabs>.open>a,
    .with-nav-tabs.panel-danger .nav-tabs>.open>a:hover,
    .with-nav-tabs.panel-danger .nav-tabs>.open>a:focus,
    .with-nav-tabs.panel-danger .nav-tabs>li>a:hover,
    .with-nav-tabs.panel-danger .nav-tabs>li>a:focus {
        color: #a94442;
        background-color: #ebccd1;
        border-color: transparent;
    }

    .with-nav-tabs.panel-danger .nav-tabs>li.active>a,
    .with-nav-tabs.panel-danger .nav-tabs>li.active>a:hover,
    .with-nav-tabs.panel-danger .nav-tabs>li.active>a:focus {
        color: #a94442;
        background-color: #fff;
        border-color: #ebccd1;
        border-bottom-color: transparent;
    }

    .with-nav-tabs.panel-danger .nav-tabs>li.dropdown .dropdown-menu {
        background-color: #f2dede;
        /* bg color */
        border-color: #ebccd1;
        /* border color */
    }

    .with-nav-tabs.panel-danger .nav-tabs>li.dropdown .dropdown-menu>li>a {
        color: #a94442;
        /* normal text color */
    }

    .with-nav-tabs.panel-danger .nav-tabs>li.dropdown .dropdown-menu>li>a:hover,
    .with-nav-tabs.panel-danger .nav-tabs>li.dropdown .dropdown-menu>li>a:focus {
        background-color: #ebccd1;
        /* hover bg color */
    }

    .with-nav-tabs.panel-danger .nav-tabs>li.dropdown .dropdown-menu>.active>a,
    .with-nav-tabs.panel-danger .nav-tabs>li.dropdown .dropdown-menu>.active>a:hover,
    .with-nav-tabs.panel-danger .nav-tabs>li.dropdown .dropdown-menu>.active>a:focus {
        color: #fff;
        /* active text color */
        background-color: #a94442;
        /* active bg color */
    }

    .send-loading {
        position: fixed;
        left: 0px;
        top: 0px;
        width: 100%;
        height: 100vh;
        z-index: 9999;
        background: url("{{ asset('img/net-sendloader.gif') }}") center no-repeat rgba(255, 255, 255, 0.5);
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
        background: url("{{ asset('img/net-sendloader.gif') }}") center no-repeat #fff;
    }
</style>
