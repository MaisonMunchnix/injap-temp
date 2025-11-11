<!-------------------- START - Mobile Menu -------------------->
<div class="menu-mobile menu-activated-on-click color-scheme-dark">
    <div class="mm-logo-buttons-w">
        <a class="mm-logo" href="{{route('home')}}"><span>Purple Life</span></a>
        <div class="mm-buttons">
            <div class="content-panel-open">
                <div class="os-icon os-icon-grid-circles"></div>
            </div>
            <div class="mobile-menu-trigger">
                <div class="os-icon os-icon-hamburger-menu-1"></div>
            </div>
        </div>
    </div>
    <div class="menu-and-user">
        <div class="logged-user-w">
            <div class="avatar-w"><img alt="" src="{{asset('img/default_image.png')}}"></div>
            <div class="logged-user-info-w">
                <div class="logged-user-name">@if(!empty($global_user_data->first_name)) {{$global_user_data->first_name}} @endif @if(!empty($global_user_data->last_name)) {{$global_user_data->last_name}} @endif</div>
                <div class="logged-user-role">Teller</div>
            </div>
        </div>
        <!-------------------- START - Mobile Menu List -------------------->
        <ul class="main-menu">
            <li>
                <a href="{{route('teller-dashboard')}}">
                    <div class="icon-w">
                        <div class="os-icon os-icon-layout"></div>
                    </div><span>Dashboard</span>
                </a>
            </li>
            <li class="has-sub-menu">
                <a href="#">
                    <div class="icon-w">
                        <div class="os-icon os-icon-users"></div>
                    </div><span>New Transaction</span>
                </a>
                <ul class="sub-menu">
                    <li><a href="{!! url('tellers/new-transaction/non-member') !!}">Walk In / Non-Member</a></li>
                    <li><a href="{!! url('tellers/new-transaction/member') !!}">Walk In / Member</a></li>
                    <li><a href="{{ route('logout') }}">Logout</a></li>
                </ul>
            </li>

            <li class="has-sub-menu">
                <a href="#">
                    <div class="icon-w">
                        <div class="os-icon os-icon-tasks-checked"></div>
                    </div><span>Order Management</span>
                </a>
                <ul class="sub-menu">
                    <li><a href="{!! url('tellers/process-order') !!}">Process Order</a></li>
                    <li><a href="{!! url('tellers/record-sales') !!}">Record Sales</a></li>
                    <li><a href="{!! url('tellers/override-sales') !!}">Refund Transaction</a></li>
                    <li><a href="{!! url('tellers/void-transaction') !!}">Void Transaction</a></li>
                </ul>
            </li>

            <li class="has-sub-menu">
                <a href="#">
                    <div class="icon-w">
                        <div class="os-icon os-icon-users"></div>
                    </div><span>Profile</span>
                </a>
                <ul class="sub-menu">
                    <li><a href="#">View Profile</a></li>
                    <li><a href="#">Update Profile</a></li>
                    <li><a href="{{ route('logout') }}">Logout</a></li>
                </ul>
            </li>

        </ul>
        <!-------------------- END - Mobile Menu List -------------------->
        <div class="mobile-menu-magic">
            <h4>Purple Life</h4>
            <p>Organic Products</p>

        </div>
    </div>
</div>
<!-------------------- END - Mobile Menu -------------------->

<!-------------------- START - Main Menu -------------------->
<div class="menu-w color-scheme-dark color-style-bright menu-position-side menu-side-left menu-layout-compact sub-menu-style-over sub-menu-color-bright selected-menu-color-light menu-activated-on-hover menu-has-selected-link">
    <div class="logo-w">
        <a class="logo" href="">
            <div style=" height: 5px;"></div>
            <div class="logo-label">Purple Life Organic</div>
        </a>
    </div>
    <div class="logged-user-w avatar-inline">
        <div class="logged-user-i">
            <div class="avatar-w"><img alt="" @if(!empty($global_user_data->profile_picture)) src="{{asset('img/')}}" @else src="{{asset('img/default_image.png')}}" @endif></div>
            <div class="logged-user-info-w">
                <div class="logged-user-name text-capitalize">@if(!empty($global_user_data->first_name)) {{$global_user_data->first_name}} @endif @if(!empty($global_user_data->last_name)) {{$global_user_data->last_name}} @endif</div>
                <div class="logged-user-role text-capitalize">Teller</div>
            </div>
            <div class="logged-user-toggler-arrow">
                <div class="os-icon os-icon-chevron-down"></div>
            </div>
            <div class="logged-user-menu color-style-bright">
                <div class="logged-user-avatar-info">
                    <div class="avatar-w"><img alt="" src="{{asset('img/default_image.png')}}"></div>
                    <div class="logged-user-info-w">
                        <div class="logged-user-name text-capitalize">@if(!empty($global_user_data->first_name)) {{$global_user_data->first_name}} @endif @if(!empty($global_user_data->last_name)) {{$global_user_data->last_name}} @endif</div>
                        <div class="logged-user-role text-capitalize">Teller</div>
                    </div>
                </div>
                <div class="bg-icon"><i class="os-icon os-icon-wallet-loaded"></i></div>
                <ul>

                    <!--<li><a href="#"><i class="os-icon os-icon-user-male-circle2"></i><span>Profile Details</span></a></li>-->
                    <li><a href="{{ route('logout') }}"><i class="os-icon os-icon-signs-11"></i><span>Logout</span></a></li>
                </ul>
            </div>
        </div>
    </div>
    <!-------------------- END - Messages Link in secondary top menu -------------------->
    <!--</div>-->
    <!--<div class="element-search autosuggest-search-activator">
        <input placeholder="Start typing to search..." type="text">
    </div>-->
    <h1 class="menu-page-header">Page Header</h1>
    <ul class="main-menu">
        <li class="sub-header"><span>Options</span></li>
        <li>
            <a href="{{route('teller-dashboard')}}">
                <div class="icon-w">
                    <div class="os-icon os-icon-layout"></div>
                </div><span>Dashboard</span>
            </a>
        </li>
        <li class=" has-sub-menu">
            <a href="#">
                <div class="icon-w">
                    <div class="os-icon os-icon-users"></div>
                </div><span>New Transaction</span>
            </a>
            <div class="sub-menu-w">
                <div class="sub-menu-header">Transaction</div>
                <div class="sub-menu-icon"><i class="os-icon os-icon-users"></i></div>
                <div class="sub-menu-i">
                    <ul class="sub-menu">
                        <li><a href="{!! url('tellers/new-transaction/non-member'); !!}">Walk In / Non-Member</a></li>
                        <li><a href="{!! url('tellers/new-transaction/member'); !!}">Walk In / Member</a></li>
                    </ul>
                </div>
            </div>
        </li>

        <li class="has-sub-menu">
            <a href="#">
                <div class="icon-w">
                    <div class="os-icon os-icon-tasks-checked"></div>
                </div><span>Order Management</span>
            </a>
            <div class="sub-menu-w">
                <div class="sub-menu-header">Order</div>
                <div class="sub-menu-icon"><i class="os-icon os-icon-tasks-checked"></i></div>
                <div class="sub-menu-i">
                    <ul class="sub-menu">
                        <li><a href="{!! url('tellers/process-order') !!}">Process Order</a></li>
                        <li><a href="{!! url('tellers/record-sales') !!}">Record Sales</a></li>
                        <li><a href="{!! url('tellers/override-sales') !!}">Refund Transaction</a></li>
                        <li><a href="{!! url('tellers/void-transaction') !!}">Void Transaction</a></li>
                    </ul>
                </div>
            </div>
        </li>

        <li class="sub-header"><span>Others</span></li>
        <li class="selected has-sub-menu">
            <a href="{{ route('logout') }}">
                <div class="icon-w">
                    <div class="os-icon os-icon-signs-11"></div>
                </div><span>Logout</span>
            </a>

        </li>

    </ul>
    <div class="side-menu-magic">
        <h4>Purple Life</h4>
        <p>Organic Products</p>

    </div>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
</div>
<!-------------------- END - Main Menu -------------------->
