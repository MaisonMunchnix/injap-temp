<?php

namespace App\Http\Controllers;

use App\User;
use App\UserInfo;
use App\ProductCode;
use App\Referral;
use App\Network;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;



class EncashmentController extends Controller
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



    public function viewEncashment($type){
        $auth_id =Auth::id();
        $user_data = DB::table('users')
			->join('user_infos', 'user_infos.user_id', '=', 'users.id')
            ->join('networks', 'networks.user_id', '=', 'users.id')
            ->join('packages', 'networks.package', '=', 'packages.id')
			->select('users.id AS user_id','users.created_at AS user_created_at','users.*','user_infos.*','networks.*','packages.type AS package_type')
			->where('users.id',$auth_id)
            ->first();
       
            
            return view('user.encashment.index',compact('auth_id','user_data'));
      
        
    }



   
}
