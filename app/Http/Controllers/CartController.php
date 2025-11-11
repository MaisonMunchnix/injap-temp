<?php

namespace App\Http\Controllers;

use App\Product;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function add(Product $product, Request $request)
    {
        $qty = $request->qty ?? 1;
        $item = Cart::instance(Auth::user())->add($product, $qty, ['image' => $product->image]);

        if($product->category == 1) {
            Cart::setDiscount($item->rowId, 0);
        }

        return response([
            'content' => Cart::content()->toArray(),
            'count' => Cart::count(),
            'sub_total' => Cart::subtotal()
        ]);
    }

    public function remove($rowId) {
        Cart::instance(Auth::user())->remove($rowId);

        return response([
            'content' => Cart::content()->toArray(),
            'count' => Cart::count(),
            'sub_total' => Cart::subtotal()
        ]);
    }

    public function update($rowId, Request $request)
    {
        $qty = $request->qty ?? 1;
        Cart::instance(Auth::user())->update($rowId, $qty);

        return response([
            'content' => Cart::content()->toArray(),
            'count' => Cart::count(),
            'sub_total' => Cart::subtotal()
        ]);
    }


}
