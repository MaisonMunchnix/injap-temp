@extends('layouts.landing.master')
@section('title', 'INJAP - Innovation Japan | Home')
@section('page-title', 'INJAP - Innovation Japan | Home')

@section('stylesheets')
    {{-- additional style here --}}
@endsection

@section('content')
 <!-- Hero Section Start -->
    <div class="hero parallaxie">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-8">
                    <!-- Section Title start -->
                    <div class="section-title">
                        <h3 class="wow fadeInUp" data-wow-delay="0.25s">Let us help each other in times of disaster and hardship</h3>
                        <h1 class="text-anime">Innovation Japan call for unity</h1>
                    </div>
                    <!-- Section Title end -->

                    <!-- Hero Body start -->
                    <div class="hero-body">
                        <p class="wow fadeInUp" data-wow-delay="0.50s">Empowering every member to uplift one another through creativity, compassion, and shared purpose. Together, we rise—spreading hope, unity, and opportunity for a better, abundant life.</p>
                        <a href="{{ route('landing.application') }}" class="btn-default hero-btn wow fadeInUp" data-wow-delay="0.75s">Get Started</a>
                    </div>
                    <!-- Hero Body end -->
                </div>
            </div>
        </div>
    </div>
    <!-- Hero Section End -->

    <!-- Home Inforamtion Section Starts -->
    <div class="home-info-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-6 col-12">
                    <!-- Information Box Item start -->
                    <div class="info-box wow fadeInUp" data-wow-delay="0.50s">
                        <div class="box-icon">
                            <img src="{{ asset('new_landing/images/icon-peace-of-mind.svg')}}" alt="">
                        </div>
                        <div class="box-body">
                            <h3>Vision</h3>  
                            <p>To be the most creative organization in terms of economic in the Country</p>
                            
                        </div>
                    </div>
                    <!-- Information Box Item end -->
                </div>

                <div class="col-lg-4 col-md-6 col-12">
                    <!-- Information Box Item start -->
                    <div class="info-box wow fadeInUp" data-wow-delay="0.75s">
                        <div class="box-icon">
                           <img src="{{ asset('new_landing/images/icon-peace-of-mind.svg')}}" alt="">
                        </div>
                        <div class="box-body">
                            <h3>Mission</h3>
                            <p>To bring joy, peace and unity to every member</p>
                           
                        </div>
                    </div>
                    <!-- Information Box Item end -->
                </div>

                <div class="col-lg-4 col-md-6 col-12">
                    <!-- Information Box Item start -->
                    <div class="info-box wow fadeInUp" data-wow-delay="1.0s">
                        <div class="box-icon">
                           <img src="{{ asset('new_landing/images/icon-peace-of-mind.svg')}}" alt="">
                        </div>
                        <div class="box-body">
                            <h3>Goals</h3>
                            <p>To Transform Human Lives from poverty to abundant life</p>
                        </div>
                    </div>
                    <!-- Information Box Item end -->
                </div>                
            </div>
        </div>
    </div>
    <!-- Home Inforamtion Section End -->
        <!-- Currency Exchange Rates Section Start -->


<div class="about-section">
        <div class="container">
            <div class="row align-items-center">
                

                <div class="col-lg-6 col-md-12 order-lg-2 order-2">
                    <div class="about-content">
                        <!-- Section Title start -->
                        <div class="section-title">
                        
                            <h2 class="text-anime">Standing Together in Natural Calamities</h2>
                        </div>
                        <!-- Section Title end -->

                        <div class="about-body">
                            <p class="wow fadeInUp" data-wow-delay="0.50s">Natural calamities test not only our strength but also our unity as people. In these moments of crisis, compassion and cooperation become the foundation of recovery. At Innovation Japan, we believe that helping one another during disasters is a powerful form of innovation—one that brings hope, peace, and healing to affected communities.</p>
                       
                       <p>Guided by our mission to create a united future, we stand alongside those facing hardship, empowering communities to rebuild with resilience and purpose. Through shared creativity and support, we help transform loss into opportunity, ensuring that no one stands alone on the path toward recovery and a better tomorrow.</p>
                       
                        </div>  

                        <!-- About Icon Box start -->
                       
                        <!-- About Icon Box end -->

                        
                    </div>
                </div>
              
              <div class="col-lg-6 col-md-12 order-lg-1 order-1">
                    <!-- About video start -->
					<div class="ratio ratio-16x9">
            <iframe 
                src="https://www.youtube.com/embed/pLATFqeNsks"
                    
                    
                title="Natural Calamity"
                frameborder="0"
                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                referrerpolicy="strict-origin-when-cross-origin"
                allowfullscreen>
            </iframe>
        </div>
					<!-- About video end -->
                </div>
              
              
            </div>
        </div>
    </div>



    <div class="currency-rates-section">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <!-- Section Title start -->
                  
                  
                    <div class="section-title text-center">
                      
         
                      
                      
                        <h3 class="wow fadeInUp" data-wow-delay="0.25s">Exchange Rates</h3>
                        <h2 class="text-anime" style="color:black;">Current Currency Exchange Rates</h2>
                    </div>
                    <!-- Section Title end -->
                </div>
            </div>

            <div class="row mt-5">
                <div class="col-md-4">
                    <div class="card shadow-none border mb-0 wow fadeInUp" data-wow-delay="0.50s">
                        <div class="card-header">
                            <h5>YEN</h5>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('admin.currency-update') }}" method="post">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">Exchange Rate</label>
                                            <input type="hidden" name="currency" value="yen" disabled>
                                            <input type="number" name='buy' step="0.01" class="form-control"
                                                placeholder="Buy" value="{{ $yen->buy ?? null }}" disabled>
                                        </div>
                                    </div>
                                    <!-- <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">Sell</label>
                                            <input type="number" name='sell' step="0.01" class="form-control"
                                                placeholder="Sell" value="{{ $yen->sell ?? null }}" required>
                                        </div>
                                    </div> -->
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card shadow-none border mb-0 wow fadeInUp" data-wow-delay="0.75s">
                        <div class="card-header">
                            <h5>HKD</h5>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('admin.currency-update') }}" method="post">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">Exchange Rate</label>
                                            <input type="hidden" name="currency" value="hkd" disabled>
                                            <input type="number" name='buy' step="0.01"
                                                class="form-control" placeholder="Buy"
                                                value="{{ $hkd->buy ?? null }}" disabled>
                                        </div>
                                    </div>
                                    <!-- <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">Sell</label>
                                            <input type="number" name='sell' step="0.01"
                                                class="form-control" placeholder="Sell"
                                                value="{{ $hkd->sell ?? null }}" required>
                                        </div>
                                    </div> -->
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card shadow-none border mb-0 wow fadeInUp" data-wow-delay="1.0s">
                        <div class="card-header">
                            <h5>USD</h5>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('admin.currency-update') }}" method="post">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">Exchange Rate</label>
                                            <input type="hidden" name="currency" value="usd" disabled>
                                            <input type="number" name='buy' step="0.01"
                                                class="form-control" placeholder="Buy"
                                                value="{{ $usd->buy ?? null }}" disabled>
                                        </div>
                                    </div>
                                    <!-- <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">Sell</label>
                                            <input type="number" name='sell' step="0.01"
                                                class="form-control" placeholder="Sell"
                                                value="{{ $usd->sell ?? null }}" required>
                                        </div>
                                    </div> -->
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Currency Exchange Rates Section End -->

    <!-- About Section Start -->
    <div class="about-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 col-md-12 order-lg-1 order-2">
                    <!-- About video start -->
					<div class="about-video wow fadeInLeft" data-wow-delay="0.25s">
                        <figure class="image-anime">
                            <img src="{{ asset('new_landing/images/video-placeholder.jpg')}}" alt="">
                        </figure>
					</div>
					<!-- About video end -->
                </div>

                <div class="col-lg-6 col-md-12 order-lg-2 order-1">
                    <div class="about-content">
                        <!-- Section Title start -->
                        <div class="section-title">
                            <h3 class="wow fadeInUp" data-wow-delay="0.25s">Innovation Japan</h3>
                            <h2 class="text-anime">Innovating for a United Future</h2>
                        </div>
                        <!-- Section Title end -->

                        <div class="about-body">
                            <p class="wow fadeInUp" data-wow-delay="0.50s">Innovation Japan is an organization dedicated to fostering unity, creativity, and progress among individuals and communities. Guided by our mission to bring joy, peace, and harmony to every member, we believe that true innovation begins with compassion and cooperation.</p>
                       
                       <p>Our goal is to transform lives—helping people rise from poverty to abundance through shared purpose, creativity, and support for one another. In times of disaster and hardship, we stand together, empowering communities to rebuild with hope, resilience, and a vision for a better tomorrow.</p>
                       
                        </div>  

                        <!-- About Icon Box start -->
                       
                        <!-- About Icon Box end -->

                        <div class="about-btn">
                            <a href="{{ route('landing.application') }}" class="btn-default wow fadeInUp" data-wow-delay="1.25s">Be A Member</a>
                          
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- About Section End -->

    <!-- Our Services Start -->
    <div class="our-service">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <!-- Section Title start -->
                    <div class="section-title text-center">
                        <h3 class="wow fadeInUp" data-wow-delay="0.25s">PURPOSES</h3>
                        <h2 class="text-anime">Empowering Members Through Training and Growth</h2>
                    </div>
                    <!-- Section Title end -->
                </div>
            </div>

            <div class="row">
                <!-- Services Step Box Start -->
                <div class="col-lg-4 col-md-12">
                    <div class="step-box wow fadeInUp" data-wow-delay="0.50s">
                        <!-- Step Box Img start -->
                        <div class="step-img">
                            <figure class="image-anime">
                                <br>
                                <br>
                                <br>
                                <br>
                            </figure>
                        </div>
                        <!-- Step Box Img end -->

                        <!-- Step Box Body start -->
                        <div class="step-body">
                            <!-- Step Icon start -->
                            <div class="step-icon">
                                <img src="{{ asset('new_landing/images/icon-services-1.svg')}}" alt="">
                            </div>
                            <!-- Step Icon end -->

                            <h3>Purpose No. 1</h3>
                            <p>To conduct work good manner and right conduct training and
business strategy seminars to all members so that each member
will have a peaceful, competitive, and prosperous life style and
to be more participants in boosting country economy by paying
individual taxes to government.</p>
                           
                        </div>
                        <!-- Step Box Body end -->
                    </div>
                </div>
                <!-- Services Step Box End -->

                <!-- Services Step Box Start -->
                <div class="col-lg-4 col-md-12">
                    <div class="step-box wow fadeInUp" data-wow-delay="0.50s">
                        <!-- Step Box Img start -->
                        <div class="step-img">
                            <figure class="image-anime">
                                <br>
                                <br>
                                <br>
                                <br>
                            </figure>
                        </div>
                        <!-- Step Box Img end -->

                        <!-- Step Box Body start -->
                        <div class="step-body">
                            <!-- Step Icon start -->
                            <div class="step-icon">
                                <img src="{{ asset('new_landing/images/icon-services-1.svg')}}" alt="">
                            </div>
                            <!-- Step Icon end -->

                            <h3>Purpose No. 2</h3>
                            <p>To assist all members to be more familiar of Japanese Laws and
customs to be able to become more efficient to work with
Japanese people and to become more productive in all aspect of
life.</p>
                            <br>
                             <br>
                             <br>
                        </div>
                        <!-- Step Box Body end -->
                    </div>
                </div>
                <!-- Services Step Box End -->

                <!-- Services Step Box Start -->
                <div class="col-lg-4 col-md-12">
                    <div class="step-box wow fadeInUp" data-wow-delay="0.50s">
                        <!-- Step Box Img start -->
                        <div class="step-img">
                            <figure class="image-anime">
                                <br>
                                <br>
                                <br>
                                <br>
                            </figure>
                        </div>
                        <!-- Step Box Img end -->

                        <!-- Step Box Body start -->
                        <div class="step-body">
                            <!-- Step Icon start -->
                            <div class="step-icon">
                                <img src="{{ asset('new_landing/images/icon-services-1.svg')}}" alt="">
                            </div>
                            <!-- Step Icon end -->

                            <h3>Purpose No. 3</h3>
                            <p>To conduct project and or livelihood program to be able to assist the day to day lives of in need member.</p>
                            <br>
                            <br>
                           <br>
                            <br>
                             <br>
                             <br>
                             <br>
                        </div>
                        <!-- Step Box Body end -->
                    </div>
                </div>

              <hr>

                <div class="col-lg-6 col-md-12">
                    <div class="step-box wow fadeInUp" data-wow-delay="0.50s">
                        <!-- Step Box Img start -->
                        <div class="step-img">
                            <figure class="image-anime">
                                <br>
                                <br>
                                <br>
                                <br>
                            </figure>
                        </div>
                        <!-- Step Box Img end -->

                        <!-- Step Box Body start -->
                        <div class="step-body">
                            <!-- Step Icon start -->
                            <div class="step-icon">
                                <img src="{{ asset('new_landing/images/icon-services-1.svg')}}" alt="">
                            </div>
                            <!-- Step Icon end -->

                            <h3>Purpose No. 4</h3>
                            <p>To assist the community or government in the time of calamity and disaster.</p>
                           
                        </div>
                        <!-- Step Box Body end -->
                    </div>
                </div>

                <div class="col-lg-6 col-md-12">
                    <div class="step-box wow fadeInUp" data-wow-delay="0.50s">
                        <!-- Step Box Img start -->
                        <div class="step-img">
                            <figure class="image-anime">
                                <br>
                                <br>
                                <br>
                                <br>
                            </figure>
                        </div>
                        <!-- Step Box Img end -->

                        <!-- Step Box Body start -->
                        <div class="step-body">
                            <!-- Step Icon start -->
                            <div class="step-icon">
                                <img src="{{ asset('new_landing/images/icon-services-1.svg')}}" alt="">
                            </div>
                            <!-- Step Icon end -->

                            <h3>Purpose No. 5</h3>
                            <p>To build a Business, Music and English training center for kids, youth and to any interested resident of Japan.</p>
                           
                        </div>
                        <!-- Step Box Body end -->
                    </div>
                </div>
                <!-- Services Step Box End -->
            </div>

           
        </div>
    </div>
    <!-- Our Services End -->

    <!-- Get Consultations Start -->
    <div class="get-consulations">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 col-md-12">
                    <!-- Consulations Image start -->
                    <div class="consulations-img text-lg-start text-center wow fadeInUp" data-wow-delay="0.50s">
                        <img src="{{ asset('new_landing/images/get-consulations.png')}}" alt="">
                    </div>
                    <!-- Consulations Image end -->
                </div>

                <div class="col-lg-6 col-md-12">
                    <div class="consulations-content">
                        <!-- Section Title start -->
                        <div class="section-title">
                            <h3 class="wow fadeInUp" data-wow-delay="0.25s">Our Services</h3>
                            <h2 class="text-anime">Supporting Members, Empowering Lives</h2>
                        </div>
                        <!-- Section Title end -->

                        <!-- Consulations Body start -->
                        <div class="consulations-body">
                            <p class="wow fadeInUp" data-wow-delay="0.50s">Offering trusted legal and translation services to help our members thrive in work, life, and community. Through unity and service, we contribute to a stronger, more prosperous nation.</p>
                        </div>
                        <!-- Consulations Body end -->

                        <!-- List Icon start -->
                        <div class="list-icon wow fadeInUp" data-wow-delay="0.75s">
                            <ul>
                                <li><span>01.</span> Legal Assistance</li>
                                <li><span>02.</span> Translation Service</li>
                                 <li><span>03.</span> Financial Assistance</li>
                            </ul>
                        </div>
                        <!-- List Icon end -->

                        <a href="{{ route('landing.contact') }}" class="btn-default wow fadeInUp" data-wow-delay="1.0s">Contact Us Now</a>

                    </div>
                </div>
            </div>
        </div>
    </div>


    
    <!-- Get Consultations Section End -->

    <!-- Counter Section Start -->
 
    <!-- Counter Section End -->

    <!-- Our Team Section Start -->
    
    <!-- Our Team Section End -->

    <!-- Why Choose Us Section Start -->
    <div class="why-choose-us parallaxie">
        <div class="container">
            <div class="row">
                <div class="col-lg-5 col-12">
                    <!-- Why Choose Image start -->
                    <div class="why-choose-img">
                        <figure  class="reveal image-anime">
                            <img src="{{ asset('new_landing/images/why-choose-us-img.jpg')}}" alt="">
                        </figure>
                    </div>
                    <!-- Why Choose Image end -->
                </div>

                <div class="col-lg-7 col-12">
                    <!-- Section Title start -->
                    <div class="section-title">
                        <h3 class="wow fadeInUp" data-wow-delay="0.25s">Members Benefit</h3>
                        <h2 class="text-anime">Providing Assistance When Members Need It Most</h2>
                    </div>
                    <!-- Section Title end -->

                    <!-- Why Choose Body start -->
                    <div class="why-choose-body">
                        <p class="wow fadeInUp" data-wow-delay="0.50s">Through our medical, food, and burial assistance programs, we stand beside our membershelping them live with dignity, security, and peace of mind.</p>
                        
                        <ul class="why-choose-list wow fadeInUp" data-wow-delay="0.75s">
                            <li>Medical Reimbursement Support</li>
                            <li>Food Reimbursement Support</li>
                            <li>Member Death & Burial Assistance</li>
      
                        </ul>

                        <!-- Support Team Section start -->
                        <div class="support-team-section wow fadeInUp" data-wow-delay="1.0s">
                            <!-- Video Section start -->
                            <div class="video-section">
                                <div class="video-section-img">
                                    <figure class="image-anime">
                                        <img src="{{ asset('new_landing/images/why-choose-us-video-img.jpg')}}" alt="">
                                    </figure>   
                                </div>
                               
                            </div>
                            <!-- Video Section end -->

                            <!-- Support Team Body start -->
                            <div class="support-team-body">
                                <img src="{{ asset('new_landing/images/icon-support-team.svg')}}" alt="">
                                <h3>Contact Us</h3>

                                <ul class="support-team-contact">
                                    <li><a href="tel:1900-05-012089" class="contact-btn">Japan Ministry of Justice Registration #1900-05-012089</a></li>
                                   
                                </ul>
                            </div>
                            <!-- Support Team Body end -->
                        </div>

                        <br>
                        <br>
                        <br>
                        <br>
                         <br>
                        <!-- Support Team Section end -->
                    </div>
                </div>
                <!-- Why Choose Body end -->
            </div>
        </div>
    </div>

    <br>
        <br>
            <br>
                <br>
                    <br>
                        <br>
                            <br>
                                <br>
                                    <br>
                                     <br>
                                     <br>

                   
    <!-- Why Choose Us Section End -->

    <!-- Testimonials Start -->
   
    <!-- Testimonials End -->
   <div class="our-articles">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <!-- Section Title Start -->
                    <div class="section-title text-center">
                        <h3 class="wow fadeInUp" data-wow-delay="0.25s">Membership Rules</h3>
                        <h2 class="text-anime">Member Duties and Social Obligations</h2>
                    </div>
                    <!-- Section Title End -->                    
                </div>
            </div>

            <div class="row">
                <!-- Post item Start -->
                <div class="col-lg-6 col-md-12">
                    <div class="post-item wow fadeInUp" data-wow-delay="0.50s">
                        <!-- Post Header start -->
                        <div class="post-header">
                            <!-- Feature Img start -->
                            <div class="feature-img">
                                <a href="{{ route('landing.recruitment') }}">
                                    <figure class="image-anime">
                                        <img src="{{ asset('new_landing/images/recruitment.jpg')}}" alt="">
                                    </figure>
                                </a>
                            </div>
                            <!-- Feature Img end -->

                            <!-- Post Meta start -->
                            <div class="post-meta">
                                <ul>
                                    <li>Invitation</li>
                                </ul>
                            </div>
                            <!-- Post Meta end -->
                        </div>
                        <!-- Post Feature Img end -->

                        <!-- Post Content start -->
                        <div class="post-content">
                            <div class="post-header">   
                          

                                <p>Each member must invite atlest two (2) person minimum to be come regular member of the association. The purpose of invitation is to boost the population of the association to be able to give more benefits to the members</p>

                        
                            </div>
                        </div>
                        <!-- Post Content end -->
                    </div>
                </div>
                <!-- Post item End -->

                <!-- Post item Start -->
                <div class="col-lg-6 col-md-12">
                    <div class="post-item wow fadeInUp" data-wow-delay="0.75s">
                        <!-- Post Header start -->
                        <div class="post-header">
                            <!-- Feature Img start -->
                            <div class="feature-img">
                                <a href="{{ route('landing.social-obligation') }}">
                                    <figure class="image-anime">
                                        <img src="{{ asset('new_landing/images/social.jpg')}}" alt="">
                                    </figure>
                                </a>
                            </div>
                            <!-- Feature Img end -->

                            <!-- Post Meta start -->
                            <div class="post-meta">
                                <ul>
                                    <li>Social Obligation</li>
                                </ul>
                            </div>
                            <!-- Post Meta end -->
                        </div>
                        <!-- Post Feature Img end -->

                        <!-- Post Content start -->
                        <div class="post-content">
                            <div class="post-header">   
                 

                                <p>Every member is compulsory to contribute through dashboard deduction if any of the member will pass away.</p>
                                <br>
                                <br>
<br>
                             
                            </div>
                        </div>
                        <!-- Post Content end -->
                    </div>
                </div>
                <!-- Post item End -->

                <!-- Post item Start -->
                
                <!-- Post item End -->
            </div>
        </div>
    </div>
    <!-- Our Articles Start -->
   
    <!-- Our Articles End -->
@endsection

@section('scripts')
    {{-- additional scripts here --}}
@endsection
