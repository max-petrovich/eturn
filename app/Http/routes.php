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
Route::get('/', 'BookingController@index');
Route::resource('booking', 'BookingController');


/* Admin part */
Route::group(['prefix' => 'admin', 'as' => 'admin', 'namespace' => 'Admin'], function() {
});
/* Api*/
Route::group(['prefix' => 'api/v1'], function () {
    Route::get('services', 'Api\ServiceController@services');
});

/**
 * Angular routing
 */
/**
 * Angular Templates
 */
Route::group(array('prefix'=>'/templates/'),function(){
    Route::get('{template}', [ function($template)
        {
            $template = str_replace(".html","",$template);
            View::addExtension('html','php');
            return View::make('angular.'.$template);
        }]);
});