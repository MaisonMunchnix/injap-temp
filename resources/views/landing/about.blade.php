@extends('layouts.landing.master')
@section('title', 'About Us')

@section('stylesheets')
    {{-- additional style here --}}

@endsection

@section('content')
    <section data-bg-src="{{ asset('landing/img/bg/about-bg-5-1.jpg') }}">
        <div class="container container-style1">
            <div class="row flex-row-reverse align-items-center gx-70">
                <div class="col-lg-6 col-xl"><img src="{{ asset('landing/img/about/ab-7-1.jpg') }}" alt="about image">
                </div>
                <div class="col-lg-6 col-xl-auto wow fadeInUp" data-wow-delay="0.2s">
                    <div class="about-box2"><span class="sec-subtitle"><i class="fas fa-bring-forward"></i>RCBO CONSUMER GOODS
                            TRADING</span>

                        <p>
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

                        <p>We believe that networking is more than just a business strategy; it's a way of fostering
                            meaningful relationships, sharing opportunities, and collectively achieving success. With RCBO
                            Consumer Goods Trading, you can be part of a community that values collaboration, personal
                            development, and financial empowerment.</p>
                        <p>Our commitment to delivering quality products at affordable prices aligns seamlessly with our
                            networking philosophy. We strive to make essential items accessible to all while providing you
                            with the tools and support you need to build and expand your network.</p>

                        <br>
                        <h2 class="sec-title h4">JOSE L MATUCOL JR</h2>

                        <h2 class="sec-title h5">FINANCIAL MANAGER</h2>


                        <div
                            class="row gx-0 align-items-center flex-row-reverse justify-content-end mt-sm-3 pt-sm-3 mb-30 pb-10">

                        </div><a href="{{ route('landing.contact') }}" class="vs-btn">Contact Us<i
                                class="far fa-long-arrow-right"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
    {{-- additional scripts here --}}
@endsection
