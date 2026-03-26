<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use App\Advertisement;
use App\Currency;

class LandingPageController extends Controller
{
    public function home()
    {
        $currencies = DB::table('currencies')->select('id','sell','buy')->get();
        $yen = $currencies->where('id',1)->first();
        $hkd = $currencies->where('id',2)->first();
        $usd = $currencies->where('id',3)->first();
        
        return view('landing.home', compact('yen', 'hkd', 'usd'));
    }

    public function legalAssistance()
    {
        return view('landing.legal_assistance');
    }

    public function translationService()
    {
        return view('landing.translation_service');
    }

    public function financialAssistance()
    {
        return view('landing.financial_assistance');
    }

    public function benefit()
    {
        return view('landing.benefit');
    }

    public function recruitment()
    {
        return view('landing.recruitment');
    }

    public function socialObligation()
    {
        return view('landing.social_obligation');
    }

    public function application()
    {
        // Get all active packages for member type selection
        $packages = DB::table('packages')
            ->where('status', 1)
            ->select('id', 'type', 'amount')
            ->get();
        
        return view('landing.application', compact('packages'));
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
