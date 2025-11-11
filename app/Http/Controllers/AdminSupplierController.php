<?php

namespace App\Http\Controllers;
use App\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;


class AdminSupplierController extends Controller
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



    public function addSupplier(){
        return view('admin.suppliers.index');
    }

    public function viewAllSupplier(){
        $suppliers_data=Supplier::where('status',1)->get();
        return view('admin.suppliers.suppliers-list',compact('suppliers_data'));
    }

    public function insertSupplier(Request $request){
        $validator = Validator::make($request->all(), [       
            'name' => 'required',
            'code' => 'required',
            'first_name' => 'required',
            'last_name' => 'required',
            'tel_num' => 'required',
            'mobile_num' => 'required',
            'email' => 'required|email',
            'address' => 'required'
        ]);
        $supplier_count=Supplier::where('supplier_name',$request['name'])->count();
        $supplier_code_count=Supplier::where('supplier_code',$request['code'])->count();
         
        if ($validator->fails()) {
            return response()->json([
                'message' => 'Please check empty input fields!.',
            ],500);
        }else if($supplier_count >= 1){
            return response()->json([
                'message' => 'supplier Name already exists!.',
            ],500);
        }else if($supplier_code_count >= 1){
            return response()->json([
                'message' => 'supplier Code already exists!.',
            ],500);
        }else{
            DB::beginTransaction();
            try {
                $supplier = new supplier();
                $supplier->supplier_name = $request['name'];
                $supplier->supplier_code = $request['code'];
                $supplier->contact_first_name = $request['first_name'];
                $supplier->contact_last_name = $request['last_name'];
                $supplier->contact_tel_num = $request['tel_num'];
                $supplier->contact_mobile_num = $request['mobile_num'];
                $supplier->contact_email = $request['email'];
                $supplier->contact_address = $request['address'];
                $supplier->save();

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
	
	public function editSupplier($id){
        $data=Supplier::where('id',$id)->first();
		return response()->json($data);
        /*return response()->json([
            'announcement_data' => $announcement_data,
        ]);*/
    }
	
	public function updateSupplier(Request $request){
        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'name' => 'required',
            'code' => 'required',
            'first_name' => 'required',
            'last_name' => 'required',
            'tel_num' => 'required',
            'mobile_num' => 'required',
            'email' => 'required',
            'address' => 'required'
        ]);
        $supplier_count=Supplier::where('supplier_name',$request['name'])->where('id','!=',$request['id'])->count();
         
        if ($validator->fails()) {
            return response()->json([
                'message' => 'Please check empty input fields or character limit (SERVER)',
            ],500);
        }else if($supplier_count>=1){
            return response()->json([
                'message' => 'Supplier name already exists.',
            ],500);
        }else{
            DB::beginTransaction();
            try {
				$supplier=Supplier::find($request['id']);
				$supplier->supplier_name = $request['name'];
                $supplier->supplier_code = $request['code'];
                $supplier->contact_first_name = $request['first_name'];
                $supplier->contact_last_name = $request['last_name'];
                $supplier->contact_tel_num = $request['tel_num'];
                $supplier->contact_mobile_num = $request['mobile_num'];
                $supplier->contact_email = $request['email'];
                $supplier->contact_address = $request['address'];
                $supplier->save();
				
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
    
    public function deleteSupplier(Request $request){
        $validator = Validator::make($request->all(), [
            'id' => 'required'
        ]);
         
        if ($validator->fails()) {
            return response()->json([
                'message' => 'Please check empty input fields or character limit (SERVER)',
            ],500);
        }else{
            DB::beginTransaction();
            try {
				$supplier=Supplier::find($request['id']);
				$supplier->status = 2;
                $supplier->save();
                
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
