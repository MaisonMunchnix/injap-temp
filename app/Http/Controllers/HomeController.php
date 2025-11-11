<?php

namespace App\Http\Controllers;



use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use App\User;
use App\UserInfo;
use App\ProductCode;
use App\PvPoint;
use App\Referral;
use App\Network;
use App\UnilevelSale;
use App\Unilevel;
use App\Pair;
use Carbon\Carbon;
use App\Announcement;
use App\Encashment;
use App\AyudaSale;
use App\IncomeTransfer;
use App\PairingComputation;




class HomeController extends Controller
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

    private $open_logo = "http://it-dev-site.epizy.com/images/badge-open.png";
    private $close_logo = "http://it-dev-site.epizy.com/images/badge-closed.png";
    private $free_logo = "http://it-dev-site.epizy.com/images/badge-07-small.png";
    private $silver_logo = "http://it-dev-site.epizy.com/images/badge-05-small.png";
    private $platinum_logo = "http://it-dev-site.epizy.com/images/badge-06-small.png";

    public function index()
    {

        return view('homeAdmin');
    }


    
    public function NetworkCheckerView(){
        $auth_id = Auth::id();
        $MynetworkData=[];

        $Network = Network::where('upline_placement_id',$auth_id)->get();
        foreach ($Network as $value) {
            if($value->placement_position=="left"){
                $left = $this->getDataleft3($value->user_id,"left");
               // $leftCount= count($left);
            }else if($value->placement_position=="right"){
                  $right = $this->getDataRight3($value->user_id,"right");
               // $righCount= count($right);
            }
        }
       //array_push($MynetworkData,$left);
       // array_push($MynetworkData,$right);
         $MynetworkData;
        if(!empty($right)){
            foreach ($right  as $value) {
                array_push($MynetworkData,$value);
            }
        }
        if(!empty($left)){
            foreach ($left  as $value) {
                array_push($MynetworkData,$value);
            }
        }

        $array_elements= count($MynetworkData);
       // return $MynetworkData;
        $current = null;
        $dataCheckertmp=[];
        $dataChecker=[];
        $totaldata=[];
        $totalright=0;
        $totalleft = 0;
        $right_total=0;
        $left_total=0;
        
     
        for ( $i = 0; $i < $array_elements; $i++) {
            $dataCheckertmp=[];
            $rightdata=0;
            $leftdata=0;
            $x=0;
           $current = $MynetworkData[$i]['dateData'];
            while ($array_elements != $x) {
                //return $MynetworkData[$x]['positionData'];
                if ($MynetworkData[$x]['dateData'] == $current) {
                   
                    if($MynetworkData[$x]['positionData'] == "right"){
                        $rightdata++;
                        //$right_total++;
                       
                    }
                   else  if($MynetworkData[$x]['positionData'] == "left"){
                        $leftdata++;
                        //$left_total++;
                       
                    }
                  
                } 
                $x++;
            }

             if($MynetworkData[$i]['positionData'] == "right"){                      
                        $right_total++;
                       
            }
            else  if($MynetworkData[$i]['positionData'] == "left"){                      
                        $left_total++;
                       
            }
           
       
                 $dataCheckertmp=[
                 'Date'=>$current,
                 'right'=>$rightdata,
                 'left'=>$leftdata
                 ];
                 $array_elements2= count($dataChecker);
                 $checkerdata=0;
                 for ($a=0; $a < $array_elements2; $a++) { 
                   if($dataChecker[$a]['Date'] == $current){
                    $checkerdata++;
                   }
                 }
                 if($checkerdata==0){
                    array_push($dataChecker,$dataCheckertmp);
                 }
                 
             
            
        }
        return view('user.network-checker.index',compact('auth_id','dataChecker','left_total','right_total'));
    }

    public function NetworkChecker(Request $request){

        
        $auth_id = Auth::id();
        $columns = array( 
			0 => 'code',
			1 => 'security_pin',
			2 => 'category',
			3 => 'used_by',
            4 => 'user_activation_date',
            5 => 'created_at'
        );
        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');
        $MynetworkData=[];

        $Network = Network::where('upline_placement_id',$auth_id)->get();
        foreach ($Network as $value) {
            if($value->placement_position=="left"){
                $left = $this->getDataleft3($value->user_id,"left");
                $leftCount= count($left);
            }else if($value->placement_position=="right"){
                 $right = $this->getDataRight3($value->user_id,"right");
                $righCount= count($right);
            }
        }
       //array_push($MynetworkData,$left);
       // array_push($MynetworkData,$right);
         $MynetworkData;
        if(!empty($right)){
            foreach ($right  as $value) {
                array_push($MynetworkData,$value);
            }
        }
        if(!empty($left)){
            foreach ($left  as $value) {
                array_push($MynetworkData,$value);
            }
        }

        $array_elements= count($MynetworkData);
       // return $MynetworkData;
        $current = null;
        $dataCheckertmp=[];
        $dataChecker=[];
        $totaldata=[];
        $totalright=0;
        $totalleft = 0;
     
        for ( $i = 0; $i < $array_elements; $i++) {
            $dataCheckertmp=[];
            $rightdata=0;
            $leftdata=0;
            $x=0;
           $current = $MynetworkData[$i]['dateData'];
            while ($array_elements != $x) {
                //return $MynetworkData[$x]['positionData'];
                if ($MynetworkData[$x]['dateData'] == $current) {
                   
                    if($MynetworkData[$x]['positionData'] == "right"){
                        $rightdata++;
                       
                    }
                   else  if($MynetworkData[$x]['positionData'] == "left"){
                        $leftdata++;
                       
                    }
                  
                } 
                $x++;
            }
           
       
                 $dataCheckertmp=[
                 'Date'=>$current,
                 'right'=>$rightdata,
                 'left'=>$leftdata
                 ];
                 $array_elements2= count($dataChecker);
                 $checkerdata=0;
                 for ($a=0; $a < $array_elements2; $a++) { 
                   if($dataChecker[$a]['Date'] == $current){
                    $checkerdata++;
                   }
                 }
                 if($checkerdata==0){
                    array_push($dataChecker,$dataCheckertmp);
                 }
                 
             
            
        }

        $json_data = array(
            
            "data"            => $dataChecker   
            );
            
        echo json_encode($json_data); 
    

    }

    
    private function getDataleft3($sponsor_id,$positions){
        //$user= User::all();
        $id=[];
        $id1=[];
        $id2=[];
        $id3=[];
        $username=[];
        $usernameData=[];
        $totalArray=[];
        $silverLeft=0;
        $silverRight=0;
        
        $goldRight=0;
        $goldleft=0;

        $platinumRight=0;
        $platinumleft=0;
       array_push($id,$sponsor_id);
        array_push($id2,$sponsor_id);
        $users = User::where('id',$sponsor_id)->first(); 
        $account_type=$users->account_type;
        if($account_type==1){
           
            $silverLeft++;
            $username=['positionData'=>'left', 'dateData'=>$users->created_at->format('m-d-Y')];
            array_push($usernameData,$username);
        }else if($account_type==2){   
                           
            $goldleft++;
            $username=['positionData'=>'left', 'dateData'=>$users->created_at->format('m-d-Y')];
        
            array_push($usernameData,$username);
        }else if($account_type==3){
            $platinumleft++;
            $username=['positionData'=>'left', 'dateData'=>$users->created_at->format('m-d-Y')];
        
            array_push($usernameData,$username);
        }
        else{
            return $account_type;
        } 
        $x=0;
        while(count($id2)>=1){
            $id3=$id2;
            $id2=[];
            foreach ($id3 as $value) {
                 $tmp = Network::where('upline_placement_id',$value)->get();
                 if(!empty($tmp)){
                    foreach ($tmp as  $value2) {
                        
                        
                         $users = User::where('id',$value2->user_id)->first(); 
                       // return $Network->placement_position;  
                         
                       $account_type=$users->account_type;
                       if($account_type==1){
                            $silverLeft++;
                            $username=['positionData'=>'left',
                            'dateData'=>$users->created_at->format('m-d-Y')      ];
                            array_push($usernameData,$username);
                       }else if($account_type==2){                     
                            $goldleft++;
                            $username=['positionData'=>'left',
                            'dateData'=>$users->created_at->format('m-d-Y')      ];
                            
                            array_push($usernameData,$username);
                                
                       }else if($account_type==3){                     
                            $platinumleft++;
                            $username=['positionData'=>'left',
                            'dateData'=>$users->created_at->format('m-d-Y')      ];
                        
                            array_push($usernameData,$username);
                        
                        }else{
                           return $account_type;
                       }                       
                        array_push($id,$value2->user_id);
                        array_push($id2,$value2->user_id); 


                    }
                 }else{
                    //return$id3=11;
                    $id2=0;
                    
                 }
               
                
            }
            
          

            
            
        }
        $id12=['silverLeft'=>$silverLeft];
        $id15=['goldleft'=>$goldleft];
        $id16=['platinumleft'=>$platinumleft];
        array_push($totalArray,$id12);
        array_push($totalArray,$id15);
        array_push($totalArray,$id16);
        return $usernameData;
      
        
    }
    private function getDataRight3($sponsor_id,$positions){
        //$user= User::all();
        $id=[];
        $id1=[];
        $id2=[];
        $id3=[];
        $totalArray=[];
        $silverLeft=0;
        $silverRight=0;
        $usernameData=[];
        $username=[];
        $goldRight=0;
        $goldleft=0;
        $platinumRight=0;
        $platinumleft=0;
       array_push($id,$sponsor_id);
        array_push($id2,$sponsor_id);
        $users = User::where('id',$sponsor_id)->first(); 
        $account_type=$users->account_type;
        if($account_type==1){
            $silverRight++;
            $username=['positionData'=>'right',
            'dateData'=>$users->created_at->format('m-d-Y')      ];
            array_push($usernameData,$username);
        }else if($account_type==2){                     
            $goldRight++;
            $username=['positionData'=>'right',
            'dateData'=>$users->created_at->format('m-d-Y')      ];
            
            array_push($usernameData,$username);
        }else if($account_type==3){                     
            $platinumRight++;
            $username=['positionData'=>'right',
            'dateData'=>$users->created_at->format('m-d-Y')      ];
            
            array_push($usernameData,$username);
        }else{
            return $account_type;
        } 
        $x=0;
        while(count($id2)>=1){
            $id3=$id2;
            $id2=[];
            foreach ($id3 as $value) {
                 $tmp = Network::where('upline_placement_id',$value)->get();
                 if(!empty($tmp)){
                    foreach ($tmp as  $value2) {
                        
                        
                         $users = User::where('id',$value2->user_id)->first(); 
                       // return $Network->placement_position;  
                         
                       $account_type=$users->account_type;
                       if($account_type==1){
                            $silverRight++;
                            $username=['positionData'=>'right',
                                        'dateData'=>$users->created_at->format('m-d-Y')                
                                        ];
                            array_push($usernameData,$username);
                       }else if($account_type==2){                     
                            $goldRight++;
                            $username=['positionData'=>'right',
                                        'dateData'=>$users->created_at->format('m-d-Y')                
                                        ];
                            array_push($usernameData,$username);
                       }else if($account_type==3){                     
                            $platinumRight++;
                            $username=['positionData'=>'right',
                                        'dateData'=>$users->created_at->format('m-d-Y')                
                                        ];
                            array_push($usernameData,$username);
                        }else{
                           return $account_type;
                       }                       
                        array_push($id,$value2->user_id);
                        array_push($id2,$value2->user_id); 


                    }
                 }else{
                    //return$id3=11;
                    $id2=0;
                    
                 }
               
                
            }
            
          

            
            
        }
        $id13=['silverRight'=>$silverRight];
        $id14=['goldRight'=>$goldRight];
        $id15=['platinumRight'=>$platinumRight];
        array_push($totalArray,$id13);
        array_push($totalArray,$id14);
        array_push($totalArray,$id15);
        return $usernameData;
      
      
        
    }

    public function test2(){
       return $Networks = DB::table('networks')
        ->select(DB::raw('networks.sponsor_id as user_id,count(networks.sponsor_id)  as ayuda'))
        ->join('product_codes', 'product_codes.user_id', '=', 'networks.sponsor_id')
        ->where('product_codes.product_id', 2)
        ->having('ayuda', '>=', 10)
        ->groupBy('networks.sponsor_id')
        ->get();
        
        $UserIdData=[];
        $UserIdDataTmp=[];
        $UserIdDataExcess=[];
        $UserIdDataTmpExcess=[];
        $date="";
        foreach ($Networks as  $Network) {

             $sponsoreDatas = DB::table('networks')    
            ->select(DB::raw('user_id , Date(created_at) as created_at'))        
            ->where('sponsor_id', $Network->user_id)
            ->get();
            $checkerCounter=0;
            foreach ($sponsoreDatas as $sponsoreData) {
                $users = DB::table('users')
                ->where('account_type', 2)
                ->where('id', $sponsoreData->user_id)
                ->count();
            if($users>0){
                $checkerCounter++;
            }

            if($checkerCounter==10){
                $date=$sponsoreData->created_at;
            }

            }
            
            if($checkerCounter >=10 &&  $date==""){
                $newformat = date('Y-m-d', strtotime("+1 months", strtotime($date)));                           
                 $newformat;
                $UserIdDataTmp=['UserID'=> $Network->user_id,'created_at' =>$date,'ayuda' =>$checkerCounter,];           
                array_push($UserIdData,$UserIdDataTmp);
            }
         
             
        }
        return $UserIdData;

      /*   $start = new Carbon('first day of this month');
        $end = new Carbon('last day of this month');
        $from_date=$start->format('Y-m-d');
        $to_date=$end->format('Y-m-d');

        DB::table('ayuda_sales')
        ->whereBetween('date_execution', [$from_date, $to_date])
        ->update(['status' => 1]);

        return $Network = DB::table('ayuda_sales')
        ->whereBetween('date_execution', [$from_date, $to_date])
        ->get(); */

       
        
      /* manual *//* 
      $Network = DB::table('networks')
      ->select(DB::raw('networks.sponsor_id as user_id,count(networks.sponsor_id)  as ayuda'))
      ->join('product_codes', 'product_codes.user_id', '=', 'networks.sponsor_id')
      ->where('product_codes.product_id', 1)
      ->having('ayuda', '>=', 10)
      ->groupBy('networks.sponsor_id')
      ->get();
      
      foreach ($Network as $value) {   
          $Ayuda_Sales_count = DB::table('ayuda_sales')->where('user_id',$value->user_id)->count();
          if($Ayuda_Sales_count==0) {
              for ($i=1; $i <=10; $i++) { 
                  $Date = Carbon::now()->addMonths($i)->format('Y-m-d');
                  $n = (int) ($value->ayuda / 10);
                  for ($x=1; $x <=$n; $x++) { 
                      $AyudaSale = new AyudaSale();
                      $AyudaSale->user_id = $value->user_id;
                      $AyudaSale->referral_type = 'Ayuda_Sales';
                      $AyudaSale->amount = 7777;
                      $AyudaSale->state = $x*10;
                      $AyudaSale->date_execution = $Date;
                      $AyudaSale->save();
                  }
                  
              }
          }                                   
      }
      return "success"; */



       /*  $upline_placement_id=3;
        $placement_position='left';
        $sponsor_id='8';
        $user_id=4;
        $x=0;
        $upline_placement_id1;
        $id=[];
        $i=0;
        $PvPoints=6;
        $tmpSponsorId=0;
        $matchPoints=0;


        while($x==0){
            $i++;
             $count = Network::where('user_id',$upline_placement_id)->where('sponsor_id', '!=',0)->count();
            if($count==0){
                //start for top sponsor 
                if($i==1){
                         $x=1;
                        $sponsor_network_data_base_upline = Network::where('upline_placement_id',$upline_placement_id)
                        ->where('placement_position' ,'!=', $placement_position)
                        ->count();
                        $points;
                        if($sponsor_network_data_base_upline ==1){
                             $this->pvPoints($upline_placement_id,$placement_position,$PvPoints,$sponsor_id,$user_id);
                           //return 'match';
                        }
                }else{
                    $sponsor_id=$upline_placement_id1->sponsor_id;
                    $x=$upline_placement_id1->sponsor_id;
                }
            }else{
                if($i==1){
                            $tmpSponsorId=$upline_placement_id;

                             $PvPointCount = PvPoint::where('user_id',$tmpSponsorId)->count();

                             if($PvPointCount==0){
                                $newPvPoint = new PvPoint();
                                $newPvPoint->user_id = $tmpSponsorId;
                                if($placement_position =='left'){
                                    $newPvPoint->leftpart = $PvPoints;
                                }else{
                                    $newPvPoint->rightpart = $PvPoints;
                                }
                                $newPvPoint->save();
                                $newPvPoint=$newPvPoint->id;

                            }else{
                                 $this->pvPoints($upline_placement_id,$placement_position,$PvPoints,$sponsor_id,$user_id);
                        }
                           //return 'match';
                }
                return $upline_placement_id;
                 $upline_placement_id1 = Network::where('user_id',$upline_placement_id)->where('sponsor_id', '!=',0)->first();
                 $upline_placement_id = $upline_placement_id1->upline_placement_id;
                 $placement_position = $upline_placement_id1->placement_position;
                 //update pv points
                 $PvPointCount = PvPoint::where('user_id',$upline_placement_id)->count();
                  $this->pvPoints($upline_placement_id,$placement_position,$PvPoints,$sponsor_id,$user_id);

                 array_push($id,$upline_placement_id);
            }



        }
       return  $id; */
    }

    private function getDataleft2($sponsor_id,$positions){
        //$user= User::all();
        $id=[];
        $id1=[];
        $id2=[];
        $id3=[];
        $username=[];
        $usernameData=[];
        $totalArray=[];
        $silverLeft=0;
        $silverRight=0;
        
        $goldRight=0;
        $goldleft=0;
       array_push($id,$sponsor_id);
        array_push($id2,$sponsor_id);
        $users = User::where('id',$sponsor_id)->first(); 
        $account_type=$users->account_type;
        if($account_type==8){
                 $silverLeft++;
                //$username=['freeleft'=>$users->username];
                //array_push($usernameData,$username);
        }else if($account_type==2){                     
                 $goldleft++;
                 $username=['paidleft'=>$users->username];
                 array_push($usernameData,$username);
        }else{
            return $account_type;
        } 
        $x=0;
        while(count($id2)>=1){
            $id3=$id2;
            $id2=[];
            foreach ($id3 as $value) {
                 $tmp = Network::where('upline_placement_id',$value)->get();
                 if(!empty($tmp)){
                    foreach ($tmp as  $value2) {
                        
                        
                         $users = User::where('id',$value2->user_id)->first(); 
                       // return $Network->placement_position;  
                         
                       $account_type=$users->account_type;
                       if($account_type==8){
                                $silverLeft++;
                                //$username=['freeleft'=>$users->username];
                                //array_push($usernameData,$username);
                       }else if($account_type==2){                     
                                $goldleft++;
                                $username=['paidleft'=>$users->username];
                                array_push($usernameData,$username);
                       }else{
                           return $account_type;
                       }                       
                        array_push($id,$value2->user_id);
                        array_push($id2,$value2->user_id); 


                    }
                 }else{
                    //return$id3=11;
                    $id2=0;
                    
                 }
               
                
            }
            
          

            
            
        }
        $id12=['silverLeft'=>$silverLeft];
        $id15=['goldleft'=>$goldleft];
        array_push($totalArray,$id12);
        array_push($totalArray,$id15);
        return $usernameData;
       return $totalArray;
        //return $id;
        
    }
    private function getDataRight2($sponsor_id,$positions){
        //$user= User::all();
        $id=[];
        $id1=[];
        $id2=[];
        $id3=[];
        $totalArray=[];
        $silverLeft=0;
        $silverRight=0;
        $usernameData=[];
        $username=[];
        $goldRight=0;
        $goldleft=0;
       array_push($id,$sponsor_id);
        array_push($id2,$sponsor_id);
        $users = User::where('id',$sponsor_id)->first(); 
        $account_type=$users->account_type;
        if($account_type==8){
                 $silverRight++;
                               // $username=['freeright'=>$users->username];
                               // array_push($usernameData,$username);
        }else if($account_type==2){                     
                 $goldRight++;
                                $username=['paidright'=>$users->username];
                                array_push($usernameData,$username);
        }else{
            return $account_type;
        } 
        $x=0;
        while(count($id2)>=1){
            $id3=$id2;
            $id2=[];
            foreach ($id3 as $value) {
                 $tmp = Network::where('upline_placement_id',$value)->get();
                 if(!empty($tmp)){
                    foreach ($tmp as  $value2) {
                        
                        
                         $users = User::where('id',$value2->user_id)->first(); 
                       // return $Network->placement_position;  
                         
                       $account_type=$users->account_type;
                       if($account_type==8){
                               $silverRight++;
                               // $username=['freeright'=>$users->username];
                                //array_push($usernameData,$username);
                       }else if($account_type==2){                     
                                $goldRight++;
                                $username=['paidright'=>$users->username];
                                array_push($usernameData,$username);
                       }else{
                           return $account_type;
                       }                       
                        array_push($id,$value2->user_id);
                        array_push($id2,$value2->user_id); 


                    }
                 }else{
                    //return$id3=11;
                    $id2=0;
                    
                 }
               
                
            }
            
          

            
            
        }
        $id13=['silverRight'=>$silverRight];
        $id14=['goldRight'=>$goldRight];
        array_push($totalArray,$id13);
        array_push($totalArray,$id14);
        return $usernameData;
       return $totalArray;
       //return $id;
      
        
    }
    private function pvPoints($upline_placement_id,$placement_position,$PvPoints,$sponsor_id,$user_id){
        $datenow= date('Y-m-d');
        $pv20thpairs= DB::table('referrals')
            ->where('user_id', '=', $upline_placement_id)
            ->whereDate('created_at', '=', $datenow)
            ->where(function ($query) {
                $query->where('status_Pv', '=', 1)
                      ->orWhere('status_Pv', '=', 2);
            })
            ->where('referral_type', 'like', '%activation_cost_reward%' )
            ->count();
        if($pv20thpairs==20){

        }else{
            $PvPointCount = PvPoint::where('user_id',$upline_placement_id)->count();
            if($PvPointCount==0){
                $newPvPoint = new PvPoint();
                $newPvPoint->user_id = $upline_placement_id;
                if($placement_position =='left'){
                    $newPvPoint->leftpart = 0;
                }else{
                    $newPvPoint->rightpart =0;
                }
		        $newPvPoint->save();
                $newPvPoint=$newPvPoint->id;
            }
            $PvPoint = PvPoint::where('user_id',$upline_placement_id)->first();
            $PvPoint = PvPoint::find($PvPoint->id);
            $tmpPvPointsLeft=0;
            $tmpPvPointsRight=0;
            $matchPoints=0;
            if($placement_position =='left'){
                $points =$PvPoint->rightpart;
                if ($points==0){
                   $PvPoint->leftpart = $PvPoint->leftpart+$PvPoints;
                }else {
                    if($PvPoint->rightpart <  $PvPoints){
                        $tmpPvPointsLeft = $PvPoints - $PvPoint->rightpart;
                        $matchPoints = $PvPoint->rightpart;
                    }else{
                        $tmpPvPointsRight  = $PvPoint->rightpart - $PvPoints;
                        $matchPoints = $PvPoints;
                    }
                    $PvPoint->leftpart = $tmpPvPointsLeft;
                    $PvPoint->rightpart = $tmpPvPointsRight;
                }
                $PvPoint->update();
            }else{
                $points =$PvPoint->leftpart;
                if ($points==0){
                   $PvPoint->rightpart = $PvPoint->rightpart+$PvPoints;
                }else {
                    if($PvPoint->leftpart <  $PvPoints){
                        $tmpPvPointsRight = $PvPoints - $PvPoint->leftpart;
                        $matchPoints = $PvPoint->leftpart;
                    }else{
                        $tmpPvPointsLeft  = $PvPoint->leftpart - $PvPoints;
                        $matchPoints = $PvPoints;
                    }
                   $PvPoint->leftpart = $tmpPvPointsLeft;
                   $PvPoint->rightpart = $tmpPvPointsRight;
                }
                $PvPoint->update();
            }
            if($matchPoints >=1){
		        for ($i=0; $i < $matchPoints; $i++) {
                    $activation_cost_reward = Referral::where('user_id',$sponsor_id)->where('status_Pv',1)->where('referral_type','activation_cost_reward') ->count();
                    $referral = new Referral();
                    $referral->user_id = $sponsor_id; //the sponsor
                    $referral->source_id =  $user_id; //the downline
                    if($activation_cost_reward==4){
                        $referral->referral_type = 'fifth_activation_cost_reward';
                        DB::table('referrals')
                        ->where('user_id',$sponsor_id)
                        ->where('status_Pv',1)
                        ->update(['status_Pv' => 2]);
                        $referral->status_Pv = 2;
                    }else{
                        $referral->referral_type = 'activation_cost_reward';
                        $referral->status_Pv = 1;
                    }
                    $referral->amount = 1000;
                    $referral->status = 0;
                    $referral->save();
                }
            }
        }
    }


    public function index2(){
        $auth_id = Auth::id();
        $activation_cost_reward = Referral::where('user_id',$auth_id)->where('status_Pv',1)->where('referral_type','activation_cost_reward') ->get();
        $x=0;
        $check = $activation_cost_reward->count();
        if($check >= 5){
            foreach ($activation_cost_reward as $data) {
                $activation_cost_reward_count = Referral::where('user_id',$auth_id)->where('status_Pv',1)->where('referral_type','activation_cost_reward') ->count();
                if($activation_cost_reward_count>=5){
                    $Referral = Referral::find($data->id);
                    if ($x==5){
                       $Referral->referral_type = 'fifth_activation_cost_reward';
                       $x=0;
                    }
                    $Referral->status_Pv = 2;
                    $Referral->update();
                    $x++;
                }
            }
        }
         

        $down_lines = DB::table('users')
			->join('user_infos', 'user_infos.user_id', '=', 'users.id')
            ->join('networks', 'networks.user_id', '=', 'users.id')
            ->join('packages', 'networks.package', '=', 'packages.id')
			->select('users.id AS user_id','users.*','user_infos.*','networks.*','packages.type AS package_type')
			->where('networks.sponsor_id',$auth_id)
            ->get();

        // $TPBunos = DB::table('referrals')                      
        //     ->where('user_id',$auth_id) 
        //     ->where('referral_type','sales_match_bonus')                
        //     ->sum('amount');
        //     dd($TPBunos);
            

        $myPair = new PairingComputation();
        


        $TPBunos = $myPair->pairing_count().".00";
        

        $TPMatch = Referral::where('user_id',$auth_id)
            ->where('referral_type','activation_cost_reward')
            ->count();

        
        $user = User::where('id',$auth_id)->first();
        if(!empty($user)){
            if($user->userType=='user'){
                return view('user.dashboard.index',compact('auth_id','down_lines','TPBunos','TPMatch'));
            } elseif ($user->userType=='teller') {
                return redirect('/staff');
            }
        }
    }


    private function UnilevelStatusChecker($user_id){
        $monthNow= date('m'); 
        $yearNow= date('Y'); 
        $rank2Count=0;
        $rank3Count=0;
        $rank4Count=0;
             $directReferral = Network::where('sponsor_id',$user_id)->get();
             foreach ($directReferral as $directReferral) {
                  $User = User::where('id',$directReferral->user_id)->first();
                  if($User->unilevel_rank==2){
                     $rank2Count++;
                  }else if($User->unilevel_rank==3){
                     $rank3Count++;
                 }else if($User->unilevel_rank==4){
                     $rank4Count++;
                 }
                  
             }
            $unilevelRank=User::select('unilevel_rank')->where('id', $user_id)->first();
            $directReferral = DB::table('networks')
            ->join('users', 'networks.user_id', '=', 'users.id')
            ->where('users.account_type','>=',2)
            ->where('networks.sponsor_id',$user_id)
            ->count();
              $groupSales = $this->UnilevelGroupSales($user_id);
               $productMaintain = DB::table('sales')
                      ->join('orders', 'orders.sale_id', '=', 'sales.id')
                      ->where('sales.user_id',$user_id)
                      ->where('orders.product_id',3)
                      ->whereMonth('sales.updated_at','=',$monthNow)
                      ->whereYear('sales.updated_at','=',$yearNow)
                      ->where('sales.products_released',1)
                      ->sum('orders.quantity');
                      $maintainStatus="";
                      
                      if ($unilevelRank['unilevel_rank'] >= 0 && $unilevelRank['unilevel_rank'] <= 1 && $directReferral >=2 &&  $productMaintain >=1 ){                  
                        DB::table('users')->where('id',$user_id)->update(['unilevel_rank' => '1','unilevel_status'=>'Maintained']);	
                        $maintainStatus="Maintained";					
                     }else if($unilevelRank['unilevel_rank'] >= 0 && $unilevelRank['unilevel_rank']<= 1 && $maintainStatus !="Maintained"){
                        DB::table('users')->where('id',$user_id)->update(['unilevel_status' => 'Not Maintained']);
                        $maintainStatus="Not Maintained";		
                     }
                     if ($unilevelRank['unilevel_rank'] >= 1 && $unilevelRank['unilevel_rank'] <= 2 && $directReferral >=5 &&  $productMaintain >=1){
                        DB::table('users')->where('id',$user_id)->update(['unilevel_rank' => '2','unilevel_status'=>'Maintained']);     
                        $maintainStatus="Maintained";	     
                     }else if($unilevelRank['unilevel_rank'] >= 1 && $unilevelRank['unilevel_rank'] <= 2 && $maintainStatus !="Maintained"){
                        DB::table('users')->where('id',$user_id)->update(['unilevel_status' => 'Not Maintained']);	
                        $maintainStatus="Not Maintained";	
                     } 
                     
                     if ($unilevelRank['unilevel_rank'] >= 2 && $unilevelRank['unilevel_rank'] <= 3 && $directReferral >=8 &&  $productMaintain >=3 && $groupSales >=200000){
                         DB::table('users')->where('id',$user_id)->update(['unilevel_rank' => '3','unilevel_status'=>'Maintained']);
                        $maintainStatus="Maintained";
                     }else if($unilevelRank['unilevel_rank'] >= 2 && $unilevelRank['unilevel_rank'] <= 3 && $maintainStatus !="Maintained"){
                        DB::table('users')->where('id',$user_id)->update(['unilevel_status' => 'Not Maintained']);	
                        $maintainStatus="Not Maintained";
                     } 
                     
                     if($unilevelRank['unilevel_rank']  >= 3 && $unilevelRank['unilevel_rank'] <= 4 &&  $rank2Count>=2 && $rank3Count>=3 && $productMaintain >=5 && $groupSales >=500000){
                         DB::table('users')->where('id',$user_id)->update(['unilevel_rank' => '4','unilevel_status'=>'Maintained']);
                         $maintainStatus="Maintained";
                     }else if( $maintainStatus !="Maintained"){
                        DB::table('users')->where('id',$user_id)->update(['unilevel_status' => 'Not Maintained']);	
                    $maintainStatus="Not Maintained";
                     }
                     
                     if($unilevelRank['unilevel_rank'] >= 4 && $unilevelRank['unilevel_rank'] <= 5 && $directReferral==20 &&  $rank4Count>=4 && $productMaintain >=10 && $groupSales >=1500000){
                         DB::table('users')->where('id',$user_id)->update(['unilevel_rank' => '5','unilevel_status'=>'Maintained']);
                         $maintainStatus="Maintained";
                     }else if( $unilevelRank['unilevel_rank'] >= 4 && $unilevelRank['unilevel_rank'] <= 5 && $maintainStatus !="Maintained"){
                        DB::table('users')->where('id',$user_id)->update(['unilevel_status' => 'Not Maintained']);
                        $maintainStatus="Not Maintained";
                     }
    
    
                if($maintainStatus !="Maintained"){
                    if($unilevelRank['unilevel_rank'] == 3  &&  $productMaintain >=3){
                        
                        if($groupSales >=200000){
                            DB::table('users')->where('id',$user_id)->update(['Unilevel_Earn_status' => '3','unilevel_status'=>'Maintained']);
                        }else{
                            DB::table('users')->where('id',$user_id)->update(['Unilevel_Earn_status' => '2','unilevel_status'=>'Maintained']);
                        }
                    }else  if($unilevelRank['unilevel_rank'] == 3){
                     DB::table('users')->where('id',$user_id)->update(['unilevel_status' => 'Not Maintained']);
                    }
        
        
                    if($unilevelRank['unilevel_rank'] == 4  &&  $productMaintain >=5 ){
                        if($groupSales >=500000 ){
                            DB::table('users')->where('id',$user_id)->update(['Unilevel_Earn_status' => '4','unilevel_status'=>'Maintained']);
                        }else if($groupSales >=200000){
                            DB::table('users')->where('id',$user_id)->update(['Unilevel_Earn_status' => '3','unilevel_status'=>'Maintained']);
                        }else{
                            DB::table('users')->where('id',$user_id)->update(['Unilevel_Earn_status' => '2','unilevel_status'=>'Maintained']);
                        }
                    }else if($unilevelRank['unilevel_rank'] == 4){
                     DB::table('users')->where('id',$user_id)->update(['unilevel_status' => 'Not Maintained']);
                    }
        
                    if($unilevelRank['unilevel_rank'] == 5  &&  $productMaintain >=10 ){
                        if($groupSales >=1500000 ){
                            DB::table('users')->where('id',$user_id)->update(['Unilevel_Earn_status' => '5','unilevel_status'=>'Maintained']);
                        }else if($groupSales >=500000 ){
                            DB::table('users')->where('id',$user_id)->update(['Unilevel_Earn_status' => '4','unilevel_status'=>'Maintained']);
                        }else if($groupSales >=200000){
                            DB::table('users')->where('id',$user_id)->update(['Unilevel_Earn_status' => '3','unilevel_status'=>'Maintained']);
                        }else{
                            DB::table('users')->where('id',$user_id)->update(['Unilevel_Earn_status' => '2','unilevel_status'=>'Maintained']);
                        }
                    }else if($unilevelRank['unilevel_rank'] == 5){
                     DB::table('users')->where('id',$user_id)->update(['unilevel_status' => 'Not Maintained']);
                    }
                }  
               
                 
                   
                     
    
    }

  

    public function getUserHomeData(){
         $auth_id =Auth::id();
        
        //  $this->UnilevelStatusChecker($auth_id); 
        $start = new Carbon('first day of last month');
        $end = new Carbon('last day of last month');
        $from_date=$start->format('Y-m-d');
        $to_date=$end->format('Y-m-d');

        $referrals = DB::table('referrals')
            ->where('user_id',$auth_id)
            ->get();
     
        //$TPBunos = $referrals                    
          //  ->where('referral_type','sales_match_bonus')                
            //->sum('amount');
 		$myPair = new PairingComputation();
        $TPBunos = $myPair->pairing_count();
      
        $TPRPoints = $referrals                                 
            ->where('reward_type','points')                
            ->sum('amount');

        $redeemed_points = DB::table('redeem_transactions')
            ->where('user_id',$auth_id)
            ->where('status',1)
            ->sum('points');

        $TPMatch = $referrals->where('referral_type','activation_cost_reward')->count();

        
         $auth_user_data = DB::table('users')
			->join('user_infos', 'user_infos.user_id', '=', 'users.id')
			->select('users.*','users.created_at AS user_created','user_infos.*')
			->where('users.id',$auth_id)
            ->first();

        //auth sponsor data
        $arr_auth_sponsor = array();
        $auth_sponsor = Network::where('user_id',$auth_id)->first();
        $auth_sponsor_name = "No Sponsor";
        $auth_sponsor_placement = "No Placement";
        $auth_sponsor_position = "No Position";
        $auth_reg_data = date('F d, Y',strtotime($auth_user_data->user_created ));
        $arr_auth_sponsor = array('register_date'=>$auth_reg_data ,'sponsor'=>$auth_sponsor_name,'placement_id'=>$auth_sponsor_placement,'placement_position'=>$auth_sponsor_position);
        $auth_sponsor_position = $auth_sponsor->placement_position;
        if($auth_sponsor->placement_position == 'null' || $auth_sponsor->placement_position==''){
            $auth_sponsor_position = 'No Position';
        }
        if(!empty($auth_sponsor)){
            if($auth_sponsor->sponsor_id != 0){
                $auth_sponsor_name = $this->getMemberName($auth_sponsor->sponsor_id);
                $auth_sponsor_placement = $this->getMemberName($auth_sponsor->upline_placement_id);
            }
            $arr_auth_sponsor = array('register_date'=>$auth_reg_data ,'sponsor'=>$auth_sponsor_name,'placement_id'=>$auth_sponsor_placement,'placement_position'=>$auth_sponsor_position);
        }
       
        //referral bonus
        $total_referral = $this->getReferral($auth_id,'referral_bonus');        
        //sales match bonus

        // $total_sales_match = $this->getReferral($auth_id,'sales_match_bonus');
        $myPair = new PairingComputation();
        $total_sales_match = $myPair->pairing_count().".00";;

        //pairing reward points
        $total_pairing_points = $TPRPoints - $redeemed_points;
        
        $start = new Carbon('first day of this month');
        $end = new Carbon('last day of this month');
        $from_date=$start->format('Y-m-d');
        $to_date=$end->format('Y-m-d');
        
        //total accumulated income
        $total_accumulated = $referrals->where('reward_type','php')
          ->where("referral_type", "!=", "sales_match_bonus")
          ->sum('amount');
      
      	$total_accumulated += $TPBunos;
        //totoal encashment
        $total_encashment = Encashment::select('amount_approved')->where('user_id',$auth_id)->where('status','claimed')->sum('amount_approved');

        //Total transfer
        $transfer = IncomeTransfer::select('amount','new_amount','from_user_id','to_user_id')
            ->where('from_user_id',$auth_id)
            ->orWhere('to_user_id',$auth_id)
            ->where('status',1)
            ->get();

        $total_sent = $transfer->where('from_user_id',$auth_id)->sum('amount');
        $total_receive = $transfer->where('to_user_id',$auth_id)->sum('new_amount');
        
        if(!empty($total_receive)){
            $total_accumulated += $total_receive;
        }
        if(!empty($total_sent)){
            $total_accumulated -= $total_sent;
        }

        //total available balance
        $total_avail_bal = $total_accumulated - $total_encashment;
        
        //Weekly Income
        $current = Carbon::now();
        $today = $current->format('Y-m-d H:i:s');
        $weekStartDate = $current->startOfWeek(Carbon::MONDAY)->format('Y-m-d H:i:s');
        $weekEndDate = $current->endOfWeek(Carbon::SUNDAY)->format('Y-m-d H:i:s');
        
        $weekly_income = $referrals
            ->where('referral_type','sales_match_bonus')
            ->whereBetween('created_at', [$weekStartDate, $weekEndDate])
            ->sum('amount');
        
        $weekly_income_points = $referrals
            ->where('reward_type','points')
            ->whereBetween('created_at', [$weekStartDate, $weekEndDate])
            ->sum('amount');

        $Total_Direct_Referral = $referrals
            ->where('referral_type','direct_referral_bonus')
            ->sum('amount');

        $Total_Weekly_Direct_Referral = $referrals
            ->where('referral_type','direct_referral_bonus')
            ->whereBetween('created_at', [$weekStartDate, $weekEndDate])
            ->sum('amount');

        $MynetworkData=[];

        return response()->json([
            //'downline_data' => $arr_downline_data,
            'arr_auth_sponsor' => $arr_auth_sponsor,
            'total_referral' => $total_referral,
            'total_sales_match' => $total_sales_match,
            'total_pairing_points' => $total_pairing_points,
            'total_accumulated' => number_format($total_accumulated,2),
            'total_avail_bal' => number_format($total_avail_bal,2),
            'total_encashment' => $total_encashment,
            'weekly_income' => $weekly_income,
            'weekly_income_points' => $weekly_income_points - $redeemed_points,
            'current' => $today,
            'start_of_week' => $weekStartDate,
            'weekend' => $weekEndDate,
            'MynetworkData' =>  $MynetworkData,
            'Total_Direct_Referral' =>$Total_Direct_Referral,
            'Total_Weekly_Direct_Referral'  =>  $Total_Weekly_Direct_Referral,
            'TPBunos'   =>  $TPBunos,
            'TPRPoints' =>  $TPRPoints,
            'TPMatch'   =>  $TPMatch,
        ]);
    }
    
    public function getUserDownlines($position){
        $auth_id = Auth::id();

        $auth_user_data = DB::table('users')
			->join('user_infos', 'user_infos.user_id', '=', 'users.id')
			->select('users.*','users.created_at AS user_created','user_infos.*')
			->where('users.id',$auth_id)
            ->first();
        
        if($position=='left' || $position=='right'){
            $network_data = DB::table('networks')
            ->join('users as user1', 'networks.user_id', '=', 'user1.id')
            ->join('user_infos as uinfo1', 'networks.user_id', '=', 'uinfo1.user_id')
			->join('user_infos as uinfo2', 'networks.upline_placement_id', '=', 'uinfo2.user_id')
			->select('user1.username AS u_uname','user1.id AS u_id','user1.created_at AS reg_date','user1.account_type AS acc_type','uinfo1.first_name AS u_fname','uinfo1.last_name AS u_lname','uinfo2.first_name AS up_fname','uinfo2.last_name AS up_lname','networks.placement_position AS position')
            ->where('networks.sponsor_id',$auth_id)
            ->where('networks.placement_position',$position)
            ->orderBy('networks.created_at','DESC')
            ->get();
        } else {
            $network_data = DB::table('networks')
            ->join('users as user1', 'networks.user_id', '=', 'user1.id')
            ->join('user_infos as uinfo1', 'networks.user_id', '=', 'uinfo1.user_id')
			->join('user_infos as uinfo2', 'networks.upline_placement_id', '=', 'uinfo2.user_id')
			->select('user1.username AS u_uname','user1.id AS u_id','user1.created_at AS reg_date','user1.account_type AS acc_type','uinfo1.first_name AS u_fname','uinfo1.last_name AS u_lname','uinfo2.first_name AS up_fname','uinfo2.last_name AS up_lname','networks.placement_position AS position')
            ->where('networks.sponsor_id',$auth_id)
            ->orderBy('networks.created_at','DESC')
            ->get();
        }
        
            
        $arr_downline_data=array();// create array for downline data
        
       // $groupSales = $this->UnilevelGroupSales($auth_id);

        
        $sponsor_full_name="";
        if(!empty($auth_user_data)){
            $sponsor_full_name=$auth_user_data->first_name." ".$auth_user_data->last_name;
        }

        foreach($network_data as $data){
            $user_name=$data->u_uname;
            $full_name=$data->u_fname." ".$data->u_lname;
            $placement_pos=$data->up_fname." ".$data->up_lname." (".$data->position.")";
            $reg_date=date("Y-m-d",strtotime($data->reg_date));
            $acc_type=$data->acc_type;
            $ac_type="";
            if($acc_type==1){
                $ac_type="Silver";
            }else{
                $ac_type="Gold";
            }

            $uid=Crypt::encrypt($data->u_id);
            $temp_data=array('full_name'=>$full_name,'user_name'=>$user_name,'sponsor'=>$sponsor_full_name,'placement_position'=>$placement_pos,'user_id'=>$uid,'reg_date'=>$reg_date,'ac_type'=>$ac_type);
            array_push($arr_downline_data,$temp_data);
        }
        
        return response()->json([
            'downline_data' => $arr_downline_data
        ]);
    }
    
    
    public function getMyNetworksCount(){
        $auth_id = Auth::id();

        $MynetworkData=[];
        $Network = Network::where('upline_placement_id',$auth_id)->get();
        foreach ($Network as $value) {
            if($value->placement_position=="left"){
                $left = $this->getDataleft($value->user_id,"left");
                $leftCount= count($left);
            }else if($value->placement_position=="right"){
                $right = $this->getDataRight($value->user_id,"right");
                $righCount= count($right);
            }
        }
        if(!empty($right)){
            foreach ($right  as $value) {
                array_push($MynetworkData,$value);
            }
        }
        if(!empty($left)){
            foreach ($left  as $value) {
                array_push($MynetworkData,$value);
            }
        }

        return response()->json([
            'MynetworkData' => $MynetworkData
        ]);
    }   

    private function getDataleft($sponsor_id,$positions){
        //$user= User::all();
        $id=[];
        $id1=[];
        $id2=[];
        $id3=[];
        $totalArray=[];
        $silverLeft=0;
        $silverRight=0;
        
        $goldRight=0;
        $goldleft=0;
       array_push($id,$sponsor_id);
        array_push($id2,$sponsor_id);
        $users = User::where('id',$sponsor_id)->first(); 
        $account_type=$users->account_type;
        if($account_type==8){
                 $silverLeft++;
        }else if($account_type==2){                     
                 $goldleft++;
        }else{
            return $account_type;
        } 
        $x=0;
        while(count($id2)>=1){
            $id3=$id2;
            $id2=[];
            foreach ($id3 as $value) {
                 $tmp = Network::where('upline_placement_id',$value)->get();
                 if(!empty($tmp)){
                    foreach ($tmp as  $value2) {
                        
                        
                         $users = User::where('id',$value2->user_id)->first(); 
                       // return $Network->placement_position;  
                         
                       $account_type=$users->account_type;
                       if($account_type==8){
                                $silverLeft++;
                       }else if($account_type==2){                     
                                $goldleft++;
                       }else{
                           return $account_type;
                       }                       
                        array_push($id,$value2->user_id);
                        array_push($id2,$value2->user_id); 


                    }
                 }else{
                    //return$id3=11;
                    $id2=0;
                    
                 }
               
                
            }
            
          

            
            
        }
        $id12=['silverLeft'=>$silverLeft];
        $id15=['goldleft'=>$goldleft];
        array_push($totalArray,$id12);
        array_push($totalArray,$id15);
       return $totalArray;
        //return $id;
        
    }
    private function getDataRight($sponsor_id,$positions){
        //$user= User::all();
        $id=[];
        $id1=[];
        $id2=[];
        $id3=[];
        $totalArray=[];
        $silverLeft=0;
        $silverRight=0;
        
        $goldRight=0;
        $goldleft=0;
       array_push($id,$sponsor_id);
        array_push($id2,$sponsor_id);
        $users = User::where('id',$sponsor_id)->first(); 
        $account_type=$users->account_type;
        if($account_type==8){
                 $silverRight++;
        }else if($account_type==2){                     
                 $goldRight++;
        }else{
            return $account_type;
        } 
        $x=0;
        while(count($id2)>=1){
            $id3=$id2;
            $id2=[];
            foreach ($id3 as $value) {
                 $tmp = Network::where('upline_placement_id',$value)->get();
                 if(!empty($tmp)){
                    foreach ($tmp as  $value2) {
                        
                        
                         $users = User::where('id',$value2->user_id)->first(); 
                       // return $Network->placement_position;  
                         
                       $account_type=$users->account_type;
                       if($account_type==8){
                               $silverRight++;
                       }else if($account_type==2){                     
                                $goldRight++;
                       }else{
                           return $account_type;
                       }                       
                        array_push($id,$value2->user_id);
                        array_push($id2,$value2->user_id); 


                    }
                 }else{
                    //return$id3=11;
                    $id2=0;
                    
                 }
               
                
            }
            
          

            
            
        }
        $id13=['silverRight'=>$silverRight];
        $id14=['goldRight'=>$goldRight];
        array_push($totalArray,$id13);
        array_push($totalArray,$id14);
       return $totalArray;
       //return $id;
      
        
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

        private function SponsorData($sponsor_id){
            return Network::where('sponsor_id',$sponsor_id)->get();
        }

    private function getReferral($user_id,$type){
        $result =Referral::select('amount')->where('user_id',$user_id)->where('referral_type',$type)->sum('amount');
        return $result;
    }

    private function getMemberName($uid){
        $user_info_data = UserInfo::select('first_name','last_name')->where('user_id',$uid)->first();
        if(!empty($user_info_data)){
            return $user_info_data->first_name ." " .$user_info_data->last_name;
        }else{
            return 'No data';
        }

    }

}
