@extends('layouts.default.master')
@section('title', 'Cart')
@section('page-title', 'Cart')

@section('stylesheets')
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
        <div class="card mt-5">
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-10 offset-lg-1">
                        <div class="row mt-5">
                            <!-- Cart -->
                            <div class="col-lg-9">
                                <div class="card border shadow-0">
                                    <div class="m-4">
                                        <h4 class="card-title mb-4">Your shopping cart</h4>
                                        <form action="#">
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="table_desc">
                                                        <div class="cart_page table-responsive">
                                                            <table class="table table-bordered">
                                                                <thead>
                                                                    <tr>
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
                                                                                <td class="product_thumb"><a
                                                                                        href="#"><img
                                                                                            src="{{ asset($item->options->image) }}"
                                                                                            alt="{{ $item->name }} Image"
                                                                                            width="50px"></a>
                                                                                </td>
                                                                                <td class="product_name"><a
                                                                                        href="#">{{ $item->name }}</a>
                                                                                </td>
                                                                                <td class="product-price">
                                                                                    P{{ number_format($item->price - $item->discount, 2) }}
                                                                                </td>
                                                                                <td class="product_quantity">
                                                                                    <div class="input-group mb-3">
                                                                                        <input class="form-control"
                                                                                            min="1" max="100"
                                                                                            value="{{ $item->qty }}"
                                                                                            type="number"
                                                                                            data-url="{{ route('products.cart.update', $item->rowId) }}">
                                                                                        <div class="input-group-append">
                                                                                            <a class="btn btn-sm btn-danger pull-right text-white"
                                                                                                href="{{ route('products.cart.remove', $item->rowId) }}"><i
                                                                                                    class="fa fa-trash-o"></i>
                                                                                            </a>
                                                                                        </div>
                                                                                    </div>
                                                                                </td>
                                                                                <td class="product_total">
                                                                                    P{{ number_format($item->qty * ($item->price - $item->discount), 2) }}
                                                                                </td>
                                                                            </tr>
                                                                        @endforeach
                                                                    @else
                                                                        <tr>
                                                                            <td colspan="6" class="text-center">No items
                                                                                in cart</td>
                                                                        </tr>
                                                                    @endif
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <!-- Cart -->
                            <!-- Summary -->
                            <div class="col-lg-3">
                                <div class="card shadow-0 border">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between cart_subtotal">
                                            <p class="mb-2">Subtotal:</p>
                                            <p class="mb-2 cart_amount">P{{ Cart::subtotal() }}</p>
                                        </div>
                                        <div class="d-flex justify-content-between cart_shipping">
                                            <p class="mb-2">Shipping:</p>
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
                                            <p class="mb-2 text-success cart_amount"></p>
                                        </div>
                                        <hr />
                                        <div class="d-flex justify-content-between cart_total">
                                            <p class="mb-2">Total price:</p>
                                            <p class="mb-2 fw-bold cart_amount"></p>
                                        </div>

                                        <div class="mt-3">
                                            <a href="{{ route('products.cart.checkout') }}"
                                                class="btn btn-success w-100 shadow-0 mb-2">Proceed to Checkout</a>
                                            <a href="{{ route('products.list') }}" class="btn btn-light w-100 border mt-2">
                                                Back to shop
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Summary -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"
        integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="{{ asset('js/user/cart.js') }}"></script>
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
