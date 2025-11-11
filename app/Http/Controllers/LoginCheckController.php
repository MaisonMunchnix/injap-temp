<?php

namespace App\Http\Controllers;

use App\UserLog;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class LoginCheckController extends Controller
{
   
	function check($user){
		$users = DB::table('users')->select('userType')->where('username',$user)->orWhere('email',$user)->first();
		$type=0;
		if(!empty($users)){
			if($users->userType=='user'){
				$type=1; //member
			}else if($users->userType=='staff'){
				$type=2; //admin
			}else{
				$type=3; //teller
			}
		}
		return response()->json([
			'type' => $type
		]);
	}

	function error(Request $request){
		return response()->json([
			'message' => 'error'
		],400);
	}
   
}
