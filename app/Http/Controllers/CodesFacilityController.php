<?php

namespace App\Http\Controllers;

use App\User;
use App\UserInfo;
use App\ProductCode;
use App\Package;
use App\UserLog;
use App\UnilevelSale;
use App\Unilevel;
use App\Network;
use App\TotalPvPoint;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use DataTables;

class CodesFacilityController extends Controller
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


    public function viewUserCodes(){
       $auth_id = Auth::id();
        $product_code=ProductCode::where('sponsor_id',$auth_id)->orderBy('created_at','DESC')->get();
        $package=Package::all();
        $activation_codes_data=[];
        $product_codes_data=[];
        $package_type="";
        $used_by="No data";
        $created="";
        $used_date="";
        foreach($product_code as $pcode){
            $created = date('F d, Y h:i:s a',strtotime($pcode->created_at));
            if($pcode->type=='product'){
                $temp_data=['codes'=>$pcode->code,'pin'=>$pcode->security_pin,'created'=>$created];
                array_push($product_codes_data,$temp_data);
            }else{
                if(!empty($pcode->category)){
                    foreach($package as $pckg){
                        if($pckg->id == $pcode->category){
                            $package_type = $pckg->type;
                        }
                    }
                    if(!empty($pcode->user_id)){
                        if($pcode->user_id==$auth_id){
                            $used_by = "You";
                        }else{
                            $used_by = $this->getUserData($pcode->user_id);
                        }
                        $used_date = date('F d, Y h:i:s a',strtotime($pcode->updated_at));
                    }else{
                        $used_date = "Not use";
                        $used_by = "Not use";
                    }
                    
                }else{
                    $package_type = "No data";
                    $used_by = "No data";
                }
                $temp_data=['codes'=>$pcode->code,'pin'=>$pcode->security_pin,'package'=>$package_type,'used_by'=>$used_by,'used_date'=>$used_date,'created'=>$created];
                array_push($activation_codes_data,$temp_data);
            }        
            
        }
        return view('user.codes-facility.index',compact('auth_id','activation_codes_data','product_codes_data'));
    }

    private function getUserData($uid){
        $user_info=UserInfo::where('user_id',$uid)->first();
        if(!empty($user_info)){
            return $user_info->first_name." ".$user_info->last_name;
        }else{
            return "No data";
        }
    }

    
    public function getCodes(Request $request){
        if ($request->ajax()) {
            $type = $request->type;
            $user_id = Auth::id();
            
            if($type == 'package'){
                $product_codes = DB::table('product_codes')
                    ->join('products','product_codes.product_id','products.id')
                    ->leftJoin('users','product_codes.user_id','users.id')
                    ->select('product_codes.code','product_codes.security_pin','products.name','users.username','product_codes.updated_at','product_codes.created_at')
                    ->where('product_codes.type', $type)
                    ->where('product_codes.sponsor_id', $user_id)
                    ->get();
            } else {
                $product_codes = DB::table('product_codes')
                    ->join('products','product_codes.product_id','products.id')
                    ->leftJoin('users','product_codes.user_id','users.id')
                    ->select('product_codes.code','product_codes.security_pin','products.name','users.username','product_codes.updated_at','product_codes.created_at')
                    ->where('product_codes.type', $type)
                    ->where('product_codes.user_id', $user_id)
                    ->get();
            }

            return Datatables::of($product_codes)
                ->editColumn('updated_at', function($product_codes) use($type) {
                    if($type == 'package'){
                        if($product_codes->username){
                            return $product_codes->updated_at;
                        } else {
                            return '';
                        }
                    } else {
                        return $product_codes->updated_at;
                    }
                })
                ->make(true);
         }
    }

    
    public function saveProductCodes(Request $request){
        $user_id = Auth::id();
        $product_code = $request->input('product_code');
        $pin = $request->input('pin');
        DB::beginTransaction();
    try {
        
        $code_check = ProductCode::where('code',$product_code)->where('security_pin',$pin)->first();
        if($code_check){
            if($code_check->status == 0){
                if($code_check->type == 'package'){
                    return response()->json([
                        'message' => 'Product Code is not for purchase',
                    ],400);
                } else {
                    $code_check->user_id = $user_id;
                    $code_check->status = 1;
                    $code_check->save();
                    
                    $product = DB::table('products')->select('pv')
                        ->where('id', $code_check->product_id)
                        ->first();
                    
                    $pv_point = TotalPvPoint::where('user_id', $user_id)->first();
                    
                    if($product->pv > 0){
                        if($pv_point){
                            $pv_point->points = $pv_point->points + $product->pv;
                            $pv_point->save();
                        } else {
                            $new_pv_point = new TotalPvPoint();
                            $new_pv_point->user_id = $user_id;
                            $new_pv_point->points = $product->pv;
                            $new_pv_point->save();
                        }
                    }
                    $monthStart = Carbon::now()->startOfMonth();
                    $monthEnd = Carbon::now()->endOfMonth();
                    
                    $total_pv = DB::table('product_codes')
                        ->select('products.pv')
                        ->join('products','product_codes.product_id','products.id')
                        ->where('product_codes.user_id', $user_id)
                        ->where('product_codes.type', 'product')
                        ->whereBetween('product_codes.updated_at', [$monthStart,$monthEnd])
                        ->sum('products.pv');
                    
                    
                    if($total_pv >= 500){
                        $user = User::find($user_id);
                        if($user->unilevel_status != 'Maintained'){
                            $user->unilevel_status = 'Maintained';
                            $user->maintained_date = Carbon::now();
                            $user->save();
                        } else {
                            if($user->maintained_date < $monthStart){
                                $user->unilevel_status = 'Maintained';
                                $user->maintained_date = Carbon::now();
                                $user->save();
                            }
                        }
                    }
                    
                    $product_id = $code_check->product_id;
                    $sale_id = $code_check->sale_id;
                    //if($product_id == 3){
                    $this->unilevelSection($user_id,$product_id,$sale_id);
                    //}
                }
                
            } else {
                return response()->json([
                    'message' => 'Product Code already used',
                ],500);
            }
            
            DB::commit();
            return response()->json();
        } else {
            return response()->json([
            'message' => 'Wrong Product Code',
            ],500);
        }
            
        }catch(\Throwable $e){
            DB::rollback();
            
            // Insert User Log Error
            $user_log =  new UserLog();
            $user_log->user_id = Auth::id();
            $user_log->description = 17; // Description ID
            $user_log->status = "Error"; 
            $user_log->error = $e->getMessage();
            $user_log->save();
            return response()->json([
                'message' => $e->getMessage(),
            ],500);
        }
    }


    private function unilevelSection($user_id,$product_id,$sale_id){
     
           
        $unilevelLimiter=0;
        $jsonData = new \stdClass();
        $price;
        if($user_id){
         
            $UniLevel = UniLevel::where('product_id', $product_id)->get();
            if($UniLevel->count() > 0){
                foreach ($UniLevel as  $value) {
                    if($value->level == 0){
                       $price = $value->price;
                    }
                }
                                    
                $UnilevelSale = new UnilevelSale();
                $UnilevelSale->user_id = $user_id;
                $UnilevelSale->source_id = $user_id;
                $UnilevelSale->sales_id = $sale_id;
                $UnilevelSale->quantity =1;
                $UnilevelSale->total_price = $price;
                $UnilevelSale->price = $price;
                $UnilevelSale->level = '0';
                $UnilevelSale->save();
                   
                $x = 1;
                $stoper = 0;
    
                $jsonData = $this->UnilevelChecker($user_id);
                $data2 = json_encode($jsonData);
                
                if($data2 != $user_id){
                    foreach ($jsonData  as $data) {
                        foreach ($data as $value5) {     
                            foreach ($UniLevel as  $value2) {
                                if($value2->level == $x){
                                    $UnilevelSale = new UnilevelSale();
                                    $UnilevelSale->user_id = $value5;
                                    $UnilevelSale->source_id = $user_id;
                                    $UnilevelSale->sales_id = $sale_id;
                                    $UnilevelSale->quantity = 1;
                                    $UnilevelSale->price = $value2->price;
                                    $UnilevelSale->total_price = $value2->price;
                                    $UnilevelSale->level = $x;
                                    $UnilevelSale->save();  
                                }
                            }                                
                        }
                        $x++;
                    }
                }
    
            }
        } else {
            return response()->json([
                'message' => 'No User Found!',
            ],400);
        }
    }

    
    private function UnilevelChecker($sponsor_id){
        
        $jsonData = new \stdClass();
         $sponsor_id=$sponsor_id;
        $x=0;
        $id=[];
        $y=1;
        $x=0;
        $id2;
        $id4=[];
        $incremental=1;
          $Network = Network::where('user_id',$sponsor_id)->get();
        while($x==0){
    
            if($y==1){
                foreach ($Network as  $value) {
    
             
    
                    if($value->sponsor_id==0){
                        return $value->user_id;
                       }else{                            
                        $id2=['level'.$incremental.''=>$value->sponsor_id];
                        $s='level'.''.$incremental;
                        array_push($id,$value->sponsor_id);
                        array_push($id4,$id2);                        
                       }
    
    
                    }
              $jsonData->$s = $id;
                json_encode($jsonData);
              }
                 $incremental++;
            $id=[];
            foreach ($id4 as $key ) {
    
                $id3=[];
                try {
                       $Network =  $this->SponsorData($key['level'.$y.'']);
                    foreach ($Network as  $value) {
                          if($value->sponsor_id !=0){                            
                            $id2=['level'.$incremental.''=>$value->sponsor_id];
                            $s='level'.''.$incremental;
                            array_push($id,$value->sponsor_id);
                            array_push($id4,$id2);                              
                          }
                       }
                    } catch (\Throwable $th) {
                        //throw $th;
                    }
            }
          $s='level'.''.$incremental;
          $jsonData->$s =$id;
          json_encode($jsonData);
    
          $y++;
          if($incremental==10) {
            $x++;
          }
    
    
    
          }
    
        return  $jsonData;
    }

    private function SponsorData($sponsor_id){
        return Network::where('user_id',$sponsor_id)->get();
    }
    //Unilevel Code Facility
    public function unilevelUserCodes(){
        $auth_id = Auth::id();
         $product_code=ProductCode::where('sponsor_id',$auth_id)->orderBy('created_at','DESC')->get();
         $package=Package::all();
         $activation_codes_data=[];
         $product_codes_data=[];
         $package_type="";
         $used_by="No data";
         $created="";
         $used_date="";
         foreach($product_code as $pcode){
             $created = date('F d, Y h:i:s a',strtotime($pcode->created_at));
             if($pcode->type=='product'){
                 $temp_data=['codes'=>$pcode->code,'pin'=>$pcode->security_pin,'created'=>$created];
                 array_push($product_codes_data,$temp_data);
             }else{
                 if(!empty($pcode->category)){
                     foreach($package as $pckg){
                         if($pckg->id == $pcode->category){
                             $package_type = $pckg->type;
                         }
                     }
                     if(!empty($pcode->user_id)){
                         if($pcode->user_id==$auth_id){
                             $used_by = "You";
                         }else{
                             $used_by = $this->getUserData($pcode->user_id);
                         }
                         $used_date = date('F d, Y h:i:s a',strtotime($pcode->updated_at));
                     }else{
                         $used_date = "Not use";
                         $used_by = "Not use";
                     }
                     
                 }else{
                     $package_type = "No data";
                     $used_by = "No data";
                 }
                 $temp_data=['codes'=>$pcode->code,'pin'=>$pcode->security_pin,'package'=>$package_type,'used_by'=>$used_by,'used_date'=>$used_date,'created'=>$created];
                 array_push($activation_codes_data,$temp_data);
             }        
             
         }
         return view('user.codes-facility.unilevel',compact('auth_id','activation_codes_data','product_codes_data'));
     }

}
