@extends('layouts.landing.master')
@section('title', 'INJAP - Innovation Japan | Benefit')

@section('stylesheets')
    {{-- additional style here --}}
@endsection

@section('content')
    <!-- Page Header Start -->
	<div class="page-header parallaxie servicr-hero">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<!-- Page Header Box start -->
					<div class="page-header-box">
						<h1 class="text-anime">Members Benefit</h1>
					
					</div>
					<!-- Page Header Box end -->
				</div>
			</div>
		</div>
	</div>
	<!-- Page Header End -->

    <!-- Blog Page Start -->
    <div class="blog-page">
        <div class="container"> 
            <div class="row">
                <!-- Post item Start -->
                <div class="col-lg-4 col-md-12">
                    <div class="post-item wow fadeInUp" data-wow-delay="0.25s">
                        <!-- Post Header start -->
                        <div class="post-header">
                            <!-- Feature Img start -->
                            <div class="feature-img">
                                <a href="{{ route('landing.contact')}}">
                                    <figure class="image-anime">
                                        <img src="{{ asset('new_landing/images/post-1.jpg')}}" alt="">
                                    </figure>
                                </a>
                            </div>
                            <!-- Feature Img end -->

                            <!-- Post Meta start -->
                            <div class="post-meta">
                                <ul>
                                    <li>Medical Reimbursement Support</li>
                                </ul>
                            </div>
                            <!-- Post Meta end -->
                        </div>
                        <!-- Post Feature Img end -->

                        <!-- Post Content start -->
                        <div class="post-content">
                            <div class="post-header">   
                                

                                <p>Member can request for reimbursement for medical support on
their own dashboard available social funds after become a
regular member.</p>
<br>
<br>
<br>
                                <a href="{{ route('landing.contact')}}" class="btn-read-more">Contact Us</a>
                            </div>
                        </div>
                        <!-- Post Content end -->
                    </div>
                </div>
                <!-- Post item End -->

                <!-- Post item Start -->
                <div class="col-lg-4 col-md-12">
                    <div class="post-item wow fadeInUp" data-wow-delay="0.50s">
                        <!-- Post Header start -->
                        <div class="post-header">
                            <!-- Feature Img start -->
                            <div class="feature-img">
                                <a href="{{ route('landing.contact')}}">
                                    <figure class="image-anime">
                                        <img src="{{ asset('new_landing/images/post-2.jpg')}}" alt="">
                                    </figure>
                                </a>
                            </div>
                            <!-- Feature Img end -->

                            <!-- Post Meta start -->
                            <div class="post-meta">
                                <ul>
                                    <li>Food Reimbursement Support</li>
                                </ul>
                            </div>
                            <!-- Post Meta end -->
                        </div>
                        <!-- Post Feature Img end -->

                        <!-- Post Content start -->
                        <div class="post-content">
                            <div class="post-header">   
                                

                                <p>Member can request for reimbursement for food support on
their own dashboard available social funds after become a
regular member.</p>
<br>
<br>
<br>
                                    <a href="{{ route('landing.contact')}}" class="btn-read-more">Contact Us</a>
                            </div>
                        </div>
                        <!-- Post Content end -->
                    </div>
                </div>
                <!-- Post item End -->

                <!-- Post item Start -->
                <div class="col-lg-4 col-md-12">
                    <div class="post-item wow fadeInUp" data-wow-delay="0.75s">
                        <!-- Post Header start -->
                        <div class="post-header">
                            <!-- Feature Img start -->
                            <div class="feature-img">
                                <a href="{{ route('landing.contact')}}">
                                    <figure class="image-anime">
                                        <img src="{{ asset('new_landing/images/post-3.jpg')}}" alt="">
                                    </figure>
                                </a>
                            </div>
                            <!-- Feature Img end -->

                            <!-- Post Meta start -->
                            <div class="post-meta">
                                <ul>
                                    <li>Member Death & Burial Assistance</li>    
                                </ul>
                            </div>
                            <!-- Post Meta end -->
                        </div>
                        <!-- Post Feature Img end -->

                        <!-- Post Content start -->
                        <div class="post-content">
                            <div class="post-header">   
                            

                                <p>After one (1) year of being regular member if anything happen to a
member the association charity department will contribute
amount agreed by the board of directors and the counsel of the
association.</p>

                                    <a href="{{ route('landing.contact')}}" class="btn-read-more">Contact Us</a>
                            </div>
                        </div>
                        <!-- Post Content end -->
                    </div>
                </div>
                <!-- Post item End -->

              
                <!-- Post item End -->

            </div>

          
        </div>
    </div>
    <!-- Blog Page End -->
@endsection

@section('scripts')
    {{-- additional scripts here --}}
@endsection
