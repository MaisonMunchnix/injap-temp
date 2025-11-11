<div class="preloader">
    <div class="whirlpool">
        <div class="ring ring1"></div>
        <div class="ring ring2"></div>
        <div class="ring ring3"></div>
        <div class="ring ring4"></div>
        <div class="ring ring5"></div>
        <div class="ring ring6"></div>
        <div class="ring ring7"></div>
        <div class="ring ring8"></div>
        <div class="ring ring9"></div>
    </div>
</div>
<header class="header-section">
    <div class="header-center p-3">
        <div class="container">
            <div class="row">
                <div class="col-xl-2 col-lg-2 col-md-2 col-sm-6 col-12 d-flex align-items-center sm-50 c-center">
                    <div class="logo">
                        <a href="#"> <img src="landing/images/2logo.png" alt="" /> </a>
                    </div>
                </div>
                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12 d-flex align-items-center c-center sm-hidden">
                    <div class="working-time">
                        <p><span class="blue-c">Opening Hours :</span>Monday To Saturday - 8AM TO 8PM</p>
                    </div>
                </div>
                <div
                    class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12 d-flex align-items-center justify-content-end c-center sm-hidden">
                    <div class="loca-map h-top-item">
                        <p><span class="fa fa-map-marker"></span> 82 Vibo Place, N. Escario Street, Cebu City </p>
                    </div>
                </div>
                <div
                    class="col-xl-2 col-lg-2 col-md-2 col-sm-6 col-12 d-flex align-items-center justify-content-end sm-50 c-center c-right">
                    <div class="login-btn"><a href="{{ route('member-login') }}"
                            class="btn btn-button btn-button-2 blue-bg">Member login</a></div>
                </div>
            </div>
        </div>
    </div>
    <div class="header-menu">
        <div class="container">
            <nav class="navbar navbar-expand-md btco-hover-menu">
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navmenu"
                    aria-controls="navmenu" aria-label="Toggle navigation"><span
                        class="navbar-toggler-icon"></span></button>
                <div class="collapse navbar-collapse" id="navmenu">
                    <ul class="navbar-nav">
                        <li><a class="dropdown-item" href="{{ route('landing.home') }}">Home</a></li>
                        <li><a class="dropdown-item" href="{{ route('landing.about') }}">About Us</a></li>
                        <li><a class="dropdown-item" href="{{ route('landing.products') }}">Our Products</a></li>
                        <li><a class="dropdown-item" href="{{ route('landing.news') }}">News and Articles</a></li>
                        <li><a class="dropdown-item" href="{{ route('landing.tutorial') }}">Tutorial</a></li>
                        <li><a class="dropdown-item" href="{{ route('landing.contact') }}">Contact Us</a></li>
                    </ul>
                </div>
            </nav>
            <div class="header-search pull-right">
                <form class="form-inline my-2 my-md-0">
                    <input class="form-control header-s-input" type="text" placeholder="Search" aria-label="Search"
                        style="display: none;" />
                    <div class="search-h-icon">
                        <button type="button" class="btn btn-button black-c"><i class="icofont">search_2</i></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</header>
