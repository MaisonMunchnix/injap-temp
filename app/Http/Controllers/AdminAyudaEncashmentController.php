<?php

namespace App\Http\Controllers;

use App\User;
use App\UserLog;
use App\UserInfo;
use App\Referral;
use App\AyudaEncashment;
use App\UserPrivelege;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

//Export Excel
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\EncashmentExport;


class AdminAyudaEncashmentController extends Controller
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



    public function adminViewEncashment($type, Request $request){
        $date_start = str_replace('/','-',$request->input('date_start'));
        
        //$ayuda_tax = 0;
        
        
        $valid_type=array('pending','approved','claimed','hold','decline','all');
        if (!in_array($type, $valid_type)){
            return view('view.error_404');
        }else{
            $pass_type=$type;
            
            
            
            if($type=='all'){
                $get_encashment = DB::table('ayuda_encashments')
                    ->join('users', 'users.id', '=', 'ayuda_encashments.user_id')
                    ->join('user_infos', 'user_infos.user_id', '=', 'ayuda_encashments.user_id')
                    ->select('users.username AS username','user_infos.first_name AS member_fname','user_infos.last_name AS member_lname','ayuda_encashments.status AS encash_status','ayuda_encashments.created_at AS encash_created','ayuda_encashments.updated_at AS encash_updated','ayuda_encashments.approved_date AS encash_appr_date','ayuda_encashments.claimed_date AS encash_claimed_date','ayuda_encashments.amount_requested AS amt_req','ayuda_encashments.amount_approved AS amt_appr','ayuda_encashments.id AS tid')
                    ->get(); 
            }else{
                $get_encashment = DB::table('ayuda_encashments')
                    ->join('users', 'users.id', '=', 'ayuda_encashments.user_id')
                    ->join('user_infos', 'user_infos.user_id', '=', 'ayuda_encashments.user_id')
                    ->select('users.username AS username','user_infos.first_name AS member_fname','user_infos.last_name AS member_lname','ayuda_encashments.status AS encash_status','ayuda_encashments.created_at AS encash_created','ayuda_encashments.updated_at AS encash_updated','ayuda_encashments.approved_date AS encash_appr_date','ayuda_encashments.claimed_date AS encash_claimed_date','ayuda_encashments.amount_requested AS amt_req','ayuda_encashments.amount_approved AS amt_appr','ayuda_encashments.id AS tid')
                    ->where('ayuda_encashments.status',$pass_type)
                    ->get();
                
            }
            return view('admin.encashment.ayuda.index',compact('get_encashment','type','ayuda_tax'));
        }
                
    }
    
    //Paginated 10-26-2020
    public function adminViewEncashmentPaginate($type, Request $request){
        $date_start = str_replace('/','-',$request->input('date_start'));
        $date_end = str_replace('/','-',$request->input('date_end'));
        $datecreate_start = date_format(date_create($date_start),'Y-m-d');
        $datecreate_end = date_format(date_create($date_end),'Y-m-d');
        $search = $request->input('search');
        
        $lastWeek = Carbon::now()->subWeek();
        
        $ayuda_tax = 0;
        $process_fee = 0;
        
        $paginate = $request->input('paginate');
        if(empty($paginate)){
            $paginate = 50;
        }
        
        $valid_type=array('pending','approved','claimed','hold','decline','all');
        if (!in_array($type, $valid_type)){
            return view('view.error_404');
        }else{
            $pass_type = $type;
            if($type=='all'){
                if(empty($search)){
                    if($date_start){
                        $encashments = DB::table('ayuda_encashments_view')
                            ->whereBetween('encash_created', array($datecreate_start . ' 00:00:00', $datecreate_end . ' 23:59:59'))
                            ->simplePaginate($paginate)
                            ->appends(request()->query());
                            //->simplePaginate($paginate);
                    } else {
                        $encashments = DB::table('ayuda_encashments_view')
                            ->where('encash_created','>=',$lastWeek)
                            //->simplePaginate($paginate);
                            ->simplePaginate($paginate)
                            ->appends(request()->query());
                    }
                } else if($search && $date_start){
                    $encashments = DB::table('ayuda_encashments_view')
                        ->whereBetween('encash_created', array($datecreate_start . ' 00:00:00', $datecreate_end . ' 23:59:59'))
                        ->where('username','like','%'.$search.'%')
                        //->simplePaginate($paginate);
                        ->simplePaginate($paginate)
                        ->appends(request()->query());
                } else {
                    if($date_start){
                        $encashments = DB::table('ayuda_encashments_view')
                        ->whereBetween('encash_created', array($datecreate_start . ' 00:00:00', $datecreate_end . ' 23:59:59'))
                        ->orWhere('username','like','%'.$search.'%')
                        ->simplePaginate($paginate);
                    } else {
                        $encashments = DB::table('ayuda_encashments_view')
                        ->where('username','like','%'.$search.'%')
                        ->simplePaginate($paginate)
                        ->appends(request()->query());
                        //->simplePaginate($paginate); 
                    }
                }
            } else {
                if(empty($search)){
                    if($date_start){
                        $encashments = DB::table('ayuda_encashments_view')
                            ->where('encash_status',$pass_type)
                            ->whereBetween('encash_created', array($datecreate_start . ' 00:00:00', $datecreate_end . ' 23:59:59'))
                            ->simplePaginate($paginate)
                            ->appends(request()->query());
                        //->simplePaginate($paginate); 
                    } else {
                        $encashments = DB::table('ayuda_encashments_view')
                            ->where('encash_status',$pass_type)
                           ->simplePaginate($paginate)
                            ->appends(request()->query());
                        //->simplePaginate($paginate); 
                    }
                } else {
                    if($date_start){
                        $encashments = DB::table('ayuda_encashments_view')
                        ->where('encash_status',$pass_type)
                        ->whereBetween('encash_created', array($datecreate_start . ' 00:00:00', $datecreate_end . ' 23:59:59'))
                        ->orWhere('username','like','%'.$search.'%')
                        ->simplePaginate($paginate)
                        ->appends(request()->query());
                        //->simplePaginate($paginate); 
                    } else {
                        $encashments = DB::table('ayuda_encashments_view')
                        ->where('encash_status',$pass_type)
                        ->where('username','like','%'.$search.'%')
                        ->simplePaginate($paginate)
                        ->appends(request()->query());
                        //->simplePaginate($paginate); 
                    }
                }
        
            }
            
            if($request->button == "export"){
                return Excel::download(new EncashmentExport($datecreate_start,$datecreate_end), 'encashments-'. now() .'.xlsx');
            } else {
                return view('admin.encashment.ayuda.index-paginate',compact('encashments','type','request','ayuda_tax','process_fee'));  
            }
        }
	}

    public function adminViewVoucher($id){
        $get_encash = DB::table('ayuda_encashments')
        ->join('users', 'users.id', '=', 'ayuda_encashments.user_id')
        ->join('user_infos', 'user_infos.user_id', '=', 'ayuda_encashments.user_id')
        ->leftJoin('banks', 'user_infos.bank_name', '=', 'banks.id')
        ->select('users.username AS username','user_infos.first_name AS member_fname','user_infos.last_name AS member_lname','user_infos.team_name','banks.name AS bank_name','user_infos.bank_account_number','user_infos.tin','ayuda_encashments.*')
        ->where('ayuda_encashments.id',$id)
        ->first();
        return view('admin.encashment.ayuda.encashment_voucher',compact('get_encash'));  
    }

    public function allEncashments(Request $request){
        $columns = array( 
			0 => 'encash_created',
			1 => 'amt_req',
			2 => 'amt_appr',
			3 => 'username',
            4 => 'member_fname',
            5 => 'member_lname',
            6 => 'encash_status',
            7 => 'encash_updated',
			8 => 'action'
        );
        
        
        $totalData=0;
        $filter=$request['filter_type'];
        $date_start = str_replace('/','-',$request->input('date_start'));
        $date_end = str_replace('/','-',$request->input('date_end'));
        $datecreate_start = date_format(date_create($date_start),'Y-m-d');
        $datecreate_end = date_format(date_create($date_end),'Y-m-d');
        
                    
        if($date_start){
            if($filter=='all'){
                $totalData = DB::table('ayuda_encashments_view')
                    ->whereBetween('encash_created', array($datecreate_start . ' 00:00:00', $datecreate_end . ' 23:59:59'))
                    ->count();
            }else{
                $totalData = DB::table('ayuda_encashments_view')
                    ->where('encash_status',$filter)
                    ->whereBetween('encash_created', array($datecreate_start . ' 00:00:00', $datecreate_end . ' 23:59:59'))
                    ->count();
            }

        } else {
            if($filter=='all'){
                $totalData = DB::table('ayuda_encashments_view')->count();
            }else{
                $totalData = DB::table('ayuda_encashments_view')->where('encash_status',$filter)->count();
            }

        }
        
        $totalFiltered = $totalData; 
        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');
        $encashments="";
        if(empty($request->input('search.value'))){
            if($filter=='all'){
                if($date_start){
                    $encashments = DB::table('ayuda_encashments_view')
                        ->whereBetween('encash_created', array($datecreate_start . ' 00:00:00', $datecreate_end . ' 23:59:59'))
                        ->offset($start)
                        ->limit($limit)
                        ->orderBy($order,$dir)
                        ->get();
                } else {
                    $encashments = DB::table('ayuda_encashments_view')
                        ->offset($start)
                        ->limit($limit)
                        ->orderBy($order,$dir)
                        ->get();
                }
                
            }else{
                if($date_start){
                    $encashments = DB::table('ayuda_encashments_view')
                        ->where('encash_status',$filter)
                        ->whereBetween('encash_created', array($datecreate_start . ' 00:00:00', $datecreate_end . ' 23:59:59'))
                        ->offset($start)
                        ->limit($limit)
                        ->orderBy($order,$dir)
                        ->get();
                } else {
                    $encashments = DB::table('ayuda_encashments_view')
                        ->where('encash_status',$filter)
                        ->offset($start)
                        ->limit($limit)
                        ->orderBy($order,$dir)
                        ->get();
                }
                
            }
        } else {
            $search = $request->input('search.value'); 
            if(is_numeric($search)){
                $search = ltrim($search, '0');
            }
            if($filter=='all'){
                if($date_start){
                    $encashments = DB::table('ayuda_encashments_view')
                        ->whereBetween('encash_created', array($datecreate_start . ' 00:00:00', $datecreate_end . ' 23:59:59'))
                        ->where('username','LIKE',"%{$search}%")
                        ->orWhere('member_fname', 'LIKE',"%{$search}%")
                        ->orWhere('member_lname', 'LIKE',"%{$search}%")
                        ->orWhere('encash_status', 'LIKE',"%{$search}%")
                        ->orWhere('encash_created', 'LIKE',"%{$search}%")
                        ->orWhere('encash_updated', 'LIKE',"%{$search}%")
                        ->orWhere('encash_appr_date', 'LIKE',"%{$search}%")
                        ->orWhere('encash_claimed_date', 'LIKE',"%{$search}%")
                        ->orWhere('amt_req', 'LIKE',"%{$search}%")
                        ->orWhere('amt_appr', 'LIKE',"%{$search}%")
                        ->offset($start)
                        ->limit($limit)
                        ->orderBy($order,$dir)
                        ->get();

                    $totalFiltered = DB::table('ayuda_encashments_view')
                        ->whereBetween('encash_created', array($datecreate_start . ' 00:00:00', $datecreate_end . ' 23:59:59'))
                        ->where('username','LIKE',"%{$search}%")
                        ->orWhere('member_fname', 'LIKE',"%{$search}%")
                        ->orWhere('member_lname', 'LIKE',"%{$search}%")
                        ->orWhere('encash_status', 'LIKE',"%{$search}%")
                        ->orWhere('encash_created', 'LIKE',"%{$search}%")
                        ->orWhere('encash_updated', 'LIKE',"%{$search}%")
                        ->orWhere('encash_appr_date', 'LIKE',"%{$search}%")
                        ->orWhere('encash_claimed_date', 'LIKE',"%{$search}%")
                        ->orWhere('amt_req', 'LIKE',"%{$search}%")
                        ->orWhere('amt_appr', 'LIKE',"%{$search}%")
                        ->count();
                    
                } else {
                    $encashments = DB::table('ayuda_encashments_view')
                        ->where('username','LIKE',"%{$search}%")
                        ->orWhere('member_fname', 'LIKE',"%{$search}%")
                        ->orWhere('member_lname', 'LIKE',"%{$search}%")
                        ->orWhere('encash_status', 'LIKE',"%{$search}%")
                        ->orWhere('encash_created', 'LIKE',"%{$search}%")
                        ->orWhere('encash_updated', 'LIKE',"%{$search}%")
                        ->orWhere('encash_appr_date', 'LIKE',"%{$search}%")
                        ->orWhere('encash_claimed_date', 'LIKE',"%{$search}%")
                        ->orWhere('amt_req', 'LIKE',"%{$search}%")
                        ->orWhere('amt_appr', 'LIKE',"%{$search}%")
                        ->offset($start)
                        ->limit($limit)
                        ->orderBy($order,$dir)
                        ->get();

                    $totalFiltered = DB::table('ayuda_encashments_view')
                        ->where('username','LIKE',"%{$search}%")
                        ->orWhere('member_fname', 'LIKE',"%{$search}%")
                        ->orWhere('member_lname', 'LIKE',"%{$search}%")
                        ->orWhere('encash_status', 'LIKE',"%{$search}%")
                        ->orWhere('encash_created', 'LIKE',"%{$search}%")
                        ->orWhere('encash_updated', 'LIKE',"%{$search}%")
                        ->orWhere('encash_appr_date', 'LIKE',"%{$search}%")
                        ->orWhere('encash_claimed_date', 'LIKE',"%{$search}%")
                        ->orWhere('amt_req', 'LIKE',"%{$search}%")
                        ->orWhere('amt_appr', 'LIKE',"%{$search}%")
                        ->count();
                }
                
                
            } else {
                if($date_start){
                    $encashments = DB::table('ayuda_encashments_view')
                        ->whereBetween('encash_created', array($datecreate_start . ' 00:00:00', $datecreate_end . ' 23:59:59'))
                        ->where('encash_status',$filter)
                        ->where(function ($query)  use ($search) {
                            $query->where('member_fname', 'LIKE',"%{$search}%")
                                ->orWhere('member_lname', 'LIKE',"%{$search}%")
                                ->orWhere('encash_created', 'LIKE',"%{$search}%")
                                ->orWhere('encash_updated', 'LIKE',"%{$search}%")
                                ->orWhere('encash_appr_date', 'LIKE',"%{$search}%")
                                ->orWhere('encash_claimed_date', 'LIKE',"%{$search}%")
                                ->orWhere('amt_req', 'LIKE',"%{$search}%")
                                ->orWhere('amt_appr', 'LIKE',"%{$search}%");
                        })     
                        ->offset($start)
                        ->limit($limit)
                        ->orderBy($order,$dir)
                        ->get();

                    $totalFiltered = DB::table('ayuda_encashments_view')
                        ->whereBetween('encash_created', array($datecreate_start . ' 00:00:00', $datecreate_end . ' 23:59:59'))
                        ->where('encash_status',$filter)
                        ->where(function ($query) use ($search){
                            $query->where('member_fname', 'LIKE',"%{$search}%")
                                ->orWhere('member_lname', 'LIKE',"%{$search}%")
                                ->orWhere('encash_created', 'LIKE',"%{$search}%")
                                ->orWhere('encash_updated', 'LIKE',"%{$search}%")
                                ->orWhere('encash_appr_date', 'LIKE',"%{$search}%")
                                ->orWhere('encash_claimed_date', 'LIKE',"%{$search}%")
                                ->orWhere('amt_req', 'LIKE',"%{$search}%")
                                ->orWhere('amt_appr', 'LIKE',"%{$search}%");
                        })     
                        ->count();
                } else {
                    $encashments = DB::table('ayuda_encashments_view')
                        ->where('encash_status',$filter)
                        ->where(function ($query)  use ($search) {
                            $query->where('member_fname', 'LIKE',"%{$search}%")
                                ->orWhere('member_lname', 'LIKE',"%{$search}%")
                                ->orWhere('encash_created', 'LIKE',"%{$search}%")
                                ->orWhere('encash_updated', 'LIKE',"%{$search}%")
                                ->orWhere('encash_appr_date', 'LIKE',"%{$search}%")
                                ->orWhere('encash_claimed_date', 'LIKE',"%{$search}%")
                                ->orWhere('amt_req', 'LIKE',"%{$search}%")
                                ->orWhere('amt_appr', 'LIKE',"%{$search}%");
                        })     
                        ->offset($start)
                        ->limit($limit)
                        ->orderBy($order,$dir)
                        ->get();

                    $totalFiltered = DB::table('ayuda_encashments_view')
                        ->where('encash_status',$filter)
                        ->where(function ($query) use ($search){
                            $query->where('member_fname', 'LIKE',"%{$search}%")
                                ->orWhere('member_lname', 'LIKE',"%{$search}%")
                                ->orWhere('encash_created', 'LIKE',"%{$search}%")
                                ->orWhere('encash_updated', 'LIKE',"%{$search}%")
                                ->orWhere('encash_appr_date', 'LIKE',"%{$search}%")
                                ->orWhere('encash_claimed_date', 'LIKE',"%{$search}%")
                                ->orWhere('amt_req', 'LIKE',"%{$search}%")
                                ->orWhere('amt_appr', 'LIKE',"%{$search}%");
                        })     
                        ->count();
                }
                
            }
        }
        $ar_approve="";
        $ar_process="";
        $ar_hold="";
        $ar_decline="";
        $privelege=UserPrivelege::where('user_id',Auth::id())->first();
		if(!empty($privelege)){
			$access_data=json_decode($privelege['privelege']);
            $ar_approve=$access_data[0]->encashment[0]->approve;
            $ar_process=$access_data[0]->encashment[0]->process;
            $ar_hold=$access_data[0]->encashment[0]->hold;
            $ar_decline=$access_data[0]->encashment[0]->decline;
        }
                
        $data = array();
        if(!empty($encashments)){
            foreach($encashments as $encash){              
                $amount_appr=0;
                if($encash->encash_status=='approved' || $encash->encash_status=='claimed'){
                    $amount_appr=$encash->amt_appr;
                }
                /* $transact_id=$encash->tid;
                if(strlen($transact_id)<10){
                    $transact_id=sprintf("%010d", $transact_id);
                } */
                $stat="";
                if($encash->encash_status=='approved'){
                    $stat="<span class='text-primary'>".$encash->encash_status."</span>";
                }else if($encash->encash_status=='claimed'){
                    $stat="<span class='text-success'>".$encash->encash_status."</span>";
                }else if($encash->encash_status=='hold' || $encash->encash_status=='decline'){
                    $stat="<span class='text-danger'>".$encash->encash_status."</span>";
                }else{
                    $stat="<span class='text-default'>".$encash->encash_status."</span>";
                }
                $action_data="<button aria-expanded='false' aria-haspopup='true' class='btn btn-primary dropdown-toggle' data-toggle='dropdown' id='dd_action' type='button'>Select Action</button>
                <div aria-labelledby='dd_action'class='dropdown-menu'>";

                
                
                if($encash->encash_status=='pending'){
                    $action_data.="<a class='dropdown-item encash-view' href='#' data-id='$encash->tid'  data-target='#view_encashment_modal' data-toggle='modal'> View Details</a>";
                    if($ar_process=="" || $ar_process=="true"){
                        $action_data.="<a class='dropdown-item process-claim' href='#' data-id='$encash->tid'  data-target='#claim_modal' data-toggle='modal'> Process claim</a>";
                    }
                    if($ar_hold=="" || $ar_hold=="true"){
                        $action_data.="<a class='dropdown-item encash-hold' href='#' data-id='$encash->tid' data-target='#hold_modal' data-toggle='modal'> Hold</a>";
                    }
                    if($ar_decline=="" || $ar_decline=="true"){
                        $action_data.="<a class='dropdown-item encash-decline' href='#' data-id='$encash->tid'  data-target='#decline_modal' data-toggle='modal'> Decline</a>	";
                    }
                                   
                }else if($encash->encash_status=='hold'){
                    $action_data.="<a class='dropdown-item encash-view' href='#' data-id='$encash->tid'  data-target='#view_encashment_modal' data-toggle='modal'> View Details</a>";
                    if($ar_approve=="" || $ar_approve=="true"){
                        $action_data.="<a class='dropdown-item encash-approved' href='#' data-id='$encash->tid' data-amount='$encash->amt_req' data-target='#approve_modal' data-toggle='modal'> Approved</a>";
                    }
                    if($ar_decline=="" || $ar_decline=="true"){
                        $action_data.="<a class='dropdown-item encash-decline' href='#' data-id='$encash->tid'  data-target='#decline_modal' data-toggle='modal'> Decline</a>	";
                    }
                    
                }else if($encash->encash_status=='approved'){
                    $action_data.="<a class='dropdown-item encash-view' href='#' data-id='$encash->tid'  data-target='#view_encashment_modal' data-toggle='modal'> View Details</a>";
                    if($ar_process=="" || $ar_process=="true"){
                        $action_data.="<a class='dropdown-item process-claim' href='#' data-id='$encash->tid'  data-target='#claim_modal' data-toggle='modal'> Process claim</a>";
                    }
                    //$action_data.="<a class='dropdown-item' href='/staff/encashment-voucher/$encash->tid'> View receipt</a>";
                }else{
                    $action_data.="<a class='dropdown-item encash-view' href='#' data-id='$encash->tid'  data-target='#view_encashment_modal' data-toggle='modal'> View Details</a>";
                    $action_data.="<a class='dropdown-item' href='/staff/encashment-voucher/$encash->tid'> View receipt</a>";
                }
                $action_data.="</div>";

                $nestedData['encash_created']=$encash->encash_created;
                $nestedData['amt_req']=number_format($encash->amt_req);
                $nestedData['amount_appr']=number_format($amount_appr);
                $nestedData['username']=$encash->username;
                $nestedData['member_lname']="<span class='text-capitalize'>".$encash->member_lname."</span>";
                $nestedData['member_fname']="<span class='text-capitalize'>".$encash->member_fname."</span>";
                $nestedData['encash_status']="<span class='text-capitalize'>".$stat."</span>";
                $nestedData['encash_updated']=$encash->encash_updated;
                $nestedData['action']=$action_data;
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

    public function getEncashmentData($id){
        $encashment_data=AyudaEncashment::where('id',$id)->first();
        $user_data="";
        $user_process_data="";
        if(!empty($encashment_data)){
            $user_data = DB::table('users')
            ->join('user_infos', 'user_infos.user_id', '=', 'users.id')
            ->select('users.username','user_infos.first_name','user_infos.last_name')
            ->where('users.id',$encashment_data->user_id)
            ->first();
            if(!empty($encashment_data->process_by)){
                $user_process_data = DB::table('users')
                    ->join('user_infos', 'user_infos.user_id', '=', 'users.id')
                    ->select('user_infos.first_name','user_infos.last_name')
                    ->where('users.id',$encashment_data->process_by)
                    ->first();
            }
        }
        return response()->json([
            'encashment_data' => $encashment_data,
            'user_data' => $user_data,
            'user_process_data' => $user_process_data
        ]);
                
    }
    
    public function printEncashmentData($id){
        $encashment_data=AyudaEncashment::where('id',$id)->first();
        $user_data="";
        $user_process_data="";
        if(!empty($encashment_data)){
            $user_data = DB::table('users')
            ->join('user_infos', 'user_infos.user_id', '=', 'users.id')
            ->select('users.username','user_infos.first_name','user_infos.last_name')
            ->where('users.id',$encashment_data->user_id)
            ->first();
            
            if(!empty($encashment_data->process_by)){
                $user_process_data = DB::table('users')
                    ->join('user_infos', 'user_infos.user_id', '=', 'users.id')
                    ->select('user_infos.first_name','user_infos.last_name')
                    ->where('users.id',$encashment_data->process_by)
                    ->first();
            }
        }
        return view('admin.encashment.ayuda.print_details',compact('encashment_data','user_data','user_process_data'));         
    }

    public function processEncashment(Request $request){
        $auth_id =Auth::id();
        $validator = Validator::make($request->all(), [       
            'id' => 'required',
            'status' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'message' => 'Something went wrong. Please try again later',
            ],400);
        }else{
            DB::beginTransaction();
            try {
                $date_now=date("Y-m-d H:i:s");
                $encashment =AyudaEncashment::find($request['id']);
                $encashment->process_by = $auth_id;
                $encashment->status = $request['status'];
                
                $tax = 0;
				
				// Insert User Log
				$user_log = new UserLog();
				$user_log->user_id = Auth::id();
				$user_log->ip_address = $_SERVER['REMOTE_ADDR'];
				
                if($request['status']=='approved'){
                    $encashment->amount_approved = $request['amount_approved'];
                    $calc_tax = $request['amount_approved'] * $tax;
                    $encashment->tax = $calc_tax;
					
                    $encashment->approved_date = $date_now;
					$user_log->description = 13; // Description ID
                }
                if($request['status']=='claimed'){
                    $encashment->claimed_date = $date_now;
					$user_log->description = 14; // Description ID
                }
                if($request['status']=='hold'){
                    $encashment->reasons = $request['reasons'];
					$user_log->description = 16; // Description ID
                } else if($request['status']=='decline'){
					$encashment->reasons = $request['reasons'];
					$user_log->description = 15; // Description ID
				}
				$user_log->save();
                $encashment->save();

                DB::commit();
				return response()->json([
					'message' => 'ok',
				],200);

            }catch(\Throwable $e){
                DB::rollback();
				
				// Insert User Log Error
				$user_log =  new UserLog();
				$user_log->user_id = Auth::id();
				$user_log->description = 14; // Description ID
				$user_log->status = "Error"; 
				$user_log->error = $e->getMessage();
				$user_log->ip_address = $_SERVER['REMOTE_ADDR'];
				$user_log->save();
                return response()->json([
                    'message' => $e->getMessage(),
                ],400);
            }
        }
    }
    



   
}
