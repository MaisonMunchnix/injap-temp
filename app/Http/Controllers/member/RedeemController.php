<?php

namespace App\Http\Controllers\member;


use App\User;
use App\UserInfo;
use App\RedeemTransaction;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use DataTables;

class RedeemController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function view(){
        $auth_id =Auth::id();
        $total_points = $this->totalPoints();
        $total_reward = $total_balance = $total_redeemed = 0;
        $has_redeem = false;
        $total_reward = number_format($this->totalPoints(),2);
        $total_redeemed = number_format($this->totalRedeemed(),2);
        $total_balance = number_format($this->totalPoints() - $this->totalRedeemed(),2);
        return view('user.redeem.index',compact('auth_id','total_reward','total_balance','total_redeemed','has_redeem','total_points'));  
    }
    
    public function getProducts(Request $request){
        if ($request->ajax()) {
            $user_id = Auth::id();
            
            $products = DB::table('products')
                ->leftJoin('product_categories', 'products.category', 'product_categories.id')
                ->select('products.*', 'product_categories.name as category_name')
                ->where('products.status',1)
                ->where('products.category',2)
                ->get();

            return Datatables::of($products)
                ->editColumn('image', function($products){
                    $url = asset($products->image);
                    return '<img src="'.$url.'" border="0" width="40" class="img-rounded" align="center" />';
                })
                ->addColumn('action', function($products){
                    return "<div class='dropdown'>
                        <button class='btn btn-primary dropdown-toggle' type='button' data-toggle='dropdown'>Action </button>
                        <div class='dropdown-menu'>
                            <a href='#' class='dropdown-item btn-view-product' data-id='$products->id'>View</a>
                            <a href='#' class='dropdown-item btn-redeem' data-id='$products->id' data-point='$products->price' data-name='$products->name'>Redeem</a>
                        </div>
                    </div>";

                    })
                ->rawColumns(['image','description','action'])
                ->make(true);
         }
    }
    
    public function getRedeemedProducts(Request $request){
        if ($request->ajax()) {
            $user_id = Auth::id();
            
            $products = DB::table('redeem_transactions')
                ->join('products', 'products.id', '=', 'redeem_transactions.product_id')
                ->select('redeem_transactions.*', 'products.name')
                ->where('redeem_transactions.user_id',$user_id)
                ->get();

            return Datatables::of($products)
                ->editColumn('status', function($products){
                    if($products->status == 0){
                        $label = "<span class='badge badge-warning text-white'>Pending</span>";
                    } else if($products->status == 1){
                         $label = "<span class='badge badge-success'>Approved</span>";
                    } else {
                         $label = "<span class='badge badge-danger'>Rejected</span>";
                    }
                    return $label;                
                })
                ->rawColumns(['status'])
                ->make(true);
         }
    }

    public function getRedeemedPV(Request $request){
        if ($request->ajax()) {
            $user_id = Auth::id();
            
            $redeem_pv = DB::table('redeem_transactions')
                ->where('user_id',$user_id)
                ->where('product_id',0)
                ->get();

            return Datatables::of($redeem_pv)
                ->editColumn('status', function($redeem_pv){
                    if($redeem_pv->status == 0){
                        $label = "<span class='badge badge-warning text-white'>Pending</span>";
                    } else if($redeem_pv->status == 1){
                         $label = "<span class='badge badge-success'>Approved</span>";
                    } else {
                         $label = "<span class='badge badge-danger'>Rejected</span>";
                    }
                    return $label;                
                })
                ->rawColumns(['status'])
                ->make(true);
         }
    }
    

    public function viewProductRedeem($id){
        $redeem_product = DB::table('products')
            ->where('products.id',$id)
            ->first();
        return response()->json([
            'redeem_product' => $redeem_product
        ]);
    }

    public function requestRedeem(Request $request){
        $auth_id = Auth::id();
        $req_point = $request['point'];
        
        $validator = Validator::make($request->all(), [       
            'id' => 'required',
            'point' => 'required'
        ]);
        
        $balance = $this->totalPoints() - $this->totalRedeemed();
        $check_balance = $balance - $req_point;
        
        $check_status = DB::table('redeem_transactions')
            ->where('status',0)
            ->where('user_id', $auth_id)
            ->count();
        
        if($check_status >= 1){
            return response()->json([
                'message' => "You have pending redemption, please wait",
            ],400);
        }
        
        if($balance == 0){
            return response()->json([
                'message' => "You have 0 point to redeem!",
            ],400);
        }
        
        if($check_balance < 0){
            return response()->json([
                'message' => "You don't have enough points to redeem!"
            ],400);
        }

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Please check empty or invalid input fields.',
            ],400);
        }else{
            DB::beginTransaction();
            try {
                $redeem = new RedeemTransaction();
                $redeem->product_id = $request['id'];
                $redeem->points = $req_point;
                $redeem->user_id = $auth_id;
                $redeem->save();

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
    
    private function totalPoints(){
        $auth_id = Auth::id();
        $total_reward = 0;
        
        $get_total_referral = DB::table('referrals')
            ->select('amount')
            ->where('reward_type','points')
            ->where('user_id',$auth_id)
            ->sum('amount');
        
        if(!empty($get_total_referral)){
            $total_reward += $get_total_referral;
        }
        
        return $total_reward;
    }
    
    private function totalRedeemed(){
        $total_redeemed = 0.00;
        $total_redeemed =  RedeemTransaction::select('points')
            ->where('user_id',Auth::id())
            ->where('status',1)
            ->sum('points');
        
        return $total_redeemed;
    }
}
