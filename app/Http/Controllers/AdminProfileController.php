<?php
namespace App\Http\Controllers;
use App\User;
use App\UserLog;
use App\UserInfo;
use App\ProductCode;
use App\Referral;
use App\Network;
use App\Province;
use App\City;
use Illuminate\Support\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class AdminProfileController extends Controller {

    /**

     * Create a new controller instance.

     *

     * @return void

     */


    /**

     * Show the application dashboard.

     *

     * @return \Illuminate\Contracts\Support\Renderable

     */





    public function viewProfile(){
        $auth_id =Auth::id();
        $province="";
        $city="";
        $user_data = DB::table('users')
            ->join('user_infos', 'user_infos.user_id', '=', 'users.id')
            ->select('users.id AS u_id','users.username AS uname','users.created_at AS user_created_at','users.email','user_infos.*')
            ->where('users.id',$auth_id)
            ->first();

        if(!empty($user_data)){
            $get_prov = Province::select('provDesc')->where('provCode',$user_data->province_id)->first();
            if(!empty($get_prov)){
                $province = $get_prov->provDesc;
            }

            $get_city=City::select('citymunDesc')->where('cityMunCode',$user_data->city_id)->first();
            if(!empty($get_city)){
                $city = $get_city->citymunDesc;
            }   
        }
        
        //return response()->json($user_data,400);

        return view('admin.profile.index',compact('auth_id','user_data','province','city'));           
    }

    

    public function updateMemberProfile(Request $request){

        //user info

        $auth_id =Auth::id();
        $first_name = $request['first_name'];
        $last_name = $request['last_name'];
        $middle_name = $request['middle_name'];
        $mobile_no = $request['mobile_no'];
        $gender = $request['gender'];
        $birth_date = $request['birth_date'];
        $address = $request['address'];
        $province_id = $request['province_id'];
        $city_id = $request['city_id'];
        $validator = Validator::make($request->all(), [       
            'first_name' => 'required',
            'last_name' => 'required',
            'mobile_no' => 'required',
            'gender' => 'required',
            'birth_date' => 'required',
            'address' => 'required',
            'province_id' => 'required',
            'city_id' => 'required',
        ]);

        $check_user_info = UserInfo::where('first_name',$first_name)->where('last_name',$last_name)->where('middle_name',$middle_name)->where('user_id','!=',$auth_id)->count();
        if($check_user_info>=1){
            return response()->json([
				'message' => 'Duplicate name',
			],400);
        } else if ($validator->fails()) {
            return response()->json([
                'message' => 'Please check empty or invalid input fields.',
            ],400);
        }else if(!ctype_digit($mobile_no)){
			return response()->json([
				'message' => 'Invalid mobile number',
			],400);
		}else if(strlen($mobile_no)!=11){
			return response()->json([
				'message' => 'Mobile number must be 11 digits',
			],400);
		}else{
            DB::beginTransaction();		
            try {

                
                $user_info = UserInfo::where('user_id',$auth_id)->first();
				$user_info->first_name = $first_name;
				$user_info->middle_name = $middle_name;
				$user_info->last_name = $last_name;
				$user_info->mobile_no = $mobile_no;
				$user_info->gender = $gender;
				$user_info->birthdate = date('Y-m-d',strtotime($birth_date));
				$user_info->province_id = $province_id;
				$user_info->city_id = $city_id;
                $user_info->address = $address;
				$user_info->save();

				// Insert User Log
				$user_log =  new UserLog();
				$user_log->user_id = Auth::id();
				$user_log->description = 5; //Update Profile
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
				$user_log->description = 5; //Update Profile
				$user_log->status = "Error"; 
				$user_log->error = $e->getMessage();
				$user_log->save();
				return response()->json([
					'message' => $e->getMessage(),
				],400);
			}
        }
    }

    public function updateAccountProfile(Request $request){
        //user info
        $auth_id = Auth::id();
        //$user_name = $request['user_name'];
        $email = $request['email'];
        //$team_name = $request['team_name'];
        //$bank_name = $request['bank_name'];
        //$account_number = $request['account_number'];
        //$tin = $request['tin'];

        $validator = Validator::make($request->all(), [       
            //'user_name' => 'required',
            'email' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Please check empty or invalid input fields.',
            ],400);
        }else{
            DB::beginTransaction();		
            try {

                $user = User::find($auth_id);
				//$user->username = $user_name;
				$user->email = $email;
				$user->save();		
                
                $user_info = UserInfo::where('user_id',$auth_id)->first();
				$user_info->save();	
                
				// Insert User Log
				$user_log =  new UserLog();
				$user_log->user_id = Auth::id();
				$user_log->description = 5; //Update Profile
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
				$user_log->description = 5; //Update Profile
				$user_log->status = "Error"; 
				$user_log->error = $e->getMessage();
				$user_log->save();
				return response()->json([
					'message' => $e->getMessage(),
				],400);
			}
        }
    }
	

	 public function updateMemberPassword(Request $request){

        //user info

        $auth_id = Auth::id();
        $current_password = $request['current_password'];
        $new_password = $request['new_password'];
        $confirm_password = $request['confirm_password'];

        $validator = Validator::make($request->all(), [       
            'current_password' => 'required',
            'new_password' => 'required',
            'confirm_password' => 'required'
        ]);

        $user = User::where('id',$auth_id)->first();

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Please check empty or invalid input fields.',
            ],400);

        }else if(!Hash::check($current_password, $user->password)){
            return response()->json([
				'message' => 'Wrong Password',
			],400);

        }else if($new_password != $confirm_password){
            return response()->json([
				'message' => 'Password Not match',
			],400);

        }else if(Hash::check($current_password, $user->password)){
            DB::beginTransaction();		
            try {
                $user = User::find($auth_id);
				$user->password = bcrypt($new_password);
				$user->plain_password = $new_password;
				$user->save();

				// Insert User Log
				$user_log =  new UserLog();
				$user_log->user_id = Auth::id();
				$user_log->description = 4; //Change Password
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
				$user_log->description = 4; //Change Password
				$user_log->status = "Error"; 
				$user_log->error = $e->getMessage();
				$user_log->save();

				return response()->json([
					'message' => $e->getMessage(),
				],400);

			}

        }

    }



    public function updateMemberPicture(Request $request){

        $validator = Validator::make($request->all(), [
            'member-photo' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Please check empty input field',
            ],400);

        }else{
            DB::beginTransaction();
            
            $auth_id = Auth::id();
            $get_old_pic = UserInfo::select('profile_picture')->where('user_id',$auth_id)->first();
            try {
                if($request->hasfile('member-photo')){
                    $file = $request->file('member-photo');
                    $name = $file->getClientOriginalName();
                    $path = 'assets/img/user_photo/' . $auth_id.'/';
                    
                    if(!File::isDirectory($path)){
                        File::makeDirectory($path, 0777, true, true);
                    }

                    if(!empty($get_old_pic)){
                        File::delete($get_old_pic->profile_picture);
                    }

                    $file->move($path, $name);
                    $user_info = UserInfo::where('user_id',$auth_id)->first();
                    $user_info->profile_picture = $path.$name;
                    $user_info->save();

                    DB::commit();

                    return response()->json([
                        'message' => 'ok',
                    ],200);

                }

            }catch(\Throwable $e){
                DB::rollback();
                return response()->json([
                    'message' => $e->getMessage(),
                ],400);
            }
        }
    }
}

