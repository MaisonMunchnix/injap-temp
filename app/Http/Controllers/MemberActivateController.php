<?php

namespace App\Http\Controllers;

use App\User;
use App\UserInfo;
use App\ProductCode;
use App\Network;
use App\Referral;
use App\PvPoint;
use Session;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Http\Update;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class MemberActivateController extends Controller
{

	private $referral_bonus_amt=100;
	private $activation_cost_reward_amt=400;
	private $retail_comm_amt=300;
	private $leadership_bonus_amt=200;

	
	public function getRegister(){
        return view('view/register');

    }
	
	

	//user activation
	public function userActivation(Request $request){
		
		//product code
		$product_code = $request['activation_code'];
		$security_pin = $request['sec_pin'];
		//user
		$password=bcrypt($request['password']);
		$plain_password=$request['password'];
		$username=$request['username_member'];

		//user info
		$first_name = $request['first_name'];
		$last_name = $request['last_name'];
		$middle_name = $request['middle_name'];
		$email_address = $request['email_addr'];
		$mobile_no = $request['mobile_no'];
		$tel_no = $request['tel_no'];
		$gender = $request['gender'];
		$civil_status = $request['civil_status'];
		$tin_no = $request['tin_no'];
		$beneficiary = $request['beneficiary'];
		$birth_date = $request['birth_date'];
		$address = $request['address'];
		$province_id = $request['province_id'];
		$province_val = $request['province_val'];
		$city_id = $request['city_id'];
		$city_val = $request['city_val'];
		$zip_code = $request['zip_code'];
		$address = $request['address'];
		//account_extension

		//network
		$sponsor_id = $request['sponsor'];
		$upline_placement_id = $request['upline_placement'];
		$placement_position = $request['placement_position'];
		if($sponsor_id=='' || $sponsor_id==null){
			$sponsor_id=0;
			$upline_placement_id=0;
			$placement_position='null';
		}else{
			$sponsor = User::where('username',$request['sponsor'])->first();
			$sponsor_id=$sponsor->id;
			$upline_placement = DB::table('users')->where('username',$upline_placement_id)->first();
			$upline_placement_id=$upline_placement->id;
		}


		$package = DB::table('product_codes')->where('code',$product_code)->where('security_pin',$security_pin)->first(); 
		
		$invalid_username = DB::table('users')->where('username',$username)->first(); 
		
		$invalid_email=[];
		if($request['already_in_user']=='true'){
			$invalid_email = DB::table('users')->where('email',$email_address)->first(); 
		}
		$invalid_product_code = DB::table('product_codes')->where('code',$product_code)->where('security_pin',$security_pin)->where('status',0)->first();

		$invalid_name=0;
		$get_fname = UserInfo::where('first_name',$first_name)->first(); 
		$get_mname = UserInfo::where('last_name',$last_name)->first(); 
		$get_lname = UserInfo::where('middle_name',$middle_name)->first(); 
		if($get_fname){
			$invalid_name++;
		}
		if($get_mname){
			$invalid_name++;
		}
		if($get_lname){
			$invalid_name++;
		}

		 
		if($invalid_username){
			return response()->json([
				'message' => 'Username is already taken',
			],500);
		} else if(!$invalid_product_code){
			return response()->json([
				'message' => 'Product codes invalid',
			],500);
		} else if($invalid_email){
			return response()->json([
				'message' => 'Email is already taken',
			],500);
		}else if($invalid_name>=3){
			return response()->json([
				'message' => 'Name already in use',
			],500);
		}else if(strlen($username)<6){
			return response()->json([
				'message' => 'Invalid username',
			],500);
		}else if(!ctype_digit($zip_code)){
			return response()->json([
				'message' => 'Invalid zip code',
			],500);
		} else {
			DB::beginTransaction();		 
			$user_id;
			try {
				if($request['already_in_user']=='true'){
					//add user table
					$user = new User();
					$user->username = $username;
					$user->email = $email_address;
					$user->password = $password;
					$user->plain_password = $plain_password;
					$user->status = 1;
					$user->userType = "user";
					$user->save();
					$user_id=$user->id;
					//add user_info table
					$user_info = new UserInfo();
					$user_info->user_id = $user_id;
					$user_info->first_name = $first_name;
					$user_info->middle_name = $middle_name;
					$user_info->last_name = $last_name;
					$user_info->mobile_no = $mobile_no;
					$user_info->tel_no = $tel_no;
					$user_info->gender = $gender;
					$user_info->civil_status = $civil_status;
					$user_info->tin_no = $tin_no;
					$user_info->beneficiary = $beneficiary;
					$user_info->birthdate = date('Y-m-d',strtotime($birth_date));
					$user_info->province_id = $province_id;
					$user_info->province_val = $province_val;
					$user_info->city_id = $city_id;
					$user_info->city_val = $city_val;
					$user_info->zip_code = $zip_code;
					$user_info->save();
					//add networks table
					$network = new Network();
					$network->sponsor_id = $sponsor_id;
					$network->user_id = $user_id;
					$network->upline_placement_id = $upline_placement_id;
					$network->placement_position = $placement_position;
					$network->package=$package->category;
					$network->save();
				}else{
					$reg_user_id=$request['reg_user_id'];
					//update user table
					$user =User::find($reg_user_id);
					$user->username = $username;
					//$user->email = $email_address;
					$user->password = $password;
					$user->plain_password = $plain_password;
					$user->status = 1;
					$user->userType = "user";
					$user->update();

					$user_id=$reg_user_id;
					$get_user_info_id = UserInfo::select('id')->where('user_id',$user_id)->first();
					$get_network_id = Network::select('id')->where('user_id',$user_id)->first();

					//update user_info table
					$user_info = UserInfo::find($get_user_info_id->id);
					$user_info->user_id = $user_id;
					$user_info->first_name = $first_name;
					$user_info->middle_name = $middle_name;
					$user_info->last_name = $last_name;
					$user_info->mobile_no = $mobile_no;
					$user_info->tel_no = $tel_no;
					$user_info->gender = $gender;
					$user_info->civil_status = $civil_status;
					$user_info->tin_no = $tin_no;
					$user_info->beneficiary = $beneficiary;
					$user_info->birthdate = date('Y-m-d',strtotime($birth_date));
					$user_info->province_id = $province_id;
					$user_info->province_val = $province_val;
					$user_info->city_id = $city_id;
					$user_info->city_val = $city_val;
					$user_info->zip_code = $zip_code;
					$user_info->update();
					//update networks table
					$network = Network::find($get_network_id->id);
					$network->sponsor_id = $sponsor_id;
					$network->user_id = $user_id;
					$network->upline_placement_id = $upline_placement_id;
					$network->placement_position = $placement_position;
					$network->package=$package->category;
					$network->update();
				}
							
				//insert referral bonus
				if($sponsor_id!="" || $sponsor_id!=null || $sponsor_id!=0){
					//get sponsor network data
					$sponsor_network_data = Network::where('sponsor_id',$sponsor_id)->get();
					$product_codes = DB::table('product_codes')
					->join('packages', 'packages.id', '=', 'product_codes.category')
					->select('packages.pv_points AS pv_points')
					->where('product_codes.code',$product_code)
					->first();

					//insert direct referral bonus
					$referral = new Referral();
					$referral->user_id = $sponsor_id; //the sponsor
					$referral->source_id = $user_id; //the downline
					$referral->referral_type = 'referral_bonus';
					$referral->amount = $this->referral_bonus_amt;
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
			
					while($x==0){
						$i++;
						 $count = Network::where('user_id',$upline_placement_id)->where('sponsor_id', '!=',0)->count();
						if($count==0){
							/*start for top sponsor */
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
			
							 $upline_placement_id1 = Network::where('user_id',$upline_placement_id)->where('sponsor_id', '!=',0)->first();
							 $upline_placement_id = $upline_placement_id1->upline_placement_id;
							 $placement_position = $upline_placement_id1->placement_position;
							 /* update pv points */
							 $PvPointCount = PvPoint::where('user_id',$upline_placement_id)->count();       
							  $this->pvPoints($upline_placement_id,$placement_position,$PvPoints,$sponsor_id,$user_id);
							
							 //array_push($id,$upline_placement_id);
						} 
						
						
						
					}  

					//insert leadership bonus
					if(count($sponsor_network_data)>2){
						//insert direct referral bonus
						$referral = new Referral();
						$referral->user_id = $sponsor_id; //the sponsor
						$referral->source_id = $user_id; //the downline
						$referral->referral_type = 'leadership_bonus';
						$referral->amount = $this->leadership_bonus_amt;
						$referral->status = 0;
						$referral->save();
					}
					

					//$down_lines = DB::table('networks')->where('networks.sponsor_id',$auth_id)->get(); // getting all your network data
				}

				//update product_codes table
				$product_code_update = DB::table('product_codes')->where('code',$product_code)->where('security_pin',$security_pin)->update(['user_id' => $user_id,'status' => 1]);

				DB::commit();
				return response()->json([
					'message' => 'ok',
				],200);


			} catch(\Throwable $e){
				DB::rollback();
				return response()->json([
					'message' => $e->getMessage(),
				],500);
			}

			
			 
			 
		 }
	}

	
    private function pvPoints($upline_placement_id,$placement_position,$PvPoints,$sponsor_id,$user_id){

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

	//get datas in member register section
	public function memberGetData(){
		$users = DB::table('users')->select('username','email')->get();
		$product_codes = DB::table('product_codes')->select('code','security_pin')->where('status',0)->get();
		$package = DB::table('packages')->select('id','type')->get();
		return response()->json([
			'users' => $users,
			'product_codes' => $product_codes,
			'package' => $package
        ]);

	}
	//get datas in register section
	public function registerGetData(){
		$province = DB::table('provinces')->select('provDesc','provCode')->orderBy('provDesc', 'ASC')->get();
		$city = DB::table('cities')->select('citymunDesc','provCode','citymunCode')->orderBy('citymunDesc', 'ASC')->get();
		return response()->json([
			'province' => $province,
			'city' => $city
		]);

	}

	public function userGetData($code,$pin){
		$product_codes = DB::table('product_codes')->where('code',$code)->where('security_pin',$pin)->first();
		$sponsor_id=$product_codes->sponsor_id;		
		$check_user_in_pcode = DB::table('product_codes')->where('user_id',$sponsor_id)->count();
		$already_in_user=false;
		$array_data=array();
		$user_data = DB::table('users')
			->join('user_infos', 'user_infos.user_id', '=', 'users.id')
			->join('networks', 'networks.user_id', '=', 'users.id')
			->select('users.id AS user_id','users.username AS u_user','users.email AS u_email','user_infos.first_name AS f_name','user_infos.last_name AS l_name','user_infos.mobile_no AS mobile','networks.sponsor_id','networks.upline_placement_id','networks.upline_placement_id','networks.placement_position')
			->where('users.id',$sponsor_id)
			->first();

		array_push($array_data,$user_data);
		
		if($check_user_in_pcode>=1){
			//if user_id(column) from sponsor_id is existing in product_code tables means this code and pin...
			//add = sponsor already registered
			$already_in_user=true;						
		}else{
			//update only = sponsor not yet registered
			$already_in_user=false;					
		}

		if($user_data->sponsor_id){
			$sponsor_net=DB::table('users')->select('username')->where('id',$user_data->sponsor_id)->first();
			if($sponsor_net){
				$temp_arr=array('sponsor_username'=>$sponsor_net->username);
				array_push($array_data,$temp_arr);
			}
		}
		if($user_data->upline_placement_id){
			$upline_net=DB::table('users')->select('username')->where('id',$user_data->upline_placement_id)->first();
			if($upline_net){
				$temp_arr=array('upline_username'=>$upline_net->username);
				array_push($array_data,$temp_arr);
			}
		}
		return response()->json([
			'user_data' => $array_data,
			'already_in_user' => $already_in_user
		]);

	}

	//check username in user activation
	public function checkUsername($username){
		$check_user = DB::table('users')->where('username',$username)->first();
		$valid_username=0;
		if($check_user){
			$valid_username=1;
		}
		return response()->json([
			'valid_username' => $valid_username
        ]);

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

	//check username in user activation
	public function checkRegisteredEmail($email){
		$check_email = DB::table('users')->where('email',$email)->first();
		$valid_email=0;
		if($check_email){
			$valid_email=1;
		}
		return response()->json([
			'valid_email' => $valid_email
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
