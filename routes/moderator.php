<?php

use Illuminate\Support\Facades\Route;

Route::group([
    'namespace' => 'Admins',
    'prefix' => 'admins',
] , function() {
    Route::post('/' , 'CreateController@store');
    Route::get('/' , 'ShowController@index');
    Route::get('/{id}' , 'ShowController@show');
    Route::delete('/{id}' , 'DeleteController@destroy');
});


