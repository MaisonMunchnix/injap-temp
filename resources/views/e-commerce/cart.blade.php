@extends('layouts.guest.master')
@section('title', 'Purple Life Organic Products - Cart')

@section('content')
    <!--shopping cart area start -->
    <div class="shopping_cart_area pt-30">
        <div class="container">
            <form action="#">
                <div class="row">
                    <div class="col-12">
                        <div class="table_desc">
                            <div class="cart_page table-responsive">
                                <table>
                                    <thead>
                                        <tr>
                                            <th class="product_remove">Delete</th>
                                            <th class="product_thumb">Image</th>
                                            <th class="product_name">Product</th>
                                            <th class="product-price">Price</th>
                                            <th class="product_quantity">Quantity</th>
                                            <th class="product_total">Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (Cart::count() > 0)
                                            @foreach (Cart::content() as $item)
                                                <tr data-id="{{ $item->rowId }}">
                                                    <td class="product_remove">
                                                        {{-- <a
                                                            href="{{ route('cart.remove', $item->rowId) }}"><i
                                                                class="fa fa-trash-o"></i></a> --}}
                                                    </td>
                                                    <td class="product_thumb"><a href="#"><img
                                                                src="{{ $item->options->image }}"
                                                                alt="{{ $item->name }} Image"></a></td>
                                                    <td class="product_name"><a href="#">{{ $item->name }}</a></td>
                                                    <td class="product-price">
                                                        P{{ number_format($item->price - $item->discount, 2) }}</td>
                                                    <td class="product_quantity"><label>Quantity</label> <input
                                                            min="1" max="100" value="{{ $item->qty }}"
                                                            type="number"
                                                            data-url="{{ route('cart.update', $item->rowId) }}"></td>
                                                    <td class="product_total">
                                                        P{{ number_format($item->qty * ($item->price - $item->discount), 2) }}
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="6" class="text-center">No items in cart</td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <!--coupon code area start-->
                <div class="coupon_area">
                    <div class="row">
                        <div class="col-lg-6 col-md-6">
                        </div>
                        <div class="col-lg-6 col-md-6">
                            <div class="coupon_code right">
                                <h3>Cart Totals</h3>
                                <div class="coupon_inner">
                                    <div class="cart_subtotal">
                                        <p>Subtotal</p>
                                        <p class="cart_amount">P{{ Cart::subtotal() }}</p>
                                    </div>
                                    <div class="cart_shipping">
                                        <p>Shipping</p>
                                        <div class="custom-control custom-radio custom-control-inline">
                                            <input type="radio" id="ship-items" name="shipping"
                                                class="custom-control-input" value="ship-items" checked>
                                            <label class="custom-control-label" for="ship-items">Ship</label>
                                        </div>
                                        <div class="custom-control custom-radio custom-control-inline">
                                            <input type="radio" id="pick-up-items" name="shipping"
                                                class="custom-control-input" value="pick-up-items">
                                            <label class="custom-control-label" for="pick-up-items">Pick-up</label>
                                        </div>
                                        @if (Cart::count() === 0)
                                            <p class="cart_amount">P0.00</p>
                                        @else
                                            <p class="cart_amount">P250.00</p>
                                        @endif
                                    </div>

                                    <div class="cart_total">
                                        <p>Total</p>
                                        @if (Cart::count() === 0)
                                            <p class="cart_amount">P0.00</p>
                                        @else
                                            <p class="cart_amount">
                                                P{{ number_format(floatval(str_replace(',', '', Cart::subtotal())) + 250, 2) }}
                                            </p>
                                        @endif
                                    </div>
                                    <div class="checkout_btn">
                                        {{-- <a href="{{ route('guest.checkout') }}">Proceed to Checkout</a> --}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--coupon code area end-->
            </form>
        </div>
    </div>
    <!--shopping cart area end -->
@endsection
@section('scripts')
    <script>
        $(document).ready(function() {
            if (sessionStorage.getItem('shipping')) {
                const shipping = sessionStorage.getItem('shipping');
                $(`input[value=${shipping}]`).attr('checked', true).trigger('change');
            } else {
                $('input[value=pick-up-items]').attr('checked', true).trigger('change');
            }
        })
    </script>
@endsection
