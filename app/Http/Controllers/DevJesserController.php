<?php

namespace App\Http\Controllers;

use App\User;
use App\UserInfo;
use App\ProductCode;
use App\Network;
use App\Referral;
use App\PvPoint;
use Session;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Http\Update;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DevJesserController extends Controller
{

	public function getRegister(){
		return view('view.member_register_dev');
	}

	

	public function checkRegisteredUsername($username){
		$check_user = DB::table('users')->where('username',$username)->first();
		$valid_username=false;
		if($check_user){
			$valid_username=true;
		}
		return response()->json([
			'valid_username' => $valid_username
        ]);
	}

	public function getExtensionAccount($username){
		$get_user = DB::table('users')->where('username',$username)->first();
		$valid_username=false;
		if($get_user){
			$valid_username=true;
			$user_id=$get_user->id;
			$get_user_info = DB::table('users')
						->join('user_infos', 'user_infos.user_id', '=', 'users.id')
						->select('email','first_name','last_name','middle_name','birthdate','mobile_no','mobile_no','province_id','city_id')
						->where('users.id',$user_id)
						->first();
			return response()->json([
				'result' => $get_user_info
			]);
		}else{
			$valid_username=false;
			return response()->json([
				'result' => $valid_username
			]);
		}
		
	}





	

}
