<?php
namespace App\Http\Controllers;
use App\Sale;
use App\UnilevelSale;
use App\User;
use App\UserInfo;
use App\Package;
use App\Referral;
use App\ShippingDetail;
use App\Encashment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class SaleController extends Controller {
    
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function salesReport(Request $request){
        $date_start = str_replace('/','-',$request->input('date_start'));
        
        if($date_start){
            $date_start = str_replace('/','-',$request->input('date_start'));
            $date_end = str_replace('/','-',$request->input('date_end'));
            $datecreate_start = date_format(date_create($date_start),'Y-m-d');
            $datecreate_end = date_format(date_create($date_end),'Y-m-d');
            
            /*$sales = DB::table('users')
                ->join('sales','users.id','=','sales.user_id')
                ->join('user_infos','users.id','=','user_infos.user_id')
                ->select('users.username',DB::raw('CONCAT(user_infos.first_name,user_infos.last_name) as full_name'),DB::raw('SUM(sales.subtotal) as total'))
                ->groupBy('users.id')
                ->where('sales.products_released',1)
                ->whereBetween('sales.created_at', array($datecreate_start . ' 00:00:00', $datecreate_end . ' 23:59:59'))
                ->get();*/
            //$sales = Sale::whereBetween('sales.created_at', array($datecreate_start . ' 00:00:00', $datecreate_end . ' 23:59:59'))->get();
            $sales = DB::table('sales')
                ->leftJoin('shipping_details','sales.id','=','shipping_details.sale_id')
                ->leftJoin('payments','sales.id','=','payments.sale_id')
                ->leftJoin('user_infos','sales.user_id','=','user_infos.user_id')
                ->select('sales.*','shipping_details.first_name AS full_name','user_infos.first_name','user_infos.last_name','payments.confirmation_number', 'payments.is_paid', 'payments.fees')
                ->where('products_released',1)
                ->whereBetween('sales.created_at', array($datecreate_start . ' 00:00:00', $datecreate_end . ' 23:59:59'))
                ->get();
            
            return response()->json([
                'sales' => $sales,
            ],200);
        } else {
            
            $sales = DB::table('sales')
                ->leftJoin('shipping_details','sales.id','=','shipping_details.sale_id')
                ->leftJoin('payments','sales.id','=','payments.sale_id')
                ->leftJoin('user_infos','sales.user_id','=','user_infos.user_id')
                ->select('sales.*','shipping_details.first_name AS full_name','user_infos.first_name','user_infos.last_name','payments.confirmation_number', 'payments.is_paid', 'payments.fees')
                ->where('products_released',1)
                ->get();
            
            
            //$sales = Sale::get();
            
            /*$sales = DB::table('sales')
                ->join('shipping_details','sales.id','=','shipping_details.sale_id')
                ->join('payments','sales.id','=','payments.sale_id')
                ->leftJoin('users','payments.admin_id','=','users.id')
                ->select('payments.confirmation_number AS invoice', 'payments.driver AS transaction_type', 'shipping_details.first_name AS first_name', 'shipping_details.last_name AS last_name', 'users.username AS username', 'payments.amount', 'sales.created_at')
                ->get();*/
        }
        
            return view('admin.sales-reports.index',compact('sales'));
    }
	
    
    //Top Earners
	public function topEarners(Request $request){
        $date_start = $request->input('date_start');
        $date_end = $request->input('date_end');

        if ($date_start) {
            // Replace '/' with '-' in date strings
            $date_start = str_replace('/', '-', $date_start);
            $date_end = str_replace('/', '-', $date_end);

            // Format dates
            $datecreate_start = date_format(date_create($date_start), 'Y-m-d');
            $datecreate_end = date_format(date_create($date_end), 'Y-m-d');

            // Build the query
            $users = DB::table('users')
                ->leftJoin('user_infos', 'users.id', '=', 'user_infos.user_id')
                ->leftJoin('packages', 'users.account_type', '=', 'packages.id')
                ->leftJoin(DB::raw('(SELECT referrals.user_id, SUM(referrals.amount) AS total_referrals 
                    FROM referrals 
                    WHERE referrals.created_at >= "' . $datecreate_start . ' 00:00:00" 
                    AND referrals.created_at <= "' . $datecreate_end . ' 23:59:59" 
                    AND reward_type="php" 
                    GROUP BY referrals.user_id) as referrals'), function($join) {
                        $join->on('users.id', '=', 'referrals.user_id');
                    })
                ->select('users.id AS user_id', 'users.username AS username', DB::raw('CONCAT(user_infos.first_name, " ", user_infos.last_name) AS full_name'), 'referrals.total_referrals', 'packages.type AS rank_type')
                ->where('users.userType', 'user')
                ->limit(500)
                ->orderBy('referrals.total_referrals', 'desc')
                ->get();

            if ($users->isEmpty()) {
                return response()->json(['users' => 'NoData'], 200);
            }

            return response()->json(['users' => $users], 200);
        } else {
            $users = User::select(
                'users.id as user_id',
                'users.username',
                DB::raw('CONCAT(user_infos.first_name, " ", user_infos.last_name) as full_name'),
                'referrals.total_referrals',
                'unilevel_sales.total_unilevel_sales',
                'packages.type as rank_type'
            )
            ->leftJoin('user_infos', 'users.id', '=', 'user_infos.user_id')
            ->leftJoin('packages', 'users.account_type', '=', 'packages.id')
            ->leftJoin(DB::raw('(SELECT user_id, SUM(amount) as total_referrals FROM referrals WHERE reward_type="php" GROUP BY user_id) referrals'), 'users.id', '=', 'referrals.user_id')
            ->leftJoin(DB::raw('(SELECT user_id, SUM(total_price) as total_unilevel_sales FROM unilevel_sales GROUP BY user_id) unilevel_sales'), 'users.id', '=', 'unilevel_sales.user_id')
            ->where('users.userType', 'user')
            ->orderBy('referrals.total_referrals', 'desc')
            ->take(500)
            ->get();
        }
        
        return view('admin.top-earners.index',compact('users'));
    }
    
    public function viewTopEarner(Request $request) {
        $user_id = $request->user_id;
        $date_start = $request->date_start;
        $date_end = $request->date_end;

        $user = User::select('username', DB::raw('CONCAT(user_infos.first_name, " ", user_infos.last_name) as full_name'))
            ->join('user_infos', 'users.id', '=', 'user_infos.user_id')
            ->where('users.id', $user_id)
            ->first();
    
        $referrals = Referral::select('referral_type', 'amount', 'created_at')
            ->where('user_id', $user_id)
            ->where('reward_type', 'php');
        
        if ($date_start && $date_end) {
            $referrals->whereBetween('created_at', [$date_start . ' 00:00:00', $date_end . ' 23:59:59']);
        }
        
        $referrals = $referrals->get();
    
        $uniLevels = UnilevelSale::select('total_price', 'created_at')
            ->where('user_id', $user_id)
            ->get();
    
        // Format date fields using Carbon
        $referrals->each(function ($referral) {
            $referral->created_at = Carbon::parse($referral->created_at)->format('Y-m-d H:i:s');
        });
    
        $uniLevels->each(function ($uniLevel) {
            $uniLevel->created_at = Carbon::parse($uniLevel->created_at)->format('Y-m-d H:i:s');
        });
    
        return response()->json([
            'user' => $user,
            'referrals' => $referrals,
            'uni_levels' => $uniLevels,
            'date_range' => ($date_start && $date_end ? "$date_start to $date_end" : null)
        ], 200);
    }
    
	
	public function topRecruiters(Request $request){
        $date_start = str_replace('/','-',$request->input('date_start'));
        $date_end = str_replace('/','-',$request->input('date_end'));
        $datecreate_start = date_format(date_create($date_start),'Y-m-d');
        $datecreate_end = date_format(date_create($date_end),'Y-m-d');

        if($date_start){
            $recuiters = DB::table('users')
                ->join('networks','users.id','=','networks.sponsor_id')
                ->join('user_infos','users.id','=','user_infos.user_id')
                ->select('users.id AS user_id','users.username',DB::raw('CONCAT(user_infos.first_name,user_infos.last_name) as full_name'),DB::raw('count(networks.id) as total'))
                ->where('users.userType','user')
                ->groupBy('networks.sponsor_id')
                ->orderByRaw('total DESC')
				->whereBetween('networks.created_at', array($datecreate_start . ' 00:00:00', $datecreate_end . ' 23:59:59'))
                ->limit(10)
                ->get();
            return response()->json([
                'recuiters' => $recuiters,
            ],200);
        } else {
			$recuiters = DB::table('users')
                ->join('networks','users.id','=','networks.sponsor_id')
                ->join('user_infos','users.id','=','user_infos.user_id')
                ->select('users.id AS user_id','users.username',DB::raw('CONCAT(user_infos.first_name,user_infos.last_name) as full_name'),DB::raw('count(networks.id) as total'))
                ->where('users.userType','user')
                ->groupBy('networks.sponsor_id')
                ->orderByRaw('total DESC')
                ->limit(10)
                ->get();
        }
        
            return view('admin.top-recruiters.index',compact('recuiters'));
    }
    
    public function viewTopRecruiter(Request $request)
    {
        $user_id = $request->user_id;
        $date_start = $request->date_start;
        $date_end = $request->date_end;

        $user = User::join('user_infos', 'users.id', '=', 'user_infos.user_id')
            ->select('users.username as username', DB::raw('CONCAT(user_infos.first_name, " ", user_infos.last_name) as full_name'))
            ->where('users.id', $user_id)
            ->first();

        $recruits = User::join('user_infos', 'users.id', '=', 'user_infos.user_id')
            ->join('networks', 'users.id', '=', 'networks.user_id')
            ->select('users.username as username', DB::raw('CONCAT(user_infos.first_name, " ", user_infos.last_name) as full_name'), 'users.created_at')
            ->where('networks.sponsor_id', $user_id);

        if ($date_start && $date_end) {
            $recruits->whereBetween('users.created_at', [$date_start . ' 00:00:00', $date_end . ' 23:59:59']);
        }
        
        $recruits = $recruits->get();

        return response()->json([
            'user' => $user,
            'recruits' => $recruits,
            'date_range' => ($date_start && $date_end ? "$date_start to $date_end" : null)
        ], 200);
    }

    /**
     * Display top earners by combined Pairing and Referral bonuses
     */
    public function topPairingReferral(Request $request) {
        // Get ALL users first (without pagination)
        $allUsers = User::select(
            'users.id as user_id',
            'users.username',
            DB::raw('CONCAT(user_infos.first_name, " ", user_infos.last_name) as full_name'),
            'packages.type as rank_type'
        )
        ->leftJoin('user_infos', 'users.id', '=', 'user_infos.user_id')
        ->leftJoin('packages', 'users.account_type', '=', 'packages.id')
        ->where('users.userType', 'user')
        ->groupBy('users.id')
        ->get();

        // Calculate totals for each user
        $allUsers->each(function ($user) {
            $user->total_pairing = Referral::where('user_id', $user->user_id)
                ->where('referral_type', 'pairing_bonus')
                ->sum('amount');
            
            $user->total_referral = Referral::where('user_id', $user->user_id)
                ->where('referral_type', 'direct_referral_bonus')
                ->sum('amount');
            
            $user->total_combined = $user->total_pairing + $user->total_referral;

            //donwline count dito
            $count = 0;

            $queue = [$user->user_id];
            $visited = [];

            while (!empty($queue)) {

                $children = DB::table('networks')
                    ->whereIn('upline_placement_id', $queue)
                    ->pluck('user_id')
                    ->toArray();

                // remove duplicates just in case
                $children = array_diff($children, $visited);

                if (empty($children)) break;

                $count += count($children);

                $visited = array_merge($visited, $children);
                $queue = $children;
            }

            $user->downline_count = $count;


        });//end here

        // Apply search filter if provided
        $search = $request->input('search');
        if ($search) {
            $allUsers = $allUsers->filter(function ($user) use ($search) {
                return stripos($user->username, $search) !== false || 
                       stripos($user->full_name, $search) !== false;
            })->values();
        }

        // Sort by total_combined descending
        $sortedUsers = $allUsers->sortByDesc('total_combined')->values();

        return view('admin.top-pairing-referral.index', [
            'query' => $sortedUsers
        ]);
    }

    /**
     * Get top pairing and referral data via AJAX
     */
    public function getTopPairingReferralData(Request $request) {
        $date_start = $request->input('date_start');
        $date_end = $request->input('date_end');

        $query = User::select(
            'users.id as user_id',
            'users.username',
            DB::raw('CONCAT(user_infos.first_name, " ", user_infos.last_name) as full_name'),
            'packages.type as rank_type',
            DB::raw('COALESCE(pairing.total_pairing, 0) as total_pairing'),
            DB::raw('COALESCE(referral.total_referral, 0) as total_referral'),
            DB::raw('(COALESCE(pairing.total_pairing, 0) + COALESCE(referral.total_referral, 0)) as total_combined')
        )
        ->leftJoin('user_infos', 'users.id', '=', 'user_infos.user_id')
        ->leftJoin('packages', 'users.account_type', '=', 'packages.id')
        ->leftJoin(DB::raw('(SELECT user_id, SUM(amount) as total_pairing FROM referrals WHERE referral_type = "pairing_bonus" ' . 
            ($date_start ? 'AND created_at >= "' . date('Y-m-d', strtotime($date_start)) . ' 00:00:00" ' : '') .
            ($date_end ? 'AND created_at <= "' . date('Y-m-d', strtotime($date_end)) . ' 23:59:59" ' : '') .
            'GROUP BY user_id) as pairing'), 'users.id', '=', 'pairing.user_id')
        ->leftJoin(DB::raw('(SELECT user_id, SUM(amount) as total_referral FROM referrals WHERE referral_type = "direct_referral_bonus" ' . 
            ($date_start ? 'AND created_at >= "' . date('Y-m-d', strtotime($date_start)) . ' 00:00:00" ' : '') .
            ($date_end ? 'AND created_at <= "' . date('Y-m-d', strtotime($date_end)) . ' 23:59:59" ' : '') .
            'GROUP BY user_id) as referral'), 'users.id', '=', 'referral.user_id')
        ->where('users.userType', 'user')
        ->havingRaw('total_combined > 0')
        ->orderBy('total_combined', 'desc')
        ->limit(500)
        ->get();

        if ($query->isEmpty()) {
            return response()->json(['users' => 'NoData'], 200);
        }

        return response()->json(['users' => $query], 200);
    }
}
