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

/* Route collection for auth */
Route::auth();

/* Client part */
Route::get('/', ['as' => 'booking', 'uses' => 'BookingController@index']);

Route::group(['middleware' => ['auth','bookingSteps'] ], function() {
    Route::resource('booking.aservices', 'BookingAdditionalService', ['only' => ['index', 'store']]);
    Route::resource('booking.aservices.master', 'BookingMaster', ['only' => ['index']]);
    Route::resource('booking.aservices.master.date', 'BookingVisitDate', ['only' => 'index']);
});


/* Admin part */
Route::group(['prefix' => 'admin', 'as' => 'admin', 'namespace' => 'Admin'], function() {
});
/* Api*/
Route::group(['prefix' => 'api/v1', 'middleware' => 'api'], function () {
    Route::get('services', 'Api\ServiceController@services');
});

/**
 * Angular Templates
 */
Route::group(['prefix'=>'/templates/'],function(){
    Route::get('{template}', [ function($template)
        {
            $template = str_replace(".html","",$template);
            View::addExtension('html','php');
            return View::make('angular.'.$template);
        }]);
});