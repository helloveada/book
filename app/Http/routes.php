<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/', function () {
    return view('login');
});

Route::any('login','View\MemberController@login');
Route::any('register','View\MemberController@register');
Route::any('service/validate/create','Service\ValidateController@create');

Route::any('service/validate/send','Service\ValidateController@sendSMS');

Route::get('hello','HelloController@hello');
Route::get('test','TestController@test');
Route::get('show','ArticlesController@index');
