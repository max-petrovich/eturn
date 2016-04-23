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

/* Client part */


Route::get('/', 'MainController@index');

Route::get('/home', 'HomeController@index');

/* Admin part */

Route::group(['prefix' => 'admin', 'as' => 'admin', 'namespace' => 'Admin'], function() {
    
});

Route::group(['prefix' => 'api/v1'], function () {


});

/* Api*/
Route::auth();
