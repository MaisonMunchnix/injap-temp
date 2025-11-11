<?php

namespace App\Http\Controllers;

use App\User;
use App\UserLog;
use App\UserInfo;
use App\ProductCode;
use App\Network;
use App\Referral;
use App\PvPoint;
use App\UnilevelSale;
use App\Unilevel;
use App\Package;
use Session;

use App\Flushout;
use App\PvPointsHistory;

use App\PairingChecker;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Http\Update;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UpgradeAccountController extends Controller
{

	private $direct_referral=['1'=>'0','2'=>'500','3'=>'3000','4'=>'3000','5'=>'3000','6'=>'3000','7'=>'3000'];
	private $sales_match=1000;
	private $fifth_sales_macth=1000;
	private $retail_bonus_silver=200;

	public function viewUpgradeAccount(){
		$auth_id =Auth::id();
		return view('user.upgrade-account.index',compact('auth_id'));
	}

	public function upgradeAccount(Request $request){
		$auth_id = Auth::id();
		$product_code = $request['activation_code'];
		$security_pin = $request['sec_pin'];
        
		$p_code = ProductCode::where('code',$product_code)
            ->where('security_pin',$security_pin)
            ->where('type','package')
            ->where('status',0)
            ->first(); 
        
		$check_account = User::select('account_type')
            ->where('id',$auth_id)
            ->first();
        
        if($p_code && $check_account){
            $current_package = $this->packagePrice($check_account->account_type);
            $new_package = $this->packagePrice($p_code->category);
        }

		if(empty($p_code)){
			return response()->json([
				'message' => 'Invalid Product Code!',
			],400);
		}else if($current_package > $new_package){
			return response()->json([
				'message' => 'Downgrade account is not possible',
			],400);
		}else{
			DB::beginTransaction();
			try {
				$package_type = $p_code->category;
				$sub_package = $p_code->sub_package;
				$package_id = $p_code->category;
				$get_package = DB::table('packages')->select('type')->where('id',$package_id)->first();
				$member_type=strtolower($get_package->type);
				
				$get_package_data = DB::table('packages')->where('id',$package_id)->first();
				 
				$pv_points_data = $get_package_data->pv_points;
				$pay_type = $p_code->is_paid;
				if($pay_type == "free"){
					 $pv_points_data = 0;
				}
				
				if($pv_points_data > 0){
					 $this->upgrade_pv_points($pv_points_data, $auth_id);
				}
				
				$user = User::find($auth_id);
				$user->account_type = $package_type;
				$user->sub_package = $sub_package;
				$user->member_type = $member_type;
				$user->account_status = 'paid';
				$user->save();
                
                $p_code->user_id = $auth_id;
                $p_code->status = 1;
                $p_code->save();
				
				DB::commit();
				return response()->json([
					'message' => 'ok',
				],200);
			}catch(\Throwable $e){
				DB::rollback();
				// Insert User Log Error
				$user_log =  new UserLog();
				$user_log->user_id = $auth_id;
				$user_log->description = 2; //Upgrade Account Log
				$user_log->status = "Error";
				$user_log->error = $e->getMessage(); 
				$user_log->save();
				return response()->json([
					'message' => $e->getMessage(),
				],400);
			}	
		}
	}
    
    private function packagePrice($id){
        return Package::select('amount')->find($id);
    }
	

	private function upgrade_pv_points($PvPoints,$user_id){
		$network_data = Network::where('user_id',$user_id)
            ->where('sponsor_id', '!=',0)
            ->first();
        $upline = Network::where('user_id',$network_data->upline_placement_id)
            ->where('sponsor_id', '!=',0)
            ->first();
        
        
        if($network_data && $upline){
            
            
            $upline_placement_id = $upline->user_id;
            $sponsor_id = $network_data->sponsor_id;
            $placement_position = $network_data->placement_position;

            $x=0;
            $upline_placement_id1;
	
            $i=0;
            while($x==0){
                $i++;
                $count = Network::where('user_id',$upline_placement_id)->where('sponsor_id', '!=',0)->count();
                if($count == 0){
                    if($i == 1){
                        $x = 1;  
                        $tmpSponsorId = $upline_placement_id;	   
                        $PvPointCount = PvPoint::where('user_id',$tmpSponsorId)->count();									  
                        if($PvPointCount==0){
                            if($tmpSponsorId > 0){
                                $position_inside="";
                                $left=0;
                                $right=0;
                                $newPvPoint = new PvPoint();
                                $newPvPoint->user_id = $tmpSponsorId;
                                
                                if($placement_position =='left'){
                                    $newPvPoint->leftpart = $PvPoints;
                                    $position_inside="left";
                                }else{
                                    $newPvPoint->rightpart = $PvPoints;
                                    $position_inside="right";
                                }
                                
                                $newPvPoint->save();
                                $newPvPoint = $newPvPoint->id; 

                                $PvPointsHistory = new PvPointsHistory();
                                $PvPointsHistory->user_id = $tmpSponsorId;
                                $PvPointsHistory->pv_point = $PvPoints;
                                $PvPointsHistory->position = $position_inside;
                                $PvPointsHistory->sponsor = $user_id;
                                $PvPointsHistory->save();

                                $cycle=0;
                                $cycle_time=0;
                                $fifth_pair=0;
                                $this->pairingChecker($tmpSponsorId,$PvPoints,$left,$right,$cycle,$cycle_time,$fifth_pair,$user_id);
                            }
                        }else{
                            if($upline_placement_id > 0){
                                $this->pvPoints($upline_placement_id,$placement_position,$PvPoints,$sponsor_id,$user_id);
                            }
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
                            
                            if($upline_placement_id > 0){

                                $position_inside="";
                                $left=0;
                                $right=0;
                                $newPvPoint = new PvPoint();
                                $newPvPoint->user_id = $tmpSponsorId;
                                
                                if($placement_position =='left'){
                                    $newPvPoint->leftpart = $PvPoints;
                                    $position_inside="left";
                                    $left=$PvPoints;										
                                }else{
                                    $newPvPoint->rightpart = $PvPoints;
                                    $position_inside="right";
                                    $right=$PvPoints;
                                }
                                
                                $newPvPoint->save();
                                $newPvPoint=$newPvPoint->id;  
							
                                $PvPointsHistory = new PvPointsHistory();
                                $PvPointsHistory->user_id = $tmpSponsorId;
                                $PvPointsHistory->pv_point = $PvPoints;
                                $PvPointsHistory->position = $position_inside;
                                $PvPointsHistory->sponsor = $user_id;
                                $PvPointsHistory->save();

                                $cycle = 0;
                                $cycle_time = 0;
                                $fifth_pair = 0;
                                $this->pairingChecker($tmpSponsorId,$PvPoints,$left,$right,$cycle,$cycle_time,$fifth_pair,$user_id);
                            }
                        }else{
                            if($upline_placement_id > 0){
                                $this->pvPoints($upline_placement_id,$placement_position,$PvPoints,$sponsor_id,$user_id);
                            }
                        }                                      
                    }	
				
                    $upline_placement_id1 = Network::where('user_id',$upline_placement_id)->where('sponsor_id', '!=',0)->first();
                    $upline_placement_id = $upline_placement_id1->upline_placement_id;
                    $placement_position = $upline_placement_id1->placement_position;
				
                    $PvPointCount = PvPoint::where('user_id',$upline_placement_id)->count();       
                    if($upline_placement_id > 0){
                        $this->pvPoints($upline_placement_id,$placement_position,$PvPoints,$sponsor_id,$user_id);
                    }
				
                } 																
            }
        }
    }

	private function pairingChecker($upline_placement_id,$PvPoints,$left,$right,$cycle,$cycle_time,$fifth_pair,$source_id){
		$PairingChecker = new PairingChecker();
		$PairingChecker->user_id=$upline_placement_id;
		$PairingChecker->source_id = $source_id;
		$PairingChecker->pv_point = $PvPoints;
		$PairingChecker->left = $left;
		$PairingChecker->right = $right;
		$PairingChecker->cycle = $cycle;
		$PairingChecker->cycle_time=$cycle_time;
		$PairingChecker->fifth_pair = $fifth_pair;
		$PairingChecker->save();
	}

	//user upgrade
	public function upgradeAccountOld(Request $request){
		$auth_id =Auth::id();

		//product code
		$product_code = $request['activation_code'];
		$security_pin = $request['sec_pin'];

		$p_code = ProductCode::where('code',$product_code)->where('security_pin',$security_pin)->where('type','package')->where('status',0)->first(); 
		$check_account = User::select('account_type')->where('id',$auth_id)->first();

		if(empty($p_code)){
			return response()->json([
				'message' => 'Product codes invalid',
			],400);
		}else if($check_account->account_type > $p_code->category){
			return response()->json([
				'message' => 'Downgrade account is not possible',
			],400);
		}else{
			DB::beginTransaction();		 
			$user_id=$auth_id;
			
			try {
				$package_type=$p_code->category;
				$network = Network::where('user_id',$user_id)->first();

				$sponsor_id=0;
				$upline_placement_id=0;
				$placement_position="";
				if(!empty($network)){
					$sponsor_id=$network->sponsor_id;
				}
				if(!empty($network)){
					$upline_placement_id=$network->upline_placement_id;
				}
				if(!empty($network)){
					$placement_position=$network->placement_position;
				}
				
				
				
				//check if account is free
				$chk_account=$package_type;
				//$chk_account_user = User::select('account_type')->where('id',$sponsor_id)->first();
				//if(!empty($chk_account_user)){
				//	$chk_account=$chk_account_user->account_type;
				//}

				//update user table
				$user =User::find($user_id);
				$user->account_type = $package_type;
				$user->update();
							
				//insert referral bonus
				if($sponsor_id!="" || $sponsor_id!=null || $sponsor_id!=0 || $chk_account!=1){
					//get sponsor network data
					$sponsor_network_data = Network::where('sponsor_id',$sponsor_id)->get();
					$product_codes = DB::table('product_codes')
					->join('packages', 'packages.id', '=', 'product_codes.category')
					->select('packages.pv_points AS pv_points')
					->where('product_codes.code',$product_code)
					->first();

					//added for free member
					$sponsor_account_type="";
					$get_account_type=User::where('id',$sponsor_id)->first();
					if(!empty($get_account_type)){
						$sponsor_account_type=$get_account_type->account_type;
					}

					$referral_ammount=0;
					if($sponsor_account_type==1){
						$referral_ammount=0;
					}else{
						$referral_ammount=$this->direct_referral[$chk_account];
					}


					//insert direct referral bonus
					$referral = new Referral();
					$referral->user_id = $sponsor_id; //the sponsor
					$referral->source_id = $user_id; //the downline
					$referral->referral_type = 'referral_bonus';
					$referral->amount = $referral_ammount;
					$referral->status = 0;
					$referral->save();

					$upline_placement_id=$upline_placement_id;
        			$placement_position=$placement_position;       
					$sponsor_id=$sponsor_id;
					$x=0;
					$upline_placement_id1;
					$id=[];
					$i=0;
					 $PvPoints=$product_codes->pv_points;
					$tmpSponsorId=0;


					$monthNow= date('m'); 
					$yearNow= date('Y'); 
					$unilevelRank=User::select('unilevel_rank')->where('id', $sponsor_id)->first();
					 $directReferral = Network::where('sponsor_id',$sponsor_id)->count();
					 
					 $rank2Count=0;
					 $rank3Count=0;
					 $rank4Count=0;
					 $directReferralData = Network::where('sponsor_id',$sponsor_id)->get();
					 foreach ($directReferralData as $data) {
						  $User = User::where('id',$data->user_id)->first();
						  if($User->unilevel_rank==2){
							 $rank2Count++;
						  }else if($User->unilevel_rank==3){
							 $rank3Count++;
						 }else if($User->unilevel_rank==4){
							 $rank4Count++;
						 }
						  
					 }
					 

					 /* $UserUnilevel = User::where('id',$value5)->where('unilevel_rank', '>',1)->get(); */

					 $groupSales = $this->UnilevelGroupSales($sponsor_id);
					 $productMaintain = DB::table('sales')
							  ->join('orders', 'orders.sale_id', '=', 'sales.id')
							  ->select('orders.id AS orderId')
							  ->where('sales.user_id',$sponsor_id)
							  ->where('orders.product_id',3)
							  ->whereMonth('sales.updated_at','=',$monthNow)
							  ->whereYear('sales.updated_at','=',$yearNow)
							  ->where('sales.products_released',1)
							  ->count();
							  
					 if ($unilevelRank['unilevel_rank'] == 0 && $directReferral >=2 &&  $productMaintain >=1 ){
					DB::table('users')->where('id',$sponsor_id)->update(['unilevel_rank' => '1','unilevel_status' => 'Maintained']);						
					} if ($unilevelRank['unilevel_rank'] == 1 && $directReferral >=5 &&  $productMaintain >=1){
					DB::table('users')->where('id',$sponsor_id)->update(['unilevel_rank' => '2','unilevel_status' => 'Maintained']);          
					} if ($unilevelRank['unilevel_rank'] == 2 && $directReferral >=8 &&  $productMaintain >=3 && $groupSales >=200000){
					 DB::table('users')->where('id',$sponsor_id)->update(['unilevel_rank' => '3','unilevel_status' => 'Maintained']);
					} if($directReferral==11 &&  $rank2Count>=2 && $rank3Count>=3 && $productMaintain >=5 && $groupSales >=500000){
					 DB::table('users')->where('id',$sponsor_id)->update(['unilevel_rank' => '4','unilevel_status' => 'Maintained']);
					} if($directReferral==20 &&  $rank4Count>=4 && $productMaintain >=10 && $groupSales >=1500000){
					 DB::table('users')->where('id',$sponsor_id)->update(['unilevel_rank' => '5','unilevel_status' => 'Maintained']);
					}

					while($x==0){
						
						$i++;
						$count = Network::where('user_id',$upline_placement_id)->where('sponsor_id', '!=',0)->count();
						if($count==0){
							/*start for top sponsor */

							if($i==1){
								$x=1;  
								$tmpSponsorId=$upline_placement_id;	   
								$PvPointCount = PvPoint::where('user_id',$tmpSponsorId)->count();									  
								if($PvPointCount==0){
									if($tmpSponsorId == 0){

									}else{
										$newPvPoint = new PvPoint();
										$newPvPoint->user_id = $tmpSponsorId;
										if($placement_position =='left'){
											$newPvPoint->leftpart = $PvPoints;
										}else{
											$newPvPoint->rightpart = $PvPoints;
										}
										$newPvPoint->save();
										$newPvPoint=$newPvPoint->id; 
									}
									                            
								
								}else{
									if($upline_placement_id == 0){

									}else{
										  $this->pvPoints($upline_placement_id,$placement_position,$PvPoints,$sponsor_id,$user_id);
									}
								}     

								/* $sponsor_network_data_base_upline = Network::where('upline_placement_id',$upline_placement_id)
								->where('placement_position' ,'!=', $placement_position)
								->count();
								$points;
								if($sponsor_network_data_base_upline ==1){
									 	 $this->pvPoints($upline_placement_id,$placement_position,$PvPoints,$sponsor_id,$user_id);
								   //return 'match';                                        
								} */
							}else{
								$sponsor_id=$upline_placement_id1->sponsor_id;
								$x=$upline_placement_id1->sponsor_id;
							}               
						}else{               
							if($i==1){
								$tmpSponsorId=$upline_placement_id;							
								$PvPointCount = PvPoint::where('user_id',$tmpSponsorId)->count();									  
								if($PvPointCount==0){
									if($upline_placement_id == 0){

									}else{
										$newPvPoint = new PvPoint();
										$newPvPoint->user_id = $tmpSponsorId;
										if($placement_position =='left'){
											$newPvPoint->leftpart = $PvPoints;
										}else{
											$newPvPoint->rightpart = $PvPoints;
										}
										$newPvPoint->save();
										$newPvPoint=$newPvPoint->id;                             
									}
								}else{
									if($upline_placement_id == 0){

									}else{
										  $this->pvPoints($upline_placement_id,$placement_position,$PvPoints,$sponsor_id,$user_id);
									}
								}
								//return 'match';                                        
							}	
							
							$upline_placement_id1 = Network::where('user_id',$upline_placement_id)->where('sponsor_id', '!=',0)->first();
							$upline_placement_id = $upline_placement_id1->upline_placement_id;
							$placement_position = $upline_placement_id1->placement_position;
							/* update pv points */
							$PvPointCount = PvPoint::where('user_id',$upline_placement_id)->count();       
							if($upline_placement_id == 0){

							}else{
							 	 $this->pvPoints($upline_placement_id,$placement_position,$PvPoints,$sponsor_id,$user_id);
							}
							//array_push($id,$upline_placement_id);
						} 																
					}  
				}
				
				//update product_codes table
				$product_code_update = DB::table('product_codes')->where('code',$product_code)->where('security_pin',$security_pin)->update(['user_id' => $user_id,'status' => 1]);
				
				// Insert User Log
				$user_log =  new UserLog();
				$user_log->user_id = Auth::id();
				$user_log->description = 2; //Upgrade Account Log
				$user_log->save();
				


				DB::commit();
				return response()->json([
					'message' => 'ok',
				],200);


			} catch(\Throwable $e){
				DB::rollback();
				// Insert User Log Error
				$user_log =  new UserLog();
				$user_log->user_id = Auth::id();
				$user_log->description = 2; //Upgrade Account Log
				$user_log->status = "Error";
				$user_log->error = $e->getMessage(); 
				$user_log->save();
				
				return response()->json([
					'message' => $e->getMessage(),
				],400);
			}		 		 
		}
	}

	private function UnilevelGroupSales($sponsor_id){ 

		$sponsor_id=$sponsor_id;
        $UnilevelGroupSales =0;
        $monthNow= date('m'); 
        $yearNow= date('Y');
        $x=0;
        $jsonData = new \stdClass();  
           $jsonData = $this->UnilevelChecker($sponsor_id);
          
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
             $UnilevelSale2 = UnilevelSale::where('user_id',$sponsor_id)->whereMonth('created_at','=',$monthNow)->whereYear('created_at','=',$yearNow)->get();
            if($UnilevelSale->count() >=1){
            foreach ($UnilevelSale2 as $key) {                  
                    $UnilevelGroupSales =$UnilevelGroupSales+$key->total_price;
                }
            }
        }
        return $UnilevelGroupSales;
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

private function pvPoints($upline_placement_id,$placement_position,$PvPoints,$sponsor_id,$user_id){		
	$chk_account_user = User::select('account_type')->where('id',$upline_placement_id)->first();

	$pvPoints_limeter=0;
	 if($chk_account_user->account_type == 2 || $chk_account_user->account_type == 8){
		$pvPoints_limeter=11;
	}/* else if($chk_account_user->account_type == 2){
		$pvPoints_limeter=24;
	} */

	if($upline_placement_id==0){

	}else{
	 $datenow= date('Y-m-d');
	 $ldate = date('H:i:s');
	 $from_date='';
	 $to_date =''; 
	 $state_flush_out;
	 if($ldate>='12:00:00'){
		 $from_date='12:00:00';
		 $to_date ='23:59:00';
		 $state_flush_out="pm";
		}else{
		 $from_date='00:00:00';
		 $to_date ='11:59:00';
		 $state_flush_out="am";
		}
	  $pv_pairs_count= DB::table('referrals')
	 ->where('user_id', '=', $upline_placement_id)
	 ->whereDate('created_at', '=', $datenow)
	 ->whereBetween(DB::raw('TIME(created_at)'), array($from_date, $to_date))
	 ->where(function ($query) {
		 $query->where('status_Pv', '=', 1)
			   ->orWhere('status_Pv', '=', 2);
	 })
	 ->where('referral_type', 'like', '%activation_cost_reward%' )
	 ->count(); 
	 
	 if($pv_pairs_count>=$pvPoints_limeter){
		 $position = "";
		 $pv=0;
		 $PvPointdata = PvPoint::where('user_id',$upline_placement_id)->first();
		 if($PvPointdata->leftpart >0){
			 $position = "left";
			 $pv=$PvPointdata->leftpart;
		 }else{
			 $position = "right";
			 $pv=$PvPointdata->rightpart;
		 }
		 $Flushout = new Flushout();
		 $Flushout->user_id = $upline_placement_id;
		 $Flushout->flush_pv_point = $pv;	
		 $Flushout->position	=$position;						
		 $Flushout->sponsor = $user_id;	
		 $Flushout->state = $state_flush_out;	
		 $Flushout->save();

		 $PvPoint = PvPoint::find($PvPointdata->id);
		 $PvPoint->leftpart = 0;
		 $PvPoint->rightpart = 0;  
		 $PvPoint->update();

		 $PairingChecker = new PairingChecker();
		 $PairingChecker->user_id=$upline_placement_id;
		 $PairingChecker->source_id = $user_id;
		 $PairingChecker->pv_point = $PvPoints;
		 $PairingChecker->left = 0;
		 $PairingChecker->right = 0;
		 $PairingChecker->cycle = 0;
		 $PairingChecker->cycle_time=$state_flush_out;
		 $PairingChecker->fifth_pair = 0;
		 $PairingChecker->save();

	 }else{

				 $left=0;
				 $right=0;
				 $cycle=0;
				 $cycle_time=0;
				 $fifth_pair=0;

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
				 $position_data;
			 

				 if($placement_position =='left'){
					$points =$PvPoint->rightpart;
				   if ($points==0){
							  $leftdata=$PvPoint->leftpart;
							 $PvPoint->leftpart = $PvPoint->leftpart+$PvPoints;
							 $left=$leftdata+$PvPoints;
							 $right=0;
							 $cycle=$pv_pairs_count;
							 $cycle_time=$state_flush_out;
							 $fifth_pair=intdiv($pv_pairs_count,5);
							$this->pairingChecker($upline_placement_id,$PvPoints,$left,$right,$cycle,$cycle_time,$fifth_pair,$user_id);
					 }else {
					 
						 if($PvPoint->rightpart <  $PvPoints){
							 $tmpPvPointsLeft = $PvPoints - 			$PvPoint->rightpart;                        
							 $matchPoints = $PvPoint->rightpart;
						 }else{
							 $tmpPvPointsRight  = $PvPoint->rightpart - $PvPoints;
							 $matchPoints = $PvPoints;
						 }                    
						$PvPoint->leftpart = $tmpPvPointsLeft;
						$PvPoint->rightpart = $tmpPvPointsRight;              
				   }
				   $PvPoint->update();
				   
				   $PvPointsHistory = new PvPointsHistory();
				   $PvPointsHistory->user_id = $upline_placement_id;
				   $PvPointsHistory->pv_point = $PvPoints;
				   $PvPointsHistory->position = "left";
				   $PvPointsHistory->sponsor = $user_id;
				   $PvPointsHistory->save();
				  if($matchPoints>0){
					 $position_data="left"; 
				  }

				}else{
					  $points =$PvPoint->leftpart;
					if ($points==0){
					  $rightdata = $PvPoint->rightpart;
							$PvPoint->rightpart = $PvPoint->rightpart+$PvPoints;
							$left=0;
							$right=$rightdata+$PvPoints;
							$cycle=$pv_pairs_count;
							$cycle_time=$state_flush_out;
							$fifth_pair=intdiv($pv_pairs_count,5);
						   $this->pairingChecker($upline_placement_id,$PvPoints,$left,$right,$cycle,$cycle_time,$fifth_pair,$user_id);

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
					

					$PvPointsHistory = new PvPointsHistory();
				   $PvPointsHistory->user_id = $upline_placement_id;
				   $PvPointsHistory->pv_point = $PvPoints;
				   $PvPointsHistory->position = "right";
				   $PvPointsHistory->sponsor = $user_id;
				   $PvPointsHistory->save();

				   if($matchPoints>0){
					 $position_data="right"; 
				  }
				}

				if($matchPoints >=1){
				 $matchPoints_data =$matchPoints;
						 for ($i=0; $i < $matchPoints; $i++) { 

							 $pv_pairs_count= DB::table('referrals')
							 ->where('user_id', '=', $upline_placement_id)
							 ->whereDate('created_at', '=', $datenow)
							 ->whereBetween(DB::raw('TIME(created_at)'), array($from_date, $to_date))
							 ->where(function ($query) {
								 $query->where('status_Pv', '=', 1)
									   ->orWhere('status_Pv', '=', 2);
							 })
							 ->where('referral_type', 'like', '%activation_cost_reward%' )
							 ->count();
							 $PvPointdata_left=0;
							 $PvPointdata_right=0;
							 if($pv_pairs_count>$pvPoints_limeter){

								 $position = "";
								 $pv=0;
								 $PvPointdata = PvPoint::where('user_id',$upline_placement_id)->first();
								 if($PvPointdata->leftpart >0){
									 $position = "left";
									 $pv=$PvPointdata->leftpart;
									 $PvPointdata_left=$PvPointdata->leftpart;
								 }else{
									 $position = "right";
									 $pv=$PvPointdata->rightpart;
								 $PvPointdata_right=$PvPointdata->rightpart;
								 }
								 $Flushout = new Flushout();
								 $Flushout->user_id = $upline_placement_id;
								 $Flushout->flush_pv_point = $pv;	
								 $Flushout->position	=$position;						
								 $Flushout->sponsor = $user_id;	
								 $Flushout->state = $state_flush_out;	
								 $Flushout->save();
					 
								 $PvPoint = PvPoint::find($PvPointdata->id);
								 $PvPoint->leftpart = 0;
								 $PvPoint->rightpart = 0;  
								 $PvPoint->update();

								 $PairingChecker = new PairingChecker();
								 $PairingChecker->user_id=$upline_placement_id;
								 $PairingChecker->source_id = $user_id;
								 $PairingChecker->pv_point = $matchPoints_data;
								 $PairingChecker->left = 0;
								 $PairingChecker->right = 0;
								 $PairingChecker->cycle = 0;
								 $PairingChecker->cycle_time=$cycle_time;
								 $PairingChecker->fifth_pair = 0;
								 $PairingChecker->save();

							 }else{

							  $PvPointdata = PvPoint::where('user_id',$upline_placement_id)->first();
							  if($PvPointdata->leftpart >0){
								  $position = "left";
								  $pv=$PvPointdata->leftpart;
								  $PvPointdata_left=$PvPointdata->leftpart;
							  }else{
								  $position = "right";
								  $pv=$PvPointdata->rightpart;
							  $PvPointdata_right=$PvPointdata->rightpart;
							  }

								 $activation_cost_reward = Referral::where('user_id',$upline_placement_id)->where('status_Pv',1)->where('referral_type','activation_cost_reward') ->count();
								 $referral = new Referral();
								 $referral->user_id = $upline_placement_id; //the sponsor
								 $referral->source_id =  $user_id; //the downline
								 if($activation_cost_reward==4){
									 $referral->referral_type = 'fifth_activation_cost_reward';
									 DB::table('referrals')
										 ->where('user_id',$upline_placement_id)
										 ->where('status_Pv',1)
										 ->update(['status_Pv' => 2]);
									 $referral->status_Pv = 2;
								 }else{
									 $referral->referral_type = 'activation_cost_reward';
									 $referral->status_Pv = 1;
								 }
								 $referral->amount = 1700;
								 $referral->status = 0;
							 
								 $referral->save();


								 $activation_cost_reward_checker = Referral::where('user_id',$upline_placement_id)->where('status_Pv',1)->where('referral_type','activation_cost_reward') ->get();
								 $xx=0;
								  foreach ($activation_cost_reward_checker as $data) {
									 $activation_cost_reward_count = Referral::where('user_id',$upline_placement_id)->where('status_Pv',1)->where('referral_type','activation_cost_reward') ->count();
									 if($activation_cost_reward_count>=5){
										 $Referral = Referral::find($data->id);
										 if ($xx==5){
											$Referral->referral_type = 'fifth_activation_cost_reward';
											$xx=0;
										 }
										 $Referral->status_Pv = 2;
										 $Referral->update();
									 
										 $xx++;
									 }
								 
								  }

							  } 
								  
						   }

						   if($position_data=="right"){
							 $right=$matchPoints_data--;
							 $left=$PvPointdata_left;
						 }else{
							 $left=$matchPoints_data--;
							 $right=	$PvPointdata_right;
						 }
						 if($pv_pairs_count==0){
							 $pv_pairs_count=1;
						 }
						 if($left==0){
							 $left=1;
						 }
						 if($right==0){
							 $right=1;
						 }
						$cycle=$pv_pairs_count;
						$cycle_time=$state_flush_out;
						$fifth_pair=intdiv($pv_pairs_count,5);
					   $this->pairingChecker($upline_placement_id,$PvPoints,$left,$right,$cycle,$cycle_time,$fifth_pair,$user_id);
							 
						   
				 }
		  } 
	 
	}
}

	//check username in user activation
	public function checkPlacement($username){
		$user = DB::table('users')->where('username',$username)->first();
		$valid_username=0;
		$placement_position='invalid';
		if($user){
			$valid_username=1;
			$id=$user->id;
			$chck_place = DB::table('networks')->where('upline_placement_id',$id)->get();
			if(count($chck_place)==0){
				$placement_position='empty';
			}else if(count($chck_place)==1){
				foreach($chck_place as $data){
					if($data->placement_position=='left'){
						$placement_position='right';
					}else{
						$placement_position='left';
					}
				}				
			}else{
				$placement_position='full';
			}
		}else{
			$valid_username=0;
		}
		return response()->json([
			'valid_username' => $valid_username,
			'placement_position' => $placement_position
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
	

	
	
	
}
