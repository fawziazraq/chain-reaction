<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::group([

    'middleware' => 'api',
    'namespace' => 'App\Http\Controllers',
    'prefix' => 'auth'

    ], function ($router) {

    Route::post('login', 'AuthController@login');
    Route::post('logout', 'AuthController@logout');

    });



         Route::group([

        'middleware' => 'api',
        'namespace' => 'App\Http\Controllers',
        'prefix' => 'hr'

        ], function ($router) {

            Route::get('employees', 'HrController@employees');
            Route::post('new-employee', 'HrController@newEmployee');
            Route::put('update-state', 'HrController@updateState');
            Route::delete('delete-employee', 'HrController@deleteEmployee');

        });




        Route::group([

        'middleware' => 'api',
        'namespace' => 'App\Http\Controllers',
        'prefix' => 'employee'

        ], function ($router) {

         Route::get('profile', 'EmployeeController@profile');
         Route::put('update', 'EmployeeController@updateProfile');

         });
