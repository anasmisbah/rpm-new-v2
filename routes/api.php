<?php

use Illuminate\Http\Request;

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

Route::post('login','API\AuthController@login');
Route::middleware('auth:api')->post('logout','API\AuthController@logout');

Route::get('news','API\NewsController@allnews');
Route::get('news/{id}','API\NewsController@detail');

Route::get('event','API\EventController@allevents');
Route::get('event/{id}','API\EventController@detail');

Route::get('promo','API\PromoController@allpromos');
Route::get('promo/normal','API\PromoController@promonormal');
Route::get('promo/hot','API\PromoController@promohot');
Route::get('promo/{id}','API\PromoController@detail');

Route::get('home','API\HomeController@home');

Route::get('company/profile','API\CompanyController@profile');
Route::get('company/contact','API\CompanyController@contact');

// Videos
Route::get('videos','API\VideoController@allvideos');
Route::get('videos/{id}','API\VideoController@detail');

Route::group(['middleware' => ['auth:api']], function () {
    Route::get('user/home','API\HomeController@homelogin');
    // Route::get('/me','API\UserController@me');


    // customer
    // Route::post('/delivery/code','API\DistributorController@approve');
    // Route::get('/deliveryorder','API\DistributorController@history');

    // ******LIST API AGEN*********
    // SEE SALES ORDER ALL
    Route::get('agen/salesorder','API\SalesOrderController@index');
    Route::get('agen/salesorder/{id}','API\SalesOrderController@detail');

    // SEE CUSTOMER ALL
    Route::get('agen/customer','API\CustomerController@index');
    Route::get('agen/customer/{id}','API\CustomerController@detail');

    // SEE DRIVER ALL
    Route::get('agen/driver','API\DriverController@index');
    Route::get('agen/driver/{id}','API\DriverController@detail');

    // AGEN SEE DO READY TO APPROVE
    Route::get('agen/deliveryorder','API\DeliveryOrderController@deliveryforagen');
    // AGEN APPROVE DELIVERY ORDER
    Route::get('agen/deliveryorder/approve/{id}','API\DeliveryOrderController@agenApproveDO');
    // AGEN SEE DO DETAIL
    Route::get('agen/detail/deliveryorder/{id}','API\DeliveryOrderController@detailForAgen');



    // *****LIST API CUSTOMER*********
    Route::get('/coupon','API\CouponController@index');
    Route::post('promo/take','API\PromoController@takepromo');
    Route::get('/voucher','API\VoucherController@index');
    Route::get('/voucher/{id}','API\VoucherController@detail');

    // OLD WAY BEFORE
    // Route::get('/transaction','API\TransactionController@index');
    // Route::get('/transaction/{id}','API\TransactionController@detail');


    // NEW WAY AFTER
    // LIST ALL DELIVERY ORDER
    Route::get('/deliveryorder','API\DeliveryOrderController@index');
    // DETAIL DELIVERY ORDER
    Route::get('/deliveryorder/{id}','API\DeliveryOrderController@detail');


    // *****LIST API DRIVER*******

    // SEE DELIVERY ORDER READY FOR DRIVER
    Route::get('/driver/deliveryorder','API\DeliveryOrderController@deliveryfordriver');

    // ACCEPTED DELIVERY ORDER BY DRIVER
    Route::get('/driver/accept/{id}','API\DriverController@acceptedDelivery');
    // FINISH DELIVERY ORDER AND UPLOAD BAST
    Route::post('/driver/finish','API\DriverController@finishDelivery');
    // SEE DELIVERY ORDER HISTORY
    Route::get('/driver/deliveryorder/history','API\DriverController@history');

    // API SEE HISTORY NOTIF
    Route::get('/notif/deliveryorder/{id}','API\DeliveryOrderController@historynotifdo');


    Route::get('/critics/{id}','API\CriticsController@detail');
    Route::post('/critics/{id}','API\CriticsController@store');

});

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
