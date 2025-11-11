<?php

namespace App\Http\Controllers;

use App\User;
use App\UserInfo;
use App\ProductCode;
use App\Referral;
use App\Network;
use App\Package;
use App\Sale;
use App\ShippingDetail;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;



class AffiliateController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */



    public function viewAffiliate($type){
        $auth_id =Auth::id();
        $user_data = DB::table('users')
			->join('user_infos', 'user_infos.user_id', '=', 'users.id')
			->select('users.id AS user_id','users.created_at AS user_created_at','users.*','user_infos.*')
			->where('users.id',$auth_id)
            ->first();
        $get_package= Package::all();
        $package=array();
        foreach($get_package as $data){
            $package+= [$data->id => $data->type];
        }
        $valid_type=array('membership','retail');
        if (!in_array($type, $valid_type)){
            return view('view.error_404');
        }else{            
            $aff_link;
            if(!empty($user_data)){
                if($user_data->affiliate_link){
                    $aff_link=$user_data->affiliate_link;
                }else{
                    $affiliate_link = substr(md5(rand()),0,7);  
                    $counter_link=0;  
                    while($counter_link==0){
                        if(!ctype_digit($affiliate_link)){                                                     
                            $counter_link=1;
                        }else{
                            $affiliate_link = substr(md5(rand()),0,7);
                            $counter_link=0;
                        }               
                    }
                    $counter=0;
                    while($counter==0){                   
                        $check_link= User::where('affiliate_link',$affiliate_link)->count();
                        if($check_link==0){
                            //generate if user has no affiliate link
                            $user = User::find($auth_id);                   
                            $user->affiliate_link = $affiliate_link;
                            $user->save();
                            $counter=1;
                        }else{
                            $affiliate_link = substr(md5(rand()),0,7);
                        }
                    }
                    $aff_link=$affiliate_link;
                }
            }
            $retail_data;
            $member_data;
            
            $member_data = DB::table('users')
			    ->join('user_infos', 'user_infos.user_id', '=', 'users.id')
			    ->select('users.id AS user_id','users.created_at AS user_created_at','users.*','user_infos.*')
			    ->where('users.affiliate_link_used',$aff_link)
                ->get();
            $retail_data = DB::table('sales')
			    ->join('shipping_details', 'shipping_details.sale_id', '=', 'sales.id')
			    ->select('sales.subtotal','shipping_details.first_name','shipping_details.last_name','shipping_details.created_at')
			    ->where('sales.affiliate_link_used',$aff_link)
                ->get();

            $host = request()->getHost();
            $scheme = request()->getScheme();
			$endpoint = [ 'membership' => 'purple-register', 'retail' => 'product-retail'];
            $aff_link=$scheme."://".$host .'/' . $endpoint[$type] . '/'.$aff_link;
            return view('user.affiliate.index',compact('auth_id','user_data','aff_link','member_data','package', 'type','retail_data'));
        }
        
    }



   
}
