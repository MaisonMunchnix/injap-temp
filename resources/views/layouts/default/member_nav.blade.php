<div class="navigation">
    <div class="navigation-menu-tab">
        <ul>
            <li>
                <a href="#" data-toggle="tooltip" data-placement="right" title="Dashboard"
                    data-nav-target="#ecommerce">
                    <i data-feather="home"></i>
                </a>
            </li>
            <li>
                <a href="#" data-toggle="tooltip" data-placement="right" title="Network" data-nav-target="#user">
                    <i data-feather="users"></i>
                </a>
            </li>
            <li>
                <a href="#" data-toggle="tooltip" data-placement="right" title="Request"
                    data-nav-target="#components">
                    <i data-feather="layers"></i>
                </a>
            </li>
            <li>
                <a href="#" data-toggle="tooltip" data-placement="right" title="Codes Facility"
                    data-nav-target="#codes_fac">
                    <i data-feather="copy"></i>
                </a>
            </li>

            <li>
                <a href="#" data-toggle="tooltip" data-placement="right" title="Products"
                    data-nav-target="#products">
                    <i data-feather="star"></i>
                </a>
            </li>

            <li>
                <a href="#" data-toggle="tooltip" data-placement="right" title="Profile" data-nav-target="#pages">
                    <i data-feather="settings"></i>
                </a>
            </li>


        </ul>
    </div>
    <div class="navigation-menu-body">
        <div class="navigation-menu-group">
            <div id="ecommerce">
                <ul>
                    <li class="navigation-divider d-flex align-items-center">
                        <i class="mr-2" data-feather="home"></i> My Dashboard
                    </li>
                    <li class="navigation-divider d-flex align-items-center">
                        @if (!empty($global_user_data->first_name))
                            {{ $global_user_data->first_name }} {{ $global_user_data->last_name }}
                        @endif
                    </li>
                    <li>
                        <a class="{{ request()->is('user/home') || request()->is('user/income-listing/*') || request()->is('user/available-balance') || request()->is('user/total-income') || request()->is('user') ? 'active' : '' }}"
                            href="{{ route('home') }}">Dashboard</a>
                    </li>

                    <li class="navigation-divider">Summary</li>
                    <!-- <li>
                        <a href="#" class="d-flex align-items-start">
                            <div>
                                <figure class="avatar mr-3">
                                    <span class="avatar-title bg-success rounded"><i class="ti-user"></i></span>
                                </figure>
                            </div>
                            <div>
                                <h6>Direct Referral</h6>

                                <h6 class="mb-0 font-weight-bold" id="Direct_Referral_side">{{ number_format($Total_Direct_Referral) }} PHP</h6>


                            </div>
                        </a>
                    </li> -->
                    <li>
                        <a href="#" class="d-flex align-items-start">
                            <div>
                                <figure class="avatar mr-3">
                                    <span class="avatar-title bg-warning rounded"><i class="ti-link"></i></span>
                                </figure>
                            </div>
                            <div>
                                <h6>Pairing Bonus</h6>
                                @if (!empty($TPBunos))
                                    <h6 class="mb-0 font-weight-bold" id="ParingBonusID">{{ number_format($TPBunos) }}
                                        PHP</h6>
                                @else
                                    <h6 class="mb-0 font-weight-bold" id="ParingBonusID">0</h6>
                                @endif

                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="#" class="d-flex align-items-start">
                            <div>
                                <figure class="avatar mr-3">
                                    <span class="avatar-title bg-success rounded"><i class="ti-gift"></i></span>
                                </figure>
                            </div>
                            <div>
                                <h6>Pairing Points</h6>
                                @if (!empty($TPRPoints))
                                    <h6 class="mb-0 font-weight-bold" id="ParingPointsID">
                                        {{ number_format($TPRPoints) }} PTS</h6>
                                @else
                                    <h6 class="mb-0 font-weight-bold" id="ParingPointsID">0</h6>
                                @endif

                            </div>
                        </a>
                    </li>
                </ul>
            </div>
            <div id="user">
                <ul>
                    <li class="navigation-divider d-flex align-items-center">
                        <i class="mr-2" data-feather="users"></i> Network
                    </li>
                    @php
                        $auth_id_crypt = Crypt::encrypt($auth_id);
                    @endphp
                    <li>
                        <a class="{{ request()->is('user/view-geneology/*') ? 'active' : '' }}"
                            href="{{ route('view-geneology', $auth_id_crypt) }}">Binary Graphical</a>
                    </li>
                    <li>
                        <a class="{{ request()->is('user/view-binary-list') ? 'active' : '' }}"
                            href="{{ route('view-binary-list') }}">Binary List</a>
                    </li>
                </ul>
            </div>
            <div id="components">
                <ul>
                    <li class="navigation-divider d-flex align-items-center">
                        <i class="mr-2" data-feather="layers"></i> Request
                    </li>
                    <li>
                        <a class="{{ request()->is('user/encashment') ? 'active' : '' }}"
                            href="{{ route('encashment') }}">Encashment</a>
                    </li>
                    <li>
                        <a class="{{ request()->is('user/redeem') ? 'active' : '' }}"
                            href="{{ route('redeem.list') }}">Redeem</a>
                    </li>
                    <li>
                        <a class="{{ request()->is('user/upgrade-account') ? 'active' : '' }}"
                            href="{{ route('upgrade-account') }}">Upgrade Account</a>
                    </li>
                    {{-- <li>
                        <a class="{{ request()->is('user/donations')  ? 'active' : '' }}" href="{{route('user.donations')}}">Donations</a>
                    </li> --}}
                    <li>
                        <a class="{{ request()->is('user/transfer-income') ? 'active' : '' }}"
                            href="{{ route('user.income-transfer') }}">Transfer Income</a>
                    </li>
                    <li>
                        <a class="{{ request()->is('user/transfer-point') ? 'active' : '' }}"
                            href="{{ route('user.point-transfer') }}">Transfer Point</a>
                    </li>

                    <li>
                        <a class="{{ request()->is('user/advertisements') ? 'active' : '' }}"
                            href="{{ route('user.advertisements') }}">Advertisements</a>
                    </li>
                </ul>
            </div>

            <div id="codes_fac">
                <ul>
                    <li class="navigation-divider d-flex align-items-center">
                        <i class="mr-2" data-feather="globe"></i> Codes Facility
                    </li>
                    <li>
                        <a class="{{ request()->is('user/codes-facility') ? 'active' : '' }}"
                            href="{{ route('codes-facility') }}">Codes Facility</a>
                    </li>
                </ul>
            </div>
            <div id="products">
                <ul>
                    <li class="navigation-divider d-flex align-items-center">
                        <i class="mr-2" data-feather="globe"></i> Products
                    </li>
                    <li>
                        <a class="{{ request()->is('user/products') ? 'active' : '' }}"
                            href="{{ route('products.list') }}">Products</a>
                    </li>
                    <li>
                        <a class="{{ request()->is('user/products/cart') ? 'active' : '' }}"
                            href="{{ route('products.cart') }}">Cart</a>
                    </li>
                    <li>
                        <a class="{{ request()->is('user/products/checkout') ? 'active' : '' }}"
                            href="{{ route('products.cart.checkout') }}">Checkout</a>
                    </li>
                </ul>
            </div>
            <div id="pages">
                <ul>
                    <li class="navigation-divider d-flex align-items-center">
                        <i class="mr-2" data-feather="settings"></i> Profile
                    </li>
                    <li>
                        <a class="{{ request()->is('user/member-profile') ? 'active' : '' }}"
                            href="{{ route('member-profile') }}">Profile Setting</a>
                    </li>
                    <li>
                        <a href="{{ route('logout') }}">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
