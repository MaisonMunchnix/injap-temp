<div class="header d-print-none">

    <div class="header-left">
        <div class="navigation-toggler">
            <a href="#" data-action="navigation-toggler">
                <i class="fa fa-bars"></i>
            </a>
        </div>
        <div class="header-logo">
            <a href='#'>
                <img class="logo img-fluid" src="{{ asset('new_landing/images/logs.png') }}" width="50px" height="50px" alt="logo">
                <img class="logo-light img-fluid" src="{{ asset('new_landing/images/logs.png') }}}" width="50px" height="50px" alt="light logo">
            </a>
        </div>
    </div>

    <div class="header-body">
        <div class="header-body-left">
            <div class="page-title">
                <h4>Admin Dashboard</h4>
            </div>
        </div>
        <div class="header-body-right">
            <ul class="navbar-nav">

                <!-- end::settings -->

                <!-- begin::user menu -->
                <li class="nav-item dropdown">
                    <a href="#" class="nav-link" title="User menu" data-sidebar-target="#user-menu">
                        <span class="mr-2 d-sm-inline d-none">@if(!empty($global_user_data->username)) {{$global_user_data->username}} @endif</span>
                        <figure class="avatar avatar-sm">
                            <img @if(!empty($global_user_data->profile_picture)) src="{{ asset($global_user_data->profile_picture) }}" @else src="{{ asset('images/users/default_image.png') }}" @endif class="rounded-circle" alt="avatar">
                        </figure>
                    </a>
                </li>
                <!-- end::user menu -->

            </ul>

            <!-- begin::mobile header toggler -->
            <ul class="navbar-nav d-flex align-items-center">
                <li class="nav-item header-toggler">
                    <a href="#" class="nav-link">
                        <i data-feather="arrow-down"></i>
                    </a>
                </li>
            </ul>
            <!-- end::mobile header toggler -->
        </div>
    </div>

</div>
