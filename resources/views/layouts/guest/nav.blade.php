<div class="header_bottom sticky-header" style="background-color:blueviolet">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-12">
                <div class="main_menu_inner">
                    <div class="main_menu menu_three">
                        <nav>
                            <ul>
                                {{-- <li><a href="{{ route('guest.welcome') }}">home</a></li> --}}
                                {{-- <li><a href="{{ route('guest.company') }}">company</a></li>

                                <li><a href="{{ route('guest.products') }}">products</a></li> --}}
                                <li><a href="#">testimonials</a></li>
                                <!--<li><a href="#">news and events</a></li>-->
                                {{-- <li><a href="{{ route('guest.contact') }}"> Contact Us</a></li> --}}
                                @guest
                                    <li><a href="#">account <i class="fa fa-angle-down"></i></a>
                                        <ul class="sub_menu pages">
                                            <li><a href="{{ route('login') }}">Login</a></li>
                                        </ul>
                                    </li>
                                @endguest
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="Offcanvas_menu canvas_defult">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="canvas_open">
                    <span>MENU</span>
                    <a href="javascript:void(0)"><i class="ion-navicon"></i></a>
                </div>
                <div class="Offcanvas_menu_wrapper Offcanvas_four">
                    <div class="canvas_close">
                        <a href="javascript:void(0)"><i class="ion-arrow-left-c"></i></a>
                    </div>
                    <div class="welcome_text">
                        <p>Hello dear visitor! Glad to see you in our store. Good luck with shopping</p>
                    </div>
                    <div class="canvas_search_container">
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
                    <div id="menu" class="text-left ">
                        <ul>
                            {{-- <li><a href="{{ route('guest.welcome') }}">home</a></li> --}}
                            {{-- <li><a href="{{ route('guest.company') }}">company</a></li>
                            <li><a href="{{ route('guest.products') }}">products</a></li> --}}
                            <li><a href="#">testimonials</a></li>
                            <li><a href="#">news and events</a></li>
                            @guest
                                <li><a href="#">account <i class="fa fa-angle-down"></i></a>
                                    <ul class="sub_menu pages">
                                        <li><a href="{{ route('login') }}">Login</a></li>

                                    </ul>
                                </li>
                            @endguest
                            {{-- <li><a href="{{ route('guest.contact') }}"> Contact Us</a></li> --}}
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
