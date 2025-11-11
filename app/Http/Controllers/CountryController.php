<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Country;

class CountryController extends Controller
{
    public function getCountries(){
        return Country::select('id','nice_name')->where('status', 1)->get();
    }
}
