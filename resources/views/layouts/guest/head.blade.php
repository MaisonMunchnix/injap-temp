<!--header area start-->
<header class="header_area header_four">
    <!--header top start-->
    <div class="header_top" style="background-color:blueviolet">
        <div class="container">
            <div class="row align-items-center">

                <div class="col-lg-6 col-md-12">
                    <div class="welcome_text">
                        <p>Hello dear visitor! Glad to see you in our store. Good luck with shopping</p>
                    </div>
                </div>
                @auth
                    <div class="col-lg-6 col-md-12">
                        <div class="top_right text-right">
                            <ul>
                                <li class="top_links"><a href="#">{{ Auth::user()->info->first_name }}
                                        {{ Auth::user()->info->last_name }} <i class="ion-chevron-down"></i></a>
                                    <ul class="dropdown_links">
                                        <li><a href="{{ route('home') }}">My Account </a></li>
                                        {{-- <li><a href="{{ route('guest.checkout') }}">Checkout</a></li> --}}
                                        {{-- <li><a href="{{ route('guest.cart') }}">Shopping Cart</a></li> --}}
                                        @auth
                                            <li><a href="{{ url('/logout') }}">Logout</a></li>
                                        @endauth
                                    </ul>
                                </li>
                            </ul>
                        </div>
                    </div>
                @endauth
            </div>
        </div>
    </div>
    <!--header top start-->

    <!--header middel start-->
    <div class="header_middle middle_four" style="background-color:#c89df1">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-3 col-md-12">
                    <div class="logo">
                        <a href="index.php"><img src="{{ asset('assets/img/logo/logo.png') }}" alt=""></a>
                    </div>
                </div>
                <div class="col-lg-9 col-md-12">
                    <div class="middel_right">
                        <div class="search-container search_four">
                            <form action="#">
                                <div class="hover_category">
                                    <select class="select_option" name="category">
                                        <option selected value="">All Categories</option>
                                        @foreach (\App\ProductCategory::all() as $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="search_box">
                                    <input placeholder="Search" type="text" name="search">
                                    <button type="submit">Search</button>
                                </div>
                            </form>
                        </div>
                        <div class="middel_right_info">
                            @include('layouts.guest.mini-cart')
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--header middel end-->

    @include('layouts.guest.nav')
</header>
<!--header area end-->
