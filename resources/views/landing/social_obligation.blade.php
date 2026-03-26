@extends('layouts.landing.master')
@section('title', 'INJAP - Innovation Japan | Social Obligation')

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
                        <h1 class="text-anime">Social Obligation</h1>
                      
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
                            <h3>Membership Rules</h3>
                           <ul>
                                <li><img src="{{ asset('new_landing/images/icon-health-insurance-color.svg')}}" alt=""><a href="{{ route('landing.recruitment')}}">Invitation</a></li>
                                   <li><img src="{{ asset('new_landing/images/icon-health-insurance-color.svg')}}" alt=""><a href="{{ route('landing.social-obligation')}}">Social Obligation</a></li>
                           
                            </ul>
                        </div>

                        <div class="services-single-need-help wow fadeInUp" data-wow-delay="0.50s">
                            <div class="need-help-content">
                                <h2>Need Help?</h2>
                                <p>We're here to answer any questions you might have.</p>
                                <a href="contact.html" class="btn-default">Contact Now</a>
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
                                <img src="{{ asset('new_landing/images/social.jpg')}}" alt="">
                            </figure>
                        </div>

                        <div class="service-single-body">

                            <h3>Social Obligation</h3>
                            <p>Every member is compulsory to contribute through dashboard
deduction if any of the member will pass away.</p>

                        
                            
                            <p>This contribution serves as a shared act of compassion and solidarity among all members. By giving a small amount, each member helps provide financial assistance and comfort to the family of the departed, showing unity in times of loss.</p>

                            <p>Through this system, the association ensures that no member’s family faces hardship alone. It reflects our core values of care, support, and collective responsibility—where every contribution becomes a symbol of kindness and brotherhood.</p>

                            
                        </div>

                        <!-- FAQs Section Start -->
                       
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
