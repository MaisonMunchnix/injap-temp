@extends('layouts.landing.master')
@section('title', 'Home')
@section('page-title', 'Home')

@section('stylesheets')
    {{-- additional style here --}}
@endsection

@section('content')
    <section class="vs-hero-wrapper position-relative">
        <div class="vs-hero-carousel" data-height="850" data-container="1900" data-slidertype="responsive">
            <div class="ls-slide" data-ls="duration:12000; transition2d:5; kenburnszoom:in; kenburnsscale:1.1;">
                <img width="1920" height="850" src="{{ asset('landing//img/hero/hero-1-1.jpg') }}" class="ls-bg"
                    alt="hero-bg" />
                <div style="
                    font-size: 36px;
                    color: #000;
                    text-align: left;
                    font-style: normal;
                    text-decoration: none;
                    text-transform: none;
                    font-weight: 400;
                    letter-spacing: 0px;
                    border-style: solid;
                    border-color: #000;
                    background-position: 0% 0%;
                    background-repeat: no-repeat;
                    width: 300px;
                    height: 1558px;
                    background-color: rgba(14, 84, 245, 0.5);
                    top: -473px;
                    left: 51px;
                "
                    class="ls-l ls-text-layer d-hd-none"
                    data-ls="offsetxin:-800; offsetyin:-800; durationin:1700; delayin:1200; easingin:easeOutQuint; rotatein:43.46; offsetxout:1200; offsetyout:1200; durationout:8000; startatout:slidechangeonly + 3000; easingout:easeOutQuint; scaleyout:5; rotation:43.46;">
                </div>
                <div style="
                    font-size: 36px;
                    color: #000;
                    text-align: left;
                    font-style: normal;
                    text-decoration: none;
                    text-transform: none;
                    font-weight: 400;
                    letter-spacing: 0px;
                    border-style: solid;
                    border-color: #000;
                    background-position: 0% 0%;
                    background-repeat: no-repeat;
                    width: 589px;
                    height: 1819.7px;
                    top: -485px;
                    left: 406px;
                    background: linear-gradient(172deg, rgba(5, 26, 79, 0.35) 21%, rgba(0, 0, 0, 0) 54%);
                "
                    class="ls-l ls-text-layer d-hd-none"
                    data-ls="offsetxin:-800; offsetyin:-800; durationin:1500; delayin:1300; easingin:easeOutQuint; rotatein:43.46; offsetxout:1200; offsetyout:1200; durationout:8000; startatout:slidechangeonly + 3000; easingout:easeOutQuint; scaleyout:5; bgcolorout:transparent; colorout:transparent; rotation:43.46;">
                </div>
                <p style="
                    font-size: 18px;
                    text-align: left;
                    font-style: normal;
                    text-decoration: none;
                    text-transform: none;
                    font-weight: 600;
                    letter-spacing: 0px;
                    border-style: solid;
                    background-position: 0% 0%;
                    background-repeat: no-repeat;
                    font-family: Exo;
                    color: #ffffff;
                    border-width: 2px 2px 2px 2px;
                    border-color: #ffffff;
                    border-radius: 5px 5px 5px 5px;
                    padding-top: 9px;
                    padding-right: 23.5px;
                    padding-left: 23.5px;
                    top: 240px;
                    left: 588px;
                    padding-bottom: 9px;
                "
                    class="ls-l ls-hide-tablet ls-hide-phone ls-text-layer"
                    data-ls="offsetxin:300; durationin:1500; delayin:400; easingin:easeOutQuint; offsetxout:300; durationout:1500; easingout:easeOutQuint;">
                    JOIN US TODAY
                </p>
                <h1 style="top: 225px; left: 345px; font-weight: 700; background-size: inherit; background-position: inherit; font-size: 60px; color: #ffffff; font-family: Exo;"
                    class="ls-l ls-hide-tablet ls-hide-phone ls-text-layer"
                    data-ls="offsetxin:-200; durationin:1500; easingin:easeOutQuint; offsetxout:-100; durationout:1500; easingout:easeOutQuint; position:relative;">
                    RCBO
                </h1>
                <h1 style="
                    top: 305px;
                    left: 345px;
                    font-weight: 700;
                    background-size: inherit;
                    background-position: inherit;
                    font-size: 60px;
                    font-family: Exo;
                    color: #ffffff;
                    text-transform: none;
                    border-style: solid;
                    border-color: #000;
                    background-color: transparent;
                    background-repeat: no-repeat;
                    cursor: auto;
                "
                    class="ls-l ls-hide-tablet ls-hide-phone ls-text-layer"
                    data-ls="offsetxin:-200; durationin:1500; delayin:200; easingin:easeOutQuint; offsetxout:-100; durationout:1500; easingout:easeOutQuint;">
                    CONSUMER GOODS TRADING
                </h1>
                <div style="top: 405px; left: 350px; background-size: inherit; background-position: inherit; font-size: 16px; line-height: 28px; font-family: Fira Sans; width: 695px; color: #ffffff; white-space: normal;"
                    class="ls-l ls-hide-tablet ls-hide-phone ls-text-layer"
                    data-ls="offsetyin:50; durationin:1500; delayin:600; easingin:easeOutQuint; offsetyout:50; durationout:1500; easingout:easeOutQuint; position:relative;">
                    Whether you are looking for high-quality consumer goods at affordable prices or seeking an
                    entrepreneurial opportunity that can change your life, {{ env('APP_NAME') }} is here to serve your
                    needs. Join our growing community and experience the difference that our MLM platform can make in your
                    life.

                </div>

                <div style="top: 495px; left: 350px; background-size: inherit; background-position: inherit; font-size: 24px;"
                    class="ls-l ls-hide-tablet ls-hide-phone ls-html-layer"
                    data-ls="offsetyin:50; durationin:1500; delayin:900; easingin:easeOutQuint; offsetyout:50; durationout:1500; easingout:easeOutQuint; position:relative;">
                    <br>



                    <div class="ls-btn-group">

                        <a href="{{ route('landing.about') }}" class="vs-btn ls-hero-btn">ABOUT US<i
                                class="far fa-arrow-right"></i></a> <a href="{{ route('landing.contact') }}"
                            class="vs-btn style2 ls-hero-btn">CONTACT US<i class="far fa-arrow-right"></i></a>
                    </div>
                </div>
                <p style="
                    font-size: 32px;
                    text-align: left;
                    font-style: normal;
                    text-decoration: none;
                    text-transform: none;
                    font-weight: 600;
                    letter-spacing: 0px;
                    border-style: solid;
                    background-position: 0% 0%;
                    background-repeat: no-repeat;
                    font-family: Exo;
                    color: #ffffff;
                    border-width: 2px 2px 2px 2px;
                    border-color: #ffffff;
                    border-radius: 5px 5px 5px 5px;
                    padding-top: 18px;
                    padding-right: 44px;
                    padding-left: 44px;
                    top: 160px;
                    left: 90px;
                    padding-bottom: 18px;
                "
                    class="ls-l ls-hide-desktop ls-hide-phone ls-text-layer"
                    data-ls="offsetxin:300; durationin:1500; delayin:400; easingin:easeOutQuint; offsetxout:300; durationout:1500; easingout:easeOutQuint;">
                    JOIN US TODAY
                </p>
                <h1 style="top: 280px; left: 80px; font-weight: 700; background-size: inherit; background-position: inherit; font-size: 80px; color: #ffffff; font-family: Exo;"
                    class="ls-l ls-hide-desktop ls-hide-phone ls-text-layer"
                    data-ls="offsetxin:-200; durationin:1500; easingin:easeOutQuint; offsetxout:-100; durationout:1500; easingout:easeOutQuint; position:relative;">
                    RCBO
                </h1>
                <h1 style="
                    top: 380px;
                    left: 80px;
                    font-weight: 700;
                    background-size: inherit;
                    background-position: inherit;
                    font-size: 80px;
                    font-family: Exo;
                    color: #ffffff;
                    text-transform: none;
                    border-style: solid;
                    border-color: #000;
                    background-color: transparent;
                    background-repeat: no-repeat;
                    cursor: auto;
                "
                    class="ls-l ls-hide-desktop ls-hide-phone ls-text-layer"
                    data-ls="offsetxin:-200; durationin:1500; delayin:200; easingin:easeOutQuint; offsetxout:-100; durationout:1500; easingout:easeOutQuint;">
                    CONSUMER GOODS TRADING
                </h1>
                <div style="top: 540px; left: 80px; background-size: inherit; background-position: inherit; font-size: 24px;"
                    class="ls-l ls-hide-desktop ls-hide-phone ls-html-layer"
                    data-ls="offsetyin:50; durationin:1500; delayin:900; easingin:easeOutQuint; offsetyout:50; durationout:1500; easingout:easeOutQuint; position:relative;">
                    <div class="ls-btn-group">
                        <a href="{{ route('landing.about') }}" class="vs-btn ls-hero-btn">ABOUT US<i
                                class="far fa-arrow-right"></i></a> <a href="{{ route('landing.contact') }}"
                            class="vs-btn style2 ls-hero-btn">CONTACT US<i class="far fa-arrow-right"></i></a>
                    </div>
                </div>
                <h1 style="top: 120px; left: 50%; text-align: center; font-weight: 700; background-size: inherit; background-position: inherit; font-size: 130px; color: #ffffff; font-family: Exo; width: 10000px;"
                    class="ls-l ls-hide-desktop ls-hide-tablet ls-text-layer"
                    data-ls="offsetxin:-200; durationin:1500; easingin:easeOutQuint; offsetxout:-100; durationout:1500; easingout:easeOutQuint; position:relative;">
                    RCBO
                </h1>
                <h1 style="
                    top: 280px;
                    left: 50%;
                    text-align: center;
                    font-weight: 700;
                    background-size: inherit;
                    background-position: inherit;
                    font-size: 130px;
                    font-family: Exo;
                    color: #ffffff;
                    width: 10000px;
                    text-transform: none;
                    border-style: solid;
                    border-color: #000;
                    background-color: transparent;
                    background-repeat: no-repeat;
                    cursor: auto;
                "
                    class="ls-l ls-hide-desktop ls-hide-tablet ls-text-layer"
                    data-ls="offsetxin:-200; durationin:1500; delayin:200; easingin:easeOutQuint; offsetxout:-100; durationout:1500; easingout:easeOutQuint;">
                    CONSUMER GOODS TRADING
                </h1>
                <div style="top: 520px; left: 50%; text-align: center; background-size: inherit; background-position: inherit; font-size: 24px; width: 1000px;"
                    class="ls-l ls-hide-desktop ls-hide-tablet ls-html-layer"
                    data-ls="offsetyin:50; durationin:1500; delayin:900; easingin:easeOutQuint; offsetyout:50; durationout:1500; easingout:easeOutQuint; position:relative;">
                    <div class="ls-btn-group">
                        <a href="{{ route('landing.about') }}" class="vs-btn ls-hero-btn">ABOUT US<i
                                class="far fa-arrow-right"></i></a> <a href="{{ route('landing.contact') }}"
                            class="vs-btn style2 ls-hero-btn">CONTACT US<i class="far fa-arrow-right"></i></a>
                    </div>
                </div>
                <a class="ls-l ls-hide-tablet ls-hide-phone" href="#next" target="_self" data-ls="static:forever;">
                    <div style="
                        font-size: 36px;
                        color: #000;
                        text-align: left;
                        font-style: normal;
                        text-decoration: none;
                        text-transform: none;
                        font-weight: 400;
                        letter-spacing: 0px;
                        border-style: solid;
                        border-color: #000;
                        background-position: 0% 0%;
                        background-repeat: no-repeat;
                        left: 1685px;
                        top: 50%;
                    "
                        class="ls-html-layer">
                        <span class="icon-btn style2"><i class="far fa-arrow-right"></i></span>
                    </div>
                </a>
                <a class="ls-l ls-hide-tablet ls-hide-phone" href="#prev" target="_self" data-ls="static:forever;">
                    <div style="
                        font-size: 36px;
                        color: #000;
                        text-align: left;
                        font-style: normal;
                        text-decoration: none;
                        text-transform: none;
                        font-weight: 400;
                        letter-spacing: 0px;
                        border-style: solid;
                        border-color: #000;
                        background-position: 0% 0%;
                        background-repeat: no-repeat;
                        left: 150px;
                        top: 50%;
                    "
                        class="ls-html-layer">
                        <span class="icon-btn style2"><i class="far fa-arrow-left"></i></span>
                    </div>
                </a>
            </div>
            <div class="ls-slide" data-ls="duration:12000; transition2d:5; kenburnszoom:out; kenburnsscale:1.1;">
                <img width="1920" height="850" src="{{ asset('landing//img/hero/hero-1-2.jpg') }}" class="ls-bg"
                    alt="hero-bg" />
                <div style="
                    font-size: 36px;
                    color: #000;
                    text-align: left;
                    font-style: normal;
                    text-decoration: none;
                    text-transform: none;
                    font-weight: 400;
                    letter-spacing: 0px;
                    border-style: solid;
                    border-color: #000;
                    background-position: 0% 0%;
                    background-repeat: no-repeat;
                    width: 300px;
                    height: 1558px;
                    background-color: rgba(14, 84, 245, 0.5);
                    top: -473px;
                    left: 51px;
                "
                    class="ls-l ls-text-layer d-hd-none"
                    data-ls="offsetxin:-800; offsetyin:-800; durationin:1700; delayin:1200; easingin:easeOutQuint; rotatein:43.46; offsetxout:1200; offsetyout:1200; durationout:8000; startatout:slidechangeonly + 3000; easingout:easeOutQuint; scaleyout:5; rotation:43.46;">
                </div>
                <div style="
                    font-size: 36px;
                    color: #000;
                    text-align: left;
                    font-style: normal;
                    text-decoration: none;
                    text-transform: none;
                    font-weight: 400;
                    letter-spacing: 0px;
                    border-style: solid;
                    border-color: #000;
                    background-position: 0% 0%;
                    background-repeat: no-repeat;
                    width: 589px;
                    height: 1819.7px;
                    top: -485px;
                    left: 406px;
                    background: linear-gradient(172deg, rgba(5, 26, 79, 0.35) 21%, rgba(0, 0, 0, 0) 54%);
                "
                    class="ls-l ls-text-layer d-hd-none"
                    data-ls="offsetxin:-800; offsetyin:-800; durationin:1500; delayin:1300; easingin:easeOutQuint; rotatein:43.46; offsetxout:1200; offsetyout:1200; durationout:8000; startatout:slidechangeonly + 3000; easingout:easeOutQuint; scaleyout:5; bgcolorout:transparent; colorout:transparent; rotation:43.46;">
                </div>
                <p style="
                    font-size: 18px;
                    text-align: left;
                    font-style: normal;
                    text-decoration: none;
                    text-transform: none;
                    font-weight: 600;
                    letter-spacing: 0px;
                    border-style: solid;
                    background-position: 0% 0%;
                    background-repeat: no-repeat;
                    font-family: Exo;
                    color: #ffffff;
                    border-width: 2px 2px 2px 2px;
                    border-color: #ffffff;
                    border-radius: 5px 5px 5px 5px;
                    padding-top: 9px;
                    padding-right: 23.5px;
                    padding-left: 23.5px;
                    top: 240px;
                    left: 558px;
                    padding-bottom: 9px;
                "
                    class="ls-l ls-hide-tablet ls-hide-phone ls-text-layer"
                    data-ls="offsetxin:300; durationin:1500; delayin:400; easingin:easeOutQuint; offsetxout:300; durationout:1500; easingout:easeOutQuint;">
                    JOIN US TODAY
                </p>
                <h1 style="top: 225px; left: 345px; font-weight: 700; background-size: inherit; background-position: inherit; font-size: 60px; color: #ffffff; font-family: Exo;"
                    class="ls-l ls-hide-tablet ls-hide-phone ls-text-layer"
                    data-ls="offsetxin:-200; durationin:1500; easingin:easeOutQuint; offsetxout:-100; durationout:1500; easingout:easeOutQuint; position:relative;">
                    RCBO
                </h1>
                <h1 style="
                    top: 305px;
                    left: 345px;
                    font-weight: 700;
                    background-size: inherit;
                    background-position: inherit;
                    font-size: 60px;
                    font-family: Exo;
                    color: #ffffff;
                    text-transform: none;
                    border-style: solid;
                    border-color: #000;
                    background-color: transparent;
                    background-repeat: no-repeat;
                    cursor: auto;
                "
                    class="ls-l ls-hide-tablet ls-hide-phone ls-text-layer"
                    data-ls="offsetxin:-200; durationin:1500; delayin:200; easingin:easeOutQuint; offsetxout:-100; durationout:1500; easingout:easeOutQuint;">
                    CONSUMER GOODS TRADING
                </h1>
                <div style="top: 405px; left: 350px; background-size: inherit; background-position: inherit; font-size: 16px; line-height: 28px; font-family: Fira Sans; width: 695px; color: #ffffff; white-space: normal;"
                    class="ls-l ls-hide-tablet ls-hide-phone ls-text-layer"
                    data-ls="offsetyin:50; durationin:1500; delayin:600; easingin:easeOutQuint; offsetyout:50; durationout:1500; easingout:easeOutQuint; position:relative;">
                    Discover the world of essential products and financial empowerment with {{ env('APP_NAME') }}.
                    Together, we can create a brighter and more prosperous future for everyone.
                </div>
                <div style="top: 495px; left: 350px; background-size: inherit; background-position: inherit; font-size: 24px;"
                    class="ls-l ls-hide-tablet ls-hide-phone ls-html-layer"
                    data-ls="offsetyin:50; durationin:1500; delayin:900; easingin:easeOutQuint; offsetyout:50; durationout:1500; easingout:easeOutQuint; position:relative;">
                    <div class="ls-btn-group">
                        <a href="{{ route('landing.about') }}" class="vs-btn ls-hero-btn">ABOUT US<i
                                class="far fa-arrow-right"></i></a> <a href="{{ route('landing.contact') }}"
                            class="vs-btn style2 ls-hero-btn">CONTACT US<i class="far fa-arrow-right"></i></a>
                    </div>
                </div>
                <p style="
                    font-size: 32px;
                    text-align: left;
                    font-style: normal;
                    text-decoration: none;
                    text-transform: none;
                    font-weight: 600;
                    letter-spacing: 0px;
                    border-style: solid;
                    background-position: 0% 0%;
                    background-repeat: no-repeat;
                    font-family: Exo;
                    color: #ffffff;
                    border-width: 2px 2px 2px 2px;
                    border-color: #ffffff;
                    border-radius: 5px 5px 5px 5px;
                    padding-top: 18px;
                    padding-right: 44px;
                    padding-left: 44px;
                    top: 160px;
                    left: 90px;
                    padding-bottom: 18px;
                "
                    class="ls-l ls-hide-desktop ls-hide-phone ls-text-layer"
                    data-ls="offsetxin:300; durationin:1500; delayin:400; easingin:easeOutQuint; offsetxout:300; durationout:1500; easingout:easeOutQuint;">
                    PROVIDE FREE CONSULTATION
                </p>
                <h1 style="top: 280px; left: 80px; font-weight: 700; background-size: inherit; background-position: inherit; font-size: 80px; color: #ffffff; font-family: Exo;"
                    class="ls-l ls-hide-desktop ls-hide-phone ls-text-layer"
                    data-ls="offsetxin:-200; durationin:1500; easingin:easeOutQuint; offsetxout:-100; durationout:1500; easingout:easeOutQuint; position:relative;">
                    RCBO
                </h1>
                <h1 style="
                    top: 380px;
                    left: 80px;
                    font-weight: 700;
                    background-size: inherit;
                    background-position: inherit;
                    font-size: 80px;
                    font-family: Exo;
                    color: #ffffff;
                    text-transform: none;
                    border-style: solid;
                    border-color: #000;
                    background-color: transparent;
                    background-repeat: no-repeat;
                    cursor: auto;
                "
                    class="ls-l ls-hide-desktop ls-hide-phone ls-text-layer"
                    data-ls="offsetxin:-200; durationin:1500; delayin:200; easingin:easeOutQuint; offsetxout:-100; durationout:1500; easingout:easeOutQuint;">
                    CONSUMER GOODS TRADING
                </h1>
                <div style="top: 540px; left: 80px; background-size: inherit; background-position: inherit; font-size: 24px;"
                    class="ls-l ls-hide-desktop ls-hide-phone ls-html-layer"
                    data-ls="offsetyin:50; durationin:1500; delayin:900; easingin:easeOutQuint; offsetyout:50; durationout:1500; easingout:easeOutQuint; position:relative;">
                    <div class="ls-btn-group">
                        <a href="{{ route('landing.about') }}" class="vs-btn ls-hero-btn">ABOUT US<i
                                class="far fa-arrow-right"></i></a> <a href="{{ route('landing.contact') }}"
                            class="vs-btn style2 ls-hero-btn">CONTACT US<i class="far fa-arrow-right"></i></a>
                    </div>
                </div>
                <h1 style="top: 120px; left: 50%; text-align: center; font-weight: 700; background-size: inherit; background-position: inherit; font-size: 130px; color: #ffffff; font-family: Exo; width: 10000px;"
                    class="ls-l ls-hide-desktop ls-hide-tablet ls-text-layer"
                    data-ls="offsetxin:-200; durationin:1500; easingin:easeOutQuint; offsetxout:-100; durationout:1500; easingout:easeOutQuint; position:relative;">
                    RCBO
                </h1>
                <h1 style="
                    top: 280px;
                    left: 50%;
                    text-align: center;
                    font-weight: 700;
                    background-size: inherit;
                    background-position: inherit;
                    font-size: 130px;
                    font-family: Exo;
                    color: #ffffff;
                    width: 10000px;
                    text-transform: none;
                    border-style: solid;
                    border-color: #000;
                    background-color: transparent;
                    background-repeat: no-repeat;
                    cursor: auto;
                "
                    class="ls-l ls-hide-desktop ls-hide-tablet ls-text-layer"
                    data-ls="offsetxin:-200; durationin:1500; delayin:200; easingin:easeOutQuint; offsetxout:-100; durationout:1500; easingout:easeOutQuint;">
                    CONSUMER GOODS TRADING
                </h1>
                <div style="top: 520px; left: 50%; text-align: center; background-size: inherit; background-position: inherit; font-size: 24px; width: 1000px;"
                    class="ls-l ls-hide-desktop ls-hide-tablet ls-html-layer"
                    data-ls="offsetyin:50; durationin:1500; delayin:900; easingin:easeOutQuint; offsetyout:50; durationout:1500; easingout:easeOutQuint; position:relative;">
                    <div class="ls-btn-group">
                        <a href="{{ route('landing.about') }}" class="vs-btn ls-hero-btn">ABOUT US<i
                                class="far fa-arrow-right"></i></a> <a href="{{ route('landing.contact') }}"
                            class="vs-btn style2 ls-hero-btn">CONTACT US<i class="far fa-arrow-right"></i></a>
                    </div>
                </div>
            </div>

        </div>
    </section>
    <div data-bg-src="{{ asset('landing/img/bg/ab-bg-1-1.jpg') }}">
        <section class="feature-wrap1 space-top space-extra-bottom">
            <div class="container wow fadeInUp" data-wow-delay="0.2s">
                <div class="row vs-carousel" data-slide-show="3" data-lg-slide-show="2" data-md-slide-show="2">
                    <div class="col-xl-4">
                        <div class="feature-style1">

                            <h3 class="feature-title h5"><a class="text-inherit"
                                    href="{{ route('landing.package', 'wgc-membership') }}">WGC Membership -
                                    Empower
                                    Your Start</a></h3>
                            <p class="feature-text">Unlock your journey to financial freedom with our WGC Japan Charity
                                Package, designed for those who are willing...</p>
                            <a href="{{ route('landing.package', 'wgc-membership') }}" class="vs-btn style3">Read More<i
                                    class="far fa-long-arrow-right"></i></a>
                        </div>
                    </div>
                    <div class="col-xl-4">
                        <div class="feature-style1">

                            <h3 class="feature-title h5"><a class="text-inherit"
                                    href="{{ route('landing.package', 'gold') }}">Gold Package
                                    - Accelerate Your Growth</a></h3>
                            <p class="feature-text">Ready to amplify your earnings and network? Upgrade to the Gold Package
                                to fast-track your journey towards financial success and abundance.</p>
                            <a href="{{ route('landing.package', 'gold') }}" class="vs-btn style3">Read More<i
                                    class="far fa-long-arrow-right"></i></a>
                        </div>
                    </div>
                    <div class="col-xl-4">
                        <div class="feature-style1">

                            <h3 class="feature-title h5"><a class="text-inherit"
                                    href="{{ route('landing.package', 'diamond') }}">Diamond
                                    Package - Achieve the Highest Level</a></h3>
                            <p class="feature-text">For those who have big dreams and want to reach the very top, the
                                Diamond Package is the best choice. You lead and achieve extraordinary success.</p>
                            <a href="{{ route('landing.package', 'diamond') }}" class="vs-btn style3">Read More<i
                                    class="far fa-long-arrow-right"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="position-relative space-bottom">
            <span class="about-shape1 d-none d-xl-block">RCBO</span>
            <div class="container z-index-common">
                <div class="row gx-60">
                    <div class="col-lg-6 col-xl-5 mb-50 mb-lg-0 wow fadeInUp" data-wow-delay="0.2s">
                        <div class="img-box1">
                            <div class="img-1"><img src="{{ asset('landing/img/about/ab-1-1.jpg') }}" alt="About image"
                                    style="border-radius: 25px" /></div>
                            <br>
                            <h2 class="sec-title h4">RONALD CLARION BOLO</h2>

                            <h2 class="sec-title h5">PROPRIETOR/OWNER</h2>

                        </div>
                    </div>
                    <div class="col-lg-6 col-xl-7 align-self-center wow fadeInUp" data-wow-delay="0.3s">
                        <span class="sec-subtitle"><i class="fas fa-bring-forward"></i>{{ env('APP_NAME') }}</span>
                        <h2 class="sec-title h1">Unlock Opportunities with {{ env('APP_NAME') }}</h2>
                        <p class="mb-4 mt-1 pb-3">
                            Welcome to {{ env('APP_NAME') }}, your go-to destination for essential products and an
                            exceptional networking business experience. Our company was founded with a dedication to
                            delivering top-quality goods while nurturing entrepreneurial growth. We are proud to be your
                            dependable partner on the path to achieving financial independence and self-sufficiency through
                            networking opportunities.
                        </p>
                        <p>At {{ env('APP_NAME') }}, we understand the power of building connections and leveraging
                            them for mutual benefit. Our networking business model offers you a unique avenue to explore
                            entrepreneurship, connect with like-minded individuals, and access essential products at
                            competitive prices.</p>
                        <a href="{{ route('landing.about') }}" class="vs-btn">More About Us<i
                                class="far fa-long-arrow-right"></i></a>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <section class="space-top space-extra-bottom" data-bg-src="{{ asset('landing/img/bg/sr-bg-1-1.png') }}">
        <div class="container">
            <div class="row justify-content-center text-center">
                <div class="col-lg-8 col-xl-6 wow fadeInUp" data-wow-delay="0.2s">
                    <div class="title-area">
                        <span class="sec-subtitle">Our Membership Benefits</span>
                        <h2 class="sec-title h1">Membership Benefits at {{ env('APP_NAME') }}</h2>
                    </div>
                </div>
            </div>
            <div class="row wow fadeInUp" data-wow-delay="0.2s">

                <div class="col-md-6 col-lg-4">
                    <div class="service-style1">
                        <div class="service-bg" data-bg-src="{{ asset('landing/img/bg/sr-box-bg-1.jpg') }}"></div>

                        <h3 class="service-title h5"><a href="#">Referral Bonus</a></h3>
                        <p class="service-text">As a valued member of {{ env('APP_NAME') }}, you can earn Referral
                            Bonuses by introducing new individuals to our networking business. For each new member you bring
                            in, you'll receive a Referral Bonus that varies depending on your chosen package.</p>

                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="service-style1">
                        <div class="service-bg" data-bg-src="{{ asset('landing/img/bg/sr-box-bg-1.jpg') }}"></div>
                        <h3 class="service-title h5"><a href="#">Pairing Bonus</a></h3>
                        <p class="service-text">With our Pairing Bonus, your earnings grow as your network expands. For
                            each successful pairing within your network, you'll receive a Pairing Bonus. The Pairing Bonus
                            amount differs based on your package. </p>
                        <br>

                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="service-style1">
                        <div class="service-bg" data-bg-src="{{ asset('landing/img/bg/sr-box-bg-1.jpg') }}"></div>

                        <h3 class="service-title h5"><a href="#">Product Reward Points</a></h3>
                        <p class="service-text">Our Product Reward Points system allows you to accumulate points with every
                            purchase of our essential products. These points can be redeemed or convertibale to cash. The
                            more you shop and build your network, the more Product Reward Points you can earn.</p>

                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="service-style1">
                        <div class="service-bg" data-bg-src="{{ asset('landing/img/bg/sr-box-bg-1.jpg') }}"></div>

                        <h3 class="service-title h5"><a href="#">Encashment</a></h3>
                        <p class="service-text">At {{ env('APP_NAME') }}, we understand that financial flexibility is
                            crucial. Our members have the option to encash their earned bonuses and rewards, providing you
                            with a source of cash when you need it most. This feature ensures that you have the freedom to
                            use your earnings as you see fit.</p>

                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="service-style1">
                        <div class="service-bg" data-bg-src="{{ asset('landing/img/bg/sr-box-bg-1.jpg') }}"></div>

                        <h3 class="service-title h5"><a href="#">Transfer Funds</a></h3>
                        <p class="service-text">Transferring funds within our network is quick and easy. You can send and
                            receive funds from other members securely and efficiently. Whether you're supporting a team
                            member or conducting business transactions, our Transfer Funds feature simplifies financial
                            interactions within RCBO community.</p>

                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="service-style1">
                        <div class="service-bg" data-bg-src="{{ asset('landing/img/bg/sr-box-bg-1.jpg') }}"></div>

                        <h3 class="service-title h5"><a href="#">Transfer Reward Points</a></h3>
                        <p class="service-text">In addition to transferring funds, you can also transfer Reward Points to
                            other members. This can be a powerful tool for helping your team members access rewards and
                            incentives more quickly, fostering a sense of collaboration and mutual success within our
                            networks.</p>
                        <br>
                    </div>
                </div>
            </div>
        </div>
    </section>




    <section class="z-index-common space" data-bg-src="{{ asset('landing/img/bg/cta-bg-1-1.jpg') }}">
        <div class="container">
            <div class="row text-center text-lg-start align-items-center justify-content-between">
                <div class="col-lg-auto">
                    <span class="sec-subtitle text-white">We are here to answer your questions 24/7</span>
                    <h2 class="h1 sec-title cta-title1">Need A Consultation?</h2>
                </div>
                <div class="col-lg-auto">
                    <a href="{{ route('landing.contact') }}" class="vs-btn">Contact Us Now<i
                            class="far fa-arrow-right"></i></a>
                </div>
            </div>
        </div>
    </section>



    <!-- <section class="vs-blog-wrapper space-top space-extra-bottom"
                        data-bg-src="{{ asset('landing/img/bg/blog-bg-1-1.jpg') }}">
                        <div class="container wow fadeInUp" data-wow-delay="0.2s">
                            <div class="row justify-content-center text-center">
                                <div class="col-xl-6">
                                    <div class="title-area">
                                        <span class="sec-subtitle">Announcement</span>
                                        <h2 class="sec-title h1">RCBO News and Announcements</h2>
                                    </div>
                                </div>
                            </div>
                            <div class="row vs-carousel" data-slide-show="3" data-md-slide-show="2">
                                <div class="col-xl-4">
                                    <div class="vs-blog blog-style1">
                                        <div class="blog-img">
                                            <img src="{{ asset('landing/img/blog/blog-1-1.jpg') }}" alt="Blog Image" class="w-100" />
                                            <div class="blog-content">
                                                <div class="blog-meta">
                                                    <a href="{{ route('landing.announcements') }}"><i class="far fa-calendar"></i>24
                                                        August, 2023</a> <a href="{{ route('landing.announcements') }}"></a>
                                                </div>
                                                <h3 class="blog-title h5"><a href="announcement-dynamic-single-page.html">Sample
                                                        Announcement Title 1</a></h3>
                                                <a href="announcement-dynamic-single-page.html" class="link-btn">Read Details<i
                                                        class="far fa-arrow-right"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-4">
                                    <div class="vs-blog blog-style1">
                                        <div class="blog-img">
                                            <img src="{{ asset('landing/img/blog/blog-1-4.jpg') }}" alt="Blog Image" class="w-100" />
                                            <div class="blog-content">
                                                <div class="blog-meta">
                                                    <a href="{{ route('landing.announcements') }}"><i class="far fa-calendar"></i>25
                                                        August, 2023</a> <a href="{{ route('landing.announcements') }}"></a>
                                                </div>
                                                <h3 class="blog-title h5"><a href="announcement-dynamic-single-page.html">Sample
                                                        Announcement Title 2</a></h3>
                                                <a href="announcement-dynamic-single-page.html" class="link-btn">Read Details<i
                                                        class="far fa-arrow-right"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-4">
                                    <div class="vs-blog blog-style1">
                                        <div class="blog-img">
                                            <img src="{{ asset('landing/img/blog/blog-1-2.jpg') }}" alt="Blog Image" class="w-100" />
                                            <div class="blog-content">
                                                <div class="blog-meta">
                                                    <a href="{{ route('landing.announcements') }}"><i class="far fa-calendar"></i>26
                                                        August, 2023</a> <a href="{{ route('landing.announcements') }}"></a>
                                                </div>
                                                <h3 class="blog-title h5"><a href="announcement-dynamic-single-page.html">Sample
                                                        Announcement Title 3</a></h3>
                                                <a href="announcement-dynamic-single-page.html" class="link-btn">Read Details<i
                                                        class="far fa-arrow-right"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-4">
                                    <div class="vs-blog blog-style1">
                                        <div class="blog-img">
                                            <img src="{{ asset('landing/img/blog/blog-1-3.jpg') }}" alt="Blog Image" class="w-100" />
                                            <div class="blog-content">
                                                <div class="blog-meta">
                                                    <a href="{{ route('landing.announcements') }}"><i class="far fa-calendar"></i>27
                                                        August, 2023</a> <a href="{{ route('landing.announcements') }}"></a>
                                                </div>
                                                <h3 class="blog-title h5"><a href="announcement-dynamic-single-page.html">Sample
                                                        Announcement Title 4</a></h3>
                                                <a href="announcement-dynamic-single-page.html" class="link-btn">Read Details<i
                                                        class="far fa-arrow-right"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>-->



@endsection

@section('scripts')
    {{-- additional scripts here --}}
@endsection
