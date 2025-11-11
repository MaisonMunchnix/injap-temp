@extends('layouts.guest.master')
@section('title', 'Purple Life Organic Products - Products')

@section('content')
    <div class="shop_area shop_reverse pt-30">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-12">
                    <!--sidebar widget start-->
                    <aside class="sidebar_widget">
                        <div class="widget_inner">

                            <div class="widget_list widget_categories">
                                <h2>Product categories</h2>
                                <ul>
                                    <li>
                                        <input
                                            type="checkbox"{{ Request::query('category') == null && Request::query('search') == null ? ' checked' : '' }}
                                            disabled>
                                        <a href="{{ route('guest.products') }}">Show All</a>
                                        <span class="checkmark"></span>
                                    </li>
                                    @foreach (\App\ProductCategory::all() as $category)
                                        <li>
                                            <input
                                                type="checkbox"{{ Request::query('category') == $category->id ? ' checked' : '' }}
                                                disabled>
                                            <a
                                                href="{{ route('guest.products', ['category' => $category->id]) }}">{{ $category->name }}</a>
                                            <span class="checkmark"></span>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>


                        </div>
                        <div class="single_banner">
                            <a href="#"><img src="assets/img/bg/banner19.jpg" alt=""></a>
                        </div>
                    </aside>
                    <!--sidebar widget end-->
                </div>
                <div class="col-lg-9 col-md-12">
                    <!--shop wrapper start-->
                    <!--shop toolbar start-->
                    <div class="shop_toolbar_wrapper">
                        <div class="shop_toolbar_btn">
                            <button data-role="grid_3" type="button" class=" btn-grid-3" data-toggle="tooltip"
                                title="3 Columns"></button>
                            <button data-role="grid_4" type="button" class=" btn-grid-4" data-toggle="tooltip"
                                title="4 Columns"></button>
                            <button data-role="grid_list" type="button" class="active btn-list" data-toggle="tooltip"
                                title="List"></button>
                        </div>
                        <div class="page_amount">
                            <p>Showing {{ $products->firstItem() }}–{{ $products->lastItem() }} of {{ $products->total() }}
                                results</p>
                        </div>
                    </div>
                    <!--shop toolbar end-->
                    <div class="row shop_wrapper grid_list">
                        @foreach ($products as $product)
                            @php
                                $discount = $product->price - ($product->discount / 100) * $product->price;
                            @endphp
                            <div class="col-md-12 ">
                                <div class="single_product">
                                    <div class="product_thumb">
                                        {{-- <a class="primary_img" href="{{-- {{ route('guest.products.view', $product->id) }} --}}"><img height="250" width="250"
                                            src="{{ $product->image }}" alt="{{ $product->name }} Image"></a> --}}
                                        <div class="quick_button text-center">
                                            <a href="#" data-toggle="modal"
                                                data-target="#product_modal_{{ $product->id }}" title="quick view"> <i
                                                    class="ion-eye"></i></a>
                                        </div>
                                    </div>

                                    <div class="product_content grid_content">
                                        <div class="content_inner">
                                            <div class="product_name">
                                                <h3><a href="{{-- {{ route('guest.products.view', $product->id) }} --}}">{{ $product->name }}</a></h3>
                                            </div>
                                            <div class="product_ratings">
                                                <ul>
                                                    @for ($i = 0; $i < floor($product->rating); $i++)
                                                        <li><a href="#"><i class="ion-ios-star"></i></a></li>
                                                    @endfor
                                                    @for ($i = 0; $i < 5 - floor($product->rating); $i++)
                                                        <li><a href="#"><i class="ion-ios-star-outline"></i></a></li>
                                                    @endfor
                                                </ul>
                                            </div>
                                            <div class="price_box">
                                                @if ($product->discount > 0)
                                                    <span class="old_price">P{{ $product->price }}</span>
                                                    <span class="current_price">P{{ number_format($discount, 2) }}</span>
                                                @else
                                                    <span class="current_price">P{{ $product->price }}</span>
                                                @endif
                                            </div>
                                            <div class="action_links text-center">
                                                <ul>
                                                    <li class="add_to_cart"><a href="{{ route('cart.add', $product->id) }}"
                                                            title="add to cart"><i class="ion-bag"></i> add to cart</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="product_content list_content">
                                        <div class="left_caption">
                                            <div class="product_name">
                                                <h3><a href="{{-- {{ route('guest.products.view', $product->id) }} --}}">{{ $product->name }}</a></h3>
                                            </div>
                                            <div class="product_ratings">
                                                <ul>
                                                    @for ($i = 0; $i < floor($product->rating); $i++)
                                                        <li><a href="#"><i class="ion-ios-star"></i></a></li>
                                                    @endfor
                                                    @for ($i = 0; $i < 5 - floor($product->rating); $i++)
                                                        <li><a href="#"><i class="ion-ios-star-outline"></i></a></li>
                                                    @endfor
                                                </ul>
                                            </div>
                                            <div class="price_box">
                                                @if ($product->discount > 0 && $product->category !== 1)
                                                    <span class="old_price">P{{ $product->price }}</span>
                                                    <span class="current_price">P{{ number_format($discount, 2) }}</span>
                                                @else
                                                    <span class="current_price">P{{ $product->price }}</span>
                                                @endif
                                            </div>
                                            <div class="product_desc" style="width: 310px">
                                                <p>{{ $product->description }}</p>
                                            </div>
                                        </div>
                                        <div class="right_caption">
                                            <div class="add_to_links">
                                                <ul>
                                                    <li class="add_to_cart"><a href="{{ route('cart.add', $product->id) }}"
                                                            title="add to cart"><i class="ion-bag"></i> add to cart</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        @endforeach
                    </div>

                    @if ($products->hasPages())
                        <div class="shop_toolbar t_bottom">
                            <div class="pagination">
                                {{ $products->links() }}
                            </div>
                        </div>
                    @endif

                    <!--shop toolbar end-->
                    <!--shop wrapper end-->
                </div>
            </div>
        </div>
    </div>
    <!-- modal area start-->
    @foreach ($products as $product)
        <div class="modal fade" id="product_modal_{{ $product->id }}" tabindex="-1" role="dialog" aria-hidden="true">
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
                                                    <img src="{{ $product->image }}" alt="">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-7 col-md-7 col-sm-12">
                                    <div class="modal_right">
                                        <div class="modal_title mb-10">
                                            <h2>{{ $product->name }}</h2>
                                        </div>
                                        <div class="modal_price mb-10">
                                            @if ($product->discount > 0)
                                                <span class="old_price">P{{ $product->price }}</span>
                                                <span
                                                    class="new_price">P{{ ($product->discount / 100) * $product->price }}</span>
                                            @else
                                                <span class="new_price">P{{ $product->price }}</span>
                                            @endif
                                        </div>
                                        <div class="modal_description mb-15">
                                            <p>{{ $product->description }}</p>
                                        </div>
                                        <div class="variants_selects">
                                            <div class="modal_add_to_cart">
                                                <form class="add_to_cart_modal"
                                                    action="{{ route('cart.add', $product->id) }}" method="POST">
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
    <!-- modal area end-->
@endsection
