<?php

namespace App\Http\Controllers;

use App\Billing\OverTheCounterPaymentGateway;
use App\Province;
use App\Transaction;
use App\ProductCode;
use App\User;
use App\UserLog;
use App\Sale;
use App\UserInfo;
use App\Product;
use App\Package;
use App\ProductTransaction;
use App\ProductTransactionInfo;
use App\ProductInventory;
use App\UnilevelSale;
use App\Unilevel;
use App\Network;
use App\ShippingDetail;
use Illuminate\Support\Str;
use App\Payment;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Mail;

//Export Excel
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ProductCodeExport;

class TransactionController extends Controller
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
	
	
	public function getDashboard() {
        $user = Auth::user();
    
        $orders_count = 0;
        $sales_count = 0;
    
        if ($user && filled($user->branch_id)) {
            $orders_count = Sale::where('products_released', 0)
                ->where('branch_id', $user->branch_id)
                ->get()
                ->filter(function ($sale) {
                    return $sale->payment && $sale->payment->status == 1;
                })
                ->count();
            $sales_count = Sale::where('branch_id', $user->branch_id)->count();
        }
    
        return view('TellerSystem.dashboard.index', compact('orders_count', 'sales_count'));
    }
    
		
	 public function index(){
		$products = DB::table('products')
            ->select('id','name')
            ->where('category','!=',1)
            ->where('status',1)
            ->get();
         
		$packages = DB::table('packages')
            ->select('id','type')
            ->where('amount','>',0)
            ->where('status',1)
            ->get();
         
       return view('TellerSystem.new-transaction/member', compact('products','packages'));
    }
	
    
    public function index_non() {
        $packages = DB::table('products')
            ->where('category',1)
            ->where('status',1)
            ->get();
        
        $products = DB::table('products')->where('category','!=',1)->where('status',1)->get();

		return view('TellerSystem.new-transaction/new-non-member',compact('packages','products'));
    }
	

    public function package(Request $request)
    {
        $user = User::where('id',Auth::id())->first();
        $id = $request['id'];
        $package = Product::where('id',$id)->first();
        
        $stocks = DB::table('product_inventories')
            ->select('product_inventories.quantity AS quantity')
            ->where('product_inventories.branch_id',$user->branch_id)
            ->where('product_inventories.product_id',$id)
            ->first();
        
        return response()->json([
            'price' => $package->price,
            'stocks' => $stocks->quantity,
        ]);
    }
    
    public function upgrade_account(Request $request)
    {
        $user_id = $request['username'];
        $upgrade_code = $request['upgrade_code'];
        $security_pin = $request['security_pin'];
        if($user_id){
            DB::beginTransaction();
            try {
                $user = User::where('id',$user_id)->first();
                $product_code = ProductCode::where('code',$upgrade_code)->where('security_pin',$security_pin)->first();
                if($product_code){
                    if($product_code->status == 0){
                        if($user->account_type >= $product_code->category){
                            return response()->json([
                                'message' => 'It Need to be higher Package to Upgrade the Account',
                            ],400);
                        } else {
                            $user->account_type = $product_code->category;
                            $user->save();
                            
                            $product_code->status = 1;
                            $product_code->save();
                            // Insert User Log Error
                            $user_log =  new UserLog();
                            $user_log->user_id = Auth::id();
                            $user_log->description = 2; // Description ID
                            $user_log->status = "Success";
                            //$user_log->error = $e->getMessage();
                            $user_log->ip_address = $_SERVER['REMOTE_ADDR'];
                            $user_log->save();
                            
                            DB::commit();
                            return response()->json([
                                'message' => 'Updgrade Success',
                            ],200);
                        }
                    } else {
                        return response()->json([
                            'message' => 'Product Code is Already Active',
                        ],400);
                    }
                } else {
                    return response()->json([
                        'message' => 'Wrong Product Code and Security PIN',
                    ],400);
                }
            
            }catch(\Throwable $e){
                DB::rollback();
                // Insert User Log Error
                $user_log =  new UserLog();
                $user_log->user_id = Auth::id();
                $user_log->description = 2; // Description ID
                $user_log->status = "Error";
                $user_log->error = $e->getMessage();
                $user_log->ip_address = $_SERVER['REMOTE_ADDR'];
                $user_log->save();
                return response()->json([
                    'message' => $e->getMessage(),
                ],400);
            }
        } else {
            return view('TellerSystem.new-transaction/upgrade-member');
        }
        
    }


	private function sernum(){
		$template = 'X9X9-9XX9-9X9X';
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
	
	private function secpin(){
		$secpin = mt_rand(100000, 999999);
		return $secpin;
	}

    public function store(Request $request){

        $user = null;
		$user_id = $request['username'];
        $member_payment=0;
		DB::beginTransaction();
		try {
            $product_transaction_info =  new ProductTransactionInfo();

            $user_log =  new UserLog();
            $user_log->user_id = Auth::id();
            if($user_id){
                $user=User::where('id',$user_id)->first();
                $user_info=UserInfo::where('user_id',$user_id)->first();

                $product_transaction_info->full_name = $user_info->first_name . ' ' . $user_info->last_name;
                $product_transaction_info->email_address = $user->email;
                $product_transaction_info->mobile_number = $user_info->mobile_no;
                $product_transaction_info->tel_number = $user_info->tel_no;
                $product_transaction_info->address = $user_info->address;
                $id = $user->id;
                // Insert User Log
                $user_log->description = 11; // Description ID
            } else {
                $product_transaction_info->full_name = $request['full_name'];
                $product_transaction_info->email_address = $request['email_address'];
                $product_transaction_info->mobile_number = $request['mobile_number'];
                $product_transaction_info->tel_number = $request['telephone_number'];
                $product_transaction_info->address = $request['address'];
                $id = NULL;
                $user_log->description = 12;
                $member_payment=1;
            }
            $user_log->ip_address = $_SERVER['REMOTE_ADDR'];
            $user_log->save();
            $product_transaction_info->save();

            $cart = Cart::instance($user->id ?? null);
            
            

            $shipping_fee =  0.0;
            $fees=0.0;
            $payment['is_paid'] = 1;
            $payment['admin_id'] = Auth::user()->id;
            
            $sale = new Sale();
            $sale->user_id = $user->id ?? null;
            $sale->branch_id = Auth::user()->branch_id;
            $sale->subtotal =$request['total_price'];
            $sale->discount = 0.0;
            $sale->shipping = $shipping_fee;
            $sale->fees = $fees;
            $sale->total = $request['total_price'];
            $sale->ship_to_another_address = 0;
            $sale->products_released = 1;

            $sale->save();
            $salesId= $sale->id;

            if($request->ajax()){
                $product = $request->select_product;
                $qty = $request->product_qty;
                $price = $request->product_price;

                $package = $request->select_package;
                $package_qty = $request->package_qty;
                $package_price = $request->package_price;

                $count_product = count(array($product));
                if(empty($package) && empty($product)){
                    return response()->json([
                        'message' => 'No Product or Package Selected!',
                    ],400);
                } else {
                    if(!empty($product)){
                        if(empty($qty) || $qty <= 0){
                            return response()->json([
                                'message' => 'Empty Product Quantity',
                            ],400);
                        } else {
                            for($count = 0; $count < count($product); $count++){
                                $product_total_qty = 0;
                                $data = array(
                                    'transaction_info_id' => $product_transaction_info->id,
                                    'product_id' => $product[$count],
                                    'quantity' => $qty[$count],
                                    'user_id' => $id,
                                    'transaction_id' => Str::uuid(),
                                    'admin_id' => Auth::id(),
                                    'entry_type' => 'outgoing'
                                );

                                $product_total_qty = $product_total_qty + $qty[$count];

                               
                                for($p=0;$p<$product_total_qty;$p++){
                                    $sernum = $this->sernum();
                                    $secpin = $this->secpin();
                                    
                                    $product_code = new ProductCode();
                                    $product_code->sponsor_id = $id;
                                    $product_code->sale_id = $salesId;
                                    //$product_code->category = $package[$count];
                                    $product_code->product_id = $product[$count];
                                    $product_code->type = 'product';
                                    $product_code->code = $sernum;
                                    $product_code->security_pin = $secpin;
                                    $product_code->save();

                                }

                                $product_inventory = ProductInventory::where('product_id',$product[$count])->first();
                                $product_name = Product::where('id',$product[$count])->first();
                                if($product_inventory){
                                    $temp_out = $product_inventory->quantity - $qty[$count];
                                    if($product_inventory->quantity == 0){
                                        return response()->json([
                                            'message' => ' No Stock Available',
                                        ],400);
                                    } else if($temp_out < 0){
                                        return response()->json([
                                            'message' => ' Not enough stocks',
                                        ],400);
                                    } else {
                                        $product_inventory->quantity = $product_inventory->quantity - $qty[$count];
                                        $product_inventory->save();
                                    }
                                }
                                $insert_data[] = $data;

                                $tc_product = Product::find($product[$count]);
                                $item = $cart->add($tc_product, $qty[$count]);
                                if($user) $cart->setDiscount($item->rowId, $user->package->account_discount * 100);
                            }
                            ProductTransaction::insert($insert_data);
                        }
                    }

                    if(!empty($package)){
                        if(empty($package_qty)){
                            return response()->json([
                                'message' => 'Empty Package Quantity',
                            ],400);
                        } else { 
                            $activation_list=[];
                            for($count2 = 0; $count2 < count($package); $count2++){
                                $total_qty = 0;
                                $data2 = array(
                                    'transaction_info_id' => $product_transaction_info->id,
                                    'product_id' => $package[$count2],
                                    'quantity' => $package_qty[$count2],
                                    'user_id' => $id,
                                    'transaction_id' => Str::uuid(),
                                    'admin_id' => Auth::id(),
                                    'entry_type' => 'package_outgoing'
                                );

                                $total_qty = $total_qty + $data2['quantity'];
                                $cat = Product::find($package[$count2]);
                                for($i=0;$i<$total_qty;$i++){
                                    $sernum = $this->sernum();
                                    $secpin = $this->secpin();
                                    $temp_data=['count'=>$i, 'code'=>$sernum, 'pin'=>$secpin];
                                    array_push($activation_list,$temp_data);
                                    $product_code = new ProductCode();
                                    $product_code->sponsor_id = $id;
                                    $product_code->sale_id = $salesId;
                                    $product_code->category = $cat->package_id;
                                    $product_code->product_id = $package[$count2];
                                    $product_code->type = 'package';
                                    $product_code->code = $sernum;
                                    $product_code->security_pin = $secpin;
                                    if($cat->price == 0){
                                        $product_code->is_paid = 'free';
                                    }
                                    $product_code->save();
                                 
                                }
                                $insert_data2[] = $data2;

                                $tc_product = Product::find($package[$count2]);
                                $item = $cart->add($tc_product, $package_qty[$count2]);
                                $cart->setDiscount($item->rowId, 0);
                            }
                            ProductTransaction::insert($insert_data2);
                        }

                    }
                }
            }

           $Payment = new Payment();
           $Payment->sale_id = $salesId;
           $Payment->amount = $request['total_price'];
           $Payment->confirmation_number = "REF-" . strtotime(now());
           $Payment->currency = 'php';
           $Payment->shipping = 0.0;
           $Payment->fees = 0.0;
           $Payment->driver = 'OverTheCounterPaymentGateway';
           $Payment->status = 1;
           $Payment->is_paid = $member_payment;
           $Payment->save();

           $discount=0.0;
            $commission=0.0;
            if(!empty($product)){
                for($count = 0; $count < count($product); $count++){             
                    
                    $product2 = DB::table('products')
                        ->where('products.id',$product[$count])
                        ->first();
                    $sub_total = $product2->price;
                    
                    
                    DB::table('orders')->insert([
                        'sale_id'    => $salesId,
                        'product_id' => $product[$count],
                        'quantity'   => $qty[$count],
                        'price'      => $sub_total,
                        'discount'   => $discount,
                        'commission' => $commission
                    ]); 
                }
            }
          
            if(!empty($package)){
                for($count2 = 0; $count2 < count($package); $count2++){
                    $User_data = User::where('id',$user_id)->first();
                    if($User_data){
                        $product2 = DB::table('products')
                            ->where('category',1)
                            ->where('id',$package[$count2])
                            ->first();
                    } else {
                        $product2 = DB::table('products')
                            ->where('category',1)
                            ->where('products.id',$package[$count2])
                            ->first();
                        
                    }
                    $sub_total = $product2->price;
                    
                    DB::table('orders')->insert([
                        'sale_id'    => $salesId,
                        'product_id' =>$package[$count2],
                        'quantity'   => $package_qty[$count2],
                        'price'      => $sub_total,
                        'discount'   => $discount,
                        'commission' => $commission
                    ]); 
                }
            }        

            if(!$user){
                $shipping_detail = new ShippingDetail();
                $shipping_detail->first_name = $request->full_name;
                $shipping_detail->email = $request->email_address;
                $shipping_detail->mobile_number = $request->mobile_number;
                $shipping_detail->street_address = $request->address;
                $shipping_detail->city = $request->city;
                $shipping_detail->province = $request->province;
                $shipping_detail->save();
            }
            
            DB::commit();

            return response()->json([
                'success' => true,
                'transaction_id' => $sale->id,
            ],200);
            
        }catch(\Throwable $e){
            DB::rollback();
			// Insert User Log Error
			$user_log =  new UserLog();
			$user_log->user_id = Auth::id();
			$user_log->description = 8; // Description ID
			$user_log->status = "Error";
			$user_log->error = $e->getMessage();
            $user_log->ip_address = $_SERVER['REMOTE_ADDR'];
			$user_log->save();
            return response()->json([
                'message' => $e->getMessage(),
            ],400);
        }
	
	}
    
    public function Export($id){
        return Excel::download(new ProductCodeExport($id), 'Product Codes '. date('Y') . '-' .sprintf('%06d',$id) .'.xlsx');
    }
	
   private function unilevelSection($sale,$orders){
     
           
    $unilevelLimiter=0;
    $jsonData = new \stdClass();
    $price;
    if ($sale->user_id==null){
     
    }else{
    
    $this->unilevelStatusChanger($sale->user_id);
       $User_data = User::where('id',$sale->user_id)->where('unilevel_rank', '>=',0)->where('unilevel_rank','<',6)->where('unilevel_status','Maintained')->get();

        $orders = DB::table('orders')->where('sale_id',$sale->id)->first();
    
        $UniLevel = UniLevel::where('product_id', $orders->product_id)->get();
    if($UniLevel->count()==0){

    }else{
        if($User_data->count()==0){
            $this->executeData($sale ,$UniLevel,$orders);
        }else{
            foreach ($UniLevel as  $value) {
                if($value->level==0){
                   $price=$value->price;
                }
            }

            if($User_data->count()>=1){
                                 
                $UnilevelSale = new UnilevelSale();
                $UnilevelSale->user_id = $sale->user_id;
                $UnilevelSale->source_id = $sale->user_id;
                $UnilevelSale->sales_id = $sale->id;
                $UnilevelSale->quantity = $orders->quantity;
                $UnilevelSale->total_price = number_format($price * $orders->quantity,2, '.','');
                $UnilevelSale->price = $price;
                $UnilevelSale->level = '0';
                $UnilevelSale->save();
               

                $this->unilevelStatusChanger($sale->user_id);

                $x=1;
                $stoper=0;

                $jsonData = $this->UnilevelChecker($sale->user_id);
                json_encode($jsonData);
                if($jsonData==$sale->user_id){

                }else{
                    foreach ($jsonData  as $data) {
                        foreach ($data as $value5) {
                             $counter = User::where('id',$value5)->where('unilevel_rank','>=',0)->where('unilevel_rank','<',6)->where('unilevel_status','Maintained')->get();
                              /* if($counter->count()==0){
                                $unilevelLimiter=0;
                              }else if($counter[0]->unilevel_rank == 0){
                                $unilevelLimiter=10;
                              }else if($counter[0]->unilevel_rank == 1){
                                  $unilevelLimiter=12;
                              }else if($counter[0]->unilevel_rank == 2){
                                $unilevelLimiter=1;
                              }else if($counter[0]->unilevel_rank == 3){
                                  $unilevelLimiter=16;
                              }else if($counter[0]->unilevel_rank == 4){
                                  $unilevelLimiter=18;
                              }else if($counter[0]->unilevel_rank == 5){ */
                                  $unilevelLimiter=20;
                              /* } */

                            if($unilevelLimiter>=$stoper &&$unilevelLimiter!=0 ){
                                foreach ($UniLevel as  $value2) {
                                    if($value2->level==$x){

                                        if($counter->count()>=1){
                                           
                                                    $UnilevelSale = new UnilevelSale();
                                                    $UnilevelSale->user_id = $value5;
                                                    $UnilevelSale->source_id = $sale->user_id;
                                                    $UnilevelSale->sales_id = $sale->id;
                                                    $UnilevelSale->quantity = $orders->quantity;
                                                    $UnilevelSale->price =    $value2->price;
                                                    $UnilevelSale->total_price =number_format($value2->price * $orders->quantity,2, '.','');
                                                    $UnilevelSale->level = $x;
                                                    $UnilevelSale->save();
                                                

                                        }
                                    }
                                }
                            }
                        }

                  // return $x;
                        $stoper++;
                        $x++;
                    }
                }


            }
        }

    }


    // Insert User Log
}
}

 private function unilevelStatusChanger($user_id){
    $monthNow= date('m'); 
    $yearNow= date('Y'); 
    $rank1Count=0;
    $rank2Count=0;
    $rank3Count=0;
    $rank4Count=0;
          /*$directReferral = Network::where('sponsor_id',$user_id)->get();
         foreach ($directReferral as $directReferral) {
              $User = User::where('id',$directReferral->user_id)->first();
              if($User->unilevel_rank==1){
                 $rank1Count++;
              }else if($User->unilevel_rank==2){
                 $rank2Count++;
             }else if($User->unilevel_rank==3){
                 $rank3Count++;
             }else if($User->unilevel_rank==4){
                 $rank4Count++;
             }
              
         }
        $unilevelRank=User::select('unilevel_rank')->where('id', $user_id)->first();
        // $directReferral = Network::where('sponsor_id',$user_id)->count();
         $directReferral = DB::table('networks')
         ->join('users', 'networks.user_id', '=', 'users.id')
         ->where('users.account_status','>=','paid')
         ->where('users.account_type','>=',1)
         ->where('networks.sponsor_id',$user_id)
         ->count(); */
  
          
            $productMaintain = DB::table('sales')
                  ->join('orders', 'orders.sale_id', '=', 'sales.id')
                  ->where('sales.user_id',$user_id)
                  ->where('orders.product_id',3)
                  ->whereMonth('sales.updated_at','=',$monthNow)
                  ->whereYear('sales.updated_at','=',$yearNow)
                  ->where('sales.products_released',1)
                  ->sum('orders.quantity');
                  $maintainStatus="";
                  
                      if ($productMaintain >=25){
                         DB::table('users')->where('id',$user_id)->update(['unilevel_rank' => '1','unilevel_status'=>'Maintained']);	
                         $maintainStatus="Maintained";					
                      }else {
                         DB::table('users')->where('id',$user_id)->update(['unilevel_status' => 'Not Maintained']);		
                      }                  
 
  /* 
                 if ($unilevelRank['unilevel_rank'] ==0 && $directReferral >=5 &&  $productMaintain >=5){
                     DB::table('users')->where('id',$user_id)->update(['unilevel_rank' => '1','unilevel_status'=>'Maintained']);     
                     $maintainStatus="Maintained";	     
                  }else if($unilevelRank['unilevel_rank'] == 1  && $maintainStatus !="Maintained"){
                    DB::table('users')->where('id',$user_id)->update(['unilevel_status' => 'Not Maintained']);	
                    $maintainStatus="Not Maintained";	
                 } 
                 
                 if ($unilevelRank['unilevel_rank'] == 1  && $directReferral >=5 && $rank1Count >=1 && $productMaintain >=8 ){
                     DB::table('users')->where('id',$user_id)->update(['unilevel_rank' => '2','unilevel_status'=>'Maintained']);
                    $maintainStatus="Maintained";
                 }else if($unilevelRank['unilevel_rank'] == 1 && $maintainStatus !="Maintained"){
                    DB::table('users')->where('id',$user_id)->update(['unilevel_status' => 'Not Maintained']);	
                    $maintainStatus="Not Maintained";
                 }
                 
                 if ($unilevelRank['unilevel_rank'] == 2  && $directReferral >=10 && $rank2Count >=5 && $productMaintain >=10 ){
                     DB::table('users')->where('id',$user_id)->update(['unilevel_rank' => '3','unilevel_status'=>'Maintained']);
                    $maintainStatus="Maintained";
                 }else if($unilevelRank['unilevel_rank'] == 2 && $maintainStatus !="Maintained"){
                    DB::table('users')->where('id',$user_id)->update(['unilevel_status' => 'Not Maintained']);	
                    $maintainStatus="Not Maintained";
                 }
                 
                 if($unilevelRank['unilevel_rank']  == 3 && $directReferral==15 && $rank3Count>=5 && $productMaintain >=12){
                     DB::table('users')->where('id',$user_id)->update(['unilevel_rank' => '4','unilevel_status'=>'Maintained']);
                     $maintainStatus="Maintained";
                 }else if($unilevelRank['unilevel_rank']  == 3 && $maintainStatus !="Maintained"){
                    DB::table('users')->where('id',$user_id)->update(['unilevel_status' => 'Not Maintained']);	
                $maintainStatus="Not Maintained";
                 }
                 
                 if($unilevelRank['unilevel_rank'] >= 4  && $directReferral==20 &&  $rank4Count>=10 && $productMaintain >=15){
                     DB::table('users')->where('id',$user_id)->update(['unilevel_rank' => '5','unilevel_status'=>'Maintained']);
                     $maintainStatus="Maintained";
                 }else if( $unilevelRank['unilevel_rank'] >= 4 && $unilevelRank['unilevel_rank'] <= 5 && $maintainStatus !="Maintained"){
                    DB::table('users')->where('id',$user_id)->update(['unilevel_status' => 'Not Maintained']);
                    $maintainStatus="Not Maintained";
                 }
  
                 if($unilevelRank['unilevel_rank'] >= 5  && $directReferral==20 &&  $rank4Count>=10 && $productMaintain >=15){
                     DB::table('users')->where('id',$user_id)->update(['unilevel_rank' => '5','unilevel_status'=>'Maintained']);
                     $maintainStatus="Maintained";
                 }else if( $unilevelRank['unilevel_rank'] >= 4 && $unilevelRank['unilevel_rank'] <= 5 && $maintainStatus !="Maintained"){
                    DB::table('users')->where('id',$user_id)->update(['unilevel_status' => 'Not Maintained']);
                    $maintainStatus="Not Maintained";
                 } */
           
}


private function executeData($sale ,$UniLevel,$orders){
$x=1;
$stoper=0;
$this->unilevelStatusChanger($sale->user_id);
$jsonData = $this->UnilevelChecker($sale->user_id);  
  json_encode($jsonData);
if($jsonData==$sale->user_id ||$jsonData==null ){

}else{
 foreach ($jsonData  as $data) {
     foreach ($data as $value5) {
           $counter = User::where('id',$value5)->get();             
             foreach ($UniLevel as  $value2) {
                 if($value2->level==$x){
                                          
                     if($counter->count()>=1){
                         $UnilevelSale = new UnilevelSale();
                         $UnilevelSale->user_id = $value5;
                         $UnilevelSale->source_id = $sale->user_id;
                         $UnilevelSale->sales_id = $sale->id;
                         $UnilevelSale->quantity = $orders->quantity;
                         $UnilevelSale->price =    $value2->price;
                         $UnilevelSale->total_price = number_format($value2->price * $orders->quantity,2, '.','');
                         $UnilevelSale->level = $x;
                         $UnilevelSale->save(); 
                     
                   }
                 }
             }    
         
     }
    
// return $x;
    
     $x++; 
 }
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

                $this->unilevelStatusChanger($value->sponsor_id);

                if($value->sponsor_id==0){
                    return $value->user_id;
                   }else{
                         $UnilevelUserCount = User::where('id',$value->sponsor_id)->where('unilevel_rank','>=',1)->where('unilevel_status','Maintained')->count();
                    if($UnilevelUserCount ==1){
                       $id2=['level'.$incremental.''=>$value->sponsor_id];
                       $s='level'.''.$incremental;
                      array_push($id,$value->sponsor_id);
                          array_push($id4,$id2);
                    }else{

                         $rollback =  $this->rollback($value->sponsor_id);
                         if($rollback==null){
                            return $rollback;
                         }
                      foreach ($rollback as $rollback) {
                           $id2=['level'.$incremental.''=>$rollback->user_id];
                           array_push($id,$rollback->user_id);
                            $s='level'.''.$incremental;
                           array_push($id4,$id2);
                      }

                    }
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
                                 $UnilevelUserCount = User::where('id',$value->sponsor_id)->where('unilevel_rank','>=',1)->where('unilevel_status','Maintained')->count();
                          if($UnilevelUserCount ==1){
                             $id2=['level'.$incremental.''=>$value->sponsor_id];
                             $s='level'.''.$incremental;
                            array_push($id,$value->sponsor_id);
                            array_push($id4,$id2);
                          }else{
                                 $rollback =  $this->rollback($value->sponsor_id);
                            foreach ($rollback as $rollback) {
                                  $id2=['level'.$incremental.''=>$rollback->user_id];
                                  $s='level'.''.$incremental;
                                 array_push($id,$rollback->user_id);
                                 array_push($id4,$id2);


                            }

                          }
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

private function rollback($sponsor_id){
    $Network= Network::where('user_id',$sponsor_id)->get();
   $x=0;
   while ($x ==0){
     foreach ($Network as  $value) {  
         
         if($value->sponsor_id !=0){
                   $UnilevelUserCount = User::where('id',$value->sponsor_id)->where('unilevel_rank','>=',1)->where('unilevel_status','Maintained')->count();
             if($UnilevelUserCount ==1){
                 $x++;
               return  Network::where('user_id',$value->sponsor_id)->get();
               
             }else{
                 
                          $Network = $this->SponsorData($value->sponsor_id);
                
                 
             }
         }else{
             $x++;
          }                
      }
   }

}




private function UnilevelGroupSalesChecker($sponsor_id){        
$jsonData = new \stdClass();        
$sponsor_id=$sponsor_id; 
$x=0;
$id=[];
$y=1;
$x=0;
$id2;
$id4=[];
$incremental=1;            
$Network = Network::where('sponsor_id',$sponsor_id)->get();

if($Network->count()==0)
{
    array_push($id,$sponsor_id);
    $jsonData->level1 = $id;
    return  $jsonData;
}else{
while($x==0){          
  if($y==1){
      foreach ($Network as  $value) {
            $id2=['level'.$incremental.''=>$value->user_id];
            $s='level'.''.$incremental;
            array_push($id,$value->user_id);
            array_push($id4,$id2);
          }
    $jsonData->$s = $id;
    json_encode($jsonData);
    }
      $incremental++;  
      $id=[];
    foreach ($id4 as $key ) {
      $id3=[];         
      try {
          $Network =  $this->SponsorDataGroupSales($key['level'.$y.'']);
          foreach ($Network as  $value) {   
            $id3=['level'.$incremental.''=>$value->user_id];            
            array_push($id,$value->user_id);
            array_push($id4,$id3);                 
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
}      
return  $jsonData;      
}

private function SponsorData($sponsor_id){
return Network::where('user_id',$sponsor_id)->get();
}

private function SponsorDataGroupSales($sponsor_id){
return Network::where('sponsor_id',$sponsor_id)->get();
}
	public function transaction_receipt($id){

		$product_transaction_info = DB::table('product_transaction_infos')->where('id',$id)->first();

		$product_transactions = DB::table('product_transactions')
		->Join('products','product_transactions.product_id', '=', 'products.id' )
		->select('product_transactions.*', 'products.name', 'products.price')
		->where('product_transactions.transaction_info_id', $product_transaction_info->id)
		->get();

		return view('TellerSystem.new-transaction.transaction-receipt', ['product_transactions' => $product_transactions,'product_transaction_info' => $product_transaction_info]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function show(Transaction $transaction)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function edit(Transaction $transaction)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Transaction $transaction)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function destroy(Transaction $transaction)
    {
        //
    }
}
