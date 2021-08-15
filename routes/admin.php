<?php

use Illuminate\Support\Facades\Route;

Route::group([
    'namespace' => 'Orders',
    'prefix' => 'orders',
], function(){
    Route::get('/' , 'ShowController@index');
    Route::get('/{id}' , 'ShowController@show');
    Route::get('/{status}' , 'ShowController@status');
    Route::patch('/{id}/ship' , 'UpdateController@ship');
    Route::patch('/{id}/deliver' , 'UpdateController@deliver');
    Route::patch('/{id}/cancel' , 'UpdateController@cancel');

});

Route::group([
    'namespace' => 'Watches',
    'prefix' => 'watches',
] , function(){
    Route::post('/' , 'CreateController@store');
    Route::get('/' , 'ShowController@index');
    Route::get('/{id}' , 'ShowController@show');
    Route::patch('/{id}' , 'UpdateController@update');
    Route::patch('/{id}/image' , 'UpdateController@updateImage');
    Route::delete('/{id}' , 'DeleteController@destroy');
});


Route::group([
    'namespace' => 'Users',
    'prefix' => 'users',
] , function(){
    Route::get('/' , 'ShowController@index');
    Route::get('/{id}' , 'ShowController@show');
    Route::pattern('gender' , '[A-z]+');
    Route::get('/{gender}' , 'ShowController@gender');
    Route::get('/{id}/orders' , 'ShowController@getOrders');
});



