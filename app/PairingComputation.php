<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Auth;
use DB;
use App\Network;
class PairingComputation extends Model
{




    public function pairing_count(){
       
     
        $uid =Auth::id();
        $user_id = $uid;

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
            $tempo=[array($var_name=>$id_left)];
            array_push($row_array,$tempo);
            $tempo=[array($var_name=>$id_right)];
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
      
        // dd($downline_id);
        $left_array = array();
        $right_array = array();
        foreach($downline_id as $key => $down_value){
            $divisor = $key / 2;       
            for($d =0 ; $d < $key; $d++){
                $counter = $d+1;
                if($counter <= $divisor){
                    if($down_value[$d] != 0){
                        $left_array[$key][$down_value[$d]] = $down_value[$d]; 
                    }
                }else{
                    if($down_value[$d] != 0){
                        $right_array[$key][$down_value[$d]] = $down_value[$d]; 
                    }
                }
            }
        }

        $data_pattern = $left_array;
        $other_pattern = $right_array;
        
        if(count($left_array) > count($right_array) ){
            $data_pattern = $right_array;
            $other_pattern = $left_array;
        }

        
       $total_amount = 0;
            foreach($data_pattern as $key2 => $pat){
                $last_pattern = $data_pattern[$key2];
                if(count($data_pattern[$key2]) > count($other_pattern[$key2])){
                    $last_pattern = $other_pattern[$key2];
                }

                foreach($last_pattern as $key3 => $tbl_data){
                    $account_id = DB::table("users")
                        ->where("id", $tbl_data)
                        ->value("account_type");
                  
                    $amount = DB::table("packages")
                        ->where('id', $account_id)
                        ->value("pairing_amount");
                    $total_amount += $amount;

               }
            }
        return $total_amount;
   }

   public function pairing_data(){

    $uid =Auth::id();
    $user_id = $uid;

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
        $tempo=[array($var_name=>$id_left)];
        array_push($row_array,$tempo);
        $tempo=[array($var_name=>$id_right)];
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



            // dd($downline_id);
            $left_array = array();
            $right_array = array();
            foreach($downline_id as $key => $down_value){
                $divisor = $key / 2;       
                for($d =0 ; $d < $key; $d++){
                    $counter = $d+1;
                    if($counter <= $divisor){
                        if($down_value[$d] != 0){
                            $left_array[$key][$down_value[$d]] = $down_value[$d]; 
                        }
                    }else{
                        if($down_value[$d] != 0){
                            $right_array[$key][$down_value[$d]] = $down_value[$d]; 
                        }
                    }
                }
            }

            $data_pattern = $left_array;
            $other_pattern = $right_array;
            
            if(count($left_array) > count($right_array) ){
                $data_pattern = $right_array;
                $other_pattern = $left_array;
            }


            $pair_data = array();



            $total_amount = 0;
            $column_index = 0;
            foreach($data_pattern as $key2 => $pat){
                $last_pattern = $data_pattern[$key2];
                if(count($data_pattern[$key2]) > count($other_pattern[$key2])){
                    $last_pattern = $other_pattern[$key2];
                }
                
                foreach($last_pattern as $key3 => $tbl_data){

                    $trans_data = DB::table("users")
                        ->where("id", $tbl_data)
                        ->first();
                        $user_info = DB::table("user_infos")
                            ->where("user_id", $tbl_data)
                            ->first();
                        $full_name = $user_info->first_name." ".$user_info->last_name;

                        $amount = DB::table("packages")
                            ->where('id', $trans_data->account_type)
                            ->value("pairing_amount");
                        
                        $column_index++;
                        array_push($pair_data,array(
                            "count" => $column_index,
                            "trans_id" => $tbl_data,
                            "trans_date" => $trans_data->updated_at,
                            "trans_type" => "Salesmatch Bonus",
                            "source" => $full_name,
                            "amount" => number_format($amount, 2)
                        ));

               

               }
            }
  


            return $pair_data;

    }

}