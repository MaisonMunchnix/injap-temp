<?php
namespace App\Http\Composers;
use Illuminate\View\View;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\UserInfo;
use App\UserPrivelege;
use App\Referral;
use App\PairingComputation;
use Gloudemans\Shoppingcart\Facades\Cart;

class UserComposer {
    protected $users;
    public function __contruct(UserRepository $users){
        $this->users = $users;
    } 
    public function Compose (View $view){
        $auth_id =Auth::id();
        $access_data="";
        $privelege=UserPrivelege::where('user_id',Auth::id())->first();
        if(!empty($privelege)){
            $access_data=json_decode($privelege['privelege']);
        }
        $user_data = DB::table('users')
			->join('user_infos', 'user_infos.user_id', '=', 'users.id')
            ->join('packages', 'packages.id', '=', 'users.account_type')
			->select('users.id AS user_id','users.created_at AS user_created_at','users.*','user_infos.*','packages.type AS package_type')
			->where('users.id',$auth_id)
            ->first();
        $package_type = '';
        


        if($user_data){
            $switch_accounts = DB::table('users')
                ->select('users.id', 'users.username')
                ->join('user_infos','users.id','=','user_infos.user_id')
                ->where('user_infos.first_name', $user_data->first_name)
                ->where('user_infos.last_name', $user_data->last_name)
                ->where('user_infos.middle_name', $user_data->middle_name)
                ->where('users.username', '!=', $user_data->username)
                ->get();
            
            if($user_data->userType == 'user'){
            if($user_data->member_type == 'distributor'){
                $package = DB::table('packages')->select('type')->where('id', 2)->first();
                $package_type = $package->type;
            } else {
                $package_type = ucwords($user_data->member_type);
            }
        }
        } else {
            $switch_accounts = [];
        }
        
            
        // $TPBunos = DB::table('referrals')                      
        //     ->where('user_id',$auth_id) 
        //     ->where('referral_type','sales_match_bonus')                
        //     ->sum('amount');

        $myPair = new PairingComputation();
        $TPBunos = $myPair->pairing_count().".00";;

        $TPRPoints = DB::table('referrals')                      
            ->where('user_id',$auth_id) 
            ->where('referral_type','activation_cost_reward')                
            ->sum('amount');
     
        $TPMatch=Referral::where('user_id',$auth_id)->where('referral_type','activation_cost_reward')->count();

        $Total_Direct_Referral = Referral::select('amount')
            ->where('user_id',$auth_id)
            ->where('referral_type','direct_referral_bonus')
            ->sum('amount');
             
        $pv_points = DB::table('pv_points')->where('user_id',$auth_id)->first();
        $view->with('global_user_data',$user_data);
        $view->with('global_package_type',$package_type); //Package Type
        $view->with('switch_accounts',$switch_accounts);
        $view->with('access_data',$access_data);
        $view->with('pv_points',$pv_points);
        $view->with('TPBunos',$TPBunos);
        $view->with('TPRPoints',$TPRPoints);
        $view->with('TPMatch',$TPMatch);
        $view->with('Total_Direct_Referral',$Total_Direct_Referral);
        $view->with('cart',Cart::instance(Auth::user()));
    }
}