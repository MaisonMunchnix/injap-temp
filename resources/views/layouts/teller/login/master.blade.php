<!DOCTYPE html>
<html lang="en">
@include('layouts.teller.login.includes.head')
<body class="vertical-layout">
    <!-- Start Containerbar -->
    <div id="containerbar" class="containerbar authenticate-bg">
        <!-- Start Container -->
        <div class="container">
            <div class="auth-box login-box">
                <!-- Start row -->
                <div class="row no-gutters align-items-center justify-content-center">
                   @yield('contents')             
                    <!-- Start col -->
                    
                    <!-- End col -->
                </div>
                <!-- End row -->
            </div>
        </div>
        <!-- End Container -->
    </div>
    <!-- End Containerbar -->
    
    <!-- Start js -->
    @include('layouts.teller.login.includes.javascript')    
    <!-- End js -->
</body>
</html>