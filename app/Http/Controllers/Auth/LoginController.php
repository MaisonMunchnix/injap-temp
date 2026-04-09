<?php

namespace App\Http\Controllers\Auth;
use App\UserLog;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/tellers';

    /**
     * Get the post-authentication redirect path.
     *
     * @param \Illuminate\Http\Request $request
     * @return string
     */
    protected function redirectPath()
    {
        $user = Auth::user();
        
        if ($user->userType === 'staff') {
            return '/staff';
        } elseif ($user->userType === 'paymentApprover') {
            return '/staff/payments';
        } elseif ($user->userType === 'applicationApprover') {
            return '/staff/applications/pending';
        } elseif ($user->userType === 'productApprover') {
            return '/staff/admin/products/submissions/pending';
        } elseif ($user->userType === 'instructor') {
            return '/instructor';
        } elseif ($user->userType === 'tellers') {
            return '/tellers';
        } else {
            return '/user';
        }
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function login(Request $request)
    {
        $this->validateLogin($request);

        if (method_exists($this, 'hasTooManyLoginAttempts') &&
            $this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        $referrer = basename($request->headers->get('referer'));
        $user = DB::table('users')->select('userType','status')
            ->where('username', $request->username)
            ->orWhere('email', $request->username)
            ->first();
        $user_type="";
        
        if(!empty($user)){
            $user_type = $user->userType;
            
            // Check if user is deactivated (status 0 or 2 means inactive/deactivated)
            if($user->status == 0 || $user->status == 2){
                return redirect()
                    ->back()
                    ->withInput($request->only($this->username(), 'remember'))
                    ->withErrors(['username' => 'This account has been deactivated. Please contact support.']);
            }
        }
        /* if(!empty($user)){ */
            if($referrer == 'teller-login' && $user_type != 'tellers')
                return $this->sendFailedLoginResponse($request);

            if($referrer == 'admin-login' && $user_type != 'staff')
                return $this->sendFailedLoginResponse($request);

            if($referrer == 'member-login' && !in_array($user_type, ['user', 'instructor']))
                return $this->sendFailedLoginResponse($request);

            if ($this->attemptLogin($request)) {
                return $this->sendLoginResponse($request); //orginal
                //return $this->sendFailedLoginResponse($request);
            }
        /* }else{
            return $this->sendFailedLoginResponse($request);
        } */

        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
    }

    public function logout(Request $request)
    {
        $this->guard()->logout();
       // $request->session()->invalidate();
       // $this->loggedOut($request) ?: redirect('/login');
        Auth::logout();
        return redirect('/login');
    }
	
	function authenticated(Request $request, $user){
		/*$user->update([
			'last_login_at' => Carbon::now()->toDateTimeString(),
			'last_login_ip' => $request->getClientIp()
        ]);*/
        /* return response()->json([
			'test' => $request->url()
        ]); */
        
		// Insert User Log
		$user_log = new UserLog();
		$user_log->user_id = Auth::id();
		$user_log->description = 1; // Description ID
		$user_log->ip_address = $_SERVER['REMOTE_ADDR'];
		$user_log->save();
	}

    public function username(){
        $loginType=request()->input('username');
        $this->username=filter_var($loginType, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
        request()->merge([$this->username=>$loginType]);
		// Insert User Log
		/*$user_log = new UserLog();
		$user_log->user_id = Auth::id();
		$user_log->description = 20; // Description ID
		$user_log->ip_address = $_SERVER['REMOTE_ADDR'];
		$user_log->save();*/
        return property_exists($this,'username') ? $this->username : 'email';
    }
   
}
