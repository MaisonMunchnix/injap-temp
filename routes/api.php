<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/get-network/{user_id}',[
	'uses'=>'MemberRegistrationController@Network'
]);

Route::get('get-networks-hidden-12022023',[
	'uses'=>'MemberRegistrationController@Networks'
]);

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
