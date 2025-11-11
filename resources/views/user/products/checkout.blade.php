@extends('layouts.default.master')
@section('title', 'Cart')
@section('page-title', 'Cart')

@section('stylesheets')
    {{-- additional style here --}}
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        .border-red {
            border: 1px solid red !important;
        }

        .select2-selection {
            height: 35px !important;
        }

        .card .bg-info-gradient {
            min-height: 146px !important;
        }

        @media only screen and (max-width: 767px) {
            .input-group {
                margin-bottom: 20px;
            }
        }
    </style>
@endsection

@section('content')
    <div class="content-body">
        <div class="row mt-5">
            <div class="col-md-10 offset-md-1">
                <div class="card mt-5">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-6 col-md-6">
                                <h3>Billing Details</h3>
                                <form action="{{ route('products.cart.payment') }}" method="POST">
                                    @csrf
                                    <div class="row">
                                        <div class="col-lg-4 mb-20">
                                            <label>First Name</label>
                                            <p>{{ Auth::user()->info->first_name }}</p>
                                        </div>
                                        <div class="col-lg-4 mb-20">
                                            <label>Middle Name</label>
                                            <p>{{ Auth::user()->info->middle_name }}</p>
                                        </div>
                                        <div class="col-lg-4 mb-20">
                                            <label>Last Name</label>
                                            <p>{{ Auth::user()->info->last_name }}</p>
                                        </div>
                                        <div class="col-lg-6 mb-20">
                                            <label>Email Address</label>
                                            <p>{{ Auth::user()->email }}</p>
                                        </div>
                                        <div class="col-lg-6 mb-20">
                                            <label>Mobile Number</label>
                                            <p>{{ Auth::user()->info->mobile_no }}</p>
                                        </div>
                                        <div class="col-12 mb-20">
                                            <label>Street address</label>
                                            <p>{{ Auth::user()->info->address }}</p>
                                        </div>
                                        <div class="col-6 mb-20">
                                            <label for="city">Town/City <span>*</span></label>
                                            <p>{{ Auth::user()->info->city->citymunDesc ?? 'N/A' }}</p>
                                        </div>
                                        <div class="col-6 mb-20">
                                            <label for="country">Province</label>
                                            <p>{{ Auth::user()->info->province->provDesc ?? 'N/A' }}</p>
                                        </div>
                                        <div class="col-12 mb-20">
                                            <input id="address" type="checkbox" data-target="createp_account"
                                                name="ship_to_another_address" value="yes" />
                                            <label class="righ_0" for="address">Ship to a different
                                                address?</label>

                                            <div id="showAddress">
                                                <div class="row">
                                                    <div class="col-lg-4 mb-20">
                                                        <label>First Name <span>*</span></label>
                                                        <input type="text" name="first_name" class="form-control">
                                                    </div>
                                                    <div class="col-lg-4 mb-20">
                                                        <label>Middle Name</label>
                                                        <input type="text" name="middle_name" class="form-control">
                                                    </div>
                                                    <div class="col-lg-4 mb-20">
                                                        <label>Last Name <span>*</span></label>
                                                        <input type="text" name="last_name" class="form-control">
                                                    </div>
                                                    <div class="col-lg-6 mb-20">
                                                        <label>Email Address <span>*</span></label>
                                                        <input type="text" name="email" class="form-control">
                                                    </div>
                                                    <div class="col-lg-6 mb-20">
                                                        <label>Mobile Number <span>*</span></label>
                                                        <input type="text" name="mobile_number" class="form-control">
                                                    </div>
                                                    <div class="col-12 mb-20">
                                                        <label>Street address <span>*</span></label>
                                                        <input placeholder="House number and street name" type="text"
                                                            name="street_address" class="form-control">
                                                    </div>
                                                    <div class="col-6 mb-20">
                                                        <div class="select_form_select">
                                                            <label for="province_id">Province <span>*</span></label>
                                                            <select class="form-control" name="province_id"
                                                                id="province_id">
                                                                <option value="">Select Province</option>
                                                                @foreach ($provinces as $province)
                                                                    <option value="{{ $province->provCode }}">
                                                                        {{ $province->provDesc }}</option>
                                                                @endforeach
                                                            </select>
                                                            <input type="hidden" name="province" id="province_name">
                                                        </div>
                                                    </div>
                                                    <div class="col-6 mb-20">
                                                        <div class="select_form_select">
                                                            <label for="city_id">Town/City <span>*</span></label>
                                                            <select class="form-control" name="city_id" id="city_id">
                                                                <option value="">Select City</option>
                                                                @foreach ($cities as $city)
                                                                    <option value="{{ $city->citymunDesc }}">
                                                                        {{ $city->citymunDesc }}</option>
                                                                @endforeach
                                                            </select>
                                                            <input type="hidden" name="city" id="city_name">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="order-notes">
                                                <label for="order_note">Order Notes</label>
                                                <textarea class="form-control" id="order_note" name="order_note"
                                                    placeholder="Notes about your order, e.g. special notes for delivery."></textarea>
                                            </div>
                                        </div>
                                    </div>
                            </div>

                            <div class="col-lg-6 col-md-6">
                                <h3>Your order</h3>
                                <div class="order_table table-responsive">
                                    <table class="table table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th>Product</th>
                                                <th>Total</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if (Cart::count() > 0)
                                                @foreach (Cart::content() as $item)
                                                    <tr>
                                                        <td>{{ $item->name }} <strong> × {{ $item->qty }}</strong>
                                                        </td>
                                                        <td>P{{ number_format(($item->price - $item->discount) * $item->qty, 2) }}
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @else
                                                <tr>
                                                    <td colspan="2" class="text-center">No items to checkout</td>
                                                </tr>
                                            @endif
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th>Cart Subtotal</th>
                                                <td class="checkout_subtotal"><strong
                                                        class="checkout_amount">{{ Cart::subtotal() }}</strong></td>
                                            </tr>
                                            <tr>
                                                <th>
                                                    Shipping&nbsp;&nbsp;
                                                    <div class="custom-control custom-radio custom-control-inline">
                                                        <input type="radio" id="ship-items" name="shipping_checkout"
                                                            class="custom-control-input" value="ship-items" checked>
                                                        <label class="custom-control-label" for="ship-items">Ship</label>
                                                    </div>
                                                    <div class="custom-control custom-radio custom-control-inline">
                                                        <input type="radio" id="pick-up-items" name="shipping_checkout"
                                                            class="custom-control-input" value="pick-up-items">
                                                        <label class="custom-control-label"
                                                            for="pick-up-items">Pick-up</label>
                                                    </div>
                                                </th>
                                                <td class="checkout_shipping">
                                                    <strong class="checkout_amount">
                                                        @if (Cart::count() === 0)
                                                            P0.00
                                                        @else
                                                            P250.00
                                                        @endif
                                                    </strong>
                                                </td>
                                            </tr>
                                            <tr class="order_total">
                                                <th>Order Total</th>
                                                <td class="checkout_total">
                                                    <strong class="checkout_amount ">
                                                        @if (Cart::count() === 0)
                                                            P0.00
                                                        @else
                                                            P{{ number_format(floatval(str_replace(',', '', Cart::subtotal())) + 250, 2) }}
                                                        @endif
                                                        <input type="text" name="first_name" class="form-control">
                                                    </strong>
                                                </td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>

                                <div class="payment_method">

                                    <div class="panel-default">
                                        <input id="e-wallet" name="checkout_method" type="radio"
                                            data-target="createp_account" data-value="{{ $available_balance }}"
                                            data-guest="{{ Auth::check() ? 1 : 0 }}" value="e-wallet"
                                            @guest disabled @endguest
                                            @auth @if (floatval(str_replace(',', '', Cart::subtotal())) > $available_balance) disabled @endif @endauth />
                                        <label for="e-wallet" data-toggle="collapse" data-target="#e-wallet-accordion"
                                            aria-controls="collapsedefult">E-Wallet @guest <span style="color:red;">(Login
                                                    to use
                                                    this payment method)</span>@endguest @auth @if (floatval(str_replace(',', '', Cart::subtotal())) > $available_balance)
                                                    <span style="color:red;">(Insufficient Balance)</span>
                                                @endif @endauth
                                            </label>

                                            <div id="e-wallet-accordion" class="collapse one" data-parent="#accordion">
                                                <div class="card-body1">
                                                    <p>Pay using your available e-wallet balance. </p>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="panel-default">
                                            <input id="over-the-counter" name="checkout_method" type="radio"
                                                data-target="createp_account" value="over-the-counter" checked />
                                            <label for="over-the-counter" data-toggle="collapse"
                                                data-target="#over-the-counter-accordion" aria-controls="collapsedefult">Over
                                                the counter</label>
                                            <div id="over-the-counter-accordion" class="collapse one"
                                                data-parent="#accordion">
                                                <div class="card-body1">
                                                    <p>Pay via Over the counter, details will be provided after successful
                                                        checkout.</p>
                                                </div>
                                            </div>
                                        </div>

                                        {{-- <div class="panel-default">
                                            <input id="paynamics" name="checkout_method" type="radio"
                                                data-target="createp_account" value="paynamics" />
                                            <label for="paynamics" data-toggle="collapse" data-target="#paynamix-accordion"
                                                aria-controls="collapsedefult">Paynamics <img height="50"
                                                    src="assets/img/icon/logo-paynamics.png" alt="Paynamics logo"></label>

                                            <div id="paynamics-accordion" class="collapse one" data-parent="#accordion">
                                                <div class="card-body1">
                                                    <p>Pay using Paynamics. Coming Soon.</p>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="panel-default">
                                            <input id="paypal" name="checkout_method" type="radio"
                                                data-target="createp_account" value="paypal" />
                                            <label for="paypal" data-toggle="collapse" data-target="#paypal-accordion"
                                                aria-controls="collapsedefult">PayPal <img height="50"
                                                    src="assets/img/icon/papyel.png" alt="Paypal logo"></label>

                                            <div id="paypal-accordion" class="collapse one" data-parent="#accordion">
                                                <div class="card-body1">
                                                    <p>Pay via PayPal, you can pay with your credit card if you don’t have a
                                                        PayPal
                                                        account. Coming Soon.</p>
                                                </div>
                                            </div>
                                        </div> --}}
                                        <div class="order_button">
                                            <button id="proceed-checkout" class="btn btn-primary"
                                                type="submit"{{ Cart::count() === 0 ? ' disabled' : '' }}>Proceed</button>
                                        </div>
                                    </div>
                                    <!-- Add other payment methods here with similar structure -->
                                </div>
                            </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
    @endsection

@section('scripts')
    <script>
        var get_total_income_route = "{{ route('user.get-total-income') }}";
    </script>
    <script src="{{ asset('js/user/cart.js') }}"></script>
    <script>
        var city_data;
        $(document).ready(function() {
            $('#showAddress').hide();

            $('#address').change(function() {
                if ($(this).is(':checked')) {
                    $('#showAddress').show();
                } else {
                    $('#showAddress').hide();
                }
            });
            if (sessionStorage.getItem('shipping')) {
                const shipping = sessionStorage.getItem('shipping');
                $(`input[value=${shipping}]`).attr('checked', true).trigger('change');
            } else {
                $('input[value=pick-up-items]').attr('checked', true).trigger('change');
            }
            getCityData();

            $("#province_id").change(function(event) {
                var dis_val = $(this).val();
                $('#city_id').empty();
                $('#city_id').append('<option value="">Select City</option>');
                $.each(city_data, function(i, value) {
                    if (value.provCode == dis_val) {
                        $('#city_id').append('<option value="' + value.citymunCode + '">' + value
                            .citymunDesc + '</option>');
                    }
                });
                var dis_text = $("#province_id option:selected").text();
                $('#province_name').val(dis_text);

            });
            $("#city_id").change(function(event) {
                var dis_text = $("#city_id option:selected").text();
                $('#city_name').val(dis_text);
            });

            if (sessionStorage.getItem('shipping')) {
                const shipping = sessionStorage.getItem('shipping');
                $(`input[value=${shipping}]`).attr('checked', true).trigger('change');
            } else {
                $('input[value=pick-up-items]').attr('checked', true).trigger('change');
            }
        });

        function getCityData() {
            $.ajax({
                url: "{{ route('get-province') }}",
                type: 'GET',
                success: function(response) {
                    city_data = response.city;
                },
                error: function(error) {
                    console.log('Getting data error...');
                    console.log(error);
                }
            });
        }
    </script>
@endsection
