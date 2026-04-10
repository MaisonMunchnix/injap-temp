<!-- Preloader Start -->
	<div class="preloader">
		<div class="loading-container">
			<div class="loading"></div>
			<div id="loading-icon"><img src="{{ asset('new_landing/images/logs.png')}}" alt=""></div>
		</div>
	</div>
	<!-- Preloader End -->

	<!-- Magic Cursor Start -->
	<div id="magic-cursor">
		<div id="ball"></div>
	</div>
	<!-- Magic Cursor End -->

    <!-- Topbar Section Start -->    
    <div class="header-link-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <!-- Topbar Contact Info Start -->
                    <div class="header-contact-info">
                        <ul>
                            <li><i class=""></i><span style="font-size: 11px;">Japan Ministry of Justice Registration <br>1900-05-012089</span></a></li>
                            <li><a href="mailto:innovationjapan3@gmail.com"><i class="fa-solid fa-envelope"></i>innovationjapan3@gmail.com</a></li>
                        </ul>
                    </div>
                    <!-- Topbar Contact Info End -->
                </div>
                <div class="col-md-6">
                    <!-- Header Social Links Start -->
                    <div class="header-social-link">
                        <ul>
                            <li><a href="#"><i class="fa-brands fa-facebook-f"></i></a></li>
                            <li><a href="#"><i class="fa-brands fa-twitter"></i></a></li>
                            <li><a href="#"><i class="fa-brands fa-linkedin-in"></i></a></li>
                            <li><a href="#"><i class="fa-brands fa-instagram"></i></a></li>
                        </ul>
                    </div>
                    <!-- Header Social Links End -->
                </div>
            </div>
        </div>
    </div>
    <!-- Topbar Section End -->

    <!-- Header Start -->
	<header class="main-header" id="hero-section">
		<div class="header-sticky">
			<nav class="navbar navbar-expand-lg">
				<div class="container">
					<!-- Logo Start -->
					<a class="navbar-brand" href="{{ route('landing.home') }}">
						<img src="{{ asset('new_landing/images/logs.png')}}" alt="Logo" height="100px">
					</a>
					<!-- Logo End -->
	
					<!-- Main Menu start -->
					<div class="collapse navbar-collapse main-menu">
						<ul class="navbar-nav mr-auto" id="menu">
		


                               <li class="nav-item has-submenu"><a class="nav-link" href="#">Services</a>
								<ul class="submenu">									
                                    <li class="nav-item"><a class="nav-link" href="{{ route('landing.legal-assistance') }}">Legal Assistance</a></li>
									<li class="nav-item"><a class="nav-link" href="{{ route('landing.translation-service')}}">Translation Service</a></li>

                                    <li class="nav-item"><a class="nav-link" href="{{ route('landing.financial-assistance')}}">Financial Assistance</a></li>
								
								</ul>
							</li>


                          
   <li class="nav-item"><a class="nav-link" href="{{ route('landing.benefit')}}">Members Benefit</a></li>
   <li class="nav-item"><a class="nav-link" href="{{ route('landing.education')}}">Education</a></li>

                             

                             <li class="nav-item has-submenu"><a class="nav-link" href="#">Membership Rules</a>
								<ul class="submenu">									
                                    <li class="nav-item"><a class="nav-link" href="{{ route('landing.recruitment')}}">Invitation</a></li>
									<li class="nav-item"><a class="nav-link" href="{{ route('landing.social-obligation')}}">Social Obligation</a></li>
             
								
								
								</ul>
							</li>



							<li class="nav-item"><a class="nav-link" href="{{ route('landing.application')}}">Application Form</a></li>

	<li class="nav-item"><a class="nav-link" href="{{ route('login') }}">Login</a></li>
							
                            


							
							<li class="nav-item highlighted-menu"><a class="nav-link" href="{{ route('landing.contact') }}">Contact Us</a></li>
						</ul>
					</div>
					<!-- Main Menu End -->
	
					<div class="navbar-toggle"></div>
				</div>
			</nav>
			<div class="responsive-menu"></div>
		</div>
	</header>
	<!-- Header End -->