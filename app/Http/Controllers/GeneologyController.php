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
use App\Pair;
use Session;




class GeneologyController extends Controller
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

    private $open_logo = "/images/badge-open.png";
    private $close_logo = "/images/badge-closed.png";
    private $free_logo = "/images/badge-free.png";
    private $silver_logo = "/images/badge-05-small.png";
    private $gold_logo = "/images/badge-07-small.png";

    private $diamond_logo = "/images/badge-06-small.png";


    public function viewGeneology($user_id){
        $auth_id =Auth::id();
        $get_user_id = Crypt::decrypt($user_id);
        return view('user.geneology.index',compact('auth_id','get_user_id','user_id'));
    }

    public function viewGeneologyDev($user_id){
        $auth_id =Auth::id();
        $get_user_id = Crypt::decrypt($user_id);
        return view('user.geneology.index_dev',compact('auth_id','get_user_id','user_id'));
    }


    public function getGeneoData($uid){
        $user_id = Crypt::decrypt($uid);
        //$user_id = 77;
        $binary_count=1;
        $result_data=""; //global result data
        $array_id=[$user_id];
        $counter=0;
        $count_rows=0;
		$checker_left=0;
        $checker_right=0;

        $array_user_id=[];
        $row_array=[];
        $var_name="row";
        $row_count=1;
        //test here

        $test_sponsor_head = Network::where('upline_placement_id', $user_id)->get();
        $var_name="row".$row_count;
        $tempo=[$var_name=>$user_id];
        $result_data=$this->AppendGeneo($row_count,$binary_count,$array_id);
        array_push($row_array,$tempo);
        if(count($test_sponsor_head)==0){
            //return 'end'; //no downline
            $row_count++;
            $binary_count*=2;
            $var_name="row".$row_count;
            array_push($array_user_id,0);
            array_push($array_user_id,0);
            $result_data.=$this->AppendGeneo($row_count,$binary_count,$array_user_id);
            while($binary_count!=16){
                $row_count++;
                $binary_count*=2;
                $array_user_id=[];
                for($i=0;$i<$binary_count;$i++){
                    array_push($array_user_id,0);
                }
                $result_data.=$this->AppendGeneo($row_count,$binary_count,$array_user_id);
            }
        }else{
            $binary_count*=2;
            $row_count++;
            $counter_test=0;
            $id_left=0;
            $id_right=0;
            foreach($test_sponsor_head as $data){
                if($data->placement_position=='left'){
                    $id_left=$data->user_id;
                }else{
                    $id_right=$data->user_id;
                }
            }
            $var_name="row".$row_count;
            array_push($array_user_id,$id_left);
            array_push($array_user_id,$id_right);
            $tempo=[$var_name=>$id_left];
            array_push($row_array,$tempo);
            $tempo=[$var_name=>$id_right];
            array_push($row_array,$tempo);



            $result_data.=$this->AppendGeneo($row_count,$binary_count,$array_user_id);

            while($counter_test==0){
                $temp_id=$array_user_id;
                $array_user_id=[];
                $zero=array_unique($temp_id);
                if(count($zero)==0){
                    $counter_test=1;
                }else{
                    $binary_count*=2;
                    $row_count++;
                    $var_name="row".$row_count;
                    foreach($temp_id as $id){
                        if($id==0 || $id==""  || $id=="0"){
                            array_push($array_user_id,0);
                            $tempo=[$var_name=>0];
                            array_push($row_array,$tempo);

                            array_push($array_user_id,0);
                            $tempo=[$var_name=>0];
                            array_push($row_array,$tempo);
                        }else{

                            $multi_data = Network::where('upline_placement_id', $id)->get();
                            if(count($multi_data)==0){
                                array_push($array_user_id,0);
                                $tempo=[$var_name=>0];
                                array_push($row_array,$tempo);

                                array_push($array_user_id,0);
                                $tempo=[$var_name=>0];
                                array_push($row_array,$tempo);
                            }else if(count($multi_data)==1){
                                $id_left=0;
                                $id_right=0;
                                foreach($multi_data as $data){
                                    if($data->placement_position=='left'){
                                        $id_left=$data->user_id;
                                        $id_right=0;
                                    }else{
                                        $id_left=0;
                                        $id_right=$data->user_id;
                                    }
                                }
                                array_push($array_user_id,$id_left);
                                $tempo=[$var_name=>$id_left];
                                array_push($row_array,$tempo);

                                array_push($array_user_id,$id_right);
                                $tempo=[$var_name=>$id_right];
                                array_push($row_array,$tempo);
                            }else{
                                $id_left=0;
                                $id_right=0;
                                foreach($multi_data as $data){
                                    if($data->placement_position=='left'){
                                        $id_left=$data->user_id;
                                    }
                                    if($data->placement_position=='right'){
                                        $id_right=$data->user_id;
                                    }
                                }
                                array_push($array_user_id,$id_left);
                                $tempo=[$var_name=>$id_left];
                                array_push($row_array,$tempo);

                                array_push($array_user_id,$id_right);
                                $tempo=[$var_name=>$id_right];
                                array_push($row_array,$tempo);

                            }
                        }
                    }
                }
                if(count($array_user_id)!=0){
                    if(count($array_user_id)!=$binary_count){
                        $missing=$binary_count-count($array_user_id);
                        for($i=0;$i<$missing;$i++){
                            array_push($array_user_id,0);
                        }
                        $result_data.=$this->AppendGeneo($row_count,$binary_count,$array_user_id);
                    }else{
                        $result_data.=$this->AppendGeneo($row_count,$binary_count,$array_user_id);
                    }

                }else{
                    if(count($array_user_id)==0 && $binary_count<32){
                        for($i=0;$i<$binary_count;$i++){
                            array_push($array_user_id,0);
                        }
                        $result_data.=$this->AppendGeneo($row_count,$binary_count,$array_user_id);
                    }
                }
                if($binary_count>=16){
                    $counter_test=1;
                    $array_user_id=[];
                    $binary_count=0;
                }


            }
        }
        $result_data.=$this->AppendLegend();

        return response()->json([
            'data' => $result_data
        ]);
    }

    private function AppendGeneo($row_count,$binary_count,$users){
        $data="";
        $divider="";
        $data.='<div id="genea-row">';
        $view_link="";
        $view_txt="";
        foreach($users as $id){
            $user_data = $this->getUserData($id);
            $logo = "";
            $enc = Crypt::encrypt($id);
            $view_link = $enc;
            $view_txt = 'View';
            $mem_name = $user_data['full_name'];
            $uname = $user_data['user_name'];
            $username = $user_data['user_name'];
            $full_name = $user_data['full_name'];
            $account_type = $user_data['type'];
            $sponsor = $user_data['sponsor'];
            $upline = $user_data['upline'];
            $join_date = $user_data['join_date'];
            if($user_data['full_name']=='Data' || $id==0 || $id=='0'){
                $mem_name=$id;
                if($mem_name==0 || $mem_name=='0'){
                    $mem_name='Open';
                }
            }else{
                $mem_name=$user_data['full_name'];
                $name_exp=explode(" ",$mem_name);
                $mem_name=$name_exp[0];
            }
            if($account_type == 'Silver' || $account_type == 'WGC Membership'){
                $logo = $this->silver_logo;
            }else if($account_type == 'Gold'){
                $logo = $this->gold_logo;
            }else if($account_type == 'Diamond'){
                $logo = $this->diamond_logo;
            }else{
                $view_link="../../membership-registration";
                $view_txt='Add new';
                if($binary_count>=16){
                    $view_txt='add';
                }
                $logo=$this->open_logo;
                if($id==0){
                    $logo=$this->open_logo;
                }
            }

            if($id==0 || $id=='0'){
                $username="----";
                $full_name="----";
                $sponsor="----";
                $upline="----";
                $join_date="----";
                $uname='Vacant';
            }
            
            if(strlen($uname)>10){
                $uname = substr($username, 0, 10) ."..";
            }
            $data.='
                <div class="port_binary'.$row_count.' port ui-widget  ui-helper-clearfix">
                    <img src="'.$logo.'">
                    <h2>
                    <a class="toolacct" href="#">'.$uname.
                    '<span class="classic">
                    User Name :  '.$username.
                    '<br>Full Name : '.$full_name.
                    '<br>Account Type : '.$account_type.
                    '<br>Sponsor : '.$sponsor.
                    '<br>Upline : '.$upline.
                    '<br>Joining Date : '.$join_date.
                    '</span></a>
                    </h2><a href="'.$view_link.'">'.$view_txt.'</a>
                </div>';

        }
        $data.='<div class="clr"></div>';
        for($i=0;$i<$binary_count;$i++){
            $divider.='<div id="genea-devider'.$row_count.'"></div>';
        }
        $data.=$divider.'</div>';

        return $data;
    }

    private function AppendLegend(){
        $data='<br clear="all" /><br />
        <br clear="all" /><br />
        <br clear="all" /><br />
        <p class="ml-2"><strong>Legend</strong> </p>
        <div class="clr"></div>
        <div class="d-flex mb-5">
        <div class="ml-3"> <img src="'.$this->close_logo.'" alt="Closed" width="30" height="30"> Closed Position</div>
        <div class="ml-3"><img src="'.$this->open_logo.'" alt="Sign-up" width="30" height="30"> Open for Registration</div>
        <div class="ml-3"><img src="'.$this->silver_logo.'" alt="Gold" width="30" height="30"> WGC Membership</div>
        <div class="ml-3"><img src="'.$this->gold_logo.'" alt="Gold" width="30" height="30"> Gold</div>
        <div class="ml-3"><img src="'.$this->diamond_logo.'" alt="Gold" width="30" height="30"> Diamond</div>
        </div>';

        return $data;
    }

    private function getUserData($user_id){
        $result_data=[];
        $user_full_name='Data';
        $user_name='Data';
        $sponsor_name='No sponsor';
        $upline_name='No upline';
        $acc_type='Data';
        $join_date='Data';
        if(!empty($user_id) || $user_id!=0){
            $user = DB::table('users')
                ->join('user_infos', 'user_infos.user_id', '=', 'users.id')
                ->join('packages', 'users.account_type', '=', 'packages.id')
                ->select('users.id AS user_id','users.username AS uname','users.created_at AS user_created_at','user_infos.first_name','user_infos.last_name','packages.type AS package_type')
                ->where('users.id',$user_id)
                ->first();
            $network_data=Network::where('user_id',$user_id)->first();


            if(!empty($user)){
                $user_full_name=$user->first_name.' '.$user->last_name;
                $user_name=$user->uname;
                $acc_type=$user->package_type;
                $join_date=date('F d, Y',strtotime($user->user_created_at));
            }
            if(!empty($network_data)){
                $sponsor = DB::table('users')
                ->join('user_infos', 'user_infos.user_id', '=', 'users.id')
                ->select('user_infos.first_name','user_infos.last_name')
                ->where('users.id',$network_data->sponsor_id)
                ->first();
                $upline = DB::table('users')
                ->join('user_infos', 'user_infos.user_id', '=', 'users.id')
                ->select('user_infos.first_name','user_infos.last_name')
                ->where('users.id',$network_data->upline_placement_id)
                ->first();

                if(!empty($sponsor)){
                    $sponsor_name=$sponsor->first_name.' '.$sponsor->last_name;
                }
                if(!empty($upline)){
                    $upline_name=$upline->first_name.' '.$upline->last_name;
                }
            }

        }
        $result_data=['full_name'=>$user_full_name,'user_name'=>$user_name,'type'=>$acc_type,'sponsor'=>$sponsor_name,'upline'=>$upline_name,'join_date'=>$join_date];

        return $result_data;
    }

    public function viewBinaryList(){
        $auth_id =Auth::id();
        return view('user.geneology.index-binary-list',compact('auth_id'));
    }

    public function viewBinaryListData($offset){
        $auth_id = Auth::id();
        $binary_data = $this->getBinaryListData($auth_id,$offset);
        return response()->json([
            'data' => $binary_data
        ]);
    }
    
    public function viewBinaryListTop($offset){
        $auth_id = Auth::id();

        $binary_left_data = [];
        $binary_right_data = [];

        $get_downline = Network::where('upline_placement_id', $auth_id)
          ->where("sponsor_id", $auth_id)->get();
        if(!empty($get_downline)){
            if(count($get_downline) == 1){
                foreach($get_downline as $downline){
                    if($downline->placement_position == 'left'){
                        $binary_left_data = $this->getBinaryListDataTop($downline->user_id,$offset,$downline->placement_position);
                    }else{
                        $binary_right_data = $this->getBinaryListDataTop($downline->user_id,$offset,$downline->placement_position);
                    }
                    
                }
                
            }else{
                foreach($get_downline as $downline){
                    if($downline->placement_position == 'left'){
                        $binary_left_data = $this->getBinaryListDataTop($downline->user_id,$offset,$downline->placement_position);
                    }else{
                        $binary_right_data = $this->getBinaryListDataTop($downline->user_id,$offset,$downline->placement_position);
                    }   
                }
            }
        }

        //$binary_data = $this->getBinaryListData($auth_id,$offset);
        //return $this->last_network_array;
        $total = count($binary_left_data) + count($binary_right_data);
        $data = [];
        return response()->json([
            'binary_left_data' => $binary_left_data,
            'binary_right_data' => $binary_right_data,
            'total' => $total
        ]);
    }

    private function getBinaryListDataTop($uid,$offset,$top_position){
        $user_id = $uid;
        $binary_count=1;
        $result_data=""; //global result data
        $counter=0;
        $array_data=[];
        $array_data_id=[];
        $array_user_id=[];
        $var_name="level";
        $row_count=1;
        $limit = $offset;
        if($offset > 16){
            $binary_count = $offset / 2;
        }

        $get_u_data=$this->getBinaryUserDataTop('Level-0',$user_id,$top_position);
        array_push($array_data,$get_u_data);

        if($limit <= 16){
            $sponsor_head = Network::where('upline_placement_id', $user_id)
              ->where("sponsor_id", $user_id)->get();
            if(count($sponsor_head)==0){
                //return 'end'; //no downline
                $counter=1;
            }else{
                $binary_count*=2;
                $var_name="Level-".$row_count;
                $counter=0;
                foreach($sponsor_head as $data){
                    array_push($array_user_id,$data->user_id);
                    $temp_data=[$var_name=>$data->user_id];
                    array_push($array_data_id,$temp_data);
                    $temp_var_name=$var_name;
                    $get_u_data=$this->getBinaryUserDataTop($var_name,$data->user_id,$top_position);
                    array_push($array_data,$get_u_data);
                }
                while($counter==0){
                    $temp_id = [];
                    $temp_id=$array_user_id;
                    $array_user_id=[];

                    //for the limit
                    if($binary_count == $limit){
                        $counter = 1;
                    }
                    if(count($temp_id)==0){
                        $counter=1;
                    }else{            
                        $row_count++;
                        $var_name="Level-".$row_count;
                        foreach($temp_id as $id){
                            if($id!=0 || $id!=""  || $id!="0"){
                                $multi_data = Network::where('upline_placement_id', $id)
                                  ->where("sponsor_id", "!=", $id)->get();
                                if(count($multi_data)!=0){
                                    foreach($multi_data as $data){
                                        array_push($array_user_id,$data->user_id);
                                        $temp_data=[$var_name=>$data->user_id];
                                        array_push($array_data_id,$temp_data);
                                        $get_u_data=$this->getBinaryUserDataTop($var_name,$data->user_id,$top_position);
                                        array_push($array_data,$get_u_data);
                                    }
                                }
                            }
                        }
                        session(['row_count'=> $row_count]);
                    }
                    //pass to temp data
                    session(['last_network_array'=> $array_user_id]);
                    $binary_count*=2;
                }
            }
        }else{
            $array_user_id = session('last_network_array');
            $row_count = session('row_count');
            while($counter == 0){
                $temp_id = [];
                $temp_id = $array_user_id;
                $array_user_id = [];

                //for the limit
                if($binary_count == $limit){
                    $counter = 1;
                }
                if(count($temp_id)==0){
                    $counter=1;
                }else{         
                    $row_count++;
                    $var_name="Level-".$row_count;
                    foreach($temp_id as $id){
                        if($id!=0 || $id!=""  || $id!="0"){
                            $multi_data = Network::where('upline_placement_id', $id)
                              ->where("sponsor_id", "!=", $id)->get();
                            if(count($multi_data)!=0){
                                foreach($multi_data as $data){
                                    array_push($array_user_id,$data->user_id);
                                    $temp_data=[$var_name=>$data->user_id];
                                    array_push($array_data_id,$temp_data);
                                    $get_u_data=$this->getBinaryUserDataTop($var_name,$data->user_id,$top_position);
                                    array_push($array_data,$get_u_data);
                                }
                            }
                        }
                    }
                    session(['row_count'=> $row_count]);
                }
                //pass to temp data
                session(['last_network_array'=> $array_user_id]);
                $binary_count*=2;
            }
        }
        return $array_data;
        //return $row_count;
    }
  private function getBinaryListData($uid, $offset){

        $user_id = $uid;
        //$user_id = 77;
        $binary_count=1;
        $result_data=""; //global result data
        $array_id=[$user_id];
        $counter=0;
        $count_rows=0;
        $checker_left=0;
        $checker_right=0;

        $array_user_id=[];
        $row_array=[];
        $var_name="row";
        $row_count=1;
        //test here
        $downline_id = array();


        $test_sponsor_head = Network::where('upline_placement_id', $user_id)->get();
        $var_name="row".$row_count;
        $tempo=[$var_name=>$user_id];
        array_push($row_array,$tempo);
        if(count($test_sponsor_head)==0){
            //return 'end'; //no downline
            $row_count++;
            $binary_count*=2;
            $var_name="row".$row_count;
            array_push($array_user_id,0);
            array_push($array_user_id,0);
           
            if($array_user_id != 0){
                if($array_user_id != 0){
                $downline_id[$binary_count] = $array_user_id;
            }
          
            }
          
            while($binary_count!=16){
                $row_count++;
                $binary_count*=2;
                $array_user_id=[];
                for($i=0;$i<$binary_count;$i++){
                    array_push($array_user_id,0);
                }
             
                if($array_user_id != 0){
                $downline_id[$binary_count] = $array_user_id;
            }
          
            }
        }else{
            $binary_count*=2;
            $row_count++;
            $counter_test=0;
            $id_left=0;
            $id_right=0;
            foreach($test_sponsor_head as $data){
                if($data->placement_position=='left'){
                    $id_left=$data->user_id;
                }else{
                    $id_right=$data->user_id;
                }
            }
            $var_name="row".$row_count;
            array_push($array_user_id,$id_left);
            array_push($array_user_id,$id_right);
            $tempo=[$var_name=>$id_left];
            array_push($row_array,$tempo);
            $tempo=[$var_name=>$id_right];
            array_push($row_array,$tempo);



          
            if($array_user_id != 0){
                $downline_id[$binary_count] = $array_user_id;
            }
          
            while($counter_test==0){
                $temp_id=$array_user_id;
                $array_user_id=[];
                $zero=array_unique($temp_id);
                if(count($zero)==0){
                    $counter_test=1;
                }else{
                    $binary_count*=2;
                    $row_count++;
                    $var_name="row".$row_count;
                    foreach($temp_id as $id){
                        if($id==0 || $id==""  || $id=="0"){
                            array_push($array_user_id,0);
                            $tempo=[$var_name=>0];
                            array_push($row_array,$tempo);

                            array_push($array_user_id,0);
                            $tempo=[$var_name=>0];
                            array_push($row_array,$tempo);
                        }else{

                            $multi_data = Network::where('upline_placement_id', $id)->get();
                            if(count($multi_data)==0){
                                array_push($array_user_id,0);
                                $tempo=[$var_name=>0];
                                array_push($row_array,$tempo);

                                array_push($array_user_id,0);
                                $tempo=[$var_name=>0];
                                array_push($row_array,$tempo);
                            }else if(count($multi_data)==1){
                                $id_left=0;
                                $id_right=0;
                                foreach($multi_data as $data){
                                    if($data->placement_position=='left'){
                                        $id_left=$data->user_id;
                                        $id_right=0;
                                    }else{
                                        $id_left=0;
                                        $id_right=$data->user_id;
                                    }
                                }
                                array_push($array_user_id,$id_left);
                                $tempo=[$var_name=>$id_left];
                                array_push($row_array,$tempo);

                                array_push($array_user_id,$id_right);
                                $tempo=[$var_name=>$id_right];
                                array_push($row_array,$tempo);
                            }else{
                                $id_left=0;
                                $id_right=0;
                                foreach($multi_data as $data){
                                    if($data->placement_position=='left'){
                                        $id_left=$data->user_id;
                                    }
                                    if($data->placement_position=='right'){
                                        $id_right=$data->user_id;
                                    }
                                }
                                array_push($array_user_id,$id_left);
                                $tempo=[$var_name=>$id_left];
                                array_push($row_array,$tempo);

                                array_push($array_user_id,$id_right);
                                $tempo=[$var_name=>$id_right];
                                array_push($row_array,$tempo);

                            }
                        }
                    }
                }
                if(count($array_user_id)!=0){
                    if(count($array_user_id)!=$binary_count){
                        $missing=$binary_count-count($array_user_id);
                        for($i=0;$i<$missing;$i++){
                            array_push($array_user_id,0);
                        }
                      
                        if($array_user_id != 0){
                $downline_id[$binary_count] = $array_user_id;
            }
          
                    }else{
                      
                        if($array_user_id != 0){
                $downline_id[$binary_count] = $array_user_id;
            }
          
                    }

                }else{
                    if(count($array_user_id)==0 && $binary_count<32){
                        for($i=0;$i<$binary_count;$i++){
                            array_push($array_user_id,0);
                        }
                       
                        if($array_user_id != 0){
                $downline_id[$binary_count] = $array_user_id;
            }
          
                    }
                }
                if($binary_count>=16){
                    $counter_test=1;
                    $array_user_id=[];
                    $binary_count=0;
                }


            }
        }
        // $result_data.=$this->AppendLegend();
        $array_data = array();
        $level = 0;
        foreach($downline_id as $downline){
            $level++;
            foreach($downline as $down){
                if($down > 0){
                    $var_name = "LEVEL-".$level;
                    $get_u_data=$this->getBinaryUserData($var_name,$down);
                    array_push($array_data,$get_u_data);
        
    
                }
            }

        }
        return $array_data;
    }

    private function getBinaryListDataX($uid,$offset){
        //$user_id = Crypt::decrypt($uid);
        $user_id = $uid;
        $binary_count=1;
        $result_data=""; //global result data
        $counter=0;
        $array_data=[];
        $array_data_id=[];
        $array_user_id=[];
        $var_name="level";
        $row_count=1;
        $limit = $offset;
        if($offset > 16){
            $binary_count = $offset / 2;
        }

        if($limit <= 16){
            $sponsor_head = Network::where('upline_placement_id', $user_id)
                ->where("sponsor_id", "=", $user_id)
                ->get();
            if(count($sponsor_head)==0){
                //return 'end'; //no downline
                $counter=1;
            }else{
                $binary_count*=2;
                $var_name="Level-".$row_count;
                $counter=0;
                foreach($sponsor_head as $data){

                    $this->updateLevel($data->user_id, $row_count);

                    array_push($array_user_id,$data->user_id);
                    $temp_data=[$var_name=>$data->user_id];
                    array_push($array_data_id,$temp_data);
                    $temp_var_name=$var_name;
                    $get_u_data=$this->getBinaryUserData($var_name,$data->user_id);
                    array_push($array_data,$get_u_data);
                }
                while($counter==0){
                    $temp_id = [];
                    $temp_id=$array_user_id;
                    $array_user_id=[];

                    //for the limit
                    if($binary_count == $limit){
                        $counter = 1;
                    }
                    if(count($temp_id)==0){
                        $counter=1;
                    }else{            
                        $row_count++;
                        $var_name="Level-".$row_count;
                        foreach($temp_id as $id){
                            if($id!=0 || $id!=""  || $id!="0"){
                                $multi_data = Network::where('upline_placement_id', $id)
                                ->where("sponsor_id", "!=", $id)->get();
                                if(count($multi_data)!=0){
                                    foreach($multi_data as $data){

                                        $this->updateLevel($data->user_id, $row_count);
                                                                                
                                        array_push($array_user_id,$data->user_id);
                                        $temp_data=[$var_name=>$data->user_id];
                                        array_push($array_data_id,$temp_data);
                                        $get_u_data=$this->getBinaryUserData($var_name,$data->user_id);
                                        array_push($array_data,$get_u_data);
                                    }
                                }
                            }
                        }
                        session(['row_count'=> $row_count]);
                    }
                    //pass to temp data
                    session(['last_network_array'=> $array_user_id]);
                    $binary_count*=2;
                }
            }
        }else{
            $array_user_id = session('last_network_array');
            $row_count = session('row_count');
            while($counter == 0){
                $temp_id = [];
                $temp_id = $array_user_id;
                $array_user_id = [];

                //for the limit
                if($binary_count == $limit){
                    $counter = 1;
                }
                if(count($temp_id)==0){
                    $counter=1;
                }else{         
                    $row_count++;
                    $var_name="Level-".$row_count;
                    foreach($temp_id as $id){
                        if($id!=0 || $id!=""  || $id!="0"){
                            $multi_data = Network::where('upline_placement_id', $id)
                            ->where("sponsor_id", "!=", $id)->get();
                            if(count($multi_data)!=0){
                                foreach($multi_data as $data){

                                    $this->updateLevel($data->user_id, $row_count);

                                    array_push($array_user_id,$data->user_id);
                                    $temp_data=[$var_name=>$data->user_id];
                                    array_push($array_data_id,$temp_data);
                                    $get_u_data=$this->getBinaryUserData($var_name,$data->user_id);
                                    array_push($array_data,$get_u_data);
                                }
                            }
                        }
                    }
                    session(['row_count'=> $row_count]);
                }
                //pass to temp data
                session(['last_network_array'=> $array_user_id]);
                $binary_count*=2;
            }
        }
        return $array_data;
        //return $row_count;
    }

    private function updateLevel($userId, $newLevel)
    {
        $network = Network::where('user_id', $userId)->whereNull('level')->first();

        if ($network) {
            $network->update(['level' => $newLevel]);
        }
    }

    private function getBinaryListDataOLD($uid){
        //$user_id = Crypt::decrypt($uid);
        $user_id = $uid;
        $binary_count=1;
        $result_data=""; //global result data
        $counter=0;
        $array_data=[];
        $array_data_id=[];
        $array_user_id=[];
        $var_name="level";
        $row_count=1;

        $sponsor_head = Network::where('upline_placement_id', $user_id)->get();
        if(count($sponsor_head)==0){
            //return 'end'; //no downline
            $counter=1;
        }else{
            $binary_count*=2;
            $var_name="level".$row_count;
            $counter=0;
            foreach($sponsor_head as $data){
                array_push($array_user_id,$data->user_id);
                $temp_data=[$var_name=>$data->user_id];
                array_push($array_data_id,$temp_data);
                $temp_var_name=$var_name;
                //$data_set=['level'=>$var_name,'full_name'=>null,'user_name'=>null,'package'=>null,'reg_date'=>null,'act_date'=>null,'sponsor'=>null,'placement'=>null];
                //array_push($array_data,$data_set);
                $get_u_data=$this->getBinaryUserData($var_name,$data->user_id);
                array_push($array_data,$get_u_data);
            }
            while($counter==0){
                $temp_id=$array_user_id;
                $array_user_id=[];
                if(count($temp_id)==0){
                    $counter=1;
                }else{
                    $binary_count*=2;
                    $row_count++;
                    $var_name="level".$row_count;
                    foreach($temp_id as $id){
                        if($id!=0 || $id!=""  || $id!="0"){
                            $multi_data = Network::where('upline_placement_id', $id)->get();
                            if(count($multi_data)!=0){
                                foreach($multi_data as $data){
                                    array_push($array_user_id,$data->user_id);
                                    $temp_data=[$var_name=>$data->user_id];
                                    array_push($array_data_id,$temp_data);
                                    //$data_set=['level'=>$var_name,'full_name'=>null,'user_name'=>null,'package'=>null,'reg_date'=>null,'act_date'=>null,'sponsor'=>null,'placement'=>null];
                                    //array_push($array_data,$data_set);
                                    $get_u_data=$this->getBinaryUserData($var_name,$data->user_id);
                                    array_push($array_data,$get_u_data);
                                }
                            }
                        }
                    }
                }
            }
        }
        return $array_data;
        //return $row_count;
    }

    private function getBinaryUserData($level,$user_id){
        $full_name="No data";
        $user_name="No data";
        $package="No data";
        $reg_sort_format_date="No data";
        $reg_date="No data";
        $reg_date_time="No data";
        $act_date="No data";
        $sponsor="No data";
        $placement="No data";
        $sponsor_username="No data";
        $placement_username="No data";
        $position="No data";
        $data=[];
        $user = DB::table('users')
            ->join('user_infos', 'user_infos.user_id', '=', 'users.id')
            ->join('packages', 'users.account_type', '=', 'packages.id')
            ->join('networks', 'networks.user_id', '=', 'users.id')
            ->select('users.id AS user_id','users.username AS username','users.created_at AS user_created_at','user_infos.first_name','user_infos.last_name','packages.type AS package_type','packages.id AS package_id','networks.placement_position')
            ->where('users.id',$user_id)
            ->first();
        $network_data=Network::where('user_id',$user_id)->first();

        $sponsor_data = DB::table('users')
            ->join('user_infos', 'user_infos.user_id', '=', 'users.id')
            ->select('user_infos.first_name','user_infos.last_name','users.username')
            ->where('users.id',$network_data->sponsor_id)
            ->first();
        $placement_data = DB::table('users')
            ->join('user_infos', 'user_infos.user_id', '=', 'users.id')
            ->select('user_infos.first_name','user_infos.last_name','users.username')
            ->where('users.id',$network_data->upline_placement_id)
            ->first();
        if(!empty($user)){
            $activation=ProductCode::select('updated_at')->where('user_id',$user_id)->where('category',$user->package_id)->first();
            $full_name=$user->first_name." ".$user->last_name;
            $user_name=$user->username;
            $package=$user->package_type;
            $reg_sort_format_date=date('m-d-Y',strtotime($user->user_created_at));
            $reg_date=date('F d, Y',strtotime($user->user_created_at));
            $reg_date_time=date('M d, Y h:i a',strtotime($user->user_created_at));
            $position=$user->placement_position;
        }
        if(!empty($network_data)){
            if(!empty($sponsor_data)){
                $sponsor=$sponsor_data->first_name." ".$sponsor_data->last_name;
                $sponsor_username = $sponsor_data->username;
            }
            if(!empty($placement_data)){
                $placement=$placement_data->first_name." ".$placement_data->last_name;
                $placement_username = $placement_data->username;
            }
        }
        $data = [
            'level' => $level,
            'full_name' => $full_name,
            'user_name' => $user_name,
            'package' => $package,
            'reg_sort_format_date' => $reg_sort_format_date,
            'reg_date' => $reg_date,
            'reg_date_time' => $reg_date_time,
            'act_date' => $act_date,
            'sponsor' => $sponsor,
            'placement' => $placement,
            'sponsor_username' => $sponsor_username,
            'placement_username' => $placement_username,
            'position' => $position
        ];
        return $data;
    }

    private function getBinaryUserDataTop($level,$user_id,$top_position){
        $full_name="No data";
        $user_name="No data";
        $package="No data";
        $reg_sort_format_date="No data";
        $reg_date="No data";
        $reg_date_time="No data";
        $act_date="No data";
        $sponsor="No data";
        $placement="No data";
        $sponsor_username="No data";
        $placement_username="No data";
        $position="No data";
        $data=[];
        $user = DB::table('users')
            ->join('user_infos', 'user_infos.user_id', '=', 'users.id')
            ->join('packages', 'users.account_type', '=', 'packages.id')
            ->join('networks', 'networks.user_id', '=', 'users.id')
            ->select('users.id AS user_id','users.username AS username','users.created_at AS user_created_at','user_infos.first_name','user_infos.last_name','packages.type AS package_type','packages.id AS package_id','networks.placement_position')
            ->where('users.id',$user_id)
            ->first();
        $network_data=Network::where('user_id',$user_id)->first();

        $sponsor_data = DB::table('users')
            ->join('user_infos', 'user_infos.user_id', '=', 'users.id')
            ->select('user_infos.first_name','user_infos.last_name','users.username')
            ->where('users.id',$network_data->sponsor_id)
            ->first();
        $placement_data = DB::table('users')
            ->join('user_infos', 'user_infos.user_id', '=', 'users.id')
            ->select('user_infos.first_name','user_infos.last_name','users.username')
            ->where('users.id',$network_data->upline_placement_id)
            ->first();
        if(!empty($user)){
            $activation=ProductCode::select('updated_at')->where('user_id',$user_id)->where('category',$user->package_id)->first();
            $full_name=$user->first_name." ".$user->last_name;
            $user_name=$user->username;
            $package=$user->package_type;
            $reg_sort_format_date=date('m-d-Y',strtotime($user->user_created_at));
            $reg_date=date('F d, Y',strtotime($user->user_created_at));
            $reg_date_time=date('M d, Y h:i a',strtotime($user->user_created_at));
            $position=$user->placement_position;
        }
        if(!empty($network_data)){
            if(!empty($sponsor_data)){
                $sponsor=$sponsor_data->first_name." ".$sponsor_data->last_name;
                $sponsor_username = $sponsor_data->username;
            }
            if(!empty($placement_data)){
                $placement=$placement_data->first_name." ".$placement_data->last_name;
                $placement_username = $placement_data->username;
            }
        }
        $data = [
            'level' => $level,
            'full_name' => $full_name,
            'user_name' => $user_name,
            'package' => $package,
            'reg_sort_format_date' => $reg_sort_format_date,
            'reg_date' => $reg_date,
            'reg_date_time' => $reg_date_time,
            'act_date' => $act_date,
            'sponsor' => $sponsor,
            'placement' => $placement,
            'sponsor_username' => $sponsor_username,
            'placement_username' => $placement_username,
            'position' => $position,
            'top_position' => $top_position
        ];
        return $data;
    }

    public function getNetworkTableData(){
        //$user_id = $uid;
        $user_id =Auth::id();
        $result_data=""; //global result data
        $counter=0;
        $array_data=[];
        $array_data_id=[];
        $array_user_id=[];
        $var_name="level";
        $row_count=1;
        $limit = 16;
        $binary_count = 1;

        $sponsor_head = Network::where('upline_placement_id', $user_id)->get();
        if(count($sponsor_head)==0){
            //no downline
            $counter=1;
        }else{
            $binary_count*=2;
            $var_name="level".$row_count;
            $counter=0;
            foreach($sponsor_head as $data){
                array_push($array_user_id,$data->user_id);
                $temp_data=[$var_name=>$data->user_id];
                array_push($array_data_id,$temp_data);
                $temp_var_name=$var_name;
                $get_u_data=$this->getBinaryUserData($var_name,$data->user_id);
                array_push($array_data,$get_u_data);
            }
            while($counter==0){
                $temp_id=$array_user_id;
                $array_user_id=[];
                if($binary_count == $limit){
                    $counter = 1;
                }
                if(count($temp_id)==0){
                    $counter=1;
                }else{
                    $row_count++;
                    $var_name="level".$row_count;
                    foreach($temp_id as $id){
                        if($id!=0 || $id!=""  || $id!="0"){
                            $multi_data = Network::where('upline_placement_id', $id)->get();
                            if(count($multi_data)!=0){
                                foreach($multi_data as $data){
                                    array_push($array_user_id,$data->user_id);
                                    $temp_data=[$var_name=>$data->user_id];
                                    array_push($array_data_id,$temp_data);
                                    $get_u_data=$this->getBinaryUserData($var_name,$data->user_id);
                                    array_push($array_data,$get_u_data);
                                }
                            }
                        }
                    }
                }
                $binary_count*=2;
            }
        }
        return $array_data;
        //return $array_data_id;
    }
	
	public function viewBinaryListDataUpdated($offset)
    {
        $limit = 600;
        $network = new Network();
        $parent_id = Auth::id();
        $has_offset = false;

        $count = $network->children($parent_id, $limit)->count();

        if ($count >= $limit) {
            $has_offset = true;
            $data = Network::where('upline_placement_id', '>=', $parent_id)
                ->orderBy('created_at', 'DESC')
                
                ->get()
                ->filter(function ($value) use ($parent_id) {
                    return $value->isChild($parent_id);
                })
                ->map(function ($network) {
                    return $this->getBinaryUserData($network->level,$network->user_id);
                });
        } else {
            $data = $network->children($parent_id)
                ->reverse()
                ->map(function ($level, $id) {
                    return $this->getBinaryUserData($level, $id);
                })
                ->values();
        }
        -/* >offset($offset)
                ->limit(30) */
        $has_offset = true;
        return [
            'has_offset' => $has_offset,
            'data' => $data
        ];
    }

    public function viewBinaryListDataUpdatedCOPY($offset)
    {
        $limit = 600;
        $network = new Network();
        $parent_id = Auth::id();
        $has_offset = false;

        $count = $network->children($parent_id, $limit)->count();

        if ($count >= $limit) {
            $has_offset = true;
            $data = Network::where('upline_placement_id', '>=', $parent_id)
                ->orderBy('created_at', 'DESC')
                ->offset($offset)
                ->limit(30)
                ->get()
                ->filter(function ($value) use ($parent_id) {
                    return $value->isChild($parent_id);
                })
                ->map(function ($network) {
                    return $this->getBinaryUserData($network->level,$network->user_id);
                });
        } else {
            $data = $network->children($parent_id)
                ->reverse()
                ->map(function ($level, $id) {
                    return $this->getBinaryUserData($level, $id);
                })
                ->values();
        }

        return [
            'has_offset' => $has_offset,
            'data' => $data
        ];
    }
}
