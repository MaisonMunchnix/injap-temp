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



class DirectReferralController extends Controller
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



    public function viewReferral($type){
        date_default_timezone_set('Asia/Manila');
        $auth_id =Auth::id();
        $auth_sponsor = Network::where('sponsor_id',$auth_id)->get();
        $result_data=array();// create array for downline data
        foreach($auth_sponsor as $data){
            $user_data = DB::table('users')
			    ->join('user_infos', 'user_infos.user_id', '=', 'users.id')
                ->join('packages', 'packages.id', '=', 'users.account_type')
			    ->select('users.created_at AS user_created_at','user_infos.first_name','user_infos.last_name','packages.type AS account_type')
			    ->where('users.id',$data->user_id)
                ->first();
            $user_placement = UserInfo::select('first_name','last_name')->where('user_id',$data->upline_placement_id)->first();
            $down_name = $user_data->first_name." ".$user_data->last_name;
            $placement_name = $user_placement->first_name." ".$user_placement->last_name;
            $account_type=$user_data->account_type;
            $reg_date=$user_data->user_created_at;
            $position=$data->placement_position;

            $temp_data=array('name'=>$down_name,'acc_type'=>$account_type,'placement'=>$placement_name,'placement_position'=>$position,'reg_date'=>$reg_date);
            array_push($result_data,$temp_data);
        }
        return view('user.direct-referral.index',compact('auth_id','result_data'));
        
    }



   
}
