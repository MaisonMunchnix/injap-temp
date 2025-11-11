<!doctype html>
<html lang="en">
	<head>
		@include('layouts.default.head')
		@yield('stylesheets')
	</head>
    <body class="small-navigation">
        <!-- begin::preloader-->
        <div class="preloader">
            <div class="preloader-icon"></div>
        </div>
        <!-- end::preloader -->

        <!-- BEGIN: Sidebar Group -->
        @include('layouts.default.right_bar')
        <!-- END: Sidebar Group -->
        <!-- begin::main -->
        <div class="layout-wrapper">
            <!-- begin::header -->
            @include('layouts.default.header')
            <!-- end::header -->

            <div class="content-wrapper">
                <!-- begin::navigation -->
                @include('layouts.default.member_nav')
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