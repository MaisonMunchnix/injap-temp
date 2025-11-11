<div class="mini_cart_wrapper">
    <div class="mini_cart_info">
        @if (Cart::count() > 0)
            <a href="#"><i class="ion-bag"></i>P{{ Cart::subtotal() }}</a>
            <span class="cart_quantity">{{ Cart::count() }}</span>
        @else
            <a href="#"><i class="ion-bag"></i></a>
        @endif
    </div>
    <div class="mini_cart">
        @if (Cart::count() > 0)
            @foreach (Cart::content() as $item)
                <div class="cart_item">
                    <div class="cart_img">
                        <a href="#"><img src="{{ asset($item->options->image) }}"
                                alt="{{ $item->name }} Image"></a>
                    </div>
                    <div class="cart_info">
                        <a href="#">{{ $item->name }}</a>

                        <span class="quantity">Qty: {{ $item->qty }}</span>
                        <span class="price_cart">P{{ number_format($item->price - $item->discount, 2) }}</span>

                    </div>
                    <div class="cart_remove">
                        {{-- <a href="{{ route('cart.remove', $item->rowId) }}"><i class="ion-android-close"></i></a> --}}
                    </div>
                </div>
            @endforeach
        @else
            <div class="no_item text-center">
                No items in cart
            </div>
        @endif

        <div class="mini_cart_table">
            <div class="cart_total">
                <span>Total:</span>
                <span class="price">P{{ Cart::subtotal() }}</span>
            </div>

        </div>

        <div class="mini_cart_footer">
            <div class="cart_button">
                {{-- <a href="{{ route('guest.cart') }}">View cart</a> --}}
            </div>
            <div class="cart_button">
                {{-- <a href="{{ route('guest.checkout') }}">Checkout</a> --}}
            </div>

        </div>

    </div>
</div>
