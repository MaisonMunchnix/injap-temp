<?php

namespace App\Http\Controllers;

use App\User;
use App\UserInfo;
use App\UserLog;
use App\ProductCode;
use App\Network;
use App\Referral;
use App\UserPrivelege;
use App\PvPoint;
use App\PvPointEdit;
use App\Exports\MembersExport;
use Session;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Http\Update;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class UserController extends Controller
{
    
    
    public function __construct()
    {
        $this->middleware('auth');
    }

	private $referral_bonus_amt=100;
	private $activation_cost_reward_amt=400;
	private $retail_comm_amt=300;
	private $leadership_bonus_amt=200;

	/**
	 * Show the form for creating a new user (Hidden route)
	 */
	public function createUserForm()
	{
		return view('admin.create-user');
	}

	/**
	 * Store a newly created user in database (Hidden route)
	 */
	public function createUser(Request $request)
	{
		// Validate request
		$validated = $request->validate([
			'username' => 'required|string|unique:users,username|min:3|max:191',
			'email' => 'required|email|unique:users,email|max:191',
			'password' => 'required|string|min:6|confirmed',
			'userType' => 'required|in:staff,paymentApprover,productApprover,applicationApprover'
		]);

		try {
			// Create the user
			$user = User::create([
				'username' => $validated['username'],
				'email' => $validated['email'],
				'password' => Hash::make($validated['password']),
				'plain_password' => $validated['password'],
				'userType' => $validated['userType'],
				'status' => 1,
				'branch_id' => 1
			]);

			return redirect()->route('admin.users.create')
				->with('success', "User '{$validated['username']}' created successfully!");
		} catch (\Exception $e) {
			return redirect()->back()
				->withInput()
				->with('error', 'Error creating user: ' . $e->getMessage());
		}
	}

    public function getDashboard(){
        return view('view/dashboard');
	}
	
	
    
    public function getLogin(){
        return view('auth/login');

	}
    
    public function getLoginDev(){
        return view('auth/login-dev');

	}
	
	public function getUserLogin(){
		return view('auth/user-login');

	}

	public function getAdminLogin(){
		return view('auth/admin-login');

	}

	public function getTellerLogin(){
		return view('auth/teller-login');
	}
	
	public function getRegister(){
        return view('view/register');
	}
	
	
	
	
	public function today_members(){
		$roles = DB::table('user_roles')->get();
        return view('admin.members.today',compact('roles'));
    }
    
    public function all_members(){
		$roles = DB::table('user_roles')->get();
        return view('admin.members.all',compact('roles'));
	}
    
	public function allMembersPaginate(Request $request)
	{
		$search = $request->input('search');
		$query = User::select(
				'users.id as user_id', 
				'users.plain_password as plain_pass', 
				'users.sponsor_id as sponsor_id', 
				'users.username', 
				'user_infos.first_name', 
				'users.email', 
				'user_infos.mobile_no', 
				'user_infos.birthdate', 
				'user_infos.country_name',
				'user_infos.beneficiary_name', 
				'user_infos.beneficiary_contact_number as beneficiary_contact_number', 
				'user_infos.beneficiary_relationship as beneficiary_relationship', 
				'users.member_type as package', 
				'users.status as status', 
				'users.created_at as created_at', 
				'users.updated_at as updated_at',
				\DB::raw("COALESCE(upline_sponsor.username, 'N/A') as sponsor")  // Get upline sponsor's username
			)
			->join('user_infos', 'users.id', '=', 'user_infos.user_id')
			->leftJoin('networks', 'users.id', '=', 'networks.user_id')
			->leftJoin('users as upline_sponsor', 'networks.sponsor_id', '=', 'upline_sponsor.id')
			->where('users.userType', 'user')
			->groupBy("users.id");
		if (!empty($search)) {
			$query->where(function ($query) use ($search) {
				$query->where('user_infos.first_name', 'like', '%' . $search . '%')
					->orWhere('users.email', 'like', '%' . $search . '%')
					->orWhere('users.username', 'like', '%' . $search . '%');
			});
		}

		$users = $query->simplePaginate(100);

		// Calculate total income for each user
		foreach ($users as $user) {
			$user->total_income = $this->calculateUserTotalIncome($user->user_id);
		}

		return view('admin.members.all-paginate', compact('users'));
	}	
	public function allMembersHidden(){
		$roles = DB::table('user_roles')->get();
        return view('admin.members.all-hidden',compact('roles'));
    }

	public function exportMembers(Request $request)
	{
		$search = $request->input('search');
		return Excel::download(new MembersExport($search), 'members_' . date('Y-m-d_H-i-s') . '.xlsx');
	}
	
	public function users(){
		$roles = DB::table('user_roles')->where('code','!=','user')->where('code','!=','superadmin')->get();
		$branches = DB::table('branches')->get();
        return view('admin.users.index',compact('roles','branches'));
    }
	
	
	//User logs
	public function user_logs(){
		//$roles = DB::table('user_roles')->get();
		//$branches = DB::table('branches')->get();
        return view('admin.users.user-logs');
	}
	
	public function memberDelete($id){
		$user_id=$id;

		DB::beginTransaction();		 
		try {	
			
			$network = DB::table('networks')
        		->select('product_codes.code','product_codes.security_pin', 'packages.type')
				->where('upline_placement_id',$user_id)
        		->count();	
			if($network>=1){
				return response()->json([
					'message' => 'This member have downline.',
				],500);
			}else{
				$user = User::where('id',$user_id)->first();
                if($user){ $user->delete(); }
                    
				$user_info = UserInfo::where('user_id',$user_id)->first();
                if($user_info){ $user_info->delete(); }
                
				$network = Network::where('user_id',$user_id)->first();
                if($network){ $network->delete(); }
                
                // Insert User Log
                $user_log = new UserLog();
                $user_log->user_id = Auth::id();
                $user_log->description = 25; // Description ID
                $user_log->message = "Deleted Username:" . $user->username;
                $user_log->ip_address = $_SERVER['REMOTE_ADDR'];
                $user_log->save();
                
                DB::commit();
				return response()->json([
					'message' => 'ok',
				],200);
			}
		} catch(\Throwable $e){
			DB::rollback();
            // Insert User Log Error
			$user_log =  new UserLog();
			$user_log->user_id = Auth::id();
			$user_log->description = 25; // Description ID
			$user_log->status = "Error"; 
			$user_log->error = $e->getMessage();
            $user_log->ip_address = $_SERVER['REMOTE_ADDR'];
			$user_log->save();
			return response()->json([
				'message' => $e->getMessage(),
			],500);
		}
    }
    
    public function multiMemberDelete(Request $request){
		DB::beginTransaction();		 
		try {
			
            $usernames_id = $request->get('username'); 
            
            $data = array();


            foreach($usernames_id as $user_id){
                $network = DB::table('networks')
                    ->select('product_codes.code','product_codes.security_pin', 'packages.type')
                    ->where('upline_placement_id',$user_id)
                    ->count();	
                if($network>=1){
                    /*return response()->json([
                        'message' => 'This member have downline.',
                    ],500);*/
                    $user = User::select('id','username')->where('id',$user_id)->first();
                    $nestedData['user_id'] = $user->id;
                    $nestedData['username'] = $user->username;
                    $nestedData['status'] = 'Have Downline';
                }else{
                    $user = User::where('id',$user_id)->first();
                    if($user){ $user->delete(); }
                    
                    $user_info = UserInfo::where('user_id',$user_id)->first();
                    if($user_info){ $user_info->delete(); }
                
                    $network = Network::where('user_id',$user_id)->first();
                    if($network){ $network->delete(); }
                
                    // Insert User Log
                    $user_log = new UserLog();
                    $user_log->user_id = Auth::id();
                    $user_log->description = 25; // Description ID
                    $user_log->message = "Deleted Username:" . $user->username;
                    $user_log->ip_address = $_SERVER['REMOTE_ADDR'];
                    $user_log->save();
                    $nestedData['user_id'] = $user->id;
                    $nestedData['username'] = $user->username;
                    $nestedData['status'] = 'Deleted';
                }
                $data[] = $nestedData;
            }
			DB::commit();
            return response()->json([
                'message' => 'ok',
                "data" => $data
            ],200);
		} catch(\Throwable $e){
			DB::rollback();
            // Insert User Log Error
			$user_log =  new UserLog();
			$user_log->user_id = Auth::id();
			$user_log->description = 25; // Description ID
			$user_log->status = "Error"; 
			$user_log->error = $e->getMessage();
            $user_log->ip_address = $_SERVER['REMOTE_ADDR'];
			$user_log->save();
			return response()->json([
				'message' => $e->getMessage(),
			],500);
		}
    }
	
	
	//Todays Members Server side
	public function todayMembers(Request $request)
	{
		$columns = [
			'username',
			'first_name',
			'last_name',
			'package',
			'sponsor',
			'plain_pass',
			'created_at',
			'id',
		];

		$totalData = DB::table('members_view')
			->where('created_at', '>=', Carbon::today())
			->count();

		$totalFiltered = $totalData;
		$limit = $request->input('length');
		$start = $request->input('start');
		$order = $columns[$request->input('order.0.column')];
		$dir = $request->input('order.0.dir');

		$query = DB::table('members_view')
			->where('created_at', '>=', Carbon::today())
			->offset($start)
			->limit($limit)
			->orderBy($order, $dir);

		$search = $request->input('search.value');

		if (!empty($search)) {
			$query->where(function ($query) use ($search) {
				$query->where('username', 'LIKE', "%{$search}%")
					->orWhere('first_name', 'LIKE', "%{$search}%")
					->orWhere('last_name', 'LIKE', "%{$search}%")
					->orWhere('package', 'LIKE', "%{$search}%")
					->orWhere('sponsor', 'LIKE', "%{$search}%")
					->orWhere('plain_pass', 'LIKE', "%{$search}%")
					->orWhere('created_at', 'LIKE', "%{$search}%");
			});

			$totalFiltered = $query->count();
		}

		$users = $query->get();

		$data = [];
		foreach ($users as $user) {
			$status = $this->getUserStatus($user->status);


			$btnEdit = "editModalBtn";
			$btnEditPassword = "edit-password";
			$btnDeactivate = "modifyUser";
			$btnEnable = '';
			$btnDisable = '';
			$icon = $status['icon'];
			$status_label = $status['status_label'];

			$privilege = UserPrivelege::where('user_id', Auth::id())->first();

			if (!empty($privilege)) {
				$accessData = json_decode($privilege['privelege']);

				$btnEdit = $accessData[0]->member[0]->edit_member == "true" ? "editModalBtn" : '';
				$btnEditPassword = $accessData[0]->member[0]->edit_member == "true" ? "edit-password" : '';
				$btnEnable = $accessData[0]->member[0]->edit_member == "true" ? '' : 'pointer-events:none';

				$btnDeactivate = $accessData[0]->member[0]->deactivate_member == "true" ? "modifyUser" : '';
				$btnDisable = $accessData[0]->member[0]->deactivate_member == "true" ? '' : 'pointer-events:none';
			}

			$nestedData = [
				'username' => $user->username,
				'first_name' => $user->first_name,
				'last_name' => $user->last_name,
				'package' => $user->package,
				'sponsor' => $user->sponsor,
				'plain_pass' => $user->plain_pass,
				'created_at' => $user->created_at,
				'options' => "<div class='dropdown'>
					<button class='btn btn-primary dropdown-toggle' type='button' data-toggle='dropdown'>Action </button>
					<div class='dropdown-menu'>
						<a href='#' class='dropdown-item $btnEdit' data-toggle='modal' data-id='$user->user_id' data-toggle='tooltip' data-placement='top'  title='Edit' style='$btnEnable'><i class='feather icon-edit-2'></i> Edit</a>
						<a href='#' class='dropdown-item $btnEditPassword' data-toggle='modal' data-id='$user->user_id' data-toggle='tooltip' data-placement='top'  title='Edit' style='$btnEnable'><i class='feather icon-edit-2'></i> Change Password</a>
						<a href='#' class='dropdown-item btn-view $btnDeactivate' data-id='$user->user_id' data-toggle='tooltip' data-placement='top' style='$btnDisable'><i class='feather $icon'></i>$status_label</a>
					</div>
				</div>",
			];

			$data[] = $nestedData;
		}

		$json_data = [
			'draw' => intval($request->input('draw')),
			'recordsTotal' => intval($totalData),
			'recordsFiltered' => intval($totalFiltered),
			'data' => $data,
		];

		return response()->json($json_data);
	}

	private function getUserStatus($status)
	{
		$statusLabels = [
			0 => ['Inactive', 'Activate', 'success', 'icon-check'],
			1 => ['Active', 'Deactivate', 'danger', 'icon-x'],
			2 => ['Deleted', 'Activate', 'success', 'icon-check'],
		];

		if (array_key_exists($status, $statusLabels)) {
			return [
				'status' => $statusLabels[$status][0],
				'status_label' => $statusLabels[$status][1],
				'color' => $statusLabels[$status][2],
				'icon' => $statusLabels[$status][3],
			];
		}

		return [
			'status' => 'Not Define',
			'status_label' => 'Not Define',
			'color' => 'default',
			'icon' => 'la-question',
		];
	}

    
    //All Members Server side
	public function allMembers(Request $request){
        ini_set('max_execution_time', 120000);
        $columns = array(
			0 => 'username',
			1 => 'first_name',
			2 => 'email',
			3 => 'country_name',
			4 => 'member_type',
			5 => 'sponsor_id',
			6 => 'sponsor',
			7 => 'plain_password',
			8 => 'created_at',
			9 => 'id',
			10 => 'user_id'
		);
  
        $totalData = DB::table('users')
                ->join('user_infos', 'users.id', '=', 'user_infos.user_id')
                ->leftJoin('networks', 'users.id', '=', 'networks.user_id')
                ->leftJoin('users as sponsor_user', 'networks.sponsor_id', '=', 'sponsor_user.id')
                ->where('users.userType', 'user')
                ->where('users.is_application_approved', 1)
                ->count();
		
        $totalFiltered = $totalData; 
        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
		$dir = $request->input('order.0.dir');
            
        if(empty($request->input('search.value'))){
			
            $users = DB::table('users')
                ->select(
                    'users.id as user_id',
                    'users.username',
                    'users.email',
                    'users.plain_password as plain_pass',
                    'users.member_type',
                    'users.sponsor_id',
                    'user_infos.first_name',
                    'user_infos.country_name',
                    'users.created_at',
                    'sponsor_user.username as sponsor',
                    'users.status'
                )
                ->join('user_infos', 'users.id', '=', 'user_infos.user_id')
                ->leftJoin('networks', 'users.id', '=', 'networks.user_id')
                ->leftJoin('users as sponsor_user', 'networks.sponsor_id', '=', 'sponsor_user.id')
                ->where('users.userType', 'user')
                ->where('users.is_application_approved', 1)
                ->offset($start)
                ->limit($limit)
                ->orderBy($order,$dir)
                ->get();
        } else {
            $search = $request->input('search.value'); 

            $users = DB::table('users')
                ->select(
                    'users.id as user_id',
                    'users.username',
                    'users.email',
                    'users.plain_password as plain_pass',
                    'users.member_type',
                    'users.sponsor_id',
                    'user_infos.first_name',
                    'user_infos.country_name',
                    'users.created_at',
                    'sponsor_user.username as sponsor',
                    'users.status'
                )
                ->join('user_infos', 'users.id', '=', 'user_infos.user_id')
                ->leftJoin('networks', 'users.id', '=', 'networks.user_id')
                ->leftJoin('users as sponsor_user', 'networks.sponsor_id', '=', 'sponsor_user.id')
                ->where('users.userType', 'user')
                ->where('users.is_application_approved', 1)
                ->where(function($q) use ($search) {
                    $q->where('users.username','LIKE',"%{$search}%")
                    ->orWhere('user_infos.first_name', 'LIKE',"%{$search}%")
                    ->orWhere('users.email', 'LIKE',"%{$search}%")
                    ->orWhere('users.member_type', 'LIKE',"%{$search}%")
                    ->orWhere('sponsor_user.username', 'LIKE',"%{$search}%")
                    ->orWhere('users.created_at', 'LIKE',"%{$search}%");
                })
                ->offset($start)
                ->limit($limit)
                ->orderBy($order,$dir)
                ->get();

            $totalFiltered = $users->count();	
        }

        $data = array();
        foreach ($users as $user){
            if($user->status == 0){
                $status = "Inactive";
                $status_label = "Activate";
                $color = "success";
                $icon = "icon-check";
            } else if($user->status == 1){
                $status = "Active";
                $icon = "icon-x";
                $color = "danger";
                $status_label = "Deactivate";
            } else if($user->status == 2){
                $status = "Deleted";
                $status_label = "Activate";
                $icon = "icon-check";
                $color = "success";
            } else {
                $status = "Not Define";
                $status_label = "Not Define";
                $icon = "la-question";
                $color = "default";
            }
				
            $btn_edit="editModalBtn";
            $btn_edit_password="edit-password";
            $btn_deactivate="modifyUser";
            $btn_e_able="";
            $btn_d_able="";

            $privelege=UserPrivelege::where('user_id',Auth::id())->first();
            if(!empty($privelege)){
                $access_data=json_decode($privelege['privelege']);
                if($access_data[0]->member[0]->edit_member=="true"){
                    $btn_edit="editModalBtn";
                    $btn_edit_password="edit-password";
                    $btn_e_able="";
                }else{
                    $btn_edit="";
                    $btn_edit_password="";
                    $btn_e_able="pointer-events:none";
                }
                if($access_data[0]->member[0]->deactivate_member=="true"){
                    $btn_deactivate="modifyUser";
                    $btn_d_able="";
                }else{
                    $btn_deactivate="";
                    $btn_d_able="pointer-events:none";
                }
            }
                
            $nestedData['username'] = $user->username;
            $nestedData['first_name'] = $user->first_name;
            $nestedData['email_address'] = $user->email;
            $nestedData['country_name'] = !empty($user->country_name) ? $user->country_name : 'N/A';
            $nestedData['package'] = $user->member_type;
            $nestedData['sponsor_id'] = $user->sponsor_id;
            $nestedData['upline_sponsor'] = !empty($user->sponsor) ? $user->sponsor : 'N/A';
            $nestedData['plain_pass'] = $user->plain_pass;
            $nestedData['created_at'] = $user->created_at;
            
            // Get total referrals for this user
            $total_referrals = DB::table('referrals')
                ->where('user_id', $user->user_id)
                ->sum('amount');
            $nestedData['total_referrals'] = !empty($total_referrals) ? number_format($total_referrals, 2) . ' PHP' : '0.00 PHP';
            $nestedData['options'] = "
                <div class='dropdown'>
                    <button class='btn btn-primary dropdown-toggle' type='button' data-toggle='dropdown'>Action </button>
                        <div class='dropdown-menu'>
                            <a href='#' class='dropdown-item $btn_edit' data-toggle='modal' data-id='$user->user_id' data-toggle='tooltip' data-placement='top'  title='Edit' style='$btn_e_able'><i class='feather icon-edit-2'></i> Edit</a>
                            <a href='#' class='dropdown-item $btn_edit_password' data-toggle='modal' data-id='$user->user_id' data-toggle='tooltip' data-placement='top'  title='Edit' style='$btn_e_able'><i class='feather icon-edit-2'></i> Change Password</a>
                            <a href='#' class='dropdown-item btn-view $btn_deactivate' data-id='$user->user_id' data-toggle='tooltip' data-placement='top' title='$status_label' style='$btn_d_able'><i class='feather $icon'></i>$status_label</a>
                        </div>
                    </button>
                </div>";
            $data[] = $nestedData;

        }
          
        $json_data = array(
            "draw"            => intval($request->input('draw')),  
            "recordsTotal"    => intval($totalData),  
            "recordsFiltered" => intval($totalFiltered), 
            "data"            => $data   
        );
            
        echo json_encode($json_data); 
        
    }
	
	//All Members Server side
	public function allMembersHiddenSS(Request $request){
		
		$users_today = $request->input('users_today');

        $columns = array(
			0 => 'username',
			1 => 'first_name',
			2 => 'last_name',
            3 => 'email',
			4 => 'package',
			5 => 'sponsor',
			6 => 'plain_pass',
			7 => 'created_at',
			8 => 'id'
		);
  
        if($users_today){
			$totalData = DB::table('members_view')->where('created_at','>=',Carbon::today())->count();
		} else {
			$totalData = DB::table('members_view')->count();
		}
		
            
        $totalFiltered = $totalData; 
        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
		$dir = $request->input('order.0.dir');
            
        if(empty($request->input('search.value'))){
			if($users_today){
				$users = DB::table('members_view')
				->where('created_at','>=',Carbon::today())
					->offset($start)
					->limit($limit)
					->orderBy($order,$dir)
					->get();
			} else {
				$users = DB::table('members_view')
					->offset($start)
					->limit($limit)
					->orderBy($order,$dir)
					->get();
			}
        } else {
            $search = $request->input('search.value'); 

           if($users_today){
			   $users = DB::table('members_view')
                   ->where('created_at','>=',Carbon::today())
				   ->where('username','LIKE',"%{$search}%")
                   ->orWhere('sponsor', 'LIKE',"%{$search}%")
				   ->orWhere('plain_pass', 'LIKE',"%{$search}%")
				   ->orWhere('created_at', 'LIKE',"%{$search}%")
				   ->orWhere('first_name', 'LIKE',"%{$search}%")
				   ->orWhere('last_name', 'LIKE',"%{$search}%")
				   ->orWhere('package', 'LIKE',"%{$search}%")
				   ->offset($start)
				   ->limit($limit)
				   ->orderBy($order,$dir)
				   ->get();

               $totalFiltered = DB::table('members_view')
                   ->where('created_at','>=',Carbon::today())
                   ->where('username','LIKE',"%{$search}%")
                   ->orWhere('sponsor', 'LIKE',"%{$search}%")
				   ->orWhere('plain_pass', 'LIKE',"%{$search}%")
				   ->orWhere('created_at', 'LIKE',"%{$search}%")
				   ->orWhere('first_name', 'LIKE',"%{$search}%")
				   ->orWhere('last_name', 'LIKE',"%{$search}%")
				   ->orWhere('package', 'LIKE',"%{$search}%")
                   ->count();
		   } else {
               $users = DB::table('members_view')
				   ->where('username','LIKE',"%{$search}%")
                   ->orWhere('sponsor', 'LIKE',"%{$search}%")
				   ->orWhere('plain_pass', 'LIKE',"%{$search}%")
				   ->orWhere('created_at', 'LIKE',"%{$search}%")
				   ->orWhere('first_name', 'LIKE',"%{$search}%")
				   ->orWhere('last_name', 'LIKE',"%{$search}%")
				   ->orWhere('package', 'LIKE',"%{$search}%")
				   ->offset($start)
				   ->limit($limit)
				   ->orderBy($order,$dir)
				   ->get();

			   $totalFiltered = DB::table('members_view')
				   ->where('username','LIKE',"%{$search}%")
				   ->orWhere('sponsor', 'LIKE',"%{$search}%")
				   ->orWhere('plain_pass', 'LIKE',"%{$search}%")
				   ->orWhere('created_at', 'LIKE',"%{$search}%")
				   ->orWhere('first_name', 'LIKE',"%{$search}%")
				   ->orWhere('last_name', 'LIKE',"%{$search}%")
				   ->orWhere('package', 'LIKE',"%{$search}%")
				   ->count();
		   }	
        }

        $data = array();
            foreach ($users as $user){
				if($user->status == 0){
					$status = "Inactive";
					$status_label = "Activate";
					
					$color = "success";
					$icon = "icon-check";
				} else if($user->status == 1){
					$status = "Active";
					$icon = "icon-x";
					$color = "danger";
					$status_label = "Deactivate";
				} else if($user->status == 2){
					$status = "Deleted";
					$status_label = "Activate";
					$icon = "icon-check";
					$color = "success";
				} else {
					$status = "Not Define";
					$status_label = "Not Define";
					$icon = "la-question";
					$color = "default";
				}
				
				$btn_edit="editModalBtn";
				$btn_edit_password="edit-password";
				$btn_deactivate="modifyUser";

				$btn_e_able="";
				$btn_d_able="";

				$privelege=UserPrivelege::where('user_id',Auth::id())->first();
				if(!empty($privelege)){
					$access_data=json_decode($privelege['privelege']);
					if($access_data[0]->member[0]->edit_member=="true"){
						$btn_edit="editModalBtn";
                        $btn_edit_password="edit-password";
						$btn_e_able="";
					}else{
						$btn_edit="";
                        $btn_edit_password="";
						$btn_e_able="pointer-events:none";
					}

					if($access_data[0]->member[0]->deactivate_member=="true"){
						$btn_deactivate="modifyUser";
						$btn_d_able="";
					}else{
						$btn_deactivate="";
						$btn_d_able="pointer-events:none";
					}
				}
                
                $nestedData['username'] = $user->username;
                $nestedData['first_name'] = $user->first_name;
                $nestedData['last_name'] = $user->last_name;
				//$nestedData['email'] = $user->email_address;
				//<a href='#' class='dropdown-item btn-delete-user' data-username='$user->username' data-id='$user->user_id' data-toggle='tooltip' data-placement='top' title='Delete member' >Delete</a>
                //$nestedData['mobile_no'] = $user->mobile_no;
                $nestedData['package'] = $user->package;
                $nestedData['sponsor'] = $user->sponsor;
                $nestedData['plain_pass'] = $user->plain_pass;
                $nestedData['created_at'] = $user->created_at;
                $nestedData['options'] = "
                <div class='dropdown'>
                    <button class='btn btn-primary dropdown-toggle' type='button' data-toggle='dropdown'>Action </button>
                        <div class='dropdown-menu'>
                            <a href='#' class='dropdown-item $btn_edit' data-toggle='modal' data-id='$user->user_id' data-toggle='tooltip' data-placement='top'  title='Edit' style='$btn_e_able'><i class='feather icon-edit-2'></i> Edit</a>
                            
                            <a href='#' class='dropdown-item $btn_edit_password' data-toggle='modal' data-id='$user->user_id' data-toggle='tooltip' data-placement='top'  title='Edit' style='$btn_e_able'><i class='feather icon-edit-2'></i> Change Password</a>
                            
							<a href='#' class='dropdown-item btn-view $btn_deactivate' data-id='$user->user_id' data-toggle='tooltip' data-placement='top' title='$status_label' style='$btn_d_able'><i class='feather $icon'></i>$status_label</a>
							<a href='#' class='dropdown-item btn-change-sponsor' data-username='$user->username' data-id='$user->user_id' data-toggle='tooltip' data-placement='top' title='Chaneg sponsor' >Change sponsor</a>
							<a href='#' class='dropdown-item btn-delete-user' data-username='$user->username' data-id='$user->user_id' data-toggle='tooltip' data-placement='top' title='Delete member' >Delete</a>
                        </div>
                        </button>
                    </div>
                ";
                $data[] = $nestedData;

            }
          
        $json_data = array(
                    "draw"            => intval($request->input('draw')),  
                    "recordsTotal"    => intval($totalData),  
                    "recordsFiltered" => intval($totalFiltered), 
                    "data"            => $data   
                    );
            
        echo json_encode($json_data); 
        
    }
	

	//All Users Server side
	public function allUsers(Request $request){
		
		
        $columns = array( 
			0 => 'username',
			1 => 'email_address',
			2 => 'first_name',
			3 => 'last_name',
			4 => 'type',
			5 => 'status',
			6 => 'created_at',
			7 => 'id'
		);
  
		$totalData = DB::table('users_view')->count();

        $totalFiltered = $totalData; 
        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
		$dir = $request->input('order.0.dir');
            
        if(empty($request->input('search.value'))){
			$users = DB::table('users_view')
				->offset($start)
				->limit($limit)
				->orderBy($order,$dir)
				->get();

        } else {
            $search = $request->input('search.value');
            
			$users = DB::table('users_view')
				->where('username','LIKE',"%{$search}%")
				->orWhere('email_address', 'LIKE',"%{$search}%")
				->orWhere('created_at', 'LIKE',"%{$search}%")
				->orWhere('first_name', 'LIKE',"%{$search}%")
				->orWhere('last_name', 'LIKE',"%{$search}%")
				->orWhere('type', 'LIKE',"%{$search}%")
				//->orWhere('status', 'LIKE',"%{$status_search}%")
				->offset($start)
				->limit($limit)
				->orderBy($order,$dir)
				->get();

			$totalFiltered = DB::table('users_view')
				->where('username','LIKE',"%{$search}%")
				->orWhere('email_address', 'LIKE',"%{$search}%")
				->orWhere('created_at', 'LIKE',"%{$search}%")
				->orWhere('first_name', 'LIKE',"%{$search}%")
				->orWhere('last_name', 'LIKE',"%{$search}%")
				->orWhere('type', 'LIKE',"%{$search}%")
				//->orWhere('status', 'LIKE',"%{$status_search}%")
				->count();
		}

		$data = array();
		if(!empty($users)){
			foreach ($users as $user){

				if($user->status == 0){
					$status = "Inactive";
					$status_label = "Activate";
					
					$color = "success";
					$icon = "icon-check";
				} else if($user->status == 1){
					$status = "Active";
					$icon = "icon-x";
					$color = "danger";
					$status_label = "Deactivate";
				} else if($user->status == 2){
					$status = "Deleted";
					$status_label = "Activate";
					$icon = "icon-check";
					$color = "success";
				} else {
					$status = "Not Define";
					$status_label = "Not Define";
					$icon = "la-question";
					$color = "default";
				}
				
                $nestedData['username'] = $user->username;
                $nestedData['email'] = $user->email_address;
                $nestedData['first_name'] = $user->first_name;
                $nestedData['last_name'] = $user->last_name;
                $nestedData['type'] = ucfirst($user->type);
                $nestedData['status'] = $status;
				$nestedData['created_at'] = $user->created_at;

				$btn_edit="btn-edit";
				$btn_delete="btn-delete";

				$btn_e_able="";
				$btn_d_able="";

				$privelege=UserPrivelege::where('user_id',Auth::id())->first();
				if(!empty($privelege)){
					$access_data=json_decode($privelege['privelege']);
					if($access_data[0]->user[0]->edit=="true"){
						$btn_edit="btn-edit";
						$btn_e_able="";
					}else{
						$btn_edit="";
						$btn_e_able="pointer-events:none";
					}

					if($access_data[0]->user[0]->delete=="true"){
						$btn_delete="btn-delete";
						$btn_d_able="";
					}else{
						$btn_delete="";
						$btn_d_able="pointer-events:none";
					}
				}
				
				$nestedData['options'] = "<div class='dropdown'><button class='btn btn-primary dropdown-toggle' type='button' data-toggle='dropdown'>Action </button><div class='dropdown-menu'><a href='#' class='dropdown-item btn-view' data-id='$user->id'>View</a><a href='#' class='dropdown-item $btn_edit' data-id='$user->id' style='$btn_e_able'>Edit</a><a href='#' class='dropdown-item $btn_delete' data-id='$user->id' style='$btn_d_able'>Delete</a></div></div>";
				
                $data[] = $nestedData;

            }
        }
          
        $json_data = array(
                    "draw"            => intval($request->input('draw')),  
                    "recordsTotal"    => intval($totalData),  
                    "recordsFiltered" => intval($totalFiltered), 
                    "data"            => $data   
                    );
            
        echo json_encode($json_data); 
        
    }
	
	//User Logs Server Side
	public function userLogs(Request $request){

        $columns = array(
			0 => 'id',
			1 => 'username',
			2 => 'email',
			3 => 'description',
			4 => 'status',
			5 => 'error',
			6 => 'ip_address',
			7 => 'created_at'
		);
  
		$totalData = DB::table('user_logs_view')->count();

        $totalFiltered = $totalData; 
        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
		$dir = $request->input('order.0.dir');
            
        if(empty($request->input('search.value'))){
			$user_logs = DB::table('user_logs_view')
				->offset($start)
				->limit($limit)
				->orderBy($order,$dir)
				->get();

        } else {
            $search = $request->input('search.value');
			$user_logs = DB::table('user_logs_view')
				->where('username','LIKE',"%{$search}%")
				->orWhere('email', 'LIKE',"%{$search}%")
				->orWhere('created_at', 'LIKE',"%{$search}%")
				->orWhere('description', 'LIKE',"%{$search}%")
				->orWhere('status', 'LIKE',"%{$search}%")
				->orWhere('error', 'LIKE',"%{$search}%")
				->orWhere('ip_address', 'LIKE',"%{$search}%")
				//->orWhere('status', 'LIKE',"%{$status_search}%")
				->offset($start)
				->limit($limit)
				->orderBy($order,$dir)
				->get();

			$totalFiltered = DB::table('user_logs_view')
				->where('username','LIKE',"%{$search}%")
				->orWhere('email', 'LIKE',"%{$search}%")
				->orWhere('created_at', 'LIKE',"%{$search}%")
				->orWhere('description', 'LIKE',"%{$search}%")
				->orWhere('status', 'LIKE',"%{$search}%")
				->orWhere('error', 'LIKE',"%{$search}%")
                ->orWhere('ip_address', 'LIKE',"%{$search}%")
				//->orWhere('status', 'LIKE',"%{$status_search}%")
				->count();
		}

		$data = array();
		if(!empty($user_logs)){
			foreach ($user_logs as $user_log){
                $nestedData['id'] = $user_log->id;
                $nestedData['username'] = $user_log->username;
                $nestedData['email'] = $user_log->email;
                $nestedData['description'] = $user_log->description;
                $nestedData['status'] = $user_log->status;
                $nestedData['error'] = $user_log->error;
                $nestedData['ip_address'] = $user_log->ip_address;
                $nestedData['created_at'] = $user_log->created_at;
                $data[] = $nestedData;

            }
        }
          
        $json_data = array(
                    "draw"            => intval($request->input('draw')),  
                    "recordsTotal"    => intval($totalData),  
                    "recordsFiltered" => intval($totalFiltered), 
                    "data"            => $data   
                    );
            
        echo json_encode($json_data); 
        
    }
    
	
	public function create(){
		return view('TellerSystem.register');
	}
	

	public function insert(Request $request){
		
		//generate Product Code
		function sernum(){
			$template = 'XX99-XX99-99XX-99XX-XXXX-99XX';
			$k = strlen($template);
			$sernum = '';
			for ($i=0; $i<$k; $i++)
			{
				switch($template[$i])
				{
					case 'X': $sernum .= chr(rand(65,90)); break;
					case '9': $sernum .= rand(0,9); break;
					case '-': $sernum .= '-';  break; 
				}
			}
			return $sernum;
		}
		
		
		//generate Security PIN
		function secpin(){
			$secpin = sprintf("%06d", mt_rand(1, 999999));
			return $secpin;
		}
		

		//user
		$first_name = $request->input('first_name');
		$last_name = $request->input('last_name');
		$email_address = $request->input('email_address');
		$mobile_no = $request->input('mobile_no');

		//network
		$sponsor_id = $request->input('sponsor');
		$upline_placement_id = $request->input('upline_placement');
		$placement_position = $request->input('placement_position');
		if($sponsor_id=='' || $sponsor_id==null){
			$sponsor_id=0;
			$upline_placement_id=0;
			$placement_position='null';
		}else{
			$sponsor = DB::table('users')->where('username',$sponsor_id)->first();
			$sponsor_id=$sponsor->id;
			$upline_placement = DB::table('users')->where('username',$upline_placement_id)->first();
			$upline_placement_id=$upline_placement->id;
		}
		$package = $request->input('package_type');
		$product_number = $request->input('product_num');

		//product codes
		//$product_code = $request->input('product_codes');
		//$security_pin = $request->input('sec_pin');

		$middle_name = "";	
		$username = "";
		
		$emails = DB::table('users')->where('email',$email_address)->first();
		//$product_codes = DB::table('product_codes')->where('code',$product_code)->where('status',0)->first();

		 
		if($emails){
			return response()->json([
				'message' => 'Email Address is already taken',
			],500);
		} /*else if(!$product_codes){
			return response()->json([
				'message' => 'Product Codes Invalid',
			],500);
		}*/ else /*if($product_codes)*/ {
			DB::beginTransaction();		 

			try {
				$user = new User();
				$user->username = $email_address;
				$user->plain_password = secpin();
				$user->password = bcrypt($user->plain_password);
				$user->email = $email_address;
				$user->userType = "user";
				$user->save();

				$user_info = new UserInfo();
				$user_info->user_id = $user->id;
				$user_info->first_name = $first_name;
				$user_info->last_name = $last_name;
				$user_info->mobile_no = $mobile_no;
				$user_info->save();

				$network = new Network();
				$network->user_id = $user->id;
				$network->sponsor_id = $sponsor_id;
				$network->upline_placement_id = $upline_placement_id;
				$network->placement_position = $placement_position;
				$network->package = $package;
				$network->save();
				
				for($i=1;$i<=$product_number;$i++){
					//$license = sernum(); 
					//$security_pin = secpin();
					$product_codes = ProductCode::where('code',sernum())->get();
					if($product_codes->isEmpty()) {
						$product_code = new ProductCode();
						$product_code->sponsor_id = $user->id;
						$product_code->category = $package;
						$product_code->code = sernum();
						$product_code->security_pin = secpin();
						$product_code->save();	
					}
				}
				
				

				//$product_codes = DB::table('product_codes')->where('code',$product_code)->update(['user_id' => $user->id,'status' => 1]);

				//DB::commit();
				
				//->with('success',$generated_product_codes);
				DB::commit();

				$generated_product_codes = DB::table('product_codes')
            		->join('packages', 'product_codes.category', '=', 'packages.id')
            		->select('product_codes.code','product_codes.security_pin', 'packages.type')
					->where('product_codes.sponsor_id',$user->id)
            		->get();
				
				Session::flash('product_codes',$generated_product_codes); 
				Session::flash('password',$user->plain_password);
				Session::flash('username',$email_address);
				//$product_codes = ProductCode::where('code',sernum())->get()
				return response()->json([
					'message' => 'ok',
				],200);


			} catch(\Throwable $e){
				DB::rollback();
				return response()->json([
					'message' => $e->getMessage(),
				],500);
			}
			 
		 }
	}

    
    // Get Member Datas
    public function memberEdit(Request $request){
		$id = $request['id'];
        $users = DB::table('users')
            ->join('user_infos', 'user_infos.user_id', '=', 'users.id')
			->leftJoin('product_codes','users.id','=','product_codes.user_id')
			->leftJoin('packages','product_codes.category','=','packages.id')
			->select('users.id AS id','users.branch_id','users.username','users.plain_password','users.email','users.userType','user_infos.first_name','user_infos.middle_name','user_infos.last_name','user_infos.mobile_no')
			->where('users.id',$id)
            ->first(); 
        return response()->json($users);
    }
    
    public function memberUpdate(Request $request){
        $user=User::find($request['id']);
		
		$email = $request['email_address'];
		//$username = $request['username'];
		$role = $request['role'];
		$branch_id = $request['branch_id'];
        
        
		$new_password = $request['new_password'];
		$confirm_password = $request['confirm_password'];
        
		
		
        $emails=User::where('email',$email)->first();
        //$usernames=User::where('username',$username)->first();
		
		DB::beginTransaction();
		try {
		
			if($emails){
				if($user->email == $email){
				} else {
					return response()->json([
						'message' => 'Email already used by other user!',
					],500);
				}
			} else {
				$user->email = $email;
			}
		
			/*if($usernames){
				if($user->username == $username){
				} else {
					return response()->json([
						'message' => 'Username already used by other user!',
					],500);
				}
			} else {
				$user->username = $username;
			}*/
            
            if($new_password && $confirm_password){
                if($new_password != $confirm_password){
				    return response()->json([
						'message' => 'Password Not Match',
					],500);
                } else {
                    $user->password = bcrypt($new_password);
                    $user->plain_password = $new_password;
                }
            }
            

			if($role){ $user->userType = $role; }
			if($branch_id){ $user->branch_id = $branch_id; }
			
			$user->save();
			
			$user_info = UserInfo::where('user_id',$request['id'])->first();
			$user_info->first_name = $request['first_name'];
			$user_info->middle_name = $request['middle_name'];
			$user_info->last_name = $request['last_name'];
			$user_info->mobile_no = $request['mobile_no'];
			$user_info->save();
			DB::commit();
			return response()->json();
        
		}catch(\Throwable $e){
			DB::rollback();
			return response()->json([
				'message' => $e->getMessage(),
			],500);
		}
    }
    
    public function memberPasswordUpdate(Request $request){
        $user=User::find($request['id']);
		$new_password = $request['new_password'];
		$confirm_password = $request['confirm_password'];
        
		DB::beginTransaction();
		try {
            if($new_password && $confirm_password){
                if($new_password != $confirm_password){
				    return response()->json([
						'message' => 'Password Not Match',
					],500);
                } else {
                    $user->password = bcrypt($new_password);
                    $user->plain_password = $new_password;
                }
                $user->save();
            } else {
                return response()->json([
						'message' => 'Password Required!',
					],500);
            }
            
            // Insert User Log
            $user_log = new UserLog();
            $user_log->user_id = Auth::id();
            $user_log->description = 24; // Description ID
            $user_log->message = "Changed the password of " . $user->username;
            $user_log->save();
            
			DB::commit();
			return response()->json();
        
		}catch(\Throwable $e){
			DB::rollback();
            
            // Insert User Log Error
			$user_log =  new UserLog();
			$user_log->user_id = Auth::id();
			$user_log->description = 24; // Description ID
			$user_log->status = "Error"; 
			$user_log->error = $e->getMessage();
			$user_log->save();
            
			return response()->json([
				'message' => $e->getMessage(),
			],500);
		}
    }
	
	//Add new user
	public function userAdd(Request $request){
		$email = $request['add_email_address'];
		$username = $request['add_username'];
		$password = $request['add_password'];
		$branch_id = $request['add_branch'];
		$confirm_password = $request['add_confirm_password'];
		
		
        $emails=User::where('email',$email)->first();
        $username_validation=User::where('username',$username)->first();
		if($emails){
			return response()->json([
				'message' => 'Email already used',
			],500);
		} else if($username_validation){
			return response()->json([
				'message' => 'Username already exist!',
			],500);

		} else if($password != $confirm_password){
			return response()->json([
				'message' => 'Password not match!',
			],500);

		} else {
			DB::beginTransaction();
			try {
				$user = new User();
				$user->email = $email;
				$user->branch_id = $branch_id;
				$user->username = $username;
				$user->password =  bcrypt($password);
				$user->plain_password =  $password;
				$user->userType = $request['add_role'];
				$user->account_type = 1;
				$user->status = 1;
				$user->save();
				
            	$user_info = new UserInfo();
				if($request['add_image']){
					if (!is_dir(public_path('images/users'))) {
						mkdir(public_path('images/users'), 0777);
					}
					request()->validate([
            			'add_image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:6048',
        			]);
					$imageName = time().'.'.request()->add_image->getClientOriginalExtension();
					request()->add_image->move(public_path('images/users/'. $user->id), $imageName);
					$user_info->profile_picture = $imageName;
				}
            	$user_info->user_id = $user->id;
            	$user_info->first_name = $request['add_first_name'];
            	$user_info->last_name = $request['add_last_name'];
            	$user_info->mobile_no = $request['add_mobile_number'];
            	$user_info->status = 1;
				$user_info->save();
				
				if($request['add_role']=="staff" || $request['add_role']=="Staff" || $request['add_role']=="admin"){
					$access = new UserPrivelege();
					$access->user_id = $user->id;
					$access->privelege = $request['access_rights'];
					$access->save();
				}
				DB::commit();
            	return response()->json();
			}catch(\Throwable $e){
				DB::rollback();
				return response()->json([
					'message' => $e->getMessage(),
				],500);
			}
        	
		}
    }
	
	//Activate/Deactivate member
	public function modifyMember(Request $request){
		DB::beginTransaction();
		try {
			$id = $request['id'];
  
			$user = User::find($id);
			if($user->status == 0 || $user->status == 2){
				//Activate User
				$status = 1;
			} else {
				//Deactivate User
				$status = 2;
			}

			$user->status = $status;
			$user->save();

			$user_info = UserInfo::where('user_id',$id)->first();
			$user_info->status = $status;
			$user_info->save();

			DB::commit();

			return response()->json();

		}catch(\Throwable $e){
			DB::rollback();
			return response()->json([
				'message' => $e->getMessage(),
			],500);
		}
	}
    
    
    //Delete Members VIew
    public function deleteMember(){
        return view('admin.members.delete-member');
    }
    
        
    public function selectMembers(Request $request){
        $term = $request['term'];
		$auth = Auth::id();
        
        if($term){
            $users = DB::table('users')
                ->where('id','!=',$auth)
                ->where('userType','user')
                ->select('id','username AS text')
                ->where('username', 'LIKE',"%{$term}%")
                ->get();
        } else {
           $users = DB::table('users')->where('id','!=',$auth)->where('userType','user')->select('id','username AS text')->get(); 
        }
		return response()->json([
			'results' => $users,
        ]);

	}
    
    public function deleteUser(Request $request){
		DB::beginTransaction();
		try {
			$id = $request['id'];
  
			$user = User::find($id);
            $user->status = 2;
			$user->save();
            
			$user_info = UserInfo::where('user_id',$user->id)->first();;
			$user_info->status = $user->status;
			$user_info->save();
			DB::commit();
			return response()->json();
		}catch(\Throwable $e){
			DB::rollback();
			return response()->json([
				'message' => $e->getMessage(),
			],500);
		}
	}
    
    //Change Sponsor VIew
    public function changeSponsorView(){
        return view('admin.members.change-sponsor');
    }

	public function changeSponsor(Request $request){
		DB::beginTransaction();
		try {
			$username_sponsor = $request['username_sponsor'];
			$user_id = $request['user_id'];
            
			$check_sponsor = User::where('username',$username_sponsor)->first();;
			if(!empty($check_sponsor)){
				$network = Network::where('user_id',$user_id)->first();;
				$network->sponsor_id = $check_sponsor->id;
				$network->save();
				DB::commit();
				return response()->json([
					'message' => 'ok',
				],200);
			}else{
				return response()->json([
					'message' => 'err1',
				],500);
			}
			
		}catch(\Throwable $e){
			DB::rollback();
			return response()->json([
				'message' => $e->getMessage(),
			],500);
		}
	}
    
    public function changeSponsorById(Request $request){
		DB::beginTransaction();
		try {
			$username = $request['username']; //Sponsor to change
			$new_sponsor = $request['new_sponsor']; //New Sponsor
            
            $nSponsor = User::select('username')->where('id',$new_sponsor)->first();
			
            foreach($username as $user_id){
                $network = Network::where('user_id',$user_id)->first();
				$network->sponsor_id = $new_sponsor;
				$network->save();
                
                // Insert User Log
                $user = User::select('username')->where('id',$user_id)->first();
                
                
                $user_log = new UserLog();
                $user_log->user_id = Auth::id();
                $user_log->description = 26; // Description ID
                $user_log->message = "Changed Sponsor of Username:" . $user->username . ' To ' . $nSponsor->username;
                $user_log->ip_address = $_SERVER['REMOTE_ADDR'];
                $user_log->save();
            }
				
            DB::commit();
            return response()->json([
                'message' => 'ok',
            ],200);
			
		}catch(\Throwable $e){
			DB::rollback();
            // Insert User Log Error
			$user_log = new UserLog();
			$user_log->user_id = Auth::id();
			$user_log->description = 26; // Description ID
			$user_log->status = "Error"; 
			$user_log->error = $e->getMessage();
            $user_log->ip_address = $_SERVER['REMOTE_ADDR'];
			$user_log->save();
			return response()->json([
				'message' => $e->getMessage(),
			],500);
		}
	}

	//get datas in member register section
	public function memberGetData(){
		$users = DB::table('users')->select('username','email')->get();
		$product_codes = DB::table('product_codes')->select('code','security_pin')->where('status',0)->get();
		$package = DB::table('packages')->select('id','type')->get();
		return response()->json([
			'users' => $users,
			'product_codes' => $product_codes,
			'package' => $package
        ]);

	}
	
	public function userGetData($code,$pin){
		$product_codes = DB::table('product_codes')->where('code',$code)->where('security_pin',$pin)->first();
		$sponsor_id=$product_codes->sponsor_id;		
		$check_user_in_pcode = DB::table('product_codes')->where('user_id',$sponsor_id)->count();
		$already_in_user=false;
		$user_data = DB::table('users')
			->join('user_infos', 'user_infos.user_id', '=', 'users.id')
			->join('networks', 'networks.user_id', '=', 'users.id')
			->select('users.id AS user_id','users.username AS u_user','users.email AS u_email','user_infos.first_name AS f_name','user_infos.last_name AS l_name','user_infos.mobile_no AS mobile','networks.sponsor_id','networks.upline_placement_id','networks.upline_placement_id','networks.placement_position')
			->where('users.id',$sponsor_id)
			->first();
		
		
		if($check_user_in_pcode>=1){
			//if user_id(column) from sponsor_id is existing in product_code tables means this code and pin...
			//add = sponsor already registered
			$already_in_user=true;
			/* if($sponsor_id){
				$sponsor_net=DB::table('users')->select('username')->where('id',$sponsor_id)->first();
				if($sponsor_net){
					$temp_arr=array('sponsor_username'=>$sponsor_net->username);
					array_push($user_data,$temp_arr);
				}
			} */
			
		}else{
			//update = sponsor not yet registered
			$already_in_user=false;

			$sponsor_net=array();
			$upline_net=array();
			if($user_data->sponsor_id){
				$sponsor_net=DB::table('users')->select('username')->where('id',$user_data->sponsor_id)->first();
			}
			if($user_data->upline_placement_id){
				$upline_net=DB::table('users')->select('username')->where('id',$user_data->upline_placement_id)->first();
			}
			if($sponsor_net){
				$temp_arr=array('sponsor_username'=>$sponsor_net->username);
				array_push($user_data,$temp_arr);
			}
			if($upline_net){
				$temp_arr=array('upline_username'=>$upline_net->username);
				array_push($user_data,$temp_arr);
			}
		}
		return response()->json([
			'user_data' => $user_data,
			'already_in_user' => $already_in_user
		]);

	}

	//check username in user activation
	public function checkUsername($username){
		$check_user = DB::table('users')->where('username',$username)->first();
		$valid_username=0;
		if($check_user){
			$valid_username=1;
		}
		return response()->json([
			'valid_username' => $valid_username
        ]);

	}

	//check activation code in user activation
	public function registerCheckCode($code){
		$check_code = DB::table('product_codes')->where('code',$code)->where('status',0)->first();
		$valid_code=0;//invalid
		if($check_code){
			$valid_code=1;//valid
		}
		return response()->json([
			'valid_code' => $valid_code
        ]);

	}

	//check activation code and pin in user activation
	public function registerCheckPin($code,$pin){
		$check_pin = DB::table('product_codes')->where('code',$code)->where('security_pin',$pin)->where('status',0)->first();
		$valid_pin=0;//invalid
		if($check_pin){
			$valid_pin=1;//valid
		}
		return response()->json([
			'valid_pin' => $valid_pin
        ]);

	}
    
    public function members_pv_points(){
        $PvPointEdit =  PvPointEdit::all();
        return view('admin.members.pv-points',compact('PvPointEdit'));
	}

	
	public function members_data_checker(){
        return view('admin.members.data-checker');
	}

	public function get_data_checker(Request $request){
		$Flushout_array=[];
		$pv_array=[];
		$array=[];
		$data="";
		 $user_id = $request->username;
		$Flushout = DB::table('flushouts')
		->join('users', 'flushouts.user_id', '=', 'users.id')
		->where('users.id',$user_id)
		->select('flushouts.created_at as date','flushouts.*','users.*' )
		->get();

		
		$PvPointsHistory = DB::table('pv_points_histories')
		->join('users', 'pv_points_histories.user_id', '=', 'users.id')
		->where('users.id',$user_id)
		->select('pv_points_histories.created_at as date','pv_points_histories.*','users.*' )
		->get();

		foreach ($PvPointsHistory as $value) {
			$users = DB::table('users')->where('users.id',$value->sponsor)->first();
			$data=$data."<tr><td>$value->pv_point</td><td>$value->position</td><td>$users->username</td><td>$value->date</td></tr>";
			
		}
		$pv_array=['PvPointsHistory'=>$data];
		array_push($array,$pv_array); 
		$data="";
		foreach ($Flushout as $value) {
			$users = DB::table('users')->where('users.id',$value->sponsor)->first();
			$data=$data."<tr><td>$value->flush_pv_point</td><td>$value->position</td><td>$users->username</td><td>$value->state</td><td>$value->date</td></tr>";
			
		}

		$Flushout_array=['Flushout_array'=>$data];
		array_push($array,$Flushout_array);
		
		return	$array;
	}

	public function get_members_pv_points(Request $request){
        $username =  $request->username;
        $pv = DB::table('users')
            ->join('pv_points', 'pv_points.user_id', '=', 'users.id')
            ->where('users.id',$username)
            ->first();
        return response()->json($pv);
    }

    public function update_members_pv_points(Request $request){
        $user_id = Auth::id();
        $username = $request['username'];
        $left=0;
        $right=0;
    
        $left = $request['pvLeft'];
        $right = $request['pvRight'];
        $position="";
        $oldPvPoints=0;
        $newPv=0;
	
        DB::beginTransaction();
        try {
		
            $PvPoint_id_data = DB::table('users')
                ->join('pv_points', 'pv_points.user_id', '=', 'users.id')
                ->where('users.id',$username)
                ->first();
            $PvPoint_id= $PvPoint_id_data->id;
            $PvPoint=PvPoint::find($PvPoint_id);
            if($PvPoint->leftpart!=0){
                $oldPvPoints=$PvPoint->leftpart;
                $PvPoint->leftpart = $left;
                $newPv =$left;
                $position="left";
            }else{
                $oldPvPoints=$PvPoint->rightpart;
                $PvPoint->rightpart = $right;
                $newPv = $right;
                $position="right";
            }
            $PvPoint->save();

            $PvPointEdit = new PvPointEdit();
            $PvPointEdit->user_id = $user_id;
            $PvPointEdit->Username = $PvPoint_id_data->username;
            $PvPointEdit->pv_point_old = $oldPvPoints;
            $PvPointEdit->position = $position;
            $PvPointEdit->new_value = $newPv;
            $PvPointEdit->save();
				
            DB::commit();

            return response()->json();
        } catch(\Throwable $e){
            DB::rollback();
            // Insert User Log Error
            $user_log =  new UserLog();
            $user_log->user_id = Auth::id();
            $user_log->description = 19; // Description ID
            $user_log->status = "Error"; 
            $user_log->error = $e->getMessage();
            $user_log->save();
		
            return response()->json([
                'message' => $e->getMessage(),
            ],500);
        }
    }

        /**
         * Add income to user referrals
         */
        public function addIncome(Request $request)
        {
            try {
                $user_id = $request->input('user_id');
                $amount = $request->input('amount');
                $referral_type = $request->input('referral_type');
                $reason = $request->input('reason');

                // Create a referral record
                $referral = new Referral();
                $referral->user_id = $user_id;
                $referral->source_id = Auth::id();  // Admin/staff user who added it
                $referral->amount = $amount;
                $referral->referral_type = $referral_type;
                $referral->reward_type = 'php';
                $referral->hierarchy = 0;
                $referral->status = 1;
                $referral->remarks = $reason;
                $referral->save();

                return response()->json([
                    'success' => true,
                    'message' => 'Income of ' . number_format($amount, 2) . ' ¥ added successfully'
                ]);
            } catch (\Exception $e) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error: ' . $e->getMessage()
                ], 500);
            }
        }

        /**
         * Deduct income from user referrals
         */
        public function deductIncome(Request $request)
        {
            try {
                $user_id = $request->input('user_id');
                $amount = $request->input('amount');
                $referral_type = $request->input('referral_type');
                $reason = $request->input('reason');

                // Create a negative referral record (deduction)
                $referral = new Referral();
                $referral->user_id = $user_id;
                $referral->source_id = Auth::id();  // Admin/staff user who deducted it
                $referral->amount = -$amount;  // Negative amount for deduction
                $referral->referral_type = $referral_type;
                $referral->reward_type = 'php';
                $referral->hierarchy = 0;
                $referral->status = 1;
                $referral->remarks = $reason;
                $referral->save();

                return response()->json([
                    'success' => true,
                    'message' => 'Income of ' . number_format($amount, 2) . ' ¥ deducted successfully'
                ]);
            } catch (\Exception $e) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error: ' . $e->getMessage()
                ], 500);
            }
        }

        /**
         * Get manually added incomes for a user
         */
        public function getAddedIncomes($user_id)
        {
            try {
                $incomes = Referral::where('user_id', $user_id)
                    ->where('hierarchy', 0)
                    ->orderBy('created_at', 'desc')
                    ->get()
                    ->map(function ($income) {
                        return [
                            'id' => $income->id,
                            'amount' => $income->amount,
                            'referral_type' => $income->referral_type,
                            'remarks' => $income->remarks,
                            'created_at' => $income->created_at->format('Y-m-d H:i'),
                            'type_label' => $income->referral_type == 'direct_referral_bonus' ? 'Referral Bonus' : 'Other Income',
                            'status_badge' => $income->status == 1 ? '<span class="badge badge-success">Active</span>' : '<span class="badge badge-danger">Inactive</span>'
                        ];
                    });

                return response()->json([
                    'success' => true,
                    'data' => $incomes
                ]);
            } catch (\Exception $e) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error: ' . $e->getMessage()
                ], 500);
            }
        }

        /**
         * Update manually added income
         */
        public function updateIncome(Request $request, $id)
        {
            try {
                $income = Referral::find($id);
                
                if (!$income) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Income record not found'
                    ], 404);
                }

                $newAmount = $request->input('amount');
                $oldAmount = $income->amount;
                
                $income->amount = $newAmount;
                $income->remarks = $request->input('remarks');
                $income->save();

                return response()->json([
                    'success' => true,
                    'message' => 'Income updated from ' . number_format($oldAmount, 2) . ' to ' . number_format($newAmount, 2) . ' successfully'
                ]);
            } catch (\Exception $e) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error: ' . $e->getMessage()
                ], 500);
            }
        }

        /**
         * Delete manually added income
         */
        public function deleteIncome($id)
        {
            try {
                $income = Referral::find($id);
                
                if (!$income) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Income record not found'
                    ], 404);
                }

                $amount = $income->amount;
                $income->delete();

                return response()->json([
                    'success' => true,
                    'message' => 'Income of ' . number_format(abs($amount), 2) . ' deleted successfully'
                ]);
            } catch (\Exception $e) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error: ' . $e->getMessage()
                ], 500);
            }
        }

        /**
         * Calculate total accumulated income for a user
         * Includes: referrals + pairing bonus + income transfers
         */
        private function calculateUserTotalIncome($user_id)
        {
            $total_accumulated = 0;

            // Base referrals (excluding sales_match_bonus)
            $referrals = DB::table('referrals')
                ->where('user_id', $user_id)
                ->where('reward_type', 'php')
                ->where('referral_type', '!=', 'sales_match_bonus')
                ->sum('amount');
            
            $total_accumulated += $referrals;

            // Add pairing bonus
            try {
                $pairingComputation = \App\PairingComputation::where('user_id', $user_id)->first();
                if ($pairingComputation) {
                    $TPBunos = $pairingComputation->pairing_bonus ?? 0;
                    $total_accumulated += $TPBunos;
                }
            } catch (\Exception $e) {
                // Pairing computation may not exist
            }

            // Income transfers (received - sent)
            $transfer = DB::table('income_transfers')
                ->where(function ($query) use ($user_id) {
                    $query->where('from_user_id', $user_id)
                        ->orWhere('to_user_id', $user_id);
                })
                ->where('status', 1)
                ->get();

            $total_sent = $transfer->where('from_user_id', $user_id)->sum('amount');
            $total_receive = $transfer->where('to_user_id', $user_id)->sum('new_amount');
            
            if (!empty($total_receive)) {
                $total_accumulated += $total_receive;
            }
            if (!empty($total_sent)) {
                $total_accumulated -= $total_sent;
            }

            return $total_accumulated;
        }
}
