<?php

namespace App\Http\Controllers\member;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use DataTables;
use App\User;
use App\UserInfo;
use App\Encashment;
use App\Referral;
use App\IncomeTransfer;
use App\PairingComputation;
use Illuminate\Support\Carbon;

class IncomeTransferController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $auth_id = Auth::id();
        $get_donations = DB::table('donations')->where('user_id',$auth_id)->get();
        $total_donations = DB::table('donations')->where('user_id',$auth_id)->where('status',1)->sum('amount');
       return view('user.income.index', compact('auth_id','get_donations','total_donations'));
    }

    public function transferHistories(Request $request){
        if ($request->ajax()) {
            $auth_id = Auth::id();
            $transfers = IncomeTransfer::where(function ($query) use ($auth_id) {
                $query->where('from_user_id', $auth_id)
                    ->orWhere('to_user_id', $auth_id);
            })
            ->get();

            return Datatables::of($transfers)
                ->addColumn('name', function($transfers) use($auth_id){
                    $userInfo = UserInfo::select('first_name', 'last_name')
                        ->where('user_id', $transfers->from_user_id == $auth_id ? $transfers->to_user_id : $transfers->from_user_id)
                        ->first();

                    if($userInfo){
                        $name = "{$userInfo->first_name} {$userInfo->last_name}";
                    } else {
                        $name = 'N/A';
                    }
                
                    return $name;
                })
                ->addColumn('type', function ($transfers) use ($auth_id) {
                    return ($transfers->from_user_id == $auth_id) ? "Sent" : "Received";
                })
                ->editColumn('amount', function ($transfers) use ($auth_id) {
                    $amount = ($transfers->from_user_id == $auth_id)
                        ? "<span class='text-danger'>-$transfers->amount</span>"
                        : "<span class='text-success'>+$transfers->new_amount</span>";
                    return $amount;
                })
                ->addColumn('created_at', function ($transfers) {
                    return $transfers->created_at->toDateTimeString();
                    //return Carbon::parse($transfers->created_at)->format('Y-m-d H:i:s');
                })
                ->rawColumns(['amount'])
                ->make(true);
         }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function totalIncome(){
        $auth_id = Auth::id();
    
        // Total accumulated income
        $total_accumulated = Referral::where('user_id', $auth_id)
            ->where('reward_type', 'php')
            ->where('referral_type','!=','sales_match_bonus')
            ->sum('amount');
        $myPair = new PairingComputation();
        $pairBonus = $myPair->pairing_count();
        $total_accumulated += $pairBonus;


        // Total encashment
        $total_encashment = Encashment::where('user_id', $auth_id)
            ->where('status', 'claimed')
            ->sum('amount_approved');
        
        $get_total_purchase = Auth::user()->getEWalletPurchases();
    
        // Total transfer
        $transfer = IncomeTransfer::where(function ($query) use ($auth_id) {
            $query->where('from_user_id', $auth_id)
                ->orWhere('to_user_id', $auth_id);
        })->where('status', 1)->get();
    
        // Calculate total sent and received amounts
        $total_sent = $transfer->where('from_user_id', $auth_id)->sum('amount');
        $total_received = $transfer->where('to_user_id', $auth_id)->sum('new_amount');
    
        // Calculate total available balance
        $total_available_balance = ($total_accumulated + $total_received ) - ($total_encashment + $total_sent + $get_total_purchase);
    
        return response()->json([
            'total_income' => $total_available_balance
        ]);
    }
    

    public function transferIncome(Request $request, User $user)
    {
        $validator = Validator::make($request->all(), [
            'transfer_amount' => 'required',
            'password' => 'required',
            'user_id' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => 'Invalid input fields.'], 400);
        }

        if (!Hash::check($request->input('password'), $user->password)) {
            return response()->json(['message' => 'Wrong Password.'], 400);
        }

        $tax = env('TAX') ?? 0;
        $process_fee = env('PROCESS_FEE') ?? 0;

        DB::beginTransaction();
        try {
            $transferAmount = $request->input('transfer_amount');
            $newAmount = $transferAmount - ($tax + $process_fee); // Use constants for magic numbers

            $transfer = new IncomeTransfer();
            $transfer->from_user_id = $user->id; // Use the authenticated user's ID directly
            $transfer->to_user_id = $request->input('user_id');
            $transfer->amount = $transferAmount;
            $transfer->tax = $tax;
            $transfer->new_amount = $newAmount;
            $transfer->save();

            DB::commit();

            return response()->json(['message' => 'Transfer successful.'], 200);
        } catch (\Throwable $e) {
            DB::rollback();
            return response()->json(['message' => $e->getMessage()], 400);
        }
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
