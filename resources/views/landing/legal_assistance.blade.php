@extends('layouts.landing.master')
@section('title', 'INJAP - Innovation Japan | Legal Assistance')

@section('stylesheets')
    {{-- additional style here --}}
@endsection

@section('content')
     <!-- Subpage Section Start -->
    <div class="page-header parallaxie servicr-hero">
        <div class="container">
            <div class="row">
                <div class="co-md-12">
                    <!-- Sub page Header start -->
                    <div class="page-header-box">
                        <h1 class="text-anime">Legal Assistance</h1>
                      
                    </div>
                    <!-- Sub page Header end -->
                </div>
            </div>
        </div>
    </div>
    <!-- Subpage Section End -->

    <!-- Services Single Page Start -->
    <div class="services-single-page">
        <div class="container">
            <div class="row">
                <!-- Sidebar Section Start -->
                <div class="col-lg-4 col-md-12 order-lg-1 order-2">  
                    <div class="services-single-sidebar">
                        <div class="services-single-service wow fadeInUp" data-wow-delay="0.25s">
                            <h3>Our Services</h3>
                            <ul>
                                <li><img src="{{ asset('new_landing/images/icon-health-insurance-color.svg')}}" alt=""><a href="{{ route('landing.legal-assistance') }}">Legal Assistance</a></li>
                                   <li><img src="{{ asset('new_landing/images/icon-health-insurance-color.svg')}}" alt=""><a href="{{ route('landing.translation-service')}}">Translation Service</a></li>
                                                 <li><img src="{{ asset('new_landing/images/icon-health-insurance-color.svg')}}" alt=""><a href="{{ route('landing.financial-assistance')}}">Financial Assistance</a></li>
                           
                            </ul>
                        </div>

                        <div class="services-single-need-help wow fadeInUp" data-wow-delay="0.50s">
                            <div class="need-help-content">
                                <h2>Need Help?</h2>
                                <p>We're here to answer any questions you might have.</p>
                                <a href="{{ route('landing.contact')}}" class="btn-default">Contact Now</a>
                            </div>
                            <div class="need-help-contact-image">
                                <img src="{{ asset('new_landing/images/need-help-women-image.png')}}" alt="">
                            </div>
                        </div>

                        <div class="service-single-contact wow fadeInUp" data-wow-delay="0.65s">
                            <h3>Contact Info</h3>
                            <ul>
                                <li><img src="{{ asset('new_landing/images/icon-location-color.svg')}}" alt=""><a href="#" class="service-single-location">518-0225 Japan Mie-ken, Iga Shi, Kirigaoka 3Chome 212</a></li>
                                <li><img src="{{ asset('new_landing/images/icon-phone-color.svg')}}" alt=""><a href="tel:0595518190">0595518190</a></li>
                                <li><img src="{{ asset('new_landing/images/icon-mail-color.svg')}}" alt=""><a href="mailto:innovationjapan3@gmail.com">innovationjapan3@gmail.com</a></li>
                            </ul>
                        </div>
                    </div>  
                </div>
                <!-- Sidebar Section End -->

                <!-- Services Content Start -->
                <div class="col-lg-8 col-md-12 order-lg-2 order-1">
                    <div class="service-single-content">
                        <div class="service-single-img wow fadeInUp" data-wow-delay="0.25s">
                            <figure class="image-anime">
                                <img src="{{ asset('new_landing/images/services-single-content-img.jpg')}}" alt="">
                            </figure>
                        </div>

                        <div class="service-single-body">

                            <h3>Legal Assistance</h3>
                            <p>This Association offer its legal services to all members such as labor issues, immigration and visa processing and more.</p>

                        
                            
                            <p>Our services cover a wide range of needs, including labor-related issues, immigration matters, and visa processing. We aim to make every process easier and more transparent for our members.</p>

                            <p>With our dedicated legal team, we stand by our members to protect their rights, promote fairness, and help them achieve peace of mind in both work and daily life.</p>

                            
                        </div>

                        <!-- FAQs Section Start -->
                        <div class="service-single-faq wow fadeInUp" data-wow-delay="0.50s">
                            <!-- Section Title Start -->
                            <div class="section-title">
                                <h2 class="text-anime">Frequently Asked Questions</h2>
                            </div>
                            <!-- Section Title End -->
                            
                            <!-- FAQs Section Start -->
                            <div class="faq-accordion" id="accordion">
                                <!-- FAQ Item start -->
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingOne">
                                        <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                            What legal issues can members ask help for?
                                        </button>
                                    </h2>
                                    <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne"
                                        data-bs-parent="#accordion">
                                        <div class="accordion-body">
                                            <p>Members can request assistance for labor-related concerns, immigration matters, visa processing, and other personal or work-related legal issues covered by the association.</p>
                                        </div>
                                    </div>
                                </div>
                                <!-- FAQ Item end -->

                                <!-- FAQ Item start -->
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingTwo">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                          How can I request legal assistance?
                                        </button>
                                    </h2>
                                    <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo"
                                        data-bs-parent="#accordion">
                                        <div class="accordion-body">
                                            <p>Members can visit the association office. Our legal team will review the concern and provide guidance or support accordingly.</p>
                                        </div>
                                    </div>
                                </div>
                                <!-- FAQ Item end -->

                                <!-- FAQ Item start -->
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingThree">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                            Is there any fee for legal services?
                                        </button>
                                    </h2>
                                    <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree"
                                        data-bs-parent="#accordion">
                                        <div class="accordion-body">
                                            <p>Basic legal assistance is provided as part of your membership benefits. However, certain cases that require extensive legal representation may involve minimal processing fees.</p>
                                        </div>
                                    </div>
                                </div>
                                <!-- FAQ Item end -->
                            </div>
                        </div>
                        <!-- FAQs Section Ends -->
                    </div>
                </div>
                <!-- Services Content End -->
            </div>
        </div>
    </div>
    <!-- Services Single Page End -->
@endsection

@section('scripts')
    {{-- additional scripts here --}}
@endsection
