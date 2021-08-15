<?php

use Illuminate\Support\Facades\Route;

Route::group([
    'namespace' => 'Cart',
    'prefix' => 'cart',
] , function(){
    Route::post('/' , 'CreateController@store');
    Route::get('/' , 'ShowController@index');
    Route::patch('/{id}' , 'UpdateController@updateQuantity');
    Route::delete('/{id}' , 'DeleteController@destroy');
});

Route::group([
    'namespace' => 'Orders',
    'prefix' => 'orders',
] , function(){
    Route::post('/' , 'CreateController@store');
    Route::get('/' , 'ShowController@index');
});




