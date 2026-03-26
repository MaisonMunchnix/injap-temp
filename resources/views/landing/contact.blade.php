@extends('layouts.landing.master')
@section('title', 'INJAP - Innovation Japan | Contact')

@section('stylesheets')
    {{-- additional style here --}}
@endsection

@section('content')
     <!-- Subpage Section Start -->
    <div class="page-header parallaxie contact-us-hero">
        <div class="container">
            <div class="row">
                <div class="co-md-12">
                    <!-- Sub page Header start -->
                    <div class="page-header-box">
                        <h1 class="text-anime">Contact Us</h1>
                        
                    </div>
                    <!-- Sub page Header end -->
                </div>
            </div>
        </div>
    </div>
    <!-- Subpage Section End -->

    <!-- Contact Us Section Start -->
    <div class="contact-us-section">
        <div class="container">
            <div class="row">
                <!-- Contact Info Box start -->
                <div class="col-lg-4 col-md-12">
                    <div class="contact-info-box wow fadeInUp" data-wow-delay="0.25s">
                        <div class="contact-info-icon">
                            <img src="{{ asset('new_landing/images/icon-location.svg')}}" alt="">
                        </div>
                        <div class="contact-info-body">
                            <h2>Address</h2>
                            <p>518-0225 Japan Mie-ken, Iga Shi, Kirigaoka 3Chome 212</p>
                        </div>
                    </div>
                </div>
                <!-- Contact Info Box end -->

                <!-- Contact Info Box start -->
                <div class="col-lg-4 col-md-6">
                    <div class="contact-info-box wow fadeInUp" data-wow-delay="0.50s">
                        <div class="contact-info-icon">
                            <img src="{{ asset('new_landing/images/icon-phone.svg')}}" alt="">
                        </div>
                        <div class="contact-info-body">
                            <h2>Phone Number</h2>
                            <p>
                                <a href="tel:0595518190">0595518190</a><br>
                               
                            </p>
                        </div>
                    </div>
                </div>
                <!-- Contact Info Box end -->

                <!-- Contact Info Box start -->
                <div class="col-lg-4 col-md-6">
                    <div class="contact-info-box wow fadeInUp" data-wow-delay="0.75s">
                        <div class="contact-info-icon">
                            <img src="{{ asset('new_landing/images/icon-mail.svg')}}" alt="">
                        </div>
                        <div class="contact-info-body">
                            <h2>E-mail Address</h2>
                            <p>
                                <a href="#">innovationjapan3@gmail.com</a>
                        
                            </p>
                        </div>
                    </div>
                </div>
                <!-- Contact Info Box end -->
            </div>
        </div>
    </div>
    <!-- Contact Us Section End -->

    <!-- Get In Touch Section Start -->
    <div class="get-in-touch">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <!-- Section Title start -->
                    <div class="section-title">
                        <h3 class="wow fadeInUp" data-wow-delay="0.25s">Get In Touch</h3>
                        <h2 class="text-anime">Contact Innovation Japan</h2>
                    </div>
                    <!-- Section Title end -->

                    <!-- Get In Touch start -->
                    <div class="get-in-touch-body wow fadeInUp" data-wow-delay="0.50s">
                        <p>Connect with our team for membership support, legal or translation assistance, and other inquiries—we’ll respond as soon as possible.</p>
                    </div>
                    <!-- Get In Touch end -->
                </div>

                <div class="col-lg-6">
                    <!-- Contact Form Start -->
                    <div class="contact-form wow fadeInUp" data-wow-delay="0.75s">
                        <form id="contactForm" action="#" method="POST" data-toggle="validator">
                            <div class="row">
                                <div class="form-group col-md-6 mb-3">
                                    <input type="text" class="form-control" id="name" placeholder="Name" required>
                                    <div class="help-block with-errors"></div>
                                </div>

                                <div class="form-group  col-md-6 mb-3">
                                    <input type="email" class="form-control" id="email" placeholder="Email Address" required>
                                    <div class="help-block with-errors"></div>
                                </div>

                                <div class="form-group col-md-6 mb-3">
                                    <input type="text" class="form-control" id="phone" placeholder="Contact Number" required>
                                    <div class="help-block with-errors"></div>
                                </div>

                                <div class="form-group  col-md-6 mb-3">
                                    <input type="text" class="form-control" id="subject" placeholder="Subject" required>
                                    <div class="help-block with-errors"></div>
                                </div>

                                <div class="form-group col-md-12 mb-3">
                                    <textarea class="form-control" id="msg" rows="4" placeholder="Message" required></textarea>
                                    <div class="help-block with-errors"></div>
                                </div>

                                <div class="col-md-12">
                                    <button type="submit" class="btn-default">Submit Now</button>
                                    <div id="msgSubmit" class="h3 text-left hidden"></div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <!-- Contact Form End -->
                </div>
            </div>
        </div>
    </div>
    <!-- Get In Touch Section End -->

    <!-- Google Map Start -->
   
    <!-- Google Map End -->
@endsection

@section('scripts')
    {{-- additional scripts here --}}
@endsection
