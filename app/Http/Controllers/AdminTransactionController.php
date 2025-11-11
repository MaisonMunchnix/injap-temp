<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class AdminTransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

	public function __construct()
    {
        $this->middleware('auth');
    } 
	
	
	public function index() {
		$products = DB::table('products')->where('category','!=',1)->where('status',1)->get();
        $packages = DB::table('products')
            ->where('category',1)
            ->where('status',1)
            ->where('name','!=','Stockist')
            ->where('name','!=','BO')
            ->get();
        $other_packages = DB::table('products')->where('category',1)->where('status',1)->where('name','Stockist')->orWhere('name','BO')->get();

        $users = DB::table('users')->select('id','username')->where('userType','user')->get();
		return view('admin.transaction.index',['products' => $products,'packages' => $packages,'other_packages' => $other_packages,'users' => $users]);
    }
}
