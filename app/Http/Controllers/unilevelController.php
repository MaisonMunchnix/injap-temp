<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\User;
use App\UnilevelSale;
use App\Unilevel;
use App\ProductCode;
use Carbon\Carbon;

class unilevelController extends Controller
{
    public function unilevel_view(){
        return view('admin.members.data-unilevel');
    }

    public function unilevel_execute(Request $request){
        
        $startDate = Carbon::now();
        $lastMonth =  $startDate->subMonth()->format('m');
        $year =  $startDate->year; 
        $unilevels =  DB::table('product_codes')
        ->select('user_id', DB::raw('COUNT(user_id) AS count'),'user_id','id')
        ->where('type', '!=', 'package')
        ->where('product_id', 3)
        ->where('user_id', '!=', null)
        ->where('status', 1)
        ->whereYear('updated_at', '=', $year)
        ->whereMonth('updated_at', '=', $lastMonth)
        ->where('id','>', $request->product_codeId)
        ->groupBy('user_id')
        ->get();
        foreach ($unilevels as $unilevel) {                
             $unilevel_sales =  DB::table('unilevel_sales')->where('user_id',  $unilevel->user_id)->where('status', 0)->whereYear('created_at', '=', $year)
            ->whereMonth('created_at', '=', $lastMonth)->count();
            if($unilevel_sales>0){
                $UnilevelSale = UnilevelSale::find($unilevel->user_id);
                if($unilevel->count >= 10){               
                 $UnilevelSale->status =1;     
                 $UnilevelSale->update();          
                }else{               
                 $UnilevelSale->status =2;   
                 $UnilevelSale->update();        
                }                                         
            }
            return  $unilevel->id;
        }
        
    }
}
