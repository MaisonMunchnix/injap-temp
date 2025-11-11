@extends('layouts.guest.master')
@section('title', 'Purple Life Organic Products - ' . $product->name)

@section('content')
    <!--product details start-->
    <div class="product_details pt-30">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-6">
                    <div class="product-details-tab">
                        <div id="img-1" class="zoomWrapper single-zoom">
                            <a href="#">
                                <img id="zoom1" src="{{ asset($product->image) }}"
                                    data-zoom-image="{{ asset($product->image) }}" alt="{{ $product->name }} Image">
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6">
                    <div class="product_d_right">
                        <h1>{{ $product->name }}</h1>
                        <div class="product_nav">
                            <ul>
                                @if (!$first)
                                    {{-- <li class="prev"><a href="{{ route('guest.products.view', $product->id - 1) }}"><i class="fa fa-angle-left"></i></a></li> --}}
                                @endif
                                @if (!$last)
                                    {{-- <li class="next"><a href="{{ route('guest.products.view', $product->id + 1) }}"><i class="fa fa-angle-right"></i></a></li> --}}
                                @endif
                            </ul>
                        </div>
                        <div class=" product_ratting">
                            <ul>
                                @for ($i = 0; $i < floor($product->rating); $i++)
                                    <li><a href="#"><i class="ion-ios-star"></i></a></li>
                                @endfor
                                @for ($i = 0; $i < 5 - floor($product->rating); $i++)
                                    <li><a href="#"><i class="ion-ios-star-outline"></i></a></li>
                                @endfor
                            </ul>
                        </div>
                        <div class="product_price">
                            @if ($product->discount > 0)
                                <span class="old_price">P{{ number_format($product->price, 2) }}</span>
                                <span
                                    class="current_price">P{{ number_format($product->price - ($product->discount / 100) * $product->price, 2) }}</span>
                            @else
                                <span class="current_price">P{{ number_format($product->price, 2) }}</span>
                            @endif
                        </div>
                        <div class="product_desc">
                            <p>{{ $product->description }}</p>
                        </div>

                        <div class="product_variant quantity">
                            <label>quantity</label>
                            <form class="add_to_cart_details" action="{{ route('cart.add', $product->id) }}" method="POST">
                                <input min="1" max="100" value="1" type="number">
                                <button type="submit" class="button">add to cart</button>
                            </form>
                        </div>
                        <div class="product_meta">
                            <span>Category: <a
                                    href="{{ route('guest.products', ['category' => $product->product_category->id]) }}">{{ $product->product_category->name }}</a></span>
                        </div>
                        <div class="priduct_social">
                            <ul>
                                <li><a href="#" title="facebook"><i class="fa fa-facebook"></i></a></li>
                                <li><a href="#" title="twitter"><i class="fa fa-twitter"></i></a></li>
                                <li><a href="#" title="pinterest"><i class="fa fa-pinterest"></i></a></li>
                                <li><a href="#" title="google +"><i class="fa fa-google-plus"></i></a></li>
                                <li><a href="#" title="linkedin"><i class="fa fa-linkedin"></i></a></li>
                            </ul>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--product details end-->

    <!--product area start-->
    <div class="product_area related">
        <div class="container">
            <div class="related_products">
                <div class="row">
                    <div class="col-12">
                        <div class="section_title">
                            <h2>Related Products </h2>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="product_carousel product_column4 owl-carousel">
                        @foreach ($related as $item)
                            <div class="col-lg-3">
                                <div class="single_product">
                                    <div class="product_thumb">
                                        <a class="primary_img" href="#"><img src="{{ asset($item->image) }}"
                                                alt="{{ $item->name }}"></a>
                                        <div class="quick_button">
                                            <a href="#" data-toggle="modal"
                                                data-target="#product_modal_{{ $item->id }}" title="quick view"> <i
                                                    class="ion-eye"></i></a>
                                        </div>
                                        @if ($item->discount > 0)
                                            <div class="label_product">
                                                <span class="label_sale">{{ $item->discount }}%</span>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="product_content">
                                        <div class="content_inner">
                                            <div class="product_name">
                                                <h3><a href="#">{{ $item->name }}</a></h3>
                                            </div>
                                            <div class="product_ratings">
                                                <ul>
                                                    @for ($i = 0; $i < floor($item->rating); $i++)
                                                        <li><a href="#"><i class="ion-ios-star"></i></a></li>
                                                    @endfor
                                                    @for ($i = 0; $i < 5 - floor($item->rating); $i++)
                                                        <li><a href="#"><i class="ion-ios-star-outline"></i></a></li>
                                                    @endfor
                                                </ul>
                                            </div>
                                            <div class="price_box">
                                                @if ($item->discount > 0)
                                                    <span class="old_price">P{{ number_format($item->price, 2) }}</span>
                                                    <span
                                                        class="current_price">P{{ number_format($item->price - ($item->discount / 100) * $item->price, 2) }}</span>
                                                @else
                                                    <span
                                                        class="current_price">P{{ number_format($item->price, 2) }}</span>
                                                @endif
                                            </div>
                                            <div class="action_links">
                                                <ul>
                                                    <li class="add_to_cart"><a href="{{ route('cart.add', $item->id) }}"
                                                            title="Add to cart"><i class="ion-bag"></i> Add to cart</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    @foreach ($related as $item)
        <div class="modal fade" id="product_modal_{{ $item->id }}" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <div class="modal_body">
                        <div class="container">
                            <div class="row">
                                <div class="col-lg-5 col-md-5 col-sm-12">
                                    <div class="modal_tab">
                                        <div class="tab-content product-details-large">
                                            <div class="tab-pane fade show active" role="tabpanel">
                                                <div class="modal_tab_img">
                                                    <img src="{{ asset($item->image) }}"
                                                        alt="{{ $item->name }} Image">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-7 col-md-7 col-sm-12">
                                    <div class="modal_right">
                                        <div class="modal_title mb-10">
                                            <h2>{{ $item->name }}</h2>
                                        </div>
                                        <div class="modal_price mb-10">
                                            @if ($item->discount > 0)
                                                <span class="old_price">P{{ number_format($item->price, 2) }}</span>
                                                <span
                                                    class="new_price">P{{ number_format($item->price - ($item->discount / 100) * $item->price, 2) }}</span>
                                            @else
                                                <span class="new_price">P{{ number_format($item->price, 2) }}</span>
                                            @endif
                                        </div>
                                        <div class="modal_description mb-15">
                                            <p>{{ $item->description }}</p>
                                        </div>
                                        <div class="variants_selects">
                                            <div class="modal_add_to_cart">
                                                <form class="add_to_cart_modal"
                                                    action="{{ route('cart.add', $item->id) }}" method="POST">
                                                    <input min="1" max="100" step="1" value="1"
                                                        type="number">
                                                    <button type="submit">add to cart</button>
                                                </form>
                                            </div>
                                        </div>
                                        <div class="modal_social">
                                            <h2>Share this product</h2>
                                            <ul>
                                                <li class="facebook"><a href="#"><i class="fa fa-facebook"></i></a>
                                                </li>
                                                <li class="twitter"><a href="#"><i class="fa fa-twitter"></i></a>
                                                </li>
                                                <li class="pinterest"><a href="#"><i
                                                            class="fa fa-pinterest"></i></a></li>
                                                <li class="google-plus"><a href="#"><i
                                                            class="fa fa-google-plus"></i></a></li>
                                                <li class="linkedin"><a href="#"><i class="fa fa-linkedin"></i></a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
    <!--product area end-->
@endsection
