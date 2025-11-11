<?php

namespace App\Http\Controllers;

use App\City;
use App\Encashment;
use App\Product;
use App\ProductCategory;
use App\Province;
use App\Referral;
use App\User;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;

use Mail;

class GuestController extends Controller
{
    public function welcome()
    {
        Cart::instance(Auth::user());

        $categories = Product::where('status', 1)->get()->groupBy('category');

        return view('e-commerce.welcome', compact('categories'));
    }

    public function company()
    {
        Cart::instance(Auth::user());

        return view('e-commerce.company');
    }

    public function products(Request $request)
    {
        return view('landing.products');
    }

    public function view(Product $product)
    {
        Cart::instance(Auth::user());

        $related = Product::where('id', '!=', $product->id)
            ->where('category', $product->category)
            ->inRandomOrder()
            ->limit(5)
            ->get();
        $first = Product::first()->id === $product->id;
        $last = Product::orderBy('id', 'DESC')->first()->id === $product->id;

        return view('e-commerce.product-details', compact('product', 'related', 'first', 'last'));
    }

    public function contact()
    {
        Cart::instance(Auth::user());

        return view('e-commerce.contact');
    }

    public function cart()
    {
        Cart::instance(Auth::user());

        return view('e-commerce.cart');
    }

    public function checkout()
    {

        Cart::instance(Auth::user());
        $cities = City::orderBy('citymunDesc', 'ASC')->get();
        $provinces = Province::orderBy('provDesc', 'ASC')->get();
        $available_balance = 0;
        if(Auth::check()){
            $user_id=Auth::user()->id;
            $get_total_earnings=Referral::select('amount')->where('user_id',$user_id)->where('referral_type','!=','fifth_activation_cost_reward')->sum('amount');
            $get_total_encashment=Encashment::select('amount_approved')->where('user_id', $user_id)->where('status','claimed')->sum('amount_approved');
            $get_total_purchase=Auth::user()->getEWalletPurchases();
            $available_balance = $get_total_earnings - ($get_total_encashment + $get_total_purchase);
        }

        return view('e-commerce.checkout', compact('cities', 'provinces', 'available_balance'));
    }

    public function productRetail($code) {
        $user = User::where('affiliate_link', $code)->get();

        if($user->count() === 1) {
            Cookie::queue('retail-affiliate-code', $code, 43200);
        }

        return redirect()->route('guest.products');
    }

    public function emailContactUs(Request $request) {
        $data = ['name' => $request['name'],
        'email' => $request['email'],
        'subject' => $request['subject'], 
        'msg' => $request['message']];
        Mail::send('email.contact-us',$data, function($message) use ($data){
            $message->to('support@purplelife.ph');
            $message->subject("Contact Us - Purple Website");
        });

        if (count(Mail::failures()) > 0) {
            return response()->json([
                'message' => 'error',
            ],400);
        }else{  
            return response()->json([
                'message' => 'OK',
            ],200);
        }
    }
}
