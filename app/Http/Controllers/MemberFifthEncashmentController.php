<?php

namespace App\Http\Controllers;

use App\User;
use App\UserLog;
use App\UserInfo;
use App\Referral;
use App\Encashment;
use App\FifthEncashment;
use App\Payment;
use App\Sale;
use App\UnilevelSale;
use App\Product;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;



class MemberFifthEncashmentController extends Controller
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



    public function viewEncashment(){
        $auth_id = Auth::id();
        
        $total_earnings=0;
        $total_withdrawable=0;
        $total_balance=0;
        $total_encashment=0;
        //total earnings
        $get_total_earnings = Referral::select('amount')
            ->where('user_id',$auth_id)
            ->where('referral_type','fifth_activation_cost_reward')
            ->sum('amount');
        
        if(!empty($get_total_earnings)){
            $total_earnings+=$get_total_earnings;
        }
        
        //get approved encashment
        $get_total_approved_encashment = FifthEncashment::select('amount_approved')
            ->where('user_id',$auth_id)
            ->whereIn('status',['approved','claimed'])
            ->sum('amount_approved');

        $total_balance = $total_earnings - $get_total_approved_encashment;
        $total_encashment = $get_total_approved_encashment;

        $get_encashment = FifthEncashment::where('user_id',$auth_id)
            ->orderBy('updated_at','DESC')
            ->get();

        //return $total_withdrawable;
        return view('user.encashment.fifth_encashment',compact('auth_id','total_earnings','get_encashment','total_balance','total_encashment'));  
    }

    public function requestEncashment(Request $request){
        $auth_id = Auth::id();
        
        $type = $request->type;
        
        $validator = Validator::make($request->all(), [       
            'amount' => 'required',
            'password' => 'required'
        ]);
        
        
        
        $encashment_count = FifthEncashment::where('user_id',$auth_id)
            ->where('amount',$type)
            ->where(function ($query) {
                $query->where('status','pending')
                    ->orWhere('status','approved');
            })->count();

        $user = User::find($auth_id);
        $validate_pass='invalid';
        if (Hash::check($request['password'], $user->password)) {
            // Success
            $validate_pass='valid';
        }

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Please check empty or invalid input fields.',
            ],400);
        }else if($validate_pass=='invalid'){
            return response()->json([
                'message' => 'Password does not match.',
            ],400);
        }else if($encashment_count>=1){
            return response()->json([
                'message' => 'You already requested encashment, Please wait to approve before requesting again. Thank you',
            ],400);
        }else{
            //$tax = $request['amount']*0.10;
            $tax = 0;
            $process_fee = 0;
            
            DB::beginTransaction();
            try {
                $encashment = new FifthEncashment();
                $encashment->user_id = $auth_id;
                $encashment->amount = $type;
                $encashment->amount_requested = $request['amount'];
                $encashment->amount_approved = $request['amount'];
                $encashment->current_balance = $request['balance'];
                $encashment->tax = $tax;
                $encashment->process_fee = $process_fee;
                $encashment->process_by = 0;
                $encashment->status = 'pending';
                $encashment->save();

                DB::commit();
				return response()->json([
					'message' => 'ok',
				],200);

            }catch(\Throwable $e){
                DB::rollback();
                return response()->json([
                    'message' => $e->getMessage(),
                ],400);
            }
        }
        
    }

   
}
