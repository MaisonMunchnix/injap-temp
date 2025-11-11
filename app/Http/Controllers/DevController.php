<?php

namespace App\Http\Controllers;

use App\User;
use App\UserInfo;
use App\Referral;
use App\Encashment;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Mail;



class DevController extends Controller
{

    public function testEmail(){
        $data=['test'];
        Mail::send('email.send-code',$data, function($message) use ($data){
            $message->to('support@purplelife.ph');
            $message->subject("Test mail");         
        });
        
        if (count(Mail::failures()) > 0) {
            return response()->json([
                'message' => 'error',
            ],500);

        }else{
           
            return response()->json([
                'message' => 'OK',
            ],200);
        }
                
    }


   
}
