@extends('layouts.guest.master')
@section('title', 'Purple Life Organic Products - Checkout')

@section('content')
    <!--Checkout page section-->
    <div class="Checkout_section pt-30">
        <div class="container">
            @guest
                <div class="row">
                    <div class="col-12">
                        <div class="user-actions">
                            <h3>
                                <i class="fa fa-file-o" aria-hidden="true"></i>
                                Already a member?
                                <a class="returning" href="#" data-toggle="collapse" data-target="#checkout_login"
                                    aria-expanded="true">Click here to login</a>
                            </h3>
                            <div id="checkout_login" class="collapse" data-parent="#accordion">
                                <div class="checkout_info">
                                    <p>If you have shopped with us before, please enter your details in the boxes below.</p>
                                    <form method="POST" action="{{ route('login') }}">
                                        @csrf
                                        <div class="form_group">
                                            <label for="username">Username <span>*</span></label>
                                            <input type="text" name="username" id="username" value="{{ old('username') }}"
                                                required>
                                        </div>
                                        @error('username')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                        <div class="form_group">
                                            <label for="password">Password <span>*</span></label>
                                            <input type="password" name="password" id="password" required>
                                        </div>
                                        @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                        <div class="form_group group_3 ">
                                            <button type="submit">Login</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endguest
            <div class="checkout_form">
                <div class="row">
                    <div class="col-lg-6 col-md-6">
                        <form action="{{ route('products.cart.payment') }}" method="POST">
                            {{ @csrf_field() }}
                            <h3>Billing Details</h3>
                            @guest
                                <div class="row">
                                    <div class="col-lg-4 mb-20">
                                        <label>First Name <span>*</span></label>
                                        <input type="text" name="first_name" required>
                                    </div>
                                    <div class="col-lg-4 mb-20">
                                        <label>Middle Name <span>*</span></label>
                                        <input type="text" name="middle_name" required>
                                    </div>
                                    <div class="col-lg-4 mb-20">
                                        <label>Last Name <span>*</span></label>
                                        <input type="text" name="last_name" required>
                                    </div>
                                    <div class="col-lg-8 mb-20">
                                        <label> Email Address <span>*</span></label>
                                        <input type="text" name="email" required>
                                    </div>
                                    <div class="col-lg-4 mb-20">
                                        <label>Mobile Number <span>*</span></label>
                                        <input type="text" name="mobile_number" required>
                                    </div>
                                    <div class="col-12 mb-20">
                                        <label>Street address <span>*</span></label>
                                        <input placeholder="House number and street name" type="text" name="street_address"
                                            required>
                                    </div>
                                    <div class="col-12 mb-20">
                                        <div class="select_form_select">
                                            <label for="province_id">Province <span>*</span></label>
                                            <select class="form-control" name="province_id" id="province_id" required>
                                                <option value="">Select Province</option>
                                                @foreach ($provinces as $province)
                                                    <option value="{{ $province->provCode }}">{{ $province->provDesc }}</option>
                                                @endforeach
                                            </select>
                                            <input type="hidden" name="province" id="province_name" required>
                                        </div>
                                    </div>
                                    <div class="col-12 mb-20">
                                        <div class="select_form_select">
                                            <label for="city_id">Town/City <span>*</span></label>
                                            <select class="form-control" name="city_id" id="city_id" required>
                                                <option value="">Select City</option>
                                                {{--  @foreach ($cities as $city)
                                        <option value="{{ $city->citymunDesc }}">{{ $city->citymunDesc }}</option>
                                        @endforeach --}}
                                            </select>
                                            <input type="hidden" name="city" id="city_name" required>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="order-notes">
                                            <label for="order_note">Order Notes</label>
                                            <textarea id="order_note" placeholder="Notes about your order, e.g. special notes for delivery." name="order_note"></textarea>
                                        </div>
                                    </div>
                                </div>
                            @endguest
                            @auth
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
                                    <div class="col-lg-8 mb-20">
                                        <label> Email Address</label>
                                        <p>{{ Auth::user()->email }}</p>
                                    </div>
                                    <div class="col-lg-4 mb-20">
                                        <label>Mobile Number</label>
                                        <p>{{ Auth::user()->info->mobile_no }}</p>
                                    </div>
                                    <div class="col-12 mb-20">
                                        <label>Street address</label>
                                        <p>{{ Auth::user()->info->address }}</p>
                                    </div>
                                    <div class="col-12 mb-20">
                                        <label for="city">Town/City <span>*</span></label>
                                        <p>{{ Auth::user()->info->city_val }}</p>
                                    </div>
                                    <div class="col-12 mb-20">
                                        <label for="country">Province</label>
                                        <p>{{ Auth::user()->info->province_val }}</p>
                                    </div>
                                    <div class="col-12 mb-20">
                                        <input id="address" type="checkbox" data-target="createp_account"
                                            name="ship_to_another_address" value="yes" />
                                        <label class="righ_0" for="address" data-toggle="collapse"
                                            data-target="#collapsetwo" aria-controls="collapseOne">Ship to a different
                                            address?</label>

                                        <div id="collapsetwo" class="collapse one" data-parent="#accordion">
                                            <div class="row">
                                                <div class="col-lg-4 mb-20">
                                                    <label>First Name <span>*</span></label>
                                                    <input type="text" name="first_name">
                                                </div>
                                                <div class="col-lg-4 mb-20">
                                                    <label>Middle Name <span>*</span></label>
                                                    <input type="text" name="middle_name">
                                                </div>
                                                <div class="col-lg-4 mb-20">
                                                    <label>Last Name <span>*</span></label>
                                                    <input type="text" name="last_name">
                                                </div>
                                                <div class="col-lg-8 mb-20">
                                                    <label> Email Address <span>*</span></label>
                                                    <input type="text" name="email">
                                                </div>
                                                <div class="col-lg-4 mb-20">
                                                    <label>Mobile Number <span>*</span></label>
                                                    <input type="text" name="mobile_number">
                                                </div>
                                                <div class="col-12 mb-20">
                                                    <label>Street address <span>*</span></label>
                                                    <input placeholder="House number and street name" type="text"
                                                        name="street_address">
                                                </div>
                                                <div class="col-12 mb-20">
                                                    <div class="select_form_select">
                                                        <label for="province_id">Province <span>*</span></label>
                                                        <select class="form-control" name="province_id" id="province_id">
                                                            <option value="">Select Province</option>
                                                            @foreach ($provinces as $province)
                                                                <option value="{{ $province->provCode }}">
                                                                    {{ $province->provDesc }}</option>
                                                            @endforeach
                                                        </select>
                                                        <input type="hidden" name="province" id="province_name">
                                                    </div>
                                                </div>
                                                <div class="col-12 mb-20">
                                                    <div class="select_form_select">
                                                        <label for="city_id">Town/City <span>*</span></label>
                                                        <select class="form-control" name="city_id" id="city_id">
                                                            <option value="">Select City</option>
                                                            {{--   @foreach ($cities as $city)
                                                        <option value="{{ $city->citymunDesc }}">{{ $city->citymunDesc }}</option>
                                                    @endforeach --}}
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
                                            <textarea id="order_note" placeholder="Notes about your order, e.g. special notes for delivery."></textarea>
                                        </div>
                                    </div>
                                </div>
                            @endauth
                    </div>
                    <div class="col-lg-6 col-md-6">
                        <h3>Your order</h3>
                        <div class="order_table table-responsive">
                            <table>
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
                                                <td> {{ $item->name }} <strong> × {{ $item->qty }}</strong></td>
                                                <td> P{{ number_format(($item->price - $item->discount) * $item->qty, 2) }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="2" class="text-center"> No items to checkout</td>
                                        </tr>
                                    @endif
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>Cart Subtotal</th>
                                        <td class="checkout_subtotal"><strong
                                                class="checkout_amount">P{{ Cart::subtotal() }}</strong></td>
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
                                                <label class="custom-control-label" for="pick-up-items">Pick-up</label>
                                            </div>
                                        </th>
                                        <td class="checkout_shipping"><strong class="checkout_amount">
                                                @if (Cart::count() === 0)
                                                    P0.00
                                                @else
                                                    P250.00
                                                @endif
                                            </strong></td>
                                    </tr>
                                    <tr class="order_total">
                                        <th>Order Total</th>
                                        <td class="checkout_total"><strong class="checkout_amount">
                                                @if (Cart::count() === 0)
                                                    P0.00
                                                @else
                                                    P{{ number_format(floatval(str_replace(',', '', Cart::subtotal())) + 250, 2) }}
                                                @endif
                                            </strong></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                        <div class="payment_method">
                            <div class="panel-default">
                                <input id="over-the-counter" name="checkout_method" type="radio"
                                    data-target="createp_account" value="over-the-counter" checked />
                                <label for="over-the-counter" data-toggle="collapse"
                                    data-target="#over-the-counter-accordion" aria-controls="collapsedefult">Over the
                                    counter</label>

                                <div id="over-the-counter-accordion" class="collapse one" data-parent="#accordion">
                                    <div class="card-body1">
                                        <p>Pay via Over the counter, details will be provided after successful checkout.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="panel-default">
                                <input id="bank-transfer" name="checkout_method" type="radio"
                                    data-target="createp_account" value="bank-transfer" />
                                <label for="bank-transfer" data-toggle="collapse" data-target="#bank-transfer-accordion"
                                    aria-controls="collapsedefult">Bank Transfer</label>

                                <div id="bank-transfer-accordion" class="collapse one" data-parent="#accordion">
                                    <div class="card-body1">
                                        <p>Pay via Bank Transfer, details will be provided after successful checkout.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="panel-default">
                                <input id="e-wallet" name="checkout_method" type="radio"
                                    data-target="createp_account" data-value="{{ $available_balance }}"
                                    data-guest="{{ Auth::check() ? 1 : 0 }}" value="e-wallet" @guest disabled @endguest
                                    @auth @if (floatval(str_replace(',', '', Cart::subtotal())) > $available_balance) disabled @endif @endauth />
                                <label for="e-wallet" data-toggle="collapse" data-target="#e-wallet-accordion"
                                    aria-controls="collapsedefult">E-Wallet @guest <span style="color:red;">(Login to use
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
                                            <p>Pay via PayPal, you can pay with your credit card if you don’t have a PayPal
                                                account. Coming Soon.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="order_button">
                                    <button id="proceed-checkout"
                                        type="submit"{{ Cart::count() === 0 ? ' disabled' : '' }}>Proceed</button>
                                </div>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--Checkout page section end-->
    @endsection
@section('scripts')
    <script>
        var city_data;
        $(document).ready(function() {
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
        });

        function getCityData() {
            $.ajax({
                url: 'get-province',
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
