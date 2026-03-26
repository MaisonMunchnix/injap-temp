<?php

namespace App\Http\Controllers;

use App\User;
use App\UserInfo;
use App\ProductCode;
use App\Referral;
use App\Network;
use App\ShippingDetail;
use App\Sale;
use App\Encashment;
use App\UnilevelSale;
use App\Product;
use App\AyudaSale;
use Carbon\Carbon;
use App\PairingComputation;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;



class IncomeController extends Controller
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


    public function getUnilevelSales(){

        $auth_id =Auth::id();
        $groupSales = $this->UnilevelGroupSales($auth_id);
       $unilevel_sales = DB::table('products')
                           ->join('orders', 'products.id', '=', 'orders.product_id')
                           ->join('sales', 'sales.id', '=', 'orders.sale_id')
                           ->join('unilevel_sales', 'sales.id', '=', 'unilevel_sales.sales_id')
                           ->join('users', 'users.id', '=', 'unilevel_sales.source_id')
                           ->select('unilevel_sales.created_at','products.name','users.username','unilevel_sales.quantity','unilevel_sales.total_price')
                           ->where('unilevel_sales.user_id',$auth_id )
                            ->get();
        return view('user.unilevel-sales.index',compact('auth_id','unilevel_sales','groupSales'));

    }


    private function UnilevelGroupSales($sponsor_id){ 
        $sponsor_id=$sponsor_id;
        $UnilevelGroupSales =0;
        $monthNow= date('m'); 
        $yearNow= date('Y');
        $x=0;
        $jsonData = new \stdClass();  
         $jsonData = $this->UnilevelGroupSalesChecker($sponsor_id);
         foreach ($jsonData  as $key) {
            foreach ($key as  $value) {        
                $UnilevelSale = UnilevelSale::where('user_id',$value)->whereMonth('created_at','=',$monthNow)->whereYear('created_at','=',$yearNow)->get();
                if($UnilevelSale->count() >=1){
                foreach ($UnilevelSale as $key) {                  
                        $UnilevelGroupSales =$UnilevelGroupSales+$key->total_price;
                    }
                }
            }
            $x++;  
        }
        if($x>1){
            $UnilevelSale = UnilevelSale::where('user_id',$sponsor_id)->whereMonth('created_at','=',$monthNow)->whereYear('created_at','=',$yearNow)->get();
            if($UnilevelSale->count() >=1){
            foreach ($UnilevelSale as $key) {                  
                    $UnilevelGroupSales =$UnilevelGroupSales+$key->total_price;
                }
            }
        }
        return $UnilevelGroupSales;
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
                  $Network =  $this->SponsorData($key['level'.$y.'']);
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
    public function viewIncome($type){
        $auth_id =Auth::id();
        $valid_type=array('referral-bonus','sales-match-bonus','activation-cost-reward','fifth-sales-match-bonus','fifth-sales-reward-points','total-accumulated-income','total-withdrawable-amount','direct-referral-bonus','Ayuda-Sales');
        $trans_type=['referral_bonus'=>'Referral Bonus','sales_match_bonus'=>'Salesmatch Bonus','activation_cost_reward'=>'Activation Cost Reward ','fifth_activation_cost_reward'=>'5th Sales Match Bonus','fifth_sales_reward_points'=>'5th Sales Reward Points','total_accumulated_income'=>'Total Accumulated Income','total_withdrawable_amount'=>'Total Withdrawable Amount','direct_referral_bonus'=>'Direct Referral Bonus','Ayuda_Sales'=>'Ayuda Sales'];
        $total_sum=0;
        if (!in_array($type, $valid_type)){
            return view('view.error_404');
        }else{
            $bonus_type=str_replace("-","_",$type);
            $referral;
            
            if($bonus_type=='total_accumulated_income'){
                $referral=Referral::where('user_id',$auth_id)->get();
                $total_sum=Referral::select('amount')->where('user_id',$auth_id)->sum('amount');
            }else if($bonus_type=='total_withdrawable_amount'){
                $referral=Referral::where('user_id',$auth_id)->where('referral_type','!=','fifth_activation_cost_reward')->get();
                $total_sum=Referral::select('amount')->where('user_id',$auth_id)->where('referral_type','!=','fifth_activation_cost_reward')->sum('amount');
            }else if($bonus_type=='Ayuda_Sales'){
                $start = new Carbon('first day of this month');
                $end = new Carbon('last day of this month');
                $start = $start->format('Y-m-d');
                $end = $end->format('Y-m-d');
                $referral=AyudaSale::where('user_id',$auth_id)->where('referral_type','=','Ayuda_Sales')->where('status','=',1)
               // ->whereBetween('date_execution', [$start, $end])
                ->get();
                $total_sum=AyudaSale::select('amount')->where('user_id',$auth_id)->where('referral_type','=','Ayuda_Sales')->where('status','=',1)->sum('amount');
            }
            elseif($bonus_type=='sales_match_bonus'){
                $myPair = new PairingComputation();

                $referral_array = $myPair->pairing_data();

                $total_sum = number_format($myPair->pairing_count(),2);
            }
            else{
                $referral=Referral::where('user_id',$auth_id)->where('referral_type',$bonus_type)->get();
                $total_sum=Referral::select('amount')->where('user_id',$auth_id)->where('referral_type',$bonus_type)->sum('amount');
            }      
            
            
            if($bonus_type != "sales_match_bonus"){
            $referral_array=array();
            $i=1;
            foreach($referral as $refer){
                $transact_id=$refer->id;   
                if(strlen($transact_id)<10){
                    $transact_id=sprintf("%010d", $refer->id);  
                }
                   
                $t_type = $trans_type[$refer->referral_type];
                $user_info = UserInfo::select('first_name','last_name')->where('user_id',$refer->source_id)->first();
                $user = User::select('username')->where('id',$refer->source_id)->first();
                $full_name='No Data';
                if(!empty($user)){
                    $full_name = $user->username;
                }

                if($bonus_type=='Ayuda_Sales'){
                    $user = User::select('username')->where('id',$auth_id)->first();
                    $full_name = $user->username;
                }
                if($bonus_type=='Ayuda_Sales'){
                    $temp_referral_array=array('count'=>$i,'trans_id'=>$transact_id,'trans_date'=>$refer->updated_at,'trans_type'=>$t_type,'source'=>$full_name,'amount'=>$refer->amount);
                }else{
                    $temp_referral_array=array('count'=>$i,'trans_id'=>$transact_id,'trans_date'=>$refer->created_at,'trans_type'=>$t_type,'source'=>$full_name,'amount'=>$refer->amount);   
                }
                
                $i++;
                array_push($referral_array,$temp_referral_array);
            }
          


            }





            








            return view('user.income-listing.index',compact('auth_id','referral_array','trans_type','bonus_type','total_sum'));
        }
        
    }


    public function getTotalIncome(){
        $auth_id =Auth::id();
        $affiliate_link="";
        $get_aff_link=User::select('affiliate_link')->where('id',$auth_id)->first();
        if(!empty($get_aff_link)){
            $affiliate_link=$get_aff_link->affiliate_link;
        }
        
        $result=[];
        $total_sum=0;
        $trans_type=['referral_bonus'=>'Referral Bonus','sales_match_bonus'=>'Sales Match Bonus','activation_cost_reward'=>'Activation Cost Reward','fifth_activation_cost_reward'=>'5th Sales Match Bonus','total_accumulated_income'=>'Total Accumulated Income','total_withdrawable_amount'=>'Total Withdrawable Amount','direct_referral_bonus'=>'Direct Referral Bonus','ayuda_sales'=>'Ayuda Sales'];
        
        $referral=Referral::where('user_id',$auth_id)->where('reward_type','php')
          ->where("referral_type",  "!=","sales_match_bonus")
          ->where("referral_type", "!=", "direct_referral_bonus")
          ->get();
        if(!empty($referral)){
            foreach($referral as $refer){
                $t_type=$trans_type[$refer->referral_type];
                $amount='<span class="text-success">+'.number_format($refer->amount,2).'</span>';
                //$user_info=UserInfo::select('first_name','last_name')->where('user_id',$refer->source_id)->first();
                $user = User::select('username')->where('id',$refer->source_id)->first();
                $full_name='No Data';
                if(!empty($user)){
                    $full_name = $user->username;
                }
                $temp_array=array('trans_date'=>$refer->created_at,'trans_type'=>$t_type,'source'=>$full_name,'amount'=>$amount);
                array_push($result,$temp_array);
                $total_sum+=$refer->amount;
            }
        } 
      
      $myPair = new PairingComputation();

        $referral_array = $myPair->pairing_data();
        foreach($referral_array as $pair){
            $amount='<span class="text-success">+'.number_format(floatval(str_replace(",","",$pair["amount"])),2).'</span>';
            $temp_array=array('trans_date'=>$pair["trans_date"],'trans_type'=>$pair["trans_type"],'source'=>$pair["source"],'amount'=>$amount);
            array_push($result,$temp_array);
            $total_sum+=floatval(str_replace(",","",$pair["amount"]));
        }


        return view('user.income-listing.income',compact('auth_id','total_sum','result'));
    }
    
    public function getTotalWeeklyIncome($type){
        $auth_id =Auth::id();
        $affiliate_link="";
        $get_aff_link=User::select('affiliate_link')->where('id',$auth_id)->first();
        if(!empty($get_aff_link)){
            $affiliate_link=$get_aff_link->affiliate_link;
        }
        
        $result=[];
        $total_sum=0;
        $trans_type=['referral_bonus'=>'Referral Bonus','activation_cost_reward'=>'Sales Match Bonus','fifth_activation_cost_reward'=>'5th Sales Match Bonus','total_accumulated_income'=>'Total Accumulated Income','total_withdrawable_amount'=>'Total Withdrawable Amount'];
        
        /*if($type == 'sales-match'){
            $trans_type=[
                'activation_cost_reward'=>'Sales Match Bonus'
            ];
        } else if($type == 'fifth-sales'){
            $trans_type=[
                'fifth_activation_cost_reward'=>'5th Sales Match Bonus'
            ];
        }*/
        
        
        $referral = Referral::where('user_id',$auth_id)
          ->where("referral_type",  "!=","sales_match_bonus")
          ->get();
        if(!empty($referral)){
            foreach($referral as $refer){
                $t_type=$trans_type[$refer->referral_type];
                $amount='<span class="text-success">+'.number_format($refer->amount,2).'</span>';
                //$user_info=UserInfo::select('first_name','last_name')->where('user_id',$refer->source_id)->first();
                $user = User::select('username')->where('id',$refer->source_id)->first();
                $full_name='No Data';
                if(!empty($user)){
                    $full_name = $user->username;
                }
                $temp_array=array('trans_date'=>$refer->created_at,'trans_type'=>$t_type,'source'=>$full_name,'amount'=>$amount);
                array_push($result,$temp_array);
                $total_sum +=$refer->amount;
            }
        }
   	
      $myPair = new PairingComputation();

        $referral_array = $myPair->pairing_data();
        foreach($referral_array as $pair){
            $amount='<span class="text-success">+'.number_format(floatval(str_replace(",","",$pair["amount"])),2).'</span>';
            $temp_array=array('trans_date'=>$pair["trans_date"],'trans_type'=>$pair["trans_type"],'source'=>$pair["source"],'amount'=>$amount);
            array_push($result,$temp_array);
            $total_sum+=floatval(str_replace(",","",$pair["amount"]));
        }


        return view('user.income-listing.weekly',compact('auth_id','total_sum','result'));
    }

    public function getAvailBalance(){
        $auth_id =Auth::id();
        $affiliate_link="";
        $get_aff_link=User::select('affiliate_link')->where('id',$auth_id)->first();
        if(!empty($get_aff_link)){
            $affiliate_link=$get_aff_link->affiliate_link;
        }
        
        $result=[];
        $total_sum=0;
        $total_encashment=0;
        $total_purchases=0;
        $total_bal=0;
        $trans_type=['referral_bonus'=>'Referral Bonus','activation_cost_reward'=>'Sales Match Bonus','fifth_activation_cost_reward'=>'5th Sales Match Bonus','total_accumulated_income'=>'Total Accumulated Income','total_withdrawable_amount'=>'Total Withdrawable Amount'];
        
        $referral=Referral::where('user_id',$auth_id)->get();
        if(!empty($referral)){
            foreach($referral as $refer){
                $t_type=$trans_type[$refer->referral_type];
                $amount='<span class="text-success">+'.number_format($refer->amount,2).'</span>';
                //$user_info=UserInfo::select('first_name','last_name')->where('user_id',$refer->source_id)->first();
                $user = User::select('username')->where('id',$refer->source_id)->first();
                $full_name='No Data';
                if(!empty($user)){
                    $full_name = $user->username;
                }
                $temp_array=array('trans_date'=>$refer->created_at,'trans_type'=>$t_type,'source'=>$full_name,'amount'=>$amount);
                array_push($result,$temp_array);
                $total_sum+=$refer->amount;
            }
        }

        //total commission
        $get_commission=DB::table('sales')
            ->join('orders', 'orders.sale_id', '=', 'sales.id')
            ->join('payments', 'payments.sale_id', '=', 'sales.id')
            ->select('sales.id',DB::raw('SUM(orders.commission) as total_comm'))
            ->where('sales.affiliate_link_used',$affiliate_link)
            ->where('sales.products_released',1)
            ->where('payments.is_paid',1)
            ->groupBy('sales.id')
            ->get();
        if(!empty($get_commission)){
            foreach($get_commission as $data){
                //$user_info=ShippingDetail::select('first_name','last_name')->where('sale_id',$data->id)->first();
                $user = User::select('username')->where('id',$refer->source_id)->first();
                $full_name='No Data';
                if(!empty($user)){
                    $full_name = $user->username;
                }
                $created="No data";
                $get_created=Sale::select('created_at')->where('id',$data->id)->first();
                if(!empty($get_created)){
                    $created=$get_created->created_at;
                }
                $amount='<span class="text-success">+'.number_format($data->total_comm,2).'</span>';
                $temp_array=array('trans_date'=>$created,'trans_type'=>'Retail Commission','source'=>$full_name,'amount'=>$amount);
                array_push($result,$temp_array);
                $total_sum+=$data->total_comm;
            }
        }

        $get_uni_sales=DB::table('unilevel_sales')
            ->join('user_infos as ui2', 'ui2.user_id', '=', 'unilevel_sales.source_id')
            ->select('ui2.first_name as source_f_name','ui2.last_name as source_l_name','unilevel_sales.total_price','unilevel_sales.created_at')
            ->where('unilevel_sales.user_id',$auth_id)
            ->get();
        if(!empty($get_uni_sales)){
            foreach($get_uni_sales as $data){
                $source_name=$data->source_f_name." ".$data->source_l_name;
                $amount='<span class="text-success">+'.number_format($data->total_price,2).'</span>';
                $temp_array=array('trans_date'=>$data->created_at,'trans_type'=>'Unilevel sales','source'=>$source_name,'amount'=>$amount);
                array_push($result,$temp_array);
                $total_sum+=$data->total_price;
            }
        }    

        $get_encashment=Encashment::select('amount_approved','created_at')->where('user_id',$auth_id)->where('status','claimed')->get();
        if(!empty($get_encashment)){
            foreach($get_encashment as $data){
                $amount='<span class="text-danger">-'.number_format($data->amount_approved,2).'</span>';
                $temp_array=array('trans_date'=>$data->created_at,'trans_type'=>'Encashment','source'=>'Encashment','amount'=>$amount);
                array_push($result,$temp_array);
                $total_encashment+=$data->amount_approved;
            }
        }

        $get_pay_ewallet=DB::table('sales')
            ->join('payments', 'payments.sale_id', '=', 'sales.id')
            ->select('sales.total','sales.created_at')
            ->where('sales.user_id',$auth_id)           
            ->where('sales.products_released',1)
            ->where('payments.driver','EWalletPaymentGateway')
            ->where('payments.is_paid',1)   
            ->get();
        if(!empty($get_pay_ewallet)){
            foreach($get_pay_ewallet as $data){
                $amount='<span class="text-danger">-'.number_format($data->total,2).'</span>';
                $temp_array=array('trans_date'=>$data->created_at,'trans_type'=>'E-wallet purchases','source'=>'E-wallet purchases','amount'=>$amount);
                array_push($result,$temp_array);
                $total_purchases+=$data->total;
            }
        }
            
        return view('user.income-listing.balance',compact('auth_id','total_sum','total_purchases','total_encashment','result'));
        
    }



   
}
