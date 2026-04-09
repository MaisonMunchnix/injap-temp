<!doctype html>
<html lang="en">

<head>
    @include('layouts.default.head')
    @yield('stylesheets')
</head>

<body class="small-navigation">
    <!-- begin::preloader-->
    <div class="preloader" style="z-index:9999;">
        <div class="preloader-icon"></div>
    </div>
    <!-- end::preloader -->

    @include('layouts.default.admin.right_bar')
    
    <!-- begin::main -->
    <div class="layout-wrapper">
        <!-- begin::header -->
        @include('layouts.default.admin.header')
        <!-- end::header -->

        <div class="content-wrapper">
            <!-- begin::navigation -->
            @include('layouts.default.instructor.nav')
            <!-- end::navigation -->

            <!-- content goes here-->
            @yield('content')
        </div>
        <!-- end::main -->
    </div>
    <!-- Plugin scripts -->
    @include('layouts.default.javascript')
    @yield('scripts')
</body>
</html>
