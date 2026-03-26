@extends('layouts.landing.master')
@section('title', 'INJAP - Innovation Japan | Recruitment')

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
                        <h1 class="text-anime">Invitation</h1>
                      
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
                                <img src="{{ asset('new_landing/images/recruitment.jpg')}}" alt="">
                            </figure>
                        </div>

                        <div class="service-single-body">

                            <h3>Invitation</h3>
                            <p>Each member must invite atlest two (2) person minimum to be come regular member of the association. The purpose of invitation is to boost the population of the association to be able to give more benefits to the members</p>

                        
                            
                            <p>Invitations helps strengthen the foundation of the association by expanding our network of members who share the same vision of unity, growth, and compassion. As the community grows, we are able to build a stronger support system that benefits everyone.</p>

                            <p>Through collective effort and participation, every new member contributes to the association’s mission of improving lives, promoting cooperation, and creating lasting opportunities for all. Together, we can achieve greater impact and bring more meaningful assistance to our members and communities.</p>

                            
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
