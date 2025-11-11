<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use DB;
use Auth;

class AccountSwitcherController extends Controller
{
    public function changeUser($id){
        $current_user = DB::table('user_infos')
            ->select('first_name', 'middle_name','last_name')
            ->where('user_id', Auth::id())
            ->first();
            
        $new_user = DB::table('user_infos')
            ->where('first_name', $current_user->first_name)
            ->where('last_name', $current_user->last_name)
            ->where('middle_name', $current_user->middle_name)
            ->where('user_id', $id)
            ->first();
        
        /*$user = User::where('group_id', Auth::user()->group_id)
            ->where('id', $id)
            ->first();*/
        
        if($new_user){
            Auth::logout();
            $user = User::findOrFail($id);
            Auth::login($user);
        }
        
        return redirect()->back();
    }
}
