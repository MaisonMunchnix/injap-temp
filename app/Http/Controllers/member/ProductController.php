<?php

namespace App\Http\Controllers\member;

use Gloudemans\Shoppingcart\Facades\Cart;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Product;
use App\Province;
use App\City;
use App\Referral;
use App\Encashment;

use Auth;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $auth_id = Auth::id();
        $products = Product::paginate(12);
        return view('user.products.index', compact('auth_id','products'));
    }

    public function cart()
    {
        Cart::instance(Auth::user());
        $auth_id = Auth::id();
        return view('user.products.cart', compact('auth_id'));
    }

    public function checkout()
    {
        $auth_id = Auth::id();
        Cart::instance(Auth::user());
        $cities = City::orderBy('citymunDesc', 'ASC')->get();
        $provinces = Province::orderBy('provDesc', 'ASC')->get();

        $get_total_earnings = Referral::where('user_id', $auth_id)
            ->where('referral_type', '!=', 'fifth_activation_cost_reward')
            ->sum('amount');

        $get_total_encashment = Encashment::where('user_id', $auth_id)
            ->where('status', 'claimed')
            ->sum('amount_approved');

        $get_total_purchase = Auth::user()->getEWalletPurchases();

        $available_balance = $get_total_earnings - ($get_total_encashment + $get_total_purchase);

        return view('user.products.checkout', compact('cities', 'provinces', 'available_balance', 'auth_id'));
    }
    

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
