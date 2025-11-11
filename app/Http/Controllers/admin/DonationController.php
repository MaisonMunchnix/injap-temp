<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\member\Donation;
use App\Referral;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DonationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $donations = DB::table('donations')
        ->select('users.username','donations.*')
        ->join('users','donations.user_id','users.id')
        ->where('donations.status',0)
        ->get();

        return view('admin.donations.index', compact('donations'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $donation = Donation::find($request->id);
        $status = $request->action;
        if($status == 'accept'){
            $stat = 1;
            $referral = new Referral();
            $referral->user_id = $donation->user_id;
            $referral->user_id = $donation->user_id;
            $referral->referral_type = 'donation_points';
            $referral->reward_type = 'points';
            $referral->status = 1;
            $referral->amount = $donation->amount * 0.10;
            $referral->save();
        } else {
            $stat = 2;
        }
       
        $donation->status = $stat;
        $donation->update();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
