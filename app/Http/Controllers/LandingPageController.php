<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use App\Advertisement;

class LandingPageController extends Controller
{
    public function home()
    {
        return view('landing.home');
    }

    public function about()
    {
        return view('landing.about');
    }

    public function announcements()
    {
        return view('landing.announcements');
    }

    public function announcement($slug)
    {
        return view('landing.announcement');
    }

    public function products()
    {
        return view('landing.product');
    }

    public function advertisements()
    {

        $ads = DB::table('advertisements')
        ->select('users.username','advertisements.title','advertisements.slug','advertisements.content','advertisements.image')
        ->join('users','advertisements.user_id','users.id')
        ->where('advertisements.status',1)
        ->paginate(6);
        
        return view('landing.advertisements', compact('ads'));
    }

    public function advertisement($slug)
    {
        $advertisement = Advertisement::where('slug', $slug)
            ->where('status', 1)
            ->with('user')
            ->firstOrFail();

        return view('landing.advertisement', compact('advertisement'));
    }


    public function getPackage($package){
        if(!in_array($package,['silver','wgc-membership','gold','diamond'])){
            abort(404);
        }
        return view('landing.'.$package);
    }



    public function contact()
    {
        return view('landing.contact');
    }

    public function getCurrencies()
    {
        $currencies = DB::table('currencies')
            ->select('name', 'buy', 'sell')
            ->get();

        return response()->json($currencies, 200);
    }
    


}
