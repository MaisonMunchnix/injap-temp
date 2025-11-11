<?php

namespace App\Http\Controllers;

use App\Branch;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;


class AdminBranchController extends Controller
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

    public function index(){
        return view('admin.dashboard.index');
    }

    public function addBranch(){
        return view('admin.branch.index');
    }

    public function viewAllBranch(){
        $branch_data=Branch::where('status',1)->get();
        return view('admin.branch.branch-list',compact('branch_data'));
    }

    public function getSpecificBranch($id){
        $branch_data=Branch::where('id',$id)->first();
        return response()->json($branch_data);
    }

    public function insertBranch(Request $request){
        $validator = Validator::make($request->all(), [       
            'branch_type' => 'required',
            'branch_name' => 'required',
            'branch_address' => 'required',
            'owner_first_name' => 'required',
            'owner_last_name' => 'required',
            'owner_tel_num' => 'required',
            'owner_mobile_num' => 'required',
            'owner_email' => 'required|email',
            'owner_addr' => 'required'
        ]);
        $branch_count=Branch::where('name',$request['branch_name'])->count();
         
        if ($validator->fails()) {
            return response()->json([
                'message' => 'Please check empty input fields.',
            ],500);
        }else if($branch_count>=1){
            return response()->json([
                'message' => 'Branch name already exists.',
            ],500);
        }else{
            DB::beginTransaction();
            try {
                $branch = new Branch();
                $branch->name = $request['branch_name'];
                $branch->type = $request['branch_type'];
                $branch->branch_address = $request['branch_address'];
                $branch->owner_first_name = $request['owner_first_name'];
                $branch->owner_last_name = $request['owner_last_name'];
                $branch->owner_tel_number = $request['owner_tel_num'];
                $branch->owner_mobile_number = $request['owner_mobile_num'];
                $branch->owner_email_address = $request['owner_email'];
                $branch->owner_address = $request['owner_addr'];
                $branch->save();

                DB::commit();
				return response()->json([
					'message' => 'ok',
				],200);

            }catch(\Throwable $e){
                DB::rollback();
                return response()->json([
                    'message' => $e->getMessage(),
                ],500);
            }
        }
        
    }
	
	public function updateBranch(Request $request){
        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'branch_type' => 'required',
            'branch_name' => 'required',
            'branch_address' => 'required',
            'owner_first_name' => 'required',
            'owner_last_name' => 'required',
            'owner_tel_num' => 'required',
            'owner_mobile_num' => 'required',
            'owner_email' => 'required',
            'owner_addr' => 'required'
        ]);
        $branch_count=Branch::where('name',$request['branch_name'])->where('id','!=',$request['id'])->count();
         
        if ($validator->fails()) {
            return response()->json([
                'message' => 'Please check empty input fields (SERVER)',
            ],500);
        }else if($branch_count>=1){
            return response()->json([
                'message' => 'Branch name already exists.',
            ],500);
        }else{
            DB::beginTransaction();
            try {
				$branch=Branch::find($request['id']);
				$branch->name = $request['branch_name'];
                $branch->type = $request['branch_type'];
                $branch->branch_address = $request['branch_address'];
                $branch->owner_first_name = $request['owner_first_name'];
                $branch->owner_last_name = $request['owner_last_name'];
                $branch->owner_tel_number = $request['owner_tel_num'];
                $branch->owner_mobile_number = $request['owner_mobile_num'];
                $branch->owner_email_address = $request['owner_email'];
                $branch->owner_address = $request['owner_addr'];
                $branch->save();
				
				//$request['add_attachment'];
                DB::commit();
				return response()->json([
					'message' => 'ok',
				],200);

            }catch(\Throwable $e){
                DB::rollback();
                return response()->json([
                    'message' => $e->getMessage(),
                ],500);
            }
        }
        
    }
    
    public function deleteBranch(Request $request){
        $validator = Validator::make($request->all(), [
            'id' => 'required'
        ]);
         
        if ($validator->fails()) {
            return response()->json([
                'message' => 'Please check empty input fields (SERVER)',
            ],500);
        }else{
            DB::beginTransaction();
            try {
				$branch=Branch::find($request['id']);
				$branch->status = 2;
                $branch->save();
				
				//$request['add_attachment'];
                DB::commit();
				return response()->json([
					'message' => 'ok',
				],200);

            }catch(\Throwable $e){
                DB::rollback();
                return response()->json([
                    'message' => $e->getMessage(),
                ],500);
            }
        }
        
    }
}
