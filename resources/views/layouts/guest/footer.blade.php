<div class="messages_info messages_four">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="messages_desc">
                    <p>We're a registered company engaged in distribution and direct selling of quality "<span>PURPLE
                            LIFE ORGANIC PRODUCTS</span>"</p>
                </div>
            </div>
        </div>
    </div>
</div>
<!--footer area start-->
<footer class="footer_widgets footer_four">
    <div class="container">
        <div class="footer_top">
            <div class="row">
                <div class="col-lg-4 col-md-6">
                    <div class="widgets_container contact_us">
                        <div class="footer_logo">
                            <a href="#"><img src="{{ asset('assets/img/logo/logo.png') }}" alt=""></a>
                        </div>
                        <div class="footer_contact">
                            <p>We're a registered company engaged in distribution and direct selling of quality</p>
                            <p><span>Add:</span> Unit 318-9 3rd Flr. Spark Place, P. Tuazon Blvd., Brgy. Socorro, Cubao,
                                Quezon City, Philippines</p>

                            <ul>
                                <li class="twitter"><a href="#"><i class="fa fa-twitter"></i></a></li>
                                <li class="facebook"><a href="https://www.facebook.com/purplelifeorg"><i
                                            class="fa fa-facebook"></i></a></li>
                                <li class="googleplus"><a href="#"><i class="ion-social-googleplus"></i></a></li>
                                <li class="behance"><a href="#"><i class="fa fa-behance"></i></a></li>
                                <li class="pinterest"><a href="#"><i class="fa fa-pinterest"></i></a></li>
                                <li class="youtube"><a href="#"><i class="ion-social-youtube"></i></a></li>
                            </ul>

                        </div>
                    </div>
                </div>
                <div class="col-lg-2 col-md-6">
                    <div class="widgets_container widget_menu">
                        <h3>Information</h3>
                        <div class="footer_menu">
                            <ul>
                                {{-- <li><a href="{{ route('guest.company') }}">About Us</a></li> --}}
                                <li><a href="#">Delivery Information</a></li>
                                <li><a href="#">Privacy Policy</a></li>
                                <li><a href="#">Terms & Conditions</a></li>

                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2 col-md-4">
                    <div class="widgets_container widget_menu">
                        <h3>My Account</h3>
                        <div class="footer_menu">
                            <ul>
                                <li><a href="#">My Account</a></li>
                                <li><a href="#">Order History</a></li>
                                <li><a href="#">Affiliate</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2 col-md-4">
                    <div class="widgets_container widget_menu">
                        <h3>Products</h3>
                        <div class="footer_menu">
                            <ul>
                                <?php $count = 0; ?>
                                @foreach (\App\Product::where('status', 1)->get() as $product)
                                    <?php if ($count == 10) {
                                        break;
                                    } ?>


                                    <li><a href="{{-- {{ route('guest.products.view', $product->id) }} --}}">{{ $product->name }}</a>
                                    </li>
                                    <?php $count++; ?>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="col-lg-2 col-md-4">
                    <div class="widgets_container widget_menu">

                        <div class="footer_menu">
                            <ul>

                                @foreach (\App\Product::where('status', 1)->get() as $pangputol => $product)
                                    @if ($pangputol > 11)
                                        <li><a href="{{-- {{ route('guest.products.view', $product->id) }} --}}">{{ $product->name }}</a>
                                        </li>
                                    @endif
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>

            </div>
        </div>


    </div>
    <div class="footer_bottom">
        <div class="container" style="text-align: center">
            <div class="row">
                <div class="col-lg-12 col-md-12">
                    <div class="copyright_area ">
                        <p>Copyright &copy; 2020 <a href="#">PURPLE LIFE ORGANIC PRODUCTS</a> All Right Reserved.
                        </p>
                    </div>
                </div>
                {{--  <div class="col-lg-6 col-md-12">
                    <div class="footer_paypal">
                        <ul>
                            <li><a href="#"><img src="{{ asset('assets/img/icon/paypal.jpg') }}" alt=""></a></li>
                            <li><a href="#"><img src="{{ asset('assets/img/icon/paypal1.jpg') }}" alt=""></a></li>
                            <li><a href="#"><img src="{{ asset('assets/img/icon/paypal2.jpg') }}" alt=""></a></li>
                            <li><a href="#"><img src="{{ asset('assets/img/icon/paypal3.jpg') }}" alt=""></a></li>
                            <li><a href="#"><img src="{{ asset('assets/img/icon/paypal4.jpg') }}" alt=""></a></li>
                            <li><a href="#"><img src="{{ asset('assets/img/icon/paypal5.jpg') }}" alt=""></a></li>
                        </ul>
                    </div>
                </div> --}}
            </div>
        </div>
    </div>

</footer>
<!--footer area end-->
