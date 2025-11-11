<?php

namespace App\Http\Controllers\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use App\User;
use App\UserInfo;
use App\UserLog;
use Session;
use Mail;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Http\Update;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }
    
    public function getForgotPassword(){
        return view('auth/passwords/email');

	}
    
    public function resetPassword(Request $request){
        
        DB::beginTransaction();
		try {
            $username = $request->username;
            $user = DB::table('users')
                ->leftJoin('user_infos','users.id','=','user_infos.user_id')
                ->select('users.id','users.username','users.email',DB::raw('CONCAT(user_infos.first_name," ",user_infos.last_name) as full_name'))
                ->where('users.status',1)
                ->where(function ($query) use ($username) {
                    $query->where('users.username', $username);
                    $query->orWhere('users.email', $username);
                })->first();
            
            if(!empty($user)){
                DB::table('password_resets')->insert([
                    'email' => $user->email,
                    'token' => Str::random(60),
                    'ip_address' => $_SERVER['REMOTE_ADDR']
                ]);
                
                $tokenData = DB::table('password_resets')
                    ->where('email', $user->email)
                    ->where('status', 1)
                    ->first();
                
                $email_data=[];
                $email_data = ['email' =>  $user->email,'full_name' =>  $user->full_name, 'reset_code' => $tokenData->token];
                Mail::send('email.send-reset-code',$email_data, function($message) use ($email_data){
                    $message->to($email_data['email']);
                    $message->subject( env('APP_NAME') . " | Password Reset Code");         
                });
                
                $user_log =  new UserLog();
                $user_log->user_id = $user->id;
                $user_log->description = 23; // Description ID
                $user_log->status = "Sucess"; 
                $user_log->ip_address = $_SERVER['REMOTE_ADDR'];
                $user_log->save();
                    
                DB::commit();
                return response()->json([
                    'message' => 'sucess'
                ]);
            } else {
                return response()->json([
                    'message' => 'Account not Found'
                ],400);
            }
            
        }catch(\Throwable $e){
            DB::rollback();
			// Insert User Log Error
            $users = User::select('id')->where('email', $username)->orWhere('username',$username)->first();
			$user_log =  new UserLog();
			$user_log->user_id = $users->id;
			$user_log->description = 23; // Description ID
			$user_log->status = "Error"; 
			$user_log->error = $e->getMessage();
            $user_log->ip_address = $_SERVER['REMOTE_ADDR'];
			$user_log->save();
            return response()->json([
                'message' => $e->getMessage(),
            ],400);
        }
	}
    
    public function resetPasswordUpdate(Request $request){
        $email = $request->email;
        $password = $request->password;
        $password_confirm = $request->password_confirm;
        $users = User::where('email', $email)->first();
        DB::beginTransaction();
		try {

            
            $tokenData = DB::table('password_resets')->where('token', $request->token)->where('email',$email)->first();
            if (!$tokenData){
                return view('auth.passwords.email');
            }
            $user = User::where('email', $tokenData->email)->first();
            $user_info = UserInfo::where('user_id', $user->id)->first();
            if (!$user){
                return response()->json([
                    'message' => 'Account not found',
                ],400);
            } else {
                $user->password = \Hash::make($password);
                $user->plain_password = $password;
                $user->update(); 
                
                DB::table('password_resets')->where('email', $user->email)->delete();
                
                $email_data=[];
                $email_data = ['email' =>  $user->email,'full_name' =>  "$user_info->first_name $user_info->last_name"];
                Mail::send('email.password-updated-confirmation',$email_data, function($message) use ($email_data){
                    $message->to($email_data['email']);
                    //$message->cc('support@purplelife.ph');
                    $message->subject( env('APP_NAME') . " | " . $email_data['full_name'] . "'s password changed");         
                });
                
                $user_log =  new UserLog();
                $user_log->user_id = $user->id;
                $user_log->description = 24; // Description ID
                $user_log->status = "Sucess"; 
                $user_log->ip_address = $_SERVER['REMOTE_ADDR'];
                $user_log->save();
                
                
                DB::commit();
                //Auth::login($user);
                return response()->json([
                    'message' => 'sucess'
                ],200);
            }
            
        }catch(\Throwable $e){
            DB::rollback();
            // Insert User Log Error
            $user_log =  new UserLog();
            $user_log->user_id = $users->id;
            $user_log->description = 24; // Description ID
            $user_log->status = "Error"; 
            $user_log->error = $e->getMessage();
            $user_log->ip_address = $_SERVER['REMOTE_ADDR'];
            $user_log->save();
            return response()->json([
                'message' => $e->getMessage(),
            ],400);
        }
    }
    
}
