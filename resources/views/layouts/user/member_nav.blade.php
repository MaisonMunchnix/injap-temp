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
            <div class="avatar-w"><img alt="" @if(!empty($global_user_data->profile_picture) && file_exists(public_path($global_user_data->profile_picture))) src="{{asset($global_user_data->profile_picture)}}" @else src="{{asset('img/default_image.png')}}" @endif style="width:45px; height:45px;"></div>
            <div class="logged-user-info-w">
                <div class="logged-user-name text-lowercase">@if(!empty($global_user_data->username)) {{$global_user_data->username}} @endif</div>
                <div class="logged-user-role">@if(!empty($global_user_data->package_type)) {{$global_user_data->package_type}} @endif</div>
            </div>
        </div>
        <!-------------------- START - Mobile Menu List -------------------->
        <ul class="main-menu">
            <li class="has-sub-menu">
                <a href="#">
                    <div class="icon-w">
                        <div class="os-icon os-icon-layout"></div>
                    </div><span>Dashboard</span>
                </a>
                <ul class="sub-menu">
                    <li><a href="{{route('home')}}">Home</a></li>
                    <li><a href="{{route('guest.products')}}">Shop</a></li>
                    <li><a href="{{route('income-listing','referral-bonus')}}">Total Referral Bonus</a></li>
                    <li><a href="{{route('direct-referral','view')}}">Total Direct Referral</a></li>
                    <li><a href="{{route('income-listing','sales-match-bonus')}}">Total Sales Match Bonus</a></li>
                    <li><a href="{{route('income-listing','fifth-sales-match-bonus')}}">5th Match Rewards Points</a></li>
                    <li><a href="{{ route('unilevel-sales') }}">Total RCB</a></li>
                    <li><a href="{{route('income-listing','total-accumulated-income')}}">Total Accumulated Income</a></li>
                </ul>
            </li>
            <li class="has-sub-menu">
                <a href="#">
                    <div class="icon-w">
                        <div class="os-icon os-icon-package"></div>
                    </div><span>Network</span>
                </a>
                <ul class="sub-menu">
                    @php
                    $auth_id_crypt= Crypt::encrypt($auth_id);
                    @endphp
                    <li><a href="{{route('view-geneology',$auth_id_crypt)}}">Binary Graphical</a></li>
                    <li><a href="{{route('view-binary-list')}}">Binary List</a></li>
                </ul>
            </li>
            <li class="has-sub-menu">
                <a href="#">
                    <div class="icon-w">
                        <div class="os-icon os-icon-file-text"></div>
                    </div><span>Requests</span>
                </a>
                <ul class="sub-menu">
                    <li><a href="{{route('encashment','view')}}">Enchashment</a></li>
                    <li><a href="#" data-target="#upgrade-account-modal" data-toggle="modal">Upgrade Account Activation</a></li>
                </ul>
            </li>



            <li class="has-sub-menu">
                <a href="#">
                    <div class="icon-w">
                        <div class="os-icon os-icon-grid"></div>
                    </div><span>Affiliate links</span>
                </a>
                <ul class="sub-menu">
                    <li><a href="{{ route('affiliate-links','membership') }}">Membership Links</a></li>
                    <li><a href="{{ route('affiliate-links','retail') }}">Product Retail Links</a></li>
                </ul>
            </li>
            <li class="has-sub-menu">
                <a href="{{route('codes-facility')}}">
                    <div class="icon-w">
                        <div class="os-icon os-icon-grid"></div>
                    </div><span>Codes Facility</span>
                </a>

            </li>


            {{-- <li class="has-sub-menu">
                <a href="#">
                    <div class="icon-w">
                        <div class="os-icon os-icon-info"></div>
                    </div><span>FAQs</span>
                </a>

            </li> --}}
            <li class="has-sub-menu">
                <a href="{{ route('member-profile') }}">
                    <div class="icon-w">
                        <div class="os-icon os-icon-users"></div>
                    </div><span>Profile</span>
                </a>
                <ul class="sub-menu">
                    <li><a href="{{ route('member-profile') }}">View Profile</a></li>
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
            <div class="avatar-w"><img alt="" @if(!empty($global_user_data->profile_picture) && file_exists(public_path($global_user_data->profile_picture))) src="{{asset($global_user_data->profile_picture)}}" @else src="{{asset('img/default_image.png')}}" @endif style="width:45px; height:45px;"></div>
            <div class="logged-user-info-w">
                <div class="logged-user-name text-lowercase">@if(!empty($global_user_data->username)) {{$global_user_data->username}} @endif</div>
                <div class="logged-user-role text-capitalize">@if(!empty($global_user_data->package_type)) {{$global_user_data->package_type}} @endif Member</div>
            </div>
            <div class="logged-user-toggler-arrow">
                <div class="os-icon os-icon-chevron-down"></div>
            </div>
            <div class="logged-user-menu color-style-bright">
                <div class="logged-user-avatar-info">
                    <div class="avatar-w"><img alt="" @if(!empty($global_user_data->profile_picture) && file_exists(public_path($global_user_data->profile_picture))) src="{{asset($global_user_data->profile_picture)}}" @else src="{{asset('img/default_image.png')}}" @endif style="width:45px; height:45px;"></div>
                    <div class="logged-user-info-w">
                        <div class="logged-user-name text-lowercase">@if(!empty($global_user_data->username)) {{$global_user_data->username}} @endif</div>
                        <div class="logged-user-role text-capitalize">@if(!empty($global_user_data->package_type)){{$global_user_data->package_type}} @endif Member</div>
                    </div>
                </div>
                <div class="bg-icon"><i class="os-icon os-icon-wallet-loaded"></i></div>
                <ul>

                    <li><a href="{{ route('member-profile') }}"><i class="os-icon os-icon-user-male-circle2"></i><span>Profile Details</span></a></li>
                    <li><a href="{{ route('logout') }}"><i class="os-icon os-icon-signs-11"></i><span>Logout</span></a></li>
                </ul>
            </div>
        </div>
    </div>

    <h1 class="menu-page-header">Page Header</h1>
    <ul class="main-menu">
        <li class="sub-header"><span>Statistics</span></li>
        <li class="selected has-sub-menu">
            <a href="#">
                <div class="icon-w">
                    <div class="os-icon os-icon-layout"></div>
                </div><span>Dashboard</span>
            </a>
            <div class="sub-menu-w">
                <div class="sub-menu-header">Dashboard</div>
                <div class="sub-menu-icon"><i class="os-icon os-icon-layout"></i></div>
                <div class="sub-menu-i">
                    <ul class="sub-menu">
                        <li><a href="{{route('home')}}">Home</a></li>
                        <li><a href="{{route('guest.products')}}">Shop</a></li>
                        <li><a href="{{route('income-listing','referral-bonus')}}">Total Referral Bonus</a></li>
                        <li><a href="{{route('direct-referral','view')}}">Total Direct Referral</a></li>
                        <li><a href="{{route('income-listing','sales-match-bonus')}}">Total Sales Match Bonus</a></li>
                        <li><a href="{{route('income-listing','fifth-sales-match-bonus')}}">5th Match Rewards Points</a></li>
                        <li><a href="{{ route('unilevel-sales') }}">Total RCB</a></li>
                        <li><a href="{{route('income-listing','total-accumulated-income')}}">Total Accumulated Income</a></li>
                    </ul>
                </div>
            </div>
        </li>

        <li class="sub-header"><span>Options</span></li>
        <li class=" has-sub-menu">
            <a href="#">
                <div class="icon-w">
                    <div class="os-icon os-icon-package"></div>
                </div><span>Network</span>
            </a>
            <div class="sub-menu-w">
                <div class="sub-menu-header">Network</div>
                <div class="sub-menu-icon"><i class="os-icon os-icon-package"></i></div>
                <div class="sub-menu-i">
                    <ul class="sub-menu">
                        <li><a href="{{route('view-geneology',$auth_id_crypt)}}">Binary Graphical</a></li>
                        <li><a href="{{route('view-binary-list')}}">Binary List</a></li>
                        {{-- <li><a href="#">Personal Enrollment Tree</a></li> --}}
                    </ul>
                </div>
            </div>
        </li>
        <li class=" has-sub-menu">
            <a href="#">
                <div class="icon-w">
                    <div class="os-icon os-icon-file-text"></div>
                </div><span>Request</span>
            </a>
            <div class="sub-menu-w">
                <div class="sub-menu-header">Request</div>
                <div class="sub-menu-icon"><i class="os-icon os-icon-file-text"></i></div>
                <div class="sub-menu-i">
                    <ul class="sub-menu">
                        <li><a href="{{route('encashment','view')}}">Enchashment</a></li>
                        <li><a href="#" data-target="#upgrade-account-modal" data-toggle="modal">Upgrade Account Activation</a></li>
                    </ul>

                </div>
            </div>
        </li>
        <li class=" has-sub-menu">
            <a href="#">
                <div class="icon-w">
                    <div class="os-icon os-icon-link"></div>
                </div><span>Affiliate Links</span>
            </a>
            <div class="sub-menu-w">
                <div class="sub-menu-header">Affiliate Links</div>
                <div class="sub-menu-icon"><i class="os-icon os-icon-link"></i></div>
                <div class="sub-menu-i">
                    <ul class="sub-menu">
                        <li><a href="{{ route('affiliate-links','membership') }}">Membership Links</a></li>
                        <li><a href="{{ route('affiliate-links','retail') }}">Product Retail Links</a></li>
                    </ul>
                </div>
            </div>
        </li>

        <li class=" has-sub-menu">
            <a href="{{route('codes-facility')}}">
                <div class="icon-w">
                    <div class="os-icon os-icon-grid"></div>
                </div><span>Codes Facility</span>
            </a>
        </li>


        {{-- <li class="sub-header"><span>Others</span></li> --}}
        {{-- <li class=" has-sub-menu">
                <a href="#">
                    <div class="icon-w">
                        <div class="os-icon os-icon-info"></div>
                    </div><span>FAQs</span></a>
            </li> --}}
        <li class=" has-sub-menu">
            <a href="#">
                <div class="icon-w">
                    <div class="os-icon os-icon-users"></div>
                </div><span>Profile</span>
            </a>
            <div class="sub-menu-w">
                <div class="sub-menu-header">Profile</div>
                <div class="sub-menu-icon"><i class="os-icon os-icon-users"></i></div>
                <div class="sub-menu-i">
                    <ul class="sub-menu">
                        <li><a href="{{ route('member-profile') }}">View Profile</a></li>
                        <li><a href="{{ route('logout') }}">Logout</a></li>
                    </ul>
                </div>
            </div>
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
