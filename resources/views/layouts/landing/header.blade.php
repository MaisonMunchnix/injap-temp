<div class="preloader">
    <div class="preloader-inner"><span class="loader"></span></div>
</div>

<div class="vs-menu-wrapper">
    <div class="vs-menu-area text-center">
        <button class="vs-menu-toggle"><i class="fal fa-times"></i></button>
        <div class="mobile-logo">
            <a href="{{ route('landing.home') }}"><img src="{{ asset('landing/img/logs.png') }}" alt="RCBO"
                    class="logo" /></a>
        </div>
        <div class="vs-mobile-menu">
            <ul>
                <li><a href="{{ route('landing.home') }}">Home</a></li>
                <li><a href="{{ route('landing.about') }}">About Us</a></li>
                <li><a href="{{ route('landing.advertisements') }}">Advertisements</a></li>
                <li class="menu-item-has-children">
                    <a href="#none">Our Packages</a>
                    <ul class="sub-menu">
                        <li><a href="{{ route('landing.package', 'wgc-membership') }}">WGC Membership</a></li>
                        <li><a href="{{ route('landing.package', 'gold') }}">Gold Package</a></li>
                        <li><a href="{{ route('landing.package', 'diamond') }}">Diamond Package</a></li>
                    </ul>
                </li>
                <li><a href="{{ route('landing.products') }}">Our Products</a></li>
                <li><a href="{{ route('landing.contact') }}">Contact Us</a></li>
                <li class="menu-item-has-children">
                    <a href="#none">Account</a>
                    <ul class="sub-menu">
                        <li><a href="{{ route('login') }}">Login</a></li>
                        <li><a href="{{ route('membership-registration') }}">Register</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</div>
<header class="vs-header header-layout1">
    <div class="header-top">
        <div class="container">
            <div class="row align-items-center justify-content-between gy-1 text-center text-lg-start">
                <div class="col-lg-auto d-none d-lg-block">
                    <p class="header-text"><span class="fw-medium">Register your own account now!</p>
                </div>
                <div class="col-lg-auto">
                    <div class="header-social style-white">
                        <span class="social-title">Address: 518-0835 Japan Mie ken Midorigaoka Minami machi 3885-3
                        </span>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="menu-top">
            <div class="row justify-content-between align-items-center gx-sm-0">
                <div class="col">
                    <div class="header-logo">
                        <a href="{{ route('landing.home') }}"><img src="{{ asset('landing/img/logs.png') }}"
                                alt="RCBO" class="logo" width="30%" /></a>
                    </div>
                </div>
                <div class="col-auto header-info">
                    <div class="header-info_icon"><i class="fas fa-currency"></i></div>
                    <div class="media-body text-center">
                        <span class="header-info_link">Exchange Rate</span>
                        <table class="table table-hover table-responsive table-sm">
                            <thead class="thead-light">
                                <tr>
                                    <th></th>
                                    <th>USD</th>
                                    <th>YEN</th>
                                    <th>HKD</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Buy</td>
                                    <td id="buy_usd"></td>
                                    <td id="buy_yen"></td>
                                    <td id="buy_hkd"></td>
                                </tr>
                                <tr>
                                    <td>Sell</td>
                                    <td id="sell_usd"></td>
                                    <td id="sell_yen"></td>
                                    <td id="sell_hkd"></td>
                                </tr>
                            </tbody>
                        </table>

                    </div>
                </div>

                <div class="col-auto header-info">
                    <div class="header-info_icon"><i class="fas fa-phone-alt"></i></div>
                    <div class="media-body">
                        <span class="header-info_label">Japan Contact Number</span>
                        <div class="header-info_link"><a href="tel:+81-595-51-6639">+81-595-51-6639</a></div>
                        <span class="header-info_label">Philippines Contact Number</span>
                        <div class="header-info_link"><a href="tel:+63-995-965-7236">+63-995-965-7236</a></div>
                    </div>
                </div>

                <div class="col-auto header-info d-none d-lg-flex">
                    <div class="header-info_icon"><i class="fas fa-envelope"></i></div>
                    <div class="media-body">
                        <span class="header-info_label">Mail Us For Support</span>
                        <div class="header-info_link"><a
                                href="mailto:{{ config('mail.support.address') }}">{{ config('mail.support.address') }}</a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <div class="sticky-wrapper">
        <div class="sticky-active">
            <div class="container">
                <div class="row align-items-center justify-content-between">
                    <div class="col-auto">
                        <nav class="main-menu menu-style1 d-none d-lg-block">
                            <ul>
                                <li><a href="{{ route('landing.home') }}">Home</a></li>
                                <li><a href="{{ route('landing.about') }}">About Us</a></li>
                                <li><a href="{{ route('landing.advertisements') }}">Advertisements</a></li>
                                <li class="menu-item-has-children">
                                    <a href="#none">Our Packages</a>
                                    <ul class="sub-menu">
                                        <li><a href="{{ route('landing.package', 'wgc-membership') }}">WGC
                                                Membership</a></li>
                                        <li><a href="{{ route('landing.package', 'gold') }}">Gold Package</a></li>
                                        <li><a href="{{ route('landing.package', 'diamond') }}">Diamond Package</a>
                                        </li>
                                    </ul>
                                </li>

                                <li><a href="{{ route('landing.products') }}">Our Products</a></li>

                                <!-- <li><a href="{{ route('landing.announcements') }}">Announcements</a></li>-->

                                <li><a href="{{ route('landing.contact') }}">Contact Us</a></li>
                                <li class="menu-item-has-children">
                                    <a href="#none">Account</a>
                                    <ul class="sub-menu">
                                        <li><a href={{ route('login') }}>Login</a></li>
                                        <li><a href="{{ route('membership-registration') }}">Register</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </nav>
                        <button class="vs-menu-toggle d-inline-block d-lg-none"><i class="fal fa-bars"></i></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
