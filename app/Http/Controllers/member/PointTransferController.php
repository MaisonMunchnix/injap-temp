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
use App\PointTransfer;
use Illuminate\Support\Carbon;

class PointTransferController extends Controller
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
       return view('user.income.transfer-points', compact('auth_id','get_donations','total_donations'));
    }

    public function transferHistories(Request $request){
        if ($request->ajax()) {
            $auth_id = Auth::id();
            $transfers = PointTransfer::where(function ($query) use ($auth_id) {
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
                ->editColumn('value', function ($transfers) use ($auth_id) {
                    $value = ($transfers->from_user_id == $auth_id)
                        ? "<span class='text-danger'>-$transfers->value</span>"
                        : "<span class='text-success'>+$transfers->value</span>";
                    return $value;
                })
                ->addColumn('created_at', function ($transfers) {
                    return $transfers->created_at->toDateTimeString();
                })
                ->rawColumns(['value'])
                ->make(true);
         }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getTotalPoints(){
        $auth_id = Auth::id();
    
        // Total accumulated income
        $total_accumulated = Referral::where('user_id', $auth_id)
            ->where('reward_type', 'points')
            ->sum('amount');
    
        // Total transfer
        $transfer = PointTransfer::where(function ($query) use ($auth_id) {
            $query->where('from_user_id', $auth_id)
                ->orWhere('to_user_id', $auth_id);
        })->get();
    
        // Calculate total sent and received amounts
        $total_sent = $transfer->where('from_user_id', $auth_id)->sum('value');
        $total_received = $transfer->where('to_user_id', $auth_id)->sum('value');

        return response()->json([
            'avalable_points' => (($total_accumulated + $total_received ) - ($total_sent) ?? 0)
        ]);
    }
    

    public function transferPoint(Request $request, User $user)
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

        DB::beginTransaction();
        try {
            $transfer = new PointTransfer();
            $transfer->from_user_id = $user->id;
            $transfer->to_user_id = $request->input('user_id');
            $transfer->value = $request->input('transfer_amount');
            $transfer->reference_id = "RCBO-" . strtotime(now());
            $transfer->save();
            DB::commit();
            return response()->json(['message' => 'Transfer successful.'], 200);
        } catch (\Throwable $e) {
            DB::rollback();
            return response()->json(['message' => $e->getMessage()], 400);
        }
    }
}
