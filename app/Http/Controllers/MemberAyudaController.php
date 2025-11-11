<?php

namespace App\Http\Controllers;

use App\User;
use App\UserLog;
use App\UserInfo;
use App\Referral;
use App\Encashment;
use App\AyudaEncashment;
use App\Payment;
use App\Sale;
use App\UnilevelSale;
use App\AyudaSale;
use App\Product;
use Carbon\Carbon;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;



class MemberAyudaController extends Controller
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



    public function viewEncashment($type){
        $auth_id = Auth::id();
        
        $ayuda_tax = 0;
        $process_fee = 0;

        $get_encashments = AyudaEncashment::where('user_id',$auth_id)->orderBy('updated_at','DESC')->get();
        
        $get_total_encashment = $get_encashments->where('status','claimed')->sum('amount_approved');


        
        $ayuda_sales = AyudaSale::where('user_id',$auth_id)->where('status',1)->get();
        $total_balance = $ayuda_sales->sum('amount');
        
        if(!empty($get_total_encashment)){
            if($total_balance > $get_total_encashment){
                $total_balance = $total_balance - $get_total_encashment;
            }else{
                $total_balance = $get_total_encashment - $total_balance;
            }
            
        }
        
       

        //return $total_withdrawable;
        return view('user.encashment.ayuda-encashment',compact('auth_id','ayuda_tax','process_fee','ayuda_sales','get_encashments','get_total_encashment','total_balance'));  
    }
    

    public function requestEncashment(Request $request){
        $auth_id =Auth::id();
        //return $auth_id;
        $validator = Validator::make($request->all(), [       
            'amount' => 'required',
            'password' => 'required'
        ]);
        $encashment_count = AyudaEncashment::where('user_id',$auth_id)
        ->where(function ($query) {
			$query->where('status','pending')
				  ->orWhere('status','approved');
		})
        ->count();

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
            //$tax = $request['amount'] * 0.10;
            $tax = 0;
            DB::beginTransaction();
            try {
                $encashment = new AyudaEncashment();
                $encashment->user_id = $auth_id;
                $encashment->amount_requested = $request['amount'];
                $encashment->amount_approved = $request['amount'];
                $encashment->current_balance = $request['balance'];
                $encashment->tax = $tax;
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
