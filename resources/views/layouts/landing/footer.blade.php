<footer class="footer-wrapper footer-layout1" data-bg-src="{{ asset('landing/img/shape/bg-footer-1-1.jpg') }}">

    <div class="widget-area">
        <div class="container">
            <div class="row justify-content-between">
                <div class="col-md-6 col-lg-4 col-xl-auto">
                    <div class="widget footer-widget">
                        <h3 class="widget_title">Join RCBO</h3>
                        <div class="vs-widget-about">
                            <p class="footer-text">Join us at {{ env('app_name') }} and embark on a journey that
                                goes beyond traditional business models. Discover the immense potential of networking
                                and become a part of a dynamic community that shares your vision for success.</p>

                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-2 col-xl-auto">
                    <div class="widget widget_nav_menu footer-widget">
                        <h3 class="widget_title">Useful Links</h3>
                        <div class="menu-all-pages-container">
                            <ul class="menu">
                                <li><a href="{{ route('landing.about') }}">About Us</a></li>
                                <li><a href="{{ route('landing.advertisements') }}">Advertisements</a></li>
                                <li><a href="{{ route('landing.contact') }}">Contact Us</a></li>

                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-2 col-xl-auto">
                    <div class="widget widget_nav_menu footer-widget">
                        <h3 class="widget_title">Our Packages</h3>
                        <div class="menu-all-pages-container">
                            <ul class="menu">
                                <li><a href="{{ route('landing.package', 'wgc-membership') }}">WGC Membership</a></li>
                                <li><a href="{{ route('landing.package', 'gold') }}">Gold Package</a></li>
                                <li><a href="{{ route('landing.package', 'diamond') }}">Diamond Package</a></li>

                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4 col-xl-auto">
                    <div class="widget footer-widget">
                        <h3 class="widget_title">Email Address</h3>
                        <div class="menu-all-pages-container">
                            <ul class="menu">
                                <li>
                                    <a href="mailto:{{ config('mail.support.address') }}">
                                        {{ config('mail.support.address') }}
                                    </a>
                                </li>


                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="copyright-wrap">
        <div class="container">
            <p class="copyright-text">
                Copyright <i class="fal fa-copyright"></i> {{ date('Y') }} <a class="text-white"
                    href="{{ route('landing.home') }}">{{ env('APP_NAME') }}</a>. All rights reserved.
            </p>
        </div>
    </div>
</footer>
<a href="#" class="scrollToTop scroll-btn"><i class="far fa-arrow-up"></i></a>
