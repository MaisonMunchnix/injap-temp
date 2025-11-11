<?php

namespace App\Http\Controllers;

use App\Billing\PaymentGateway;
use App\Encashment;
use App\Sale;
use App\User;
use Dompdf\Exception;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;

use App\UnilevelSale;
use App\Unilevel;
use App\Network;
 use App\Payment;
 use App\Order;
 use Illuminate\Support\Str;

class PaymentController extends Controller
{
    
    public function ewalletProcess(Request $request){
        $User_data = User::where('id',Auth::user()->id)->get();
        
        $id=0;
        $quantity=0;
        $id=$request['id'];
        $quantity=$request['quantity'];
            $discount=0.0;
            $commission=0.0;
            $price=0.0;
            $sub_total=0.0;
        
         $product = DB::table('products')
        ->join('product_discounts', 'product_discounts.product_id', '=', 'products.id')
        ->where('products.id',$id)
        ->where('product_discounts.package_type',$User_data[0]->member_type)
        ->first();
        
        $price = $product->discounted_price;
        $sub_total=$product->discounted_price;
        $price=$sub_total;
        $price=$price*$quantity;
        
        $shipping_fee =  0.0;
        $fees=0.0;

        $sale = new Sale();
        $sale->user_id = Auth::user()->id ?? null;
        $sale->branch_id = 1; //Main Branch ID
        $sale->subtotal = $price;
        $sale->discount = $discount;
        $sale->shipping = $shipping_fee;
        $sale->fees = $fees;
        $sale->total = $price;
        $sale->note = $request->input('order_note');
        $sale->ship_to_another_address = $request->has('ship_to_another_address') ?? 0;
        $sale->affiliate_link_used = Cookie::get('retail-affiliate-code');
        $commission = User::getSalesCommission($sale->affiliate_link_used);

        

        DB::beginTransaction();
        try {
            $sale->save();
           
            $Payment = new Payment();
            $Payment->sale_id = $sale->id;
            $Payment->amount = $price;
            $Payment->confirmation_number = "REF-" . strtotime(now());
            $Payment->currency = 'php';
            $Payment->shipping = 0.0;
            $Payment->fees = 0.0;
            $Payment->driver = 'EWalletPaymentGateway';
            $Payment->status = 1;
            $Payment->is_paid = 0;
            $Payment->save();


            DB::table('orders')->insert([
                'sale_id'    => $sale->id,
                'product_id' =>$id,
                'quantity'   => $quantity,
                'price'      => $sub_total,
                'discount'   => $discount,
                'commission' => $commission
            ]);
            

            //$this->unilevel($sale->id, +$id, +$quantity);

            DB::commit();
            return 'success';
            //return view('e-commerce.payment-details', compact('payment'));
        } catch (\Exception $e) {
            DB::rollback();
            return $e;
            //$payment = [ 'status' => 0, 'error' => 'Server error occurred, please try again later.'];
            //return view('e-commerce.payment-details', compact('payment'));
        }

    }

    private function unilevel($sale_id, $order_id, $qty)
    {
        $user = Auth::user();
      
        if($user->id != null && $user->id != ""){

        $sale = new \stdClass();
        $sale->user_id = $user->id;
        $sale->id = $sale_id;

        $orders = new \stdClass();
        $orders->product_id =$order_id;
        $orders->quantity= $qty;
       return $this->unilevelSection($sale,$orders);
        }
        
    }



    private function unilevelSection($sale,$orders){
      
       
        $unilevelLimiter=0;
        $jsonData = new \stdClass();
        $price;
        if ($sale->user_id==null){
         
        }else{
        
        $this->unilevelStatusChanger($sale->user_id);
           $User_data = User::where('id',$sale->user_id)->where('unilevel_rank', '>=',0)->where('unilevel_rank','<',6)->where('unilevel_status','Maintained')->get();

        //$orders = DB::table('orders')->where('sale_id',$sale->id)->first();
        
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
                                  if($counter->count()==0){
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
                                  }else if($counter[0]->unilevel_rank == 5){
                                      $unilevelLimiter=30;
                                  }

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
        $directReferral = Network::where('sponsor_id',$user_id)->get();
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
        ->count();

         
           $productMaintain = DB::table('sales')
                 ->join('orders', 'orders.sale_id', '=', 'sales.id')
                 ->where('sales.user_id',$user_id)
                 ->where('orders.product_id',3)
                 ->whereMonth('sales.updated_at','=',$monthNow)
                 ->whereYear('sales.updated_at','=',$yearNow)
                 ->where('sales.products_released',1)
                 ->sum('orders.quantity');
                 $maintainStatus="";
                 if ($unilevelRank['unilevel_rank'] == 6  || $unilevelRank['unilevel_rank'] == 0 ){
                     if ($directReferral >=2 &&  $productMaintain >=4){
                        DB::table('users')->where('id',$user_id)->update(['unilevel_rank' => '0','unilevel_status'=>'Maintained']);	
                        $maintainStatus="Maintained";					
                     }else {
                        DB::table('users')->where('id',$user_id)->update(['unilevel_status' => 'Not Maintained']);
                        $maintainStatus="Not Maintained";		
                     }                  
                   
                }

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
                }
               
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
                         $UnilevelUserCount = User::where('id',$value->sponsor_id)->where('unilevel_rank','>=',0)->where('unilevel_rank','<',6)->count();
                    if($UnilevelUserCount ==1){
                       $id2=['level'.$incremental.''=>$value->sponsor_id];
                       $s='level'.''.$incremental;
                      array_push($id,$value->sponsor_id);
                          array_push($id4,$id2);
                    }else{

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
                                 $UnilevelUserCount = User::where('id',$value->sponsor_id)->where('unilevel_rank','>=',0)->where('unilevel_rank','<',6)->count();
                          if($UnilevelUserCount ==1){
                             $id2=['level'.$incremental.''=>$value->sponsor_id];
                             $s='level'.''.$incremental;
                            array_push($id,$value->sponsor_id);
                            array_push($id4,$id2);
                          }else{
                                
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
                    foreach($Network as  $value)
                    {
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

    public function store(PaymentGateway $paymentGateway, Request $request)
    {
        $cart = Cart::instance(Auth::user());

        if($cart->count() === 0) {
            return back();
        }

        $auth_id = Auth::user()->id;

        if(!Auth::check() || $request->has('ship_to_another_address')) {
            $request->validate([
                'first_name' => 'required',
                'middle_name' => 'required',
                'last_name' => 'required',
                'email' => 'required',
                'mobile_number' => 'required',
                'street_address' => 'required',
                'city' => 'required',
                'province' => 'required',
                'shipping_checkout' => 'required',
                'checkout_method' => 'required'
            ]);
        }

        $shipping_fee = $request->input('shipping_checkout') === 'ship-items' ? 250:0;
        $payment = $paymentGateway->charge($cart->subtotal(2, '.', ''), $shipping_fee);
        $sale = new Sale();
        $sale->user_id = $auth_id ?? null;
        $sale->branch_id = 1; //Main Branch ID
        $sale->subtotal = $cart->priceTotal(2, '.', '');
        $sale->discount = $cart->discount(2, '.', '');
        $sale->shipping = $payment['shipping'];
        $sale->fees = $payment['fees'];
        $sale->total = $payment['amount'];
        $sale->note = $request->input('order_note');
        $sale->ship_to_another_address = $request->has('ship_to_another_address') ?? 0;
        $sale->affiliate_link_used = Cookie::get('retail-affiliate-code');
        $commission = User::getSalesCommission($sale->affiliate_link_used);

        DB::beginTransaction();
        try {
            $sale->save();
            $orders = $cart->content()->mapWithKeys(function($order) use ($commission, $sale) {
                if(Auth::check()) $this->unilevel($sale->id, $order->model->id, $order->qty);
                return [$order->model->id => [ 'quantity' => $order->qty, 'price' => $order->price * (1 - $order->discountRate / 100), 'discount' => $order->price * ($order->discountRate / 100), 'commission' => $order->price * $commission ]];
            });

            $sale->products()->syncWithoutDetaching($orders->toArray());

            if (!Auth::check() || $request->has('ship_to_another_address')) {
                $sale->shippingDetail()->create($request->except(['_token', 'shipping_checkout', 'checkout_method', 'order_note', 'ship_to_another_address', 'city_id', 'province_id']));
            }

            $sale->payment()->create($payment);

            $cart->destroy();
            DB::commit();
            return view('user.products.payment-status', compact('payment','auth_id'));
        } catch (\Exception $e) {
            DB::rollback();
            $payment = [ 'status' => 0, 'error' => 'Server error occurred, please try again later.'];
            return view('user.products.payment-status', compact('payment','auth_id'));
        }
    }

   
}
