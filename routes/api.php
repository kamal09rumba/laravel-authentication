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


Route::group([
        "prefix" => "auth"
    ], function (){
    Route::post("register", "ApiAuthController@register");
    Route::post("login", "ApiAuthController@login");
    Route::group([
        "middleware" => "auth:api"], function (){
            Route::get("logout", "ApiAuthController@logout");
            Route::get("me", "ApiAuthController@user");
    });
});
