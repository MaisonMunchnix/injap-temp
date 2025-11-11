<?php

namespace App\Http\Controllers;

use App\PackageProduct;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class PackageProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
	   $package_products = DB::table('package_products')->where('status',1)->get();	

        return view('TellerSystem.package-products.index', ['package_products' => $package_products]);
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
     * @param  \App\PackageProduct  $packageProduct
     * @return \Illuminate\Http\Response
     */
    public function show(PackageProduct $packageProduct)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\PackageProduct  $packageProduct
     * @return \Illuminate\Http\Response
     */
    public function edit(PackageProduct $packageProduct)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\PackageProduct  $packageProduct
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PackageProduct $packageProduct)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\PackageProduct  $packageProduct
     * @return \Illuminate\Http\Response
     */
    public function destroy(PackageProduct $packageProduct)
    {
        //
    }
}
