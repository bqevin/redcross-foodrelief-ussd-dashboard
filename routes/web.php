<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::post('/callback/ussd', 'HomeController@ussdRequest');


Auth::routes();
Route::get('/home', 'HomeController@home')->name('home')->middleware('auth');
Route::get('/feedback', 'HomeController@todayFeedback')->name('feedback')->middleware('auth');
Route::get('/all-feedback', 'HomeController@feedback')->name('all-feedback')->middleware('auth');
Route::get('/service-request', 'HomeController@todayServiceRequest')->name('service-request')->middleware('auth');
Route::get('/all-service-request', 'HomeController@serviceRequest')->name('all-service-request')->middleware('auth');
