<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AdminDashboardController extends Controller
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
    
     public function index(){
        $today = Carbon::today();
        
        $pairs = DB::table('referrals')
            ->where('referral_type', 'activation_cost_reward')
            ->whereDate('referrals.created_at', $today)
            ->count();

        $currencies = DB::table('currencies')->select('id','sell','buy')->get();
        $yen = $currencies->where('id',1)->first();
        $hkd = $currencies->where('id',2)->first();
        $usd = $currencies->where('id',3)->first();
        
        return view('admin.dashboard.index', compact('pairs','yen', 'hkd', 'usd'));
    }
    
    public function filterCount(Request $request){
        $type = $request->type;
        $date_from = $request->date_from;
        $date_to = $request->date_to;
        
        if($type == 'pair'){
            $count = DB::table('referrals')
                ->where('referral_type', 'activation_cost_reward')
                ->whereBetween('referrals.created_at', [$date_from . ' 00:00:00', $date_to . ' 23:59:59'])
                ->count();
        } else {
            $count = DB::table('users')
                ->join('packages','users.account_type', 'packages.id')
                ->where('packages.amount', '>',0)
                ->where('users.userType', 'user')
                ->whereBetween('users.created_at', [$date_from . ' 00:00:00', $date_to . ' 23:59:59'])
                ->count();
        }
        
        return response()->json([
            'count' => $count . ' '. ucfirst($type),
        ],200);
        
    }

    public function pvchecker(){
         $pairing_checkers_sponsor = DB::table('pairing_checkers')
        ->select('users.username as source')
        ->join('users', 'users.id', '=', 'pairing_checkers.source_id')
        //->where('users.id', '=', 'pairing_checkers.user_id')
       // ->where('users.id', '=', 'pairing_checkers.source_id')
        ->get();
       
         $pairing_checkers = DB::table('pairing_checkers')
        ->select('users.username as username','pairing_checkers.*')
        ->join('users', 'users.id', '=', 'pairing_checkers.user_id')
        /* ->where('pairing_checkers.user_id',144) */
        ->get();
        $datas=[];
        foreach ($pairing_checkers as  $value) {
            $pairing_checkers_sponsor = DB::table('users')->where('id',$value->source_id)->first();
            $datas[] = [            
            'username' =>$value->username,
            'source' =>$pairing_checkers_sponsor->username,
            'PV_Point' =>$value->pv_point,
            'left' =>$value->left,
            'right' =>$value->right,
            'amount' =>$value->amount,
            'cycle' =>$value->cycle,
            'cycle_time' =>$value->cycle_time,
            'fifth_pair' =>$value->fifth_pair,
            'created_at' =>$value->created_at,

            
           
        ];
        }
/*        
        foreach ($datas as  $value) {
            return $value['username'];
        } */
        return view('admin.pvChecker.pvchecker',compact('datas'));
        
        
    }
}
