<?php

namespace App\Http\Controllers;

use App\User;
use App\UserLog;
use App\UserInfo;
use App\Referral;
use App\Encashment;
use App\Payment;
use App\Branch;
use App\Sale;
use App\UnilevelSale;
use App\IncomeTransfer;
use App\Product;
use Carbon\Carbon;
use App\PairingComputation;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;



class MemberEncashmentController extends Controller
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
        $affiliate_link = "";
        $get_aff_link=User::select('affiliate_link')->where('id',$auth_id)->first();
        if(!empty($get_aff_link)){
            $affiliate_link=$get_aff_link->affiliate_link;
        }
        
        
        $total_earnings=0;
        $total_withdrawable=0;
        $total_balance=0;
        $total_encashment=0;
        $unilevel=0;
        //total earnings
        // $get_total_earnings=Referral::select('amount')->where('user_id',$auth_id)->where('referral_type','!=','fifth_activation_cost_reward')->where('reward_type','php')->sum('amount');

        //before
        // $get_total_earnings=Referral::select('amount')->where('user_id',$auth_id)->where('referral_type','!=','fifth_activation_cost_reward')->where('reward_type','php')->sum('amount');
        $get_total_earnings=Referral::select('amount')->where('user_id',$auth_id)->where('referral_type','!=','fifth_activation_cost_reward')
        ->where('referral_type','!=','sales_match_bonus')
        ->where('reward_type','php')->sum('amount');
        
        if(!empty($get_total_earnings)){
            $total_earnings+=$get_total_earnings;
        }
        //total withdrawable
        //$get_total_withdrawable=Referral::select('amount')->where('user_id',$auth_id)->where('referral_type','!=','fifth_activation_cost_reward')->sum('amount');
        $get_total_withdrawable=Referral::select('amount')->where('user_id',$auth_id)->where('referral_type','!=','fifth_activation_cost_reward')
            ->where('referral_type','!=','sales_match_bonus')
            ->where('reward_type','php')->sum('amount');
        if(!empty($get_total_withdrawable)){
            $total_withdrawable+=$get_total_withdrawable;
        }
        $myPair = new PairingComputation();
        $pairBonus = $myPair->pairing_count();
        $total_withdrawable += $pairBonus;
        $total_earnings += $pairBonus;



        //query of unilevel sales 
        $get_uni_sale=UnilevelSale::select('total_price')->where('user_id',$auth_id)->sum('total_price');
        if(!empty($get_uni_sale)){
            $total_withdrawable+=$get_uni_sale;
            $total_earnings+=$get_uni_sale;
        }

        //total commission
        $total_commission=DB::table('sales')
            ->join('orders', 'orders.sale_id', '=', 'sales.id')
            ->join('payments', 'payments.sale_id', '=', 'sales.id')
            ->select('orders.commission')
            ->where('sales.affiliate_link_used',$affiliate_link)
            ->where('sales.products_released',1)
            ->where('payments.is_paid',1)
            ->sum('commission');
        if(!empty($total_commission)){
            $total_withdrawable += $total_commission;
            $total_earnings += $total_commission;
        }

        //Total transfer
        $transfer = IncomeTransfer::select('amount','new_amount','from_user_id','to_user_id')
            ->where('from_user_id',$auth_id)
            ->orWhere('to_user_id',$auth_id)
            ->where('status',1)
            ->get();

        $total_sent = $transfer->where('from_user_id',$auth_id)->sum('amount');
        $total_receive = $transfer->where('to_user_id',$auth_id)->sum('new_amount');

        if(!empty($total_receive)){
            $total_withdrawable += $total_receive;
            $total_earnings += $total_receive;
        }

        // total_balance
        
        //total withdrawable
        $total_balance=$total_earnings;
        $get_total_encashment=Encashment::select('amount_approved')->where('user_id',$auth_id)->where('status','claimed')->sum('amount_approved');
        $total_encashment=$get_total_encashment;
        if(!empty($get_total_encashment)){
            if($total_balance>$get_total_encashment){
                $total_balance=$total_balance-$get_total_encashment;
            }else{
                $total_balance=$get_total_encashment-$total_balance;
            }
            
        }

        if(!empty($total_sent)){
            $total_balance = $total_balance - $total_sent;
        }


        

        //total bought using ewallet
        $get_pay_ewallet=DB::table('sales')
            ->join('payments', 'payments.sale_id', '=', 'sales.id')
            ->select('sales.total')
            ->where('sales.user_id',$auth_id)           
            ->where('sales.products_released',1)
            ->where('payments.driver','EWalletPaymentGateway')
            ->where('payments.is_paid',1)   
            ->sum('total');
        if(!empty($get_pay_ewallet)){
            $total_balance=$total_balance-$get_pay_ewallet;
        }
        
        $EWalletPaymentGateway=DB::table('sales')
        ->join('orders', 'orders.sale_id', '=', 'sales.id')
        ->join('payments', 'payments.sale_id', '=', 'sales.id')
        ->join('products', 'products.id', '=', 'orders.product_id')
        ->select('payments.created_at','payments.id','products.name','payments.amount','payments.updated_at','sales.products_released')
        ->where('payments.driver','EWalletPaymentGateway')
        /* ->where('sales.products_released',1) */
        ->where('payments.is_paid',1)
        ->where('sales.user_id',$auth_id) 
        ->get();


        $get_encashment=Encashment::where('user_id',$auth_id)->orderBy('updated_at','DESC')->get();

        $branches = Branch::select('id','name')->get();

        //return $total_withdrawable;
        return view('user.encashment.index',compact('auth_id','total_earnings','total_withdrawable','get_encashment','total_balance','total_encashment','EWalletPaymentGateway','branches'));  
    }
    
    public function weeklyEncashment(Request $request){
        $auth_id =Auth::id();
        
        
        //$affiliate_link="";
        //$get_aff_link=User::select('affiliate_link')->where('id',$auth_id)->first();
        //if(!empty($get_aff_link)){
        //    $affiliate_link=$get_aff_link->affiliate_link;
        //}
        
        
        $total_earnings=0;
        $total_withdrawable=0;
        $total_balance=0;
        $total_encashment=0;
        $unilevel=0;
        //total earnings
        
        //Weekly Income
        $current = Carbon::now();
        $today = $current->format('Y-m-d H:i:s');
        $weekStartDate = $current->startOfWeek(Carbon::TUESDAY)->format('Y-m-d H:i:s');
        $weekEndDate = $current->endOfWeek(Carbon::MONDAY)->format('Y-m-d H:i:s');
        
        
        
        $get_total_earnings = Referral::select('amount')
            ->where('user_id',$auth_id)
            ->where('referral_type','activation_cost_reward')
            ->whereBetween('created_at', [$weekStartDate, $weekEndDate])
            ->sum('amount');
        if(!empty($get_total_earnings)){
            $total_earnings += $get_total_earnings;
        }
        
        //query of unilevel sales 
        /*$get_uni_sale=UnilevelSale::select('total_price')
            ->where('user_id',$auth_id)
            ->whereBetween('created_at', [$weekStartDate, $weekEndDate])
            ->sum('total_price');
        
        if(!empty($get_uni_sale)){
            $total_withdrawable+=$get_uni_sale;
            $total_earnings+=$get_uni_sale;
        }

        //total commission
        $total_commission=DB::table('sales')
            ->join('orders', 'orders.sale_id', '=', 'sales.id')
            ->join('payments', 'payments.sale_id', '=', 'sales.id')
            ->select('orders.commission')
            ->where('sales.affiliate_link_used',$affiliate_link)
            ->where('sales.products_released',1)
            ->where('payments.is_paid',1)
            ->whereBetween('sales.created_at', [$weekStartDate, $weekEndDate])
            ->sum('commission');
        if(!empty($total_commission)){
            $total_withdrawable += $total_commission;
            $total_earnings += $total_commission;
        }*/
        
        //total withdrawable
        $total_balance = $total_earnings;
        $get_total_encashment = Encashment::select('amount_approved')->where('user_id',$auth_id)->where('reasons','auto_encashment')->sum('amount_approved');
        $total_encashment=$get_total_encashment;
        if(!empty($get_total_encashment)){
            if($total_balance > $get_total_encashment){
                $total_balance = $total_balance - $get_total_encashment;
            }
            
        }


        

        //total bought using ewallet
        /*$get_pay_ewallet=DB::table('sales')
            ->join('payments', 'payments.sale_id', '=', 'sales.id')
            ->select('sales.total')
            ->where('sales.user_id',$auth_id)           
            ->where('sales.products_released',1)
            ->where('payments.driver','EWalletPaymentGateway')
            ->where('payments.is_paid',1)   
            ->sum('total');
        if(!empty($get_pay_ewallet)){
            $total_balance=$total_balance-$get_pay_ewallet;
        }
        
        $EWalletPaymentGateway=DB::table('sales')
        ->join('orders', 'orders.sale_id', '=', 'sales.id')
        ->join('payments', 'payments.sale_id', '=', 'sales.id')
        ->join('products', 'products.id', '=', 'orders.product_id')
        ->select('payments.created_at','payments.id','products.name','payments.amount','payments.updated_at','sales.products_released')
        ->where('payments.driver','EWalletPaymentGateway')
         ->where('sales.products_released',1) 
        ->where('payments.is_paid',1)
        ->where('sales.user_id',$auth_id) 
        ->get();*/


        $get_encashment = Encashment::where('user_id',$auth_id)->where('reasons','auto_encashment')->orderBy('updated_at','DESC')->get();

        //return $total_withdrawable;
        return view('user.encashment.weekly_encashment',compact('auth_id','get_encashment','total_encashment','total_balance'));  
    }

    public function viewEwallet(){
        $auth_id =Auth::id();
        $User_data = User::where('id',$auth_id)->get();
        $affiliate_link="";
        /* $get_aff_link=User::select('affiliate_link')->where('id',$auth_id)->first();
        if(!empty($get_aff_link)){
            $affiliate_link=$get_aff_link->affiliate_link;
        } */
        
        $total_earnings=0;
        $total_withdrawable=0;
        $total_balance=0;
        $total_encashment=0;
        $unilevel=0;
        //total earnings
        $get_total_earnings=Referral::select('amount')->where('user_id',$auth_id)->sum('amount');
        if(!empty($get_total_earnings)){
            $total_earnings+=$get_total_earnings;
        }
        //total withdrawable
        $get_total_withdrawable=Referral::select('amount')->where('user_id',$auth_id)->where('referral_type','!=','fifth_activation_cost_reward')->sum('amount');
        if(!empty($get_total_withdrawable)){
            $total_withdrawable+=$get_total_withdrawable;
        }

        //query of unilevel sales 
        $get_uni_sale=UnilevelSale::select('total_price')->where('user_id',$auth_id)->sum('total_price');
        if(!empty($get_uni_sale)){
            $total_withdrawable+=$get_uni_sale;
            $total_earnings+=$get_uni_sale;
        }

        //total commission
        /* $total_commission=DB::table('sales')
            ->join('orders', 'orders.sale_id', '=', 'sales.id')
            ->join('payments', 'payments.sale_id', '=', 'sales.id')
            ->select('orders.commission')
            ->where('sales.affiliate_link_used',$affiliate_link)
            ->where('sales.products_released',1)
            ->where('payments.is_paid',1)
            ->sum('commission');
        if(!empty($total_commission)){
            $total_withdrawable+=$total_commission;
            $total_earnings+=$total_commission;
        } */
        
        //total withdrawable
        $total_balance=$total_earnings;
        $get_total_encashment=Encashment::select('amount_approved')->where('user_id',$auth_id)->where('status','claimed')->sum('amount_approved');
        $total_encashment=$get_total_encashment;
        if(!empty($get_total_encashment)){
            if($total_balance>$get_total_encashment){
                $total_balance=$total_balance-$get_total_encashment;
            }else{
                $total_balance=$get_total_encashment-$total_balance;
            }
            
        }


        

        //total bought using ewallet
        $get_pay_ewallet=DB::table('sales')
            ->join('payments', 'payments.sale_id', '=', 'sales.id')
            ->select('sales.total')
            ->where('sales.user_id',$auth_id)           
            ->where('sales.products_released',1)
            ->where('payments.driver','EWalletPaymentGateway')
            ->where('payments.is_paid',1)   
            ->sum('total');
        if(!empty($get_pay_ewallet)){
            $total_balance=$total_balance-$get_pay_ewallet;
        }
        
        $EWalletPaymentGateway=DB::table('sales')
        ->join('orders', 'orders.sale_id', '=', 'sales.id')
        ->join('payments', 'payments.sale_id', '=', 'sales.id')
        ->join('products', 'products.id', '=', 'orders.product_id')
        ->select('payments.created_at','payments.id','products.name','payments.amount','payments.updated_at','sales.products_released')
        ->where('payments.driver','EWalletPaymentGateway')
        ->where('payments.is_paid',1)
        ->where('sales.user_id',$auth_id) 
        ->get();


        $get_encashment=Encashment::where('user_id',$auth_id)->orderBy('updated_at','DESC')->get();

        //$products=Product::where('status',1)->get();


        $products = DB::table('products')
        ->join('product_discounts', 'product_discounts.product_id', '=', 'products.id')
        ->where('products.status',1)
        ->where('product_discounts.package_type',$User_data[0]->member_type)
        ->get();

        //return view('user.encashment.ewallet',compact('auth_id'));  
        return view('user.encashment.ewallet',compact('auth_id','total_earnings','total_withdrawable','get_encashment','total_balance','total_encashment','EWalletPaymentGateway','products'));  
    }

    public function purchaseEwallet($id){
        $product_id=$id;
        $auth_id =Auth::id();
        $affiliate_link="";
        /* $get_aff_link=User::select('affiliate_link')->where('id',$auth_id)->first();
        if(!empty($get_aff_link)){
            $affiliate_link=$get_aff_link->affiliate_link;
        } */
        
        $total_earnings=0;
        $total_withdrawable=0;
        $total_balance=0;
        $total_encashment=0;
        $unilevel=0;
        //total earnings
        $get_total_earnings=Referral::select('amount')->where('user_id',$auth_id)->sum('amount');
        if(!empty($get_total_earnings)){
            $total_earnings+=$get_total_earnings;
        }
        //total withdrawable
        $get_total_withdrawable=Referral::select('amount')->where('user_id',$auth_id)->where('referral_type','!=','fifth_activation_cost_reward')->sum('amount');
        if(!empty($get_total_withdrawable)){
            $total_withdrawable+=$get_total_withdrawable;
        }

        //query of unilevel sales 
        $get_uni_sale=UnilevelSale::select('total_price')->where('user_id',$auth_id)->sum('total_price');
        if(!empty($get_uni_sale)){
            $total_withdrawable+=$get_uni_sale;
            $total_earnings+=$get_uni_sale;
        }

        //total commission
        /* $total_commission=DB::table('sales')
            ->join('orders', 'orders.sale_id', '=', 'sales.id')
            ->join('payments', 'payments.sale_id', '=', 'sales.id')
            ->select('orders.commission')
            ->where('sales.affiliate_link_used',$affiliate_link)
            ->where('sales.products_released',1)
            ->where('payments.is_paid',1)
            ->sum('commission');
        if(!empty($total_commission)){
            $total_withdrawable+=$total_commission;
            $total_earnings+=$total_commission;
        } */
        
        //total withdrawable
        $total_balance=$total_earnings;
        $get_total_encashment=Encashment::select('amount_approved')->where('user_id',$auth_id)->where('status','claimed')->sum('amount_approved');
        $total_encashment=$get_total_encashment;
        if(!empty($get_total_encashment)){
            if($total_balance>$get_total_encashment){
                $total_balance=$total_balance-$get_total_encashment;
            }else{
                $total_balance=$get_total_encashment-$total_balance;
            }
            
        }


        

        //total bought using ewallet
        $get_pay_ewallet=DB::table('sales')
            ->join('payments', 'payments.sale_id', '=', 'sales.id')
            ->select('sales.total')
            ->where('sales.user_id',$auth_id)           
            ->where('sales.products_released',1)
            ->where('payments.driver','EWalletPaymentGateway')
            ->where('payments.is_paid',1)   
            ->sum('total');
        if(!empty($get_pay_ewallet)){
            $total_balance=$total_balance-$get_pay_ewallet;
        }
        
        $EWalletPaymentGateway=DB::table('sales')
        ->join('orders', 'orders.sale_id', '=', 'sales.id')
        ->join('payments', 'payments.sale_id', '=', 'sales.id')
        ->join('products', 'products.id', '=', 'orders.product_id')
        ->select('payments.created_at','payments.id','products.name','payments.amount','payments.updated_at','sales.products_released')
        ->where('payments.driver','EWalletPaymentGateway')
        ->where('payments.is_paid',1)
        ->where('sales.user_id',$auth_id) 
        ->get();


        $get_encashment=Encashment::where('user_id',$auth_id)->orderBy('updated_at','DESC')->get();

        $products=Product::where('status',1)->where('id',$product_id)->get();

      

        //return view('user.encashment.ewallet',compact('auth_id'));  
        return view('user.encashment.purchase',compact('auth_id','total_earnings','total_withdrawable','get_encashment','total_balance','total_encashment','EWalletPaymentGateway','products'));  
    }

    public function requestEncashment(Request $request){
        $auth_id =Auth::id();
        //return $auth_id;
        $validator = Validator::make($request->all(), [       
            'branch' => 'required',
            'amount' => 'required',
            'password' => 'required',
            'option' => 'required'
        ]);
        $encashment_count=Encashment::where('user_id',$auth_id)
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
            $tax= $request['amount'] * 0.10;
            DB::beginTransaction();
            try {
                $encashment = new Encashment();
                $encashment->user_id = $auth_id;
                $encashment->branch_id = $request['branch'];
                $encashment->cashout_option = $request['option'];
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
