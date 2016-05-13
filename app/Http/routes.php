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
Route::get('/', 'BookingController@index')->name('booking');
// Booking
Route::group(['middleware' => ['bookingSteps'] ], function() {
    Route::resource('booking.aservices', 'BookingAdditionalService', ['only' => ['index', 'store']]);
    Route::resource('booking.aservices.master', 'BookingMaster', ['only' => ['index']]);
    Route::resource('booking.aservices.master.date', 'BookingVisitDate', ['only' => 'index']);
    Route::group(['middleware' => ['auth']], function (){
        Route::resource('booking.aservices.master.date.payment', 'BookingPayment', ['only' => 'index']);
        Route::resource('booking.aservices.master.date.payment.confirm', 'BookingConfirm', ['only' => ['index', 'store']]);
    });
});

Route::get('monitoring', 'MonitoringController@index')->name('monitoring');

Route::resource('profile', 'ProfileController');
Route::put('profile/{user}/makeMaster', 'ProfileController@makeMaster')->name('profile.makeMasters');

/**
 * ========
 * ADMIN
 * ========
 */
Route::group(['prefix' => 'admin', 'namespace' => 'Admin', 'middleware' => ['auth', 'role:admin']], function() {
    Route::get('/', 'AdminController@index');
    Route::get('orders', 'OrdersController@index')->name('admin.orders');
    Route::resource('closedDates', 'ClosedDateController', ['except' => ['show', 'update']]);
    Route::resource('services', 'ServiceController', ['except' => ['show']]);
    Route::resource('userSchedule', 'UserScheduleController', ['only' => ['index', 'edit', 'update']]);
    Route::resource('userSchedule.exceptions', 'UserScheduleExceptionController', ['only' => ['create', 'store', 'destroy']]);
    Route::resource('services.additionalServices', 'AdditionalServiceController');
    Route::resource('services.users', 'ServiceUserController');
    Route::resource('services.users.additionalService', 'AdditionalServiceUserController');
    Route::resource('users', 'UserController');
});

/**
 * =======
 * API
 * =======
 */
Route::group(['prefix' => 'api/v1', 'middleware' => 'api', 'namespace' => 'Api'], function () {
    Route::get('closedDate/all', 'ClosedDateController@all');
    Route::get('monitoring', 'MonitoringController@get');
    Route::group(['prefix' => 'booking'], function (){
        Route::get('getAvailableIntervals/{date}/{masterId}/{serviceId}/{additionalServicesIds}', 'BookingVisitDateController@getAvailableIntervals');
    });
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