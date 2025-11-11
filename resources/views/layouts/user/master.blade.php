<!-- <!DOCTYPE html>
    <html>
        <head>
            @include('layouts.user.head')
            @yield('stylesheets')
        </head>
        @csrf
        <body class="menu-position-side menu-side-left full-screen with-content-panel">
            <div class="all-wrapper with-side-panel solid-bg-all">
                <div class="layout-w">
                    @if ($global_user_data->userType == 'staff')
@include('layouts.user.admin_nav')
@elseif($global_user_data->userType == 'tellers')
@include('layouts.user.teller_nav')
@else
@include('layouts.user.member_nav')
@endif

                    <div class="content-w">
                        
                        @include('layouts.user.top_bar')
                        <div class="content-panel-toggler"><i class="os-icon os-icon-grid-squares-22"></i><span>Sidebar</span></div>
                          
                        @yield('content')
                    </div>
                </div>
                <div class="display-type"></div>
            </div>
            <div class="pre-loading"></div>
            <div class="send-loading"></div>
            @if ($global_user_data->userType == 'user')
@include('layouts.user.upgrade_account_modal')
@endif
        @include('layouts.user.scripts')
        @yield('scripts')
    </body>
</html> -->
