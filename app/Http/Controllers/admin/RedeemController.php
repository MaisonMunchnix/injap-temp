<?php

namespace App\Http\Controllers\admin;

use App\{User, RedeemTransaction};
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use DataTables;

class RedeemController extends Controller
{
    public function adminViewRedeem(Request $request){
        $date_start = str_replace('/','-',$request->input('date_start'));
        
        //redeem transaction
        $redeem_transactions = DB::table('redeem_transactions')
            ->join('products', 'products.id', '=', 'redeem_transactions.product_id')
            ->join('users', 'users.id', '=', 'redeem_transactions.user_id')
            ->join('user_infos', 'user_infos.id', '=', 'redeem_transactions.user_id')
            ->select('redeem_transactions.*', 'products.name', 'users.username', 'user_infos.first_name', 'user_infos.last_name')
            ->get();

        return view('admin.redeem.index',compact('redeem_transactions'));  
                
    }
    
    public function redeemedProducts(Request $request){
        if ($request->ajax()) {
            
            $products = DB::table('redeem_transactions')
                ->join('products', 'products.id', '=', 'redeem_transactions.product_id')
                ->join('users', 'users.id', '=', 'redeem_transactions.user_id')
                ->join('user_infos', 'user_infos.id', '=', 'redeem_transactions.user_id')
                ->select('redeem_transactions.*', 'products.name', 'users.username', 'user_infos.first_name', 'user_infos.last_name')
                ->get();

            return Datatables::of($products)
                ->editColumn('status', function($products){
                    if($products->status == 0){
                        $status = "<span class='badge badge-warning'>Pending</span>";
                    }else if($products->status == 1){
                        $status = "<span class='badge badge-success'>Approved</span>";
                    } else {
                        $status = "<span class='badge badge-danger'>Rejected</span>";
                    }
                    return $status;
                })
                ->addColumn('action', function($products){
                    
                    if($products->status == 0){
                        $redeem_buttons = "<a href='#' class='dropdown-item btn-process' data-id='$products->id' data-user='$products->username' data-item='$products->name' data-point='$products->points' data-action='approve'>Approve</a>
                        <a href='#' class='dropdown-item btn-process' data-id='$products->id' data-user='$products->username' data-item='$products->name' data-point='$products->points' data-action='cancel'>Cancel</a>";
                    } else {
                        $redeem_buttons = "";
                    }                   
                    return "<div class='dropdown'>
                                <button class='btn btn-primary dropdown-toggle' type='button' data-toggle='dropdown' aria-expanded='true'>Action </button>
                                    <div class='dropdown-menu'>
                                                <a href='#' class='dropdown-item btn-view' data-id='$products->id'>View</a>
                                                <a href='#' class='dropdown-item btn-remark' data-id='$products->id' data-user='$products->username' data-item='$products->name'>Remark</a>
                                                $redeem_buttons
                                            </div>
                                        </div>";

                    })
                ->rawColumns(['status','action'])
                ->make(true);
         }
    }

    public function adminProcessRedeem(Request $request){
        $auth_id = Auth::id();

        $validator = Validator::make($request->all(), [       
            'id' => 'required',
            'action' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Please check empty or invalid input fields.',
            ],400);
        }else{
            DB::beginTransaction();
            try {
                $status = 0;
                $action = $request['action'];
                $remark = $request['remark'];
                
                $redeem = RedeemTransaction::find($request['id']);
                
                if($action == 'approve'){
                    $status = 1;
                } else if($action == 'remark'){
                    $redeem->remark = $remark;
                } else {
                    $status = 2;
                }
                $redeem->status = $status;
                $redeem->process_by = $auth_id;
                $redeem->save();
                
                /*if(!empty($redeem->cash) || $redeem->cash > 0){
                    $total_cash = Referral::where('user_id',$redeem->user_id)
                        ->where('type','currency')
                        ->sum('amount');
                    
                    $total_encashments = Encashment::where('user_id',$redeem->user_id)
                        ->whereIn('status',['claimed','approved'])
                        ->sum('amount_approved');
                    
                    
                    
                    
                    $encash = new Encashment();
                    $encash->user_id = $redeem->user_id;
                    $encash->amount_requested = $redeem->cash;
                    $encash->current_balance = number_format(($total_cash - $total_encashments) + $redeem->cash);
                    $encash->tax = env('ENCASHMENT_TAX');
                    $encash->process_fee = env('PROCESSING_FEE');
                }*/

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

    public function viewRedeemRequest($id){
        $redeem_transactions = DB::table('redeem_transactions')
            ->join('products', 'products.id', '=', 'redeem_transactions.product_id')
            ->join('users', 'users.id', '=', 'redeem_transactions.user_id')
            ->join('user_infos', 'user_infos.id', '=', 'redeem_transactions.user_id')
            ->select('redeem_transactions.*', 'products.name', 'products.image', 'products.description', 'users.username', 'user_infos.first_name', 'user_infos.last_name')
            ->where('redeem_transactions.id',$id)
            ->first();

        return response()->json([
            'redeem_transactions' => $redeem_transactions
        ]);
                
    }
}
