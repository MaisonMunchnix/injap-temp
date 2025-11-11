<?php

namespace App\Http\Controllers;
use Session;
use App\User;
use App\UserInfo;
use App\ProductCode;
use App\Network;
use App\Referral;
use App\PvPoint;
use App\RedeemTransaction;
use App\Flushout;
use App\PvPointsHistory;
use App\Product;
use App\ProductCategory;
use App\PairingChecker;
use App\Country;
use App\Province;
use App\City;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Http\Update;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class MemberRegistrationController extends Controller
{

	public function getRegister(){
		return view('view.member_register');
	}

	//user register
	public function saveMember(Request $request){
		//activation data
		$code=$request['code'];
		$pin=$request['pin'];
		$package_type="";
		$product_code_id="";
		$pay_type="";
		$member_type="";
		$sub_package="";
		//user data
		$password=bcrypt($request['password']);
		$plain_password=$request['password'];
		$username=$request['user_name'];
		//account_extension
		$chk_extension = $request['chk_extension'];
		$primary_user = $request['primary_user'];
		$account_extension_id=null;
		//user info data
		$first_name = $request['first_name'];
		$last_name = $request['last_name'];
		$middle_name = $request['middle_name'];
		$email_address = $request['email_address'];
		$mobile_no = $request['mobile_no'];
		$birth_date = $request['birth_date'];
		$address = $request['full_address'];

		$country_id = $request->country;
		$country = Country::find($country_id);
		$country_name = $country->nice_name;

		if ($country_id != 169) {
			$province_id = null;
			$city_id = null;
			$city_name = $request->input('city_name');
			$province_name = $request->input('province_name');
		} else {
			// Philippines
			$province_id = $request->input('province');
				$city_id = $request->input('city');

				$province_name = Province::where('provCode', $province_id)->value('provDesc');

				$city_name = City::where('citymunCode', $city_id)->value('citymunDesc');

				if ($province_name !== null) {
					$province_name = ucwords(strtolower($province_name));
				}

				if ($city_name !== null) {
					$city_name = ucwords(strtolower($city_name));
				}
		}

		
        $bank_name = $request['bank_name'];
		$account_number = $request['account_number'];
		$team_name = $request['team_name'];
		$tin = $request['tin'];
        
        //New Data
		$occupation_id = $request['occupation'];
		$beneficiary_name = $request['beneficiary_name'];
		$beneficiary_contact_number = $request['beneficiary_contact_number'];
		$beneficiary_relationship = $request['beneficiary_relationship'];
		$gender = $request['gender'];	
        
		//sponsor data
		$sponsor = $request['sponsor'];
		$upline_placement = $request['upline_placement'];
		$desired_position = $request['position'];
		$placement_position = "";
		$sponsor_id = 0;
		$upline_placement_id = 0;
		$direct_referral_bonus = 0;

		//check code and pin
		$product_code = ProductCode::where('code',$code)->where('security_pin',$pin)->where('status',0)->first();
		$valid_code = false;
		if($product_code){
            $valid_code = true;
			$package_type = $product_code->category;
			$package_id = $product_code->category;
			$get_package = DB::table('packages')->select('type')->where('id',$package_id)->first();
			$member_type = strtolower($get_package->type);
			$product_code_id = $product_code->id;
			$pay_type = $product_code->is_paid;
			$sub_package = $product_code->sub_package;
			//get pv points
			$packageid = $product_code->category;
			$packagesData = DB::table('packages')->where('id',$packageid)->first();
			$direct_referral_bonus = $packagesData->referral_amount;
			$pv_points = $packagesData->pv_points;
		}

		if($pay_type=="free"){
			$pv_points=0;
			$direct_referral_bonus = 0;
		}
		//check account extension
		$valid_extension=false;
		if($chk_extension==true){
            $check_extension = User::where('username',$primary_user)->first();
            if($check_extension){
                if($check_extension->info->province_id){
                    $province_id = $province_id ? $check_extension->info->province_id : null;
                }
                
                if($check_extension->info->city_id){
                    $city_id = $city_id ? $check_extension->info->city_id : null;
                }
                
                if($check_extension->info->bank_name){
                    $bank_name = $check_extension->info->bank_name;
                }
                
                if($check_extension->info->gender){
                    $gender = $check_extension->info->gender;
                }

				if($check_extension->info->occupation_id){
                    $occupation_id = $check_extension->info->occupation_id;
                }
                
                $valid_extension = true;
                $account_extension_id = $check_extension->id;
			}
		}else{
            $valid_extension=true;
		}


		//Check Register if users is null
		$check_users = User::where('userType', 'user')->count();

		if ($check_users > 0) {
			//check sponsor
			$check_sponsor = DB::table('users')
				->select('id')
				->where('username', $sponsor)
				->where('userType', 'user')
				->first();
			$valid_sponsor = false;
			if($check_sponsor){
				$valid_sponsor = true;
				$sponsor_id = $check_sponsor->id;
				
				//Limit referral based on sponsor Package
				$sponsor_package = DB::table('users')
					->join('packages','users.account_type','packages.id')
					->select('referral_amount')
					->where('users.id',$sponsor_id)
					->first();
				if($sponsor_package){
					$direct_referral_bonus = ($sponsor_package->referral_amount >= $direct_referral_bonus ? $direct_referral_bonus : $sponsor_package->referral_amount);
				}
			}

			//check upline
			$check_upline = User::select('id')->where('username',$upline_placement)->where('userType','user')->first();
			$valid_upline = false;
			if(!empty($check_upline)){
				$upline_placement_id = $check_upline->id;
				$networks = DB::table('networks')->where('upline_placement_id',$upline_placement_id)->count();
				if(!empty($networks)){
					if($networks >= 2){
						$valid_upline = false;
					}else{
						$valid_upline = true;
					}
				}else{
					$valid_upline = true;
				}
			}else{
				$valid_upline = false;
			}
			if($valid_upline == true){
				$placement_position = $this->getPlacementPosition($upline_placement_id, $desired_position);
			}
		} else {
			$upline_placement_id = 1;
			$sponsor_id = 1;
			$desired_position = 'Left';
			$valid_sponsor = true;
			$valid_upline = true;
			$check_crosslining = true;
			$check_sponsor_crosslining = true;
		}

		//validation
		$invalid_username =  User::where('username',$username)->first(); 
		$invalid_name = 0;
		$check_crosslining = true;
		//crosslining
		$check_full_name = UserInfo::where('first_name',$first_name)->where('last_name',$last_name)->where('middle_name',$middle_name)->first(); 
		if(!empty($check_full_name)){
			//if the user itself is the upline
			$check_upline_full_name = $check_upline->info->where('first_name',$first_name)->where('last_name',$last_name)->where('middle_name',$middle_name)->first();
			if(!empty($check_upline_full_name)){
				$check_crosslining = true;
			}
		}

		//sponsor cross lining
		$get_sponsor_cross_lining = $this->sponsorCrossLining($sponsor_id);
		$check_sponsor_crosslining = false;
		$sponsor_id_array = [];
		foreach($get_sponsor_cross_lining['data'] as $sp_dw){
			$sponsor_id_array[] = $sp_dw;
		}
		$sponsor_id_array[] = $sponsor_id;
		
		//check if placement id is in the list of downline of sponsor
		if (in_array($upline_placement_id, $sponsor_id_array)){
			$check_sponsor_crosslining = true;
		}

		//maximum of seven accounts
		$check_seven_accounts = User::whereHas('info', function ($query) use ($first_name, $last_name) {
			$query->where('first_name', $first_name)
				->where('last_name', $last_name);
		})->count();

		if($valid_code == false){
			return response()->json([
				'message' => 'Invalid activation code',
			],400);
		}else if($valid_extension == false){
			return response()->json([
				'message' => 'Invalid account extension username',
			],400);
		}else if($invalid_username){
			return response()->json([
				'message' => 'Username is already taken',
			],400);
		}else if($valid_sponsor == false){
			return response()->json([
				'message' => 'Invalid sponsor',
			],400);
		}else if($valid_upline == false){
			return response()->json([
				'message' => 'Invalid upline placement',
			],400);
		}else if($check_crosslining == false){
			return response()->json([
				'message' => 'invalid_crosslining',
			],400);
		}else if($check_sponsor_crosslining == false){
			return response()->json([
				'message' => 'Invalid placement position. Sponsor crosslining',
			],400);
		}else if($check_seven_accounts >= 7){
			return response()->json([
				'message' => 'Maximum of seven accounts only.',
			],400);
		 }else {
			DB::beginTransaction();		 
			try {

				//add user table
				$user = User::create([
					'username' => $username,
					'email' => $email_address,
					'password' => $password,
					'plain_password' => $plain_password,
					'status' => 1,
					'userType' => 'user',
					'account_type' => $package_type,
					'account_extension' => $account_extension_id,
					'account_status' => $pay_type,
					'member_type' => $member_type,
					'sub_package' => $sub_package,
				]);
				$user_id = $user->id;

				$user->info()->create([
					'first_name' => $first_name,
					'middle_name' => $middle_name,
					'last_name' => $last_name,
					'mobile_no' => $mobile_no,
					'birthdate' => date('Y-m-d', strtotime($birth_date)),
					'country_id' => $country_id,
					'country_name' => $country_name,
					'province_id' => $province_id,
					'province_name' => $province_name,
					'city_id' => $city_id,
					'city_name' => $city_name,
					'address' => $address,
					'bank_name' => $bank_name,
					'bank_account_number' => $account_number,
					'team_name' => $team_name,
					'tin' => $tin,
					'status' => 1,
				]);

				$count_placement_id = Network::where('upline_placement_id', $upline_placement_id)->count();

				//Add Network
				$user->network()->create([
					'sponsor_id' => $sponsor_id,
					'upline_placement_id' => $upline_placement_id,
					'placement_position' => $placement_position,
					'package' => $package_type,
					'count' => ($count_placement_id === 1 ? 2 : 1),
				]);


				//ADD NETWORK FOR HIS UPLINE
				$user->network()->create([
					'sponsor_id' => $upline_placement_id,
					'upline_placement_id' => $upline_placement_id,
					'placement_position' => $placement_position,
					'package' => $package_type,
					'count' => ($count_placement_id === 1 ? 2 : 1),
				]);



				// dd($count_placement_id);

				if($direct_referral_bonus > 0){
					$productPoints = Product::where('id', $product_code->product_id)->value('reward_points');
					$this->addReferral($sponsor_id, $user_id, 'direct_referral_bonus', 'php', $direct_referral_bonus,'sponsor');
					$this->addReferral($sponsor_id, $user_id, 'direct_referral_bonus_points', 'points', number_format($direct_referral_bonus * $productPoints, 2),'sponsor');
				}

				//update product_codes table
				$product_code->user_id = $user_id;
				$product_code->status = 1;
				$product_code->save();

				$upline_placement_id1;
				$x=0;
				$i=0;
				$PvPoints = $pv_points;
				if($PvPoints > 0){
					while($x == 0){
						$i++;
						$count = Network::where('user_id',$upline_placement_id)->where('sponsor_id', '!=',0)->count();
						if($count == 0){
							if($i == 1){
								$x=1;  
								$tmpSponsorId=$upline_placement_id;	   
								$PvPointCount = PvPoint::where('user_id',$tmpSponsorId)->count();									  
								if($PvPointCount == 0){
									if($tmpSponsorId != 0){
										$position_inside="";
										$left = 0;
										$right = 0;
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
										$newPvPoint=$newPvPoint->id; 
	
										$PvPointsHistory = new PvPointsHistory();
										$PvPointsHistory->user_id = $tmpSponsorId;
										$PvPointsHistory->pv_point = $PvPoints;
										$PvPointsHistory->position = $position_inside;
										$PvPointsHistory->sponsor = $user_id;
										$PvPointsHistory->save();
	
										$cycle=0;
										$cycle_time=0;
									   	$this->pairingChecker($tmpSponsorId,$PvPoints,$left,$right,$cycle,$cycle_time,$user_id);
									}
								}else{
									if($upline_placement_id != 0){
										$this->pvPoints($upline_placement_id,$placement_position,$PvPoints,$sponsor_id,$user_id);
									}
								}     
							}else{
								$sponsor_id=$upline_placement_id1->sponsor_id;
								$x=$upline_placement_id1->sponsor_id;
							}               
						}else{       

							if($i == 1){
								 $tmpSponsorId=$upline_placement_id;							
								$PvPointCount = PvPoint::where('user_id',$tmpSponsorId)->count();									  
								if($PvPointCount == 0){
									if($upline_placement_id != 0){
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
									   $this->pairingChecker($tmpSponsorId,$PvPoints,$left,$right,$cycle,$cycle_time,$user_id);
									}
								}else{
									if($upline_placement_id != 0){
										$this->pvPoints($upline_placement_id,$placement_position,$PvPoints,$sponsor_id,$user_id);
									}
								}                                 
							}	
							
							$upline_placement_id1 = Network::where('user_id',$upline_placement_id)->where('sponsor_id', '!=',0)->first();
							$upline_placement_id = $upline_placement_id1->upline_placement_id;
							$placement_position = $upline_placement_id1->placement_position;
							
							$PvPointCount = PvPoint::where('user_id',$upline_placement_id)->count();       
							if($upline_placement_id != 0){
								$this->pvPoints($upline_placement_id,$placement_position,$PvPoints,$sponsor_id,$user_id);
							}
						} 																
					}
				}

				DB::commit();
				return response()->json([
					'message' => 'ok',
				],200);
			} catch(\Throwable $e){
				DB::rollback();
				return response()->json([
					'message' => $e->getMessage(),
				],400);
			}	 
		}
	}

	public function fix_network(){
		$network  =DB::table("networks")
			->get();
			// dd($network);
			foreach($network as $net){
				$check =DB::table("networks")
					->where("upline_placement_id", $net->user_id)
					->get();
					
					foreach($check as $fix){
						$user_id = $fix->user_id;
						
						$check2 = DB::table("networks")
							->where("sponsor_id", $fix->upline_placement_id)
							->where("upline_placement_id", $fix->upline_placement_id)
							->where("user_id", $user_id)
							->first();
							
						if($check2 == null){
							// 
							DB::table("networks")
								->insert([
									"user_id"=> $user_id,
									"sponsor_id" => $fix->upline_placement_id,
									"upline_placement_id" => $fix->upline_placement_id,
									"placement_position" => $fix->placement_position,
									"count"  => $fix->count,
									"package" => $fix->package,
									"created_at"=> $fix->created_at,
									"updated_at" =>$fix->updated_at
								]);
						}


					}
			}

			return "fixed";
	}


	private function addReferral($user_id, $source_user_id, $type, $reward_type, $amount, $hierarchy){
		$Referral = new Referral();
		$Referral->user_id = $user_id;
		$Referral->source_id = $source_user_id;
		$Referral->referral_type = $type;
		$Referral->reward_type = $reward_type;
		$Referral->hierarchy = $hierarchy;
		$Referral->amount = $amount;
		$Referral->status = 1;
		$Referral->save();
	}
	
    
	private function pvPoints($upline_placement_id,$placement_position,$PvPoints,$sponsor_id,$user_id){		
		$chk_account_user = User::select('account_type')->where('id',$upline_placement_id)->first();

		//10-23-2021 Update Start here
		$userAccountType = $chk_account_user->account_type;
        
        $package = DB::table('packages')->select('id','limiter','referral_amount','pairing_amount')->where('id', $userAccountType)->first();
		$productPoints = Product::where('package_id', $package->id)->value('reward_points');
        
        
        $pvPoints_limiter = $package->limiter;
        $referral_amount = $package->referral_amount;
        $pairing_amount = $package->pairing_amount;
		

        if($upline_placement_id > 0){
            $datenow = date('Y-m-d');
            $ldate = date('H:i:s');

            $from_date ='00:00:00';
            $to_date = '23:59:00';
            $state_flush_out = 'daily';
            
            $pv_pairs_count = DB::table('referrals')
                ->where('user_id', '=', $upline_placement_id)
                ->whereDate('created_at', $datenow)
                ->whereBetween(DB::raw('TIME(created_at)'), array($from_date, $to_date))
                ->where(function ($query) {
                    $query->where('status_Pv', '=', 1)
                        ->orWhere('status_Pv', '=', 2);
                })
                ->where('referral_type', 'like', '%sales_match_bonus%' )
                ->count(); 
		
            if($pv_pairs_count >= $pvPoints_limiter){
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
                $Flushout->position	= $position;						
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
 
            } else {
 
                $left=0;
                $right=0;
                $cycle=0;
                $cycle_time=0;
                $PvPointCount = PvPoint::where('user_id',$upline_placement_id)->count();
                if($PvPointCount==0){
                    $newPvPoint = new PvPoint();
                    $newPvPoint->user_id = $upline_placement_id;
                    if($placement_position =='left'){
                        $newPvPoint->leftpart = 0;
                    }else{
                        $newPvPoint->rightpart = 0;
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
                        $this->pairingChecker($upline_placement_id,$PvPoints,$left,$right,$cycle,$cycle_time,$user_id);
                        
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
                    
                    if($points==0){
                        $rightdata = $PvPoint->rightpart;
                        $PvPoint->rightpart = $PvPoint->rightpart+$PvPoints;
                        $left=0;
                        $right=$rightdata+$PvPoints;
                        $cycle=$pv_pairs_count;
                        $cycle_time=$state_flush_out;
                        $this->pairingChecker($upline_placement_id,$PvPoints,$left,$right,$cycle,$cycle_time,$user_id);
 
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
                    $matchPoints_data = $matchPoints;
                    
                    for($i=0; $i < $matchPoints; $i++) {
 
                        $pv_pairs_count= DB::table('referrals')
                            ->where('user_id', $upline_placement_id)
                            ->whereDate('created_at', $datenow)
                            ->whereBetween(DB::raw('TIME(created_at)'), array($from_date, $to_date))
                            ->where(function ($query) {
                                $query->where('status_Pv', 1)
                                    ->orWhere('status_Pv', 2);
                            })
                            ->where('referral_type', 'like', '%sales_match_bonus%' )
                            ->count();
                        
                        $PvPointdata_left=0;
                        $PvPointdata_right=0;
                        if($pv_pairs_count > $pvPoints_limiter){
 
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
                            //10-23-2021

							$check_pairs = DB::table('networks')->select('user_id')->where('upline_placement_id', $upline_placement_id)->get();

							$pair1 = '';
							$pair2 = '';
							$check_pair_count = 1;
							foreach($check_pairs as $check_pair){
								$checkpair_user = DB::table('users')->select('account_type')->where('id',$check_pair->user_id)->first();
								if($check_pair_count == 1){
									$pair1 = $checkpair_user->account_type;
								} else {
									$pair2 = $checkpair_user->account_type;
								}
								$check_pair_count++;
							}

							if($pair1 == $pair2){
                                $sponsor_package = DB::table('users')
									->join('packages','users.account_type','packages.id')
									->select('pairing_amount')
									->where('users.id',$upline_placement_id)
									->first();
								if($sponsor_package){
									$max_referral = ($sponsor_package->pairing_amount >= $pairing_amount ? $pairing_amount : $sponsor_package->pairing_amount);
									$reward_points = number_format($max_referral * $productPoints, 2);
								}

								$this->addReferral($upline_placement_id, $user_id, 'sales_match_bonus', 'php', $max_referral, 'upline');
								$this->addReferral($upline_placement_id, $user_id, 'activation_cost_reward', 'points', $reward_points, 'upline');

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
                    $this->pairingChecker($upline_placement_id,$PvPoints,$left,$right,$cycle,$cycle_time,$user_id);	  
                }
            } 
        }
   }

   public function flushOut(Int $user_id, Int $upline_placement_id, String $cycle_time, Int $matchPoints_data)
   {
		$position = "";
		$pv = 0;
		$state_flush_out = 'daily';
		$PvPointdata = PvPoint::where('user_id',$upline_placement_id)->first();

		if($PvPointdata->leftpart >0){
			$position = "left";
			$pv = $PvPointdata->leftpart;
			$PvPointdata_left = $PvPointdata->leftpart;
		}else{
			$position = "right";
			$pv = $PvPointdata->rightpart;
			$PvPointdata_right = $PvPointdata->rightpart;
		}

		$Flushout = new Flushout();
		$Flushout->user_id = $upline_placement_id;
		$Flushout->flush_pv_point = $pv;	
		$Flushout->position	= $position;						
		$Flushout->sponsor = $user_id;	
		$Flushout->state = $state_flush_out;	
		$Flushout->save();
						
        $PvPoint = PvPoint::find($PvPointdata->id);
        $PvPoint->leftpart = 0;
        $PvPoint->rightpart = 0;  
        $PvPoint->update();
 
        $PairingChecker = new PairingChecker();
        $PairingChecker->user_id = $upline_placement_id;
        $PairingChecker->source_id = $user_id;
        $PairingChecker->pv_point = $matchPoints_data;
        $PairingChecker->left = 0;
        $PairingChecker->right = 0;
        $PairingChecker->cycle = 0;
        $PairingChecker->cycle_time = $cycle_time;
        $PairingChecker->fifth_pair = 0;
        $PairingChecker->save();
   }

   public function Networks(){
		$networks = Network::select('user_id')->get();

		$data = [];

		foreach($networks as $network){
			$referrals = Referral::where('user_id', $network->user_id)
				->select('id', 'source_id', 'amount', 'created_at as date')
				->where('hierarchy', 'upline')
				->where('reward_type', 'php')
				->get();

			$data[] = [
				'user_id' => $network->user_id,
				'username' => $network->user->username,
				'count' => $referrals->count(),
				'total_referrals' => $referrals->sum('amount'),
				'referrals' => $referrals,
				
			];
		}

		return $data;
   }

   public function Network(Int $user_id)
   {
		 $uplinePlacements = [];
		 
		 $network = Network::where('user_id', $user_id)
		 	->where('count', 2)
		 	->first();
	 
		 if ($network) {
			 $this->getUplinePlacementsRecursive($network, $uplinePlacements);
		 }

		 $data = [];

		 foreach($uplinePlacements as $upline_placement_id){
			
            
			$data[] = [
				'id' => $upline_placement_id
			];
		 }

		 return $data;

   }

//    private function getUplinePlacementsRecursive($network, &$uplinePlacements)
//    {
// 		$upline_placement_id = $network->upline_placement_id;
// 		$pv_pairs_count = $this->pairLimit($upline_placement_id);

// 		if($pv_pairs_count < 4 && $upline_placement_id != 0){
// 			if ($upline_placement_id) {
// 				$parentNetwork = Network::where('user_id', $upline_placement_id)->first();
				
// 				if ($parentNetwork) {
// 					$this->getUplinePlacementsRecursive($parentNetwork, $uplinePlacements);
// 				}
// 			}
// 			$uplinePlacements[] = $upline_placement_id;
// 		}
// 	}

	private function getUplinePlacementsRecursive($network, &$uplinePlacements)
	{
		$upline_placement_id = $network->upline_placement_id;
		$pv_pairs_count = $this->pairLimit($upline_placement_id);

		if ($pv_pairs_count < 4 && $upline_placement_id != 0) {
			if ($upline_placement_id) {
				$parentNetwork = Network::where('user_id', $upline_placement_id)->first();

				if ($parentNetwork) {
					$this->getUplinePlacementsRecursive($parentNetwork, $uplinePlacements);
				}
			}

			// Check for both left and right children
			$leftChild = Network::where('upline_placement_id', $upline_placement_id)
				->where('placement_position', 'left')
				->first();

			$rightChild = Network::where('upline_placement_id', $upline_placement_id)
				->where('placement_position', 'right')
				->first();

			if ($leftChild && $rightChild) {
				$uplinePlacements[] = $upline_placement_id;
			}
		}
	}


	//4 Pairs/Day
	private function pairLimit($user_id)
	{
		$datenow = date('Y-m-d');
		$ldate = date('H:i:s');
		$from_date ='00:00:00';
		$to_date = '23:59:00';
		$state_flush_out = 'daily';

		$pv_pairs_count = DB::table('referrals')
            ->where('user_id', $user_id)
            ->whereDate('created_at', $datenow)
            ->whereBetween(DB::raw('TIME(created_at)'), array($from_date, $to_date))
            ->where(function ($query) {
                $query->where('status_Pv', 1)
                    ->orWhere('status_Pv', 2);
            })
            ->where('referral_type', 'sales_match_bonus')
            ->count();

		return $pv_pairs_count;
	}


	private function pairingChecker($upline_placement_id,$PvPoints,$left,$right,$cycle,$cycle_time,$source_id){
        $cycle = 0;
        $datenow= date('Y-m-d');
        $ldate = date('H:i:s');
        
        $from_date ='00:00:00';
        $to_date = '23:59:00';
        $state_flush_out = 'daily';

        $pv_pairs_count_data= DB::table('referrals')
            ->where('user_id', '=', $upline_placement_id)
            ->whereDate('created_at', '=', $datenow)
            ->whereBetween(DB::raw('TIME(created_at)'), array($from_date, $to_date))
            ->where(function ($query) {
                $query->where('status_Pv', 1)
                    ->orWhere('status_Pv', 2);
            })
            ->where('referral_type', 'like', '%sales_match_bonus%' )
            ->count();
        
        if($pv_pairs_count_data > 0){
            $cycle = $pv_pairs_count_data;
        }else{
            $cycle = 0;
        }

		//Pairing Amount 11-07-2021
		$chk_account_user = User::select('account_type')->where('id',$upline_placement_id)->first();

		//10-23-2021 Update Start here
		$userAccountType = $chk_account_user->account_type;

        if($left >= 1 && $right >= 1){
			$package = DB::table('packages')->select('pairing_amount')->where('id',$userAccountType)->first();
			$amount = $package->pairing_amount;
        }else{
            $amount = 0;
        }
        
        $PairingChecker = new PairingChecker();
        $PairingChecker->user_id = $upline_placement_id;
        $PairingChecker->source_id = $source_id;
        $PairingChecker->pv_point = $PvPoints;
        $PairingChecker->left = $left;
        $PairingChecker->right = $right;
        $PairingChecker->cycle = $cycle;
        $PairingChecker->amount = $amount;
        $PairingChecker->cycle_time = $cycle_time;
        $PairingChecker->fifth_pair = 0;
        $PairingChecker->save();
    }

	//cross lining function
	private function crossLining($user_id,$upline_id){
		//user id of same name
		//upline id inputted
		//user_id of the same full name
		$main_user = Network::where('upline_placement_id',$user_id)->get();
		//variables
		$array_user_id = [];
		$counter = 0;

		if(count($main_user) == 0){
			//if the main user is no downline
			//return false; dati naka false 6/4/2021
			return true;
		}else{
			foreach($main_user as $data){
				array_push($array_user_id,$data->user_id);
			}	
			//while condition
			while($counter == 0){
				$temp_id = $array_user_id;
				//condition for checking kapag downline ng main user si upline(inputted)
				if(in_array($upline_id, $array_user_id)){
					$counter = 1;
					return true;
				}
				$array_user_id = []; //we will empty user_ids
				$check_unique = array_unique($temp_id);
				if(count($check_unique) == 1 && in_array("empty", $check_unique)){
					$counter = 1;
					return false;
                }else{
					foreach($temp_id as $id){
						if($id == 'empty'){
							array_push($array_user_id,'empty');
						}else{				
							$multi_data = Network::select('user_id')->where('upline_placement_id', $id)->get();			
							if(count($multi_data) == 0){
								array_push($array_user_id,'empty');
							}else{
								foreach($multi_data as $mdata){
									array_push($array_user_id,$mdata->user_id);
                                }
							}
						}
					}
				}
			}
		}
	}

	private function sponsorCrossLining($sponsor_id)
    {
		$offset = 0;
        $limit = 6000000;
        $network = new Network();
        $parent_id = $sponsor_id;
        $has_offset = false;

        $count = $network->children($parent_id, $limit)->count();

        if ($count >= $limit) {
            $has_offset = true;
            $data = Network::where('upline_placement_id', '>=', $parent_id)
                ->get()
                ->filter(function ($value) use ($parent_id) {
                    return $value->isChild($parent_id);
                })
                ->map(function ($network) {
					return $network->user_id;
                    //return $this->getBinaryUserData($network->level,$network->user_id);
                });
        } else {
            $data = $network->children($parent_id)
                ->reverse()
                ->map(function ($level, $id) {
					return $id;
                    //return $this->getBinaryUserData($level, $id);
                })
                ->values();
        }

        return [
            'data' => $data
        ];
    }
	
	private function getPlacementPosition($upline_id, $desired_position){
		$networks = DB::table('networks')->where('upline_placement_id',$upline_id)->get();
		$position = "";
		if(count($networks) == 0){
			$position = $desired_position;
		}else{
			$network_one = DB::table('networks')
                ->where('upline_placement_id',$upline_id)
                ->first();
            
			if($network_one->placement_position == 'left'){
				$position = "right";
			}else{
				$position = "left";
			}
			
		}
		return $position;
	}

	//get datas in register section
	public function getProvince(){
		$province = DB::table('provinces')->select('provDesc','provCode')->orderBy('provDesc', 'ASC')->get();
		$city = DB::table('cities')->select('citymunDesc','provCode','citymunCode')->orderBy('citymunDesc', 'ASC')->get();
		return response()->json([
			'province' => $province,
			'city' => $city
		]);

	}

	public function checkRegisteredEmail($email){
		$valid_email = DB::table('users')
			->where('email', $email)
			->exists();
	
		return response()->json([
			'valid_email' => $valid_email
		]);
	}

	public function checkRegisteredUsername($username){
		$valid_username = DB::table('users')
			->where('username', $username)
			->where('userType', 'user')
			->exists();
		return response()->json([
			'valid_username' => $valid_username
        ]);
	}

	public function checkSponsorUsername($username){
		$valid_username = DB::table('users')
			->where('username', $username)
			->where('userType', 'user')
			->exists();
	
		return response()->json([
			'valid_username' => $valid_username
		]);
	}

	public function checkUpline($username) {
		$check_user = DB::table('users')->where('username', $username)->where('userType', 'user')->first();
	
		if (empty($check_user)) {
			return response()->json([
				'msg' => 'username_invalid'
			]);
		}
	
		$upline_id = $check_user->id;
		$networksCount = DB::table('networks')->where('upline_placement_id', $upline_id)
		->where("sponsor_id", "!=", $upline_id)
		->count();
	
		if ($networksCount == 0) {
			return response()->json([
				'msg' => 'upline_ok'
			]);
		} elseif ($networksCount == 1) {
			$available_pos = DB::table('networks')->where('upline_placement_id', $upline_id)->first();
	
			return response()->json([
				'msg' => 'upline_ok',
				'upline_available' => $available_pos->placement_position == 'left' ? 'right' : 'left'
			]);
		} else {
			return response()->json([
				'msg' => 'upline_err',
				'upline_available' => 'none'
			]);
		}
	}
	


	private function getUserID($username) {
		return DB::table('users')->where('username', $username)->value('id');
	}

	public function checkPackageCode($code) {
		$valid_code = DB::table('product_codes')
			->where('code', $code)
			->where('status', 0)
			->exists();
	
		return response()->json([
			'valid_code' => $valid_code
		]);
	}	

	public function checkPackagePin($code, $pin) {
		$valid_code = DB::table('product_codes')
			->where('code', $code)
			->where('security_pin', $pin)
			->where('status', 0)
			->exists();
	
		return response()->json([
			'valid_code' => $valid_code
		]);
	}
	

	public function getExtensionAccount($username) {
		$userInfo = DB::table('users')
			->where('username', $username)
			->where('userType', 'user')
			->leftJoin('user_infos', 'user_infos.user_id', '=', 'users.id')
			->select(
				'email', 'first_name', 'last_name', 'middle_name', 'team_name',
				'bank_name', 'bank_account_number', 'tin', 'birthdate', 'gender',
				'occupation_id', 'mobile_no', 'address', 'country_id','province_id', 'province_name', 'city_id', 'city_name'
			)
			->first();
	
		if ($userInfo) {
			return response()->json([
				'result' => $userInfo
			]);
		} else {
			return response()->json([
				'result' => false
			]);
		}
	}
	
	private function addPV($upline_placement_id_new, $placement_position, $user_id) {
		$userPvPoint = PvPoint::where('user_id', $upline_placement_id_new)->first();
	
		if (!$userPvPoint) {
			return;
		}
	
		if ($placement_position == 0) {
			$userPvPoint->leftpart += 1;
			$position = "left";
		} else {
			$userPvPoint->rightpart += 1;
			$position = "right";
		}
	
		$userPvPoint->update();
	
		$pvPointsHistory = new PvPointsHistory();
		$pvPointsHistory->user_id = $upline_placement_id_new;
		$pvPointsHistory->pv_point = 1;
		$pvPointsHistory->position = $position;
		$pvPointsHistory->sponsor = $user_id;
		$pvPointsHistory->save();
	
		$pairingChecker = new PairingChecker();
		$pairingChecker->user_id = $upline_placement_id_new;
		$pairingChecker->source_id = $user_id;
		$pairingChecker->pv_point = 1;
		$pairingChecker->left = ($placement_position == 0) ? $userPvPoint->leftpart : 0;
		$pairingChecker->right = ($placement_position != 0) ? $userPvPoint->rightpart : 0;
		$pairingChecker->cycle = 0;
		$pairingChecker->cycle_time = 'daily';
		$pairingChecker->fifth_pair = 0;
		$pairingChecker->save();
	}
	
}
