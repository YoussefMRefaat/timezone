<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
    'namespace' => '\App\Http\Controllers\User\Watches',
    'prefix' => 'shop',
] , function(){
    Route::get('/new' , 'ShowController@new');
    Route::get('/highest' , 'ShowController@highest');
    Route::get('/lowest' , 'ShowController@lowest');
    Route::get('/popular' , 'ShowController@popular');
    Route::get('/{id}' , 'ShowController@show');

});

Route::group([
    'namespace' => '\App\Http\Controllers\User\Auth',
    'middleware' => 'guest',
] , function(){
    Route::post('/login' , 'AuthenticationController@login')->name('login');
    Route::post('/signup' , 'SignupController@store')->name('signup');
    Route::post('/forgot-password' , 'ResetPasswordController@send');
    Route::patch('/reset-password' , 'ResetPasswordController@reset');
});


Route::group([
    'namespace' => '\App\Http\Controllers\User',
    'middleware' => 'auth:sanctum',
] , function(){
    Route::delete('/logout' , 'Auth\AuthenticationController@logout')->name('logout');
    Route::post('/verify-email' , 'Auth\VerifyEmailController@verify');
    Route::post('/verify-email/resend' , 'Auth\VerifyEmailController@send');
    Route::get('/user' , 'Account\UpdateController@getInfo');
    Route::patch('/user' , 'Account\UpdateController@update');
    Route::patch('/user/password' , 'Account\UpdateController@updatePassword');

});



