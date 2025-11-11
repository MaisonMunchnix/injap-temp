<?php

namespace App\Http\Controllers;

use App\User;
use App\UserInfo;
use App\ProductCode;
use App\Network;
use App\Referral;
use Session;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Http\Update;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class FreeRegisterController extends Controller
{

	public function getAffiliateFreeRegister($code){
		session(['user_affiliate_val'=>$code]);
		return redirect()->route('free-register');
    }
	

	public function getFreeRegister(){
		$code = session('user_affiliate_val');
		if($code){
			return view('view.free-register', compact(['code']));
		}else{
			return view('view.error_404');
		}
        

	}

	public function testPosition($affiliate_link_used){
		$sponsor_count = User::where('affiliate_link',$affiliate_link_used)->first();
		if($sponsor_count){
			return $get_result=$this->getPlacementPosition($affiliate_link_used);
			$sponsor_id=$get_result['sponsor'];
			$upline_placement_id=$get_result['upline_placement_id'];
			$placement_position=$get_result['placement_position'];
		}
	}

	//user register
	public function insertFreeRegister(Request $request){
		//return 'test2';
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
		$city_id = $request['city_id'];
		$zip_code = $request['zip_code'];
		$address = $request['address'];

		//user affiliate link
		$affiliate_link_used = session('user_affiliate_val');
		//$affiliate_link_used='a176619';
		//question who is the default sponsor, or it will automatically from 15 accounts if the member did not used any affiliate links
		$sponsor_id=0; // default sponsor
		$upline_placement_id=0; // default upline placement
		$placement_position='null'; // default position
		//return 'test';
		if($affiliate_link_used){
			//return 'test1';
			$sponsor_count = User::where('affiliate_link',$affiliate_link_used)->first();
			//return 'test2';
			if($sponsor_count){
				//return 'test3';
				$get_result=$this->getPlacementPosition($affiliate_link_used);
				$sponsor_id=$get_result['sponsor'];
				$upline_placement_id=$get_result['upline_placement_id'];
				$placement_position=$get_result['placement_position'];
			}
		}else{
			$affiliate_link_used=null;
		}
	
        $affiliate_link=$this->generateAffiliateLink(7);
		
		//validation
		$invalid_username =  User::where('username',$username)->first(); 
		$invalid_email =  User::where('email',$email_address)->first(); 
		$invalid_name=0;

		//$register_name=$first_name.$last_name.$middle_name;
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
			],400);
		}else if($invalid_email){
			return response()->json([
				'message' => 'Email is already taken',
			],400);
		}else if($invalid_name>=3){
			return response()->json([
				'message' => 'Name already in use',
			],400);
		}else if(!ctype_digit($zip_code)){
			return response()->json([
				'message' => 'Invalid zip code',
			],400);
		}else if(strlen($zip_code)!=4){
			return response()->json([
				'message' => 'Zip code must be 4 numbers',
			],400);
		}else if(strlen($username)<6){
			return response()->json([
				'message' => 'Invalid username',
			],400);
		} else {
			DB::beginTransaction();		 

			try {
				//add user table
				$user = new User();
				$user->username = $username;
				$user->email = $email_address;
				$user->password = $password;
				$user->plain_password = $plain_password;
				$user->status = 1;			
				$user->affiliate_link = $affiliate_link;
				$user->affiliate_link_used = $affiliate_link_used;
				$user->userType = "user";
				$user->account_type = 1;
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
				$user_info->city_id = $city_id;
				$user_info->address = $address;
				$user_info->zip_code = $zip_code;
				$user_info->save();
				//add networks table
				$network = new Network();
				$network->sponsor_id = $sponsor_id;
				$network->user_id = $user_id;
				$network->upline_placement_id = $upline_placement_id;
				$network->placement_position = $placement_position;
				$network->package=1;
				$network->save();
						
				DB::commit();
				session(['user_affiliate_val'=>null]);
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

	private function generateAffiliateLink($length){
		$aff_link = substr(md5(rand()),0,$length);  

        $counter_link=0;  
        while($counter_link==0){
            if(!ctype_digit($aff_link)){                                                     
                $counter_link=1;
            }else{
                $aff_link = substr(md5(rand()),0,$length);
                $counter_link=0;
            }               
        }
        $counter=0;
        while($counter==0){                   
            $check_link= User::where('affiliate_link',$aff_link)->count();
            if($check_link==0){
                $counter=1;
            }else{
                $aff_link = substr(md5(rand()),0,$length);
            }
        }
        return $aff_link;
	}

	private function getPlacementPosition($affiliate_link){
		$sponsor = User::where('affiliate_link',$affiliate_link)->first();
		if($sponsor){
			$counter=0;
			$sponsor_id=$sponsor->id;
			$binary_count=2;
			$row_count=1;
			$binary_id=[];
			$all_id=[];
			//result data
			$res_position; // placement position
			$res_placement; //upline placement
			

			$get_sponsor_head = Network::where('upline_placement_id', $sponsor_id)->get();			
			if($get_sponsor_head->count()==0){
				$res_position='left';
				$res_placement=$sponsor_id;
				$counter=1;
			}else if($get_sponsor_head->count()==1){		
				foreach($get_sponsor_head as $data){
					if($data->placement_position=='left'){
						$res_position='right';				
					}else{
						$res_position='left';
					}
				}
				$res_placement=$sponsor_id;
				$counter=1;
			}else{
				$left_id=0;
				$right_id=0;
				foreach($get_sponsor_head as $data){			
					if($data->placement_position=='left'){
						$left_id=$data->user_id;
						array_push($all_id,[$data->user_id]);
					}else{
						$right_id=$data->user_id;
						array_push($all_id,[$data->user_id]);
					}
				}
				/* start row 2*/
				$get_sponsor_left = Network::where('upline_placement_id', $left_id)->get();
				$get_sponsor_right = Network::where('upline_placement_id', $right_id)->get();
				$count_rows=0;
				$checker_left=1;
				$checker_right=0;
				if($checker_left==1){
					if($get_sponsor_left->count()==0){				
						$res_position='left';
						$res_placement=$left_id;
						$counter=1;
					}else if($get_sponsor_left->count()==1){			
						foreach($get_sponsor_left as $data){
							if($data->placement_position=='left'){
								$res_position='right';
							}else{
								$res_position='left';				
							}
						}
						$res_placement=$left_id;
						$counter=1;
					}else if($get_sponsor_left->count()==2){
						$checker_right=1;
						$temp_left=[];
						$temp_right=[];
						foreach($get_sponsor_left as $data){
							$count_rows++;
							if( $data->placement_position=='left'){
								$temp_left=['user_id'=>$data->user_id,'position'=>$data->placement_position,'count'=>'1'];
								array_push($all_id,[$data->user_id]);
							}else{
								$temp_right=['user_id'=>$data->user_id,'position'=>$data->placement_position,'count'=>'2'];
								array_push($all_id,[$data->user_id]);
							}					
						}
						array_push($binary_id,$temp_left);
						array_push($binary_id,$temp_right);


					}
				}
				if($checker_right==1){
					if($get_sponsor_right->count()==0){
						$res_position='left';
						$res_placement=$right_id;
						$counter=1;
					}else if($get_sponsor_right->count()==1){
						foreach($get_sponsor_right as $data){
							if($data->placement_position=='left'){
								$res_position='right';
							}else{
								$res_position='left';				
							}
						}
						$res_placement=$right_id;
						$counter=1;
					}else if($get_sponsor_right->count()==2){
						$checker_left=1;
						$temp_left=[];
						$temp_right=[];
						foreach($get_sponsor_right as $data){
							$count_rows++;
							$temp=['user_id'=>$data->user_id,'position'=>$data->placement_position,'count'=>$count_rows];
							array_push($binary_id,$temp);
							array_push($all_id,[$data->user_id]);				
						}
						//array_push($binary_id,$temp_left);
						//array_push($binary_id,$temp_right);
						//go to 3rd row
						$binary_count*=2;
					}
				}
				/* end row 2*/


				//start 3rd row or multi row
				while($counter==0){
					$temp_binary=$binary_id;
					array_multisort(array_column($temp_binary, "count"), SORT_ASC, $temp_binary );
					if($binary_count==count($binary_id)){
						$binary_count*=2;
						$binary_id=[];
						$count_rows=0;
						foreach ($temp_binary as $d){
							//return $d['user_id'];
							$multi_data = Network::where('upline_placement_id', $d['user_id'])->get();		
							if($multi_data->count()==0){
								//end
								//return '0 '.$d['user_id'];
								$res_position='left';
								$res_placement=$d['user_id'];
								$counter=1;
								break;
							}else if($multi_data->count()==1){
								//end
								//return '1 '.$d['user_id'];
								$get_data = Network::where('upline_placement_id', $d['user_id'])->first();	
								if($get_data->placement_position=='left'){
									$res_position='right';
								}else{
									$res_position='left';				
								}
								$res_placement=$d['user_id'];
								$counter=1;
								break;
							}else if($multi_data->count()==2){
								//continue
								$temp_left=[];
								$temp_right=[];
								foreach($multi_data as $data){
									$count_rows++;
									//if( $data->placement_position=='left'){
									//	$temp_left=['user_id'=>$data->user_id,'position'=>$data->placement_position,'count'=>'1'];
									//	array_push($all_id,[$data->user_id]);
									//}else{
									//	$temp_right=['user_id'=>$data->user_id,'position'=>$data->placement_position,'count'=>'2'];
									//	array_push($all_id,[$data->user_id]);
									//}	
									$temp=['user_id'=>$data->user_id,'position'=>$data->placement_position,'count'=>$count_rows];
									array_push($binary_id,$temp);
									array_push($all_id,[$data->user_id]);
								}
								//array_push($binary_id,$temp_left);
								//array_push($binary_id,$temp_right);
							}			


						}
						//return $binary_id;
					}else{
						//end
						$counter=1;
					}
				}


			}

			//return results
			$result=array('sponsor'=>$sponsor_id,'upline_placement_id'=>$res_placement,'placement_position'=>$res_position);
			return $result;
		}
		
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

	//check username in user free register
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

	//check username in user free register
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





}
