<?php

namespace App\Http\Controllers;

use App\UserLog;
use Auth;
use App\Override;
use App\Payment;
use App\Sale;
use App\UnilevelSale;
use App\Unilevel;
use App\Product;
use App\ProductCode;
use App\ProductInventory;
use App\ProductTransaction;
use App\ProductTransactionInfo;
use App\Network;
use App\User;
use App\UserInfo;

use Maatwebsite\Excel\Facades\Excel;
use PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Mail;
use App\Exports\SalesExport;

class OrderManagementController extends Controller
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
	
	
	private function sernum()
    {
        $template = 'X99X-9X9X-9XX9';
        $sernum = '';

        for ($i = 0; $i < strlen($template); $i++) {
            $char = $template[$i];
            switch ($char) {
                case 'X':
                    $sernum .= chr(rand(65, 90));
                    break;
                case '9':
                    $sernum .= rand(0, 9);
                    break;
                case '-':
                    $sernum .= '-';
                    break;
            }
        }
        return $sernum;
    }

	
	private function secpin()
    {
        return sprintf("%04d", mt_rand(0, 9999));
    }

    public function ip_address(Request $request){
        $ip_address = $request->ip();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders = Sale::where('products_released', 0)->get()->filter(function($sale){
            return $sale->payment->status == 1 && $sale->branch_id == Auth::user()->branch_id;
        });

        return view('TellerSystem.order_management.process_order', compact('orders'));
    }

    

    public function order_receipt(Sale $sale){
        if($sale->branch_id !== Auth::user()->branch_id)
            return back(403);
        
        DB::beginTransaction();
        try {
           
            //if($sale->payment->is_paid==0){
                if($sale->products_released == 0){
                    //return 'ok';

                    if($sale->user_id){
						$product_transaction_info =  new ProductTransactionInfo();
                        $user=User::where('id',$sale->user_id)->first();
                        $user_info=UserInfo::where('user_id',$sale->user_id)->first();

                        $product_transaction_info->full_name = $user_info->first_name . ' ' . $user_info->last_name;
                        $product_transaction_info->email_address = $user->email;
                        $product_transaction_info->mobile_number = $user_info->mobile_no;
                        $product_transaction_info->tel_number = $user_info->tel_no;
                        $product_transaction_info->address = $user_info->address;
                        $user_id = $user->id;
						$product_transaction_info->save();
                    } else {
						$user_by_affiliate=User::where('affiliate_link',$sale->affiliate_link_used)->first();
						$user_id = $user_by_affiliate->id;
					}




                    //Generate Codes
                    $orders2 = DB::table('orders')->where('sale_id',$sale->id)->get();
                    foreach($orders2 as $order2){
                        $product = $order2->product_id;
                        $qty = $order2->quantity;

                        $prod = DB::table('products')->where('id',$product)->first();

                        if($prod->category == 1){
                            $product_total_qty = 0;

							if($sale->user_id){
                            	$data = array(
                            	    'transaction_info_id' => $product_transaction_info->id,
                            	    'product_id' => $product,
                            	    'quantity' => $qty,
                            	    'user_id' => $user_id,
                            	    'transaction_id' => Str::uuid(),
                            	    'admin_id' => Auth::id(),
                            	    'entry_type' => 'package_outgoing'
                            	);
								$insert_data[] = $data;
								ProductTransaction::insert($insert_data);
							}

                            $product_total_qty = $product_total_qty + $qty;

                            for($p=0;$p<$product_total_qty;$p++){
                                $sernum = $this->sernum();
                                $secpin = $this->secpin();
                                $product_codes = ProductCode::where('code',$sernum)->get();
                                if($product_codes->isEmpty()) {
                                    $product_code = new ProductCode();
                                    $product_code->sponsor_id = $user_id;
                                    $product_code->category = $prod->package_id;
                                    $product_code->type = 'package';
                                    $product_code->code = $sernum;
                                    $product_code->security_pin = $secpin;
                                    $product_code->save();
                                }
                            }


                            //}


                        } else {
							$product_total_qty = 0;

							if($sale->user_id){
                            	$data = array(
                            	    'transaction_info_id' => $product_transaction_info->id,
                            	    'product_id' => $product,
                            	    'quantity' => $qty,
                            	    'user_id' => $user_id,
                            	    'transaction_id' => Str::uuid(),
                            	    'admin_id' => Auth::id(),
                            	    'entry_type' => 'outgoing'
                            	);
								$insert_data[] = $data;
								ProductTransaction::insert($insert_data);
							}

                            $product_total_qty = $product_total_qty + $qty;

							for($p=0;$p<$product_total_qty;$p++){
								$sernum = $this->sernum();
								$secpin = $this->secpin();
								$product_codes = ProductCode::where('code',$sernum)->get();
								if($product_codes->isEmpty()) {
									$product_code = new ProductCode();
									$product_code->sponsor_id = $user_id;
									//$product_code->category = $package[$count];
									$product_code->type = 'product';
									$product_code->code = $sernum;
									$product_code->security_pin = $secpin;
									$product_code->save();
								}
							}

							$product_inventory=ProductInventory::where('product_id',$product)->first();
							$product_name=Product::where('id',$product)->first();
							if($product_inventory){
								$temp_out = $product_inventory->quantity - $qty;
								if($product_inventory->quantity == 0){
									/*return response()->json([
										'message' => ' No Stock Available',
									],500);*/
                                    return back()->with(['errors'=>' No Stock Available']);
								} else if($temp_out < 0){
									/*return response()->json([
										'message' => ' Not enough stocks',
									],500);*/
                                    return back()->with(['errors'=>'  Not enough stocks']);
								} else {
									$product_inventory->quantity = $product_inventory->quantity - $qty;
									$product_inventory->save();
								}
							} else {
                                return back()->with(['errors'=>'  Product not found']);
								/*return response()->json([
									'message' => 'Product not found',
								],500);*/
							}

							//}

						}

                    }
                }
                //Product Code End
                $sale->update(['products_released' => 1]);
                
                $sale->payment->update([
                    'is_paid' => 1,
                    'admin_id' => Auth::id(),
                ]);

                
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

            //Product Code Start
			//$product_released = Sale::where('id',$orders->sale_id)->where('products_released',0)->first();
            //if($product_released){
			//return $sale;


            DB::commit();

			return view('TellerSystem.order_management.order_receipt', compact('sale'));

		} catch(\Throwable $e){
            DB::rollback();
			// Insert User Log Error

            return response()->json([
                'message' => $e->getMessage(),
            ],500);
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
                 
                     if ($productMaintain >=10){
                        DB::table('users')->where('id',$user_id)->update(['unilevel_rank' => '0','unilevel_status'=>'Maintained']);	
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
 
    public function view_receipt(Sale $sale) {
        if($sale->getStatusDetails() === 'Released' && $sale->branch_id == Auth::user()->branch_id)
            return view('TellerSystem.order_management.order_receipt', compact('sale'));

        return redirect()->route('order.record-sales')->with(['error' => 'Access forbidden', 403]);
    }

    public function email_receipt(Request $request, Sale $sale) {
        if(!$request->filled('email')){
            return response(['message' => 'Email is required'], 403);
        }
        $html = view('email.invoice', compact('sale'))->render();

        $pdf = PDF::loadHTML($html)->stream();

        $data = ['name' => $sale->getInvoiceName(), 'total' => $sale->total, 'date' => $sale->created_at->format('j F Y')];

        Mail::send('email.send-invoice', $data, function($message) use ($request, $pdf){
            $message->to($request->email);
            $message->subject(env('APP_NAME') . " Invoice");
            $message->attachData($pdf, 'invoice.pdf');
        });

        return response(['message' => 'Invoice sent to ' . $request->email]);
    }

    public function export()
    {
        return Excel::download(new SalesExport(), 'sales.xlsx');
    }

    public function sales()
    {
        //$orders = Sale::where('branch_id', Auth::user()->branch_id)->get();
        $orders = DB::table('sales')
            ->leftJoin('shipping_details','sales.id','=','shipping_details.sale_id')
            ->leftJoin('payments','sales.id','=','payments.sale_id')
            ->leftJoin('user_infos','sales.user_id','=','user_infos.user_id')
            ->select('sales.*','shipping_details.first_name AS full_name','user_infos.first_name','user_infos.last_name','payments.confirmation_number', 'payments.is_paid', 'payments.fees')
            ->where('branch_id', Auth::user()->branch_id)
            ->get();

        return view('TellerSystem.order_management.sales', compact('orders'));
    }

    public function override()
    {
        $orders = Sale::all()->filter(function($sale){
            return $sale->payment->status == Payment::PROCESSED && $sale->payment->is_paid == Payment::PAID && $sale->branch_id == Auth::user()->branch_id;
        });

        return view('TellerSystem.order_management.override_sales', compact('orders'));
    }

    public function override_sale(Sale $sale, Request $request)
    {
        if($request->has('override_password')){
            $override_password = $request->input('override_password');
            $match = User::where('userType', 'admin')->get()->filter(function($admin) use ($override_password) {
                return Hash::check($override_password, $admin->password);
            });
            if($match->count() > 0){
                foreach ($match as $admin) {
                    Override::create([
                        'user_id' => $admin->id,
                        'sale_id' => $sale->id,
                        'type' => 'Refund'
                    ]);
                }
                $sale->payment->update(['is_paid' => Payment::REFUNDED ]);
                $sale->update([ 'products_released' => Sale::VOIDED ]);
				
				// Insert User Log
				$user_log = new UserLog();
				$user_log->user_id = Auth::id();
				$user_log->description = 9; // Description ID
				$user_log->ip_address = $_SERVER['REMOTE_ADDR'];
				$user_log->save();

                return response(['message' => 'Refund update success']);
            }
        }
		
		// Insert User Log Error
		$user_log =  new UserLog();
		$user_log->user_id = Auth::id();
		$user_log->description = 9; // Description ID
		$user_log->status = "Error"; 
		$user_log->error = 'Incorrect override password';
		$user_log->ip_address = $_SERVER['REMOTE_ADDR'];
		$user_log->save();
        return response(['message' => 'Incorrect override password'], 401);
    }

    public function void()
    {
        $orders = Sale::all()->filter(function($sale){
            return $sale->payment->status == Payment::PROCESSED && ($sale->products_released == Sale::PENDING || $sale->products_released == Sale::RELEASED) && $sale->branch_id == Auth::user()->branch_id;;
        });

        return view('TellerSystem.order_management.void_order', compact('orders'));
    }

    public function void_order(Sale $sale, Request $request)
    {
        if($request->has('override_password')){
            $override_password = $request->input('override_password');
            $match = User::where('userType', 'admin')->get()->filter(function($admin) use ($override_password) {
                return Hash::check($override_password, $admin->password);
            });
            if($match->count() > 0){
                foreach ($match as $admin) {
                    Override::create([
                        'user_id' => $admin->id,
                        'sale_id' => $sale->id,
                        'type' => 'Void'
                    ]);
                }
                $sale->update(['products_released' => Sale::VOIDED ]);
				// Insert User Log Success
				$user_log =  new UserLog();
				$user_log->user_id = Auth::id();
				$user_log->description = 10; // Description ID
            	$user_log->ip_address = $_SERVER['REMOTE_ADDR'];
				$user_log->save();

                return response(['message' => 'Sale void update success']);
            }
        }
		
		// Insert User Log Error
		$user_log =  new UserLog();
		$user_log->user_id = Auth::id();
		$user_log->description = 10; // Description ID
		$user_log->status = "Error"; 
		$user_log->error = 'Incorrect override password';
		$user_log->ip_address = $_SERVER['REMOTE_ADDR'];
		$user_log->save();
        return response(['message' => 'Incorrect override password'], 401);
    }

    public function show(Sale $sale)
    {
        if(Auth::user()->branch_id !== $sale->branch_id)
            return [];

        return $sale;
    }
}
