<?php

namespace App\Http\Controllers;

use App\User;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Carbon;
use Illuminate\Http\Update;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class DatatablesController extends Controller
{
    public function getIndex() {
        return view('datatables.index');
    }
    
    public function anyData() {
        //$users = User::select('id','email','created_at','updated_at');
        $users = DB::table('members_view')->select('user_id as id','email_address as email','created_at','updated_at');
        return Datatables::of($users)->make(true);
    }
}
