<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/



Auth::routes();

Route::get('chat/us',function()
{
    return view('chat');
});
Route::get('news/read/{slug}','NewsController@read')->name('news.read');
Route::get('event/read/{slug}','EventController@read')->name('event.read');
// Route::get('transaction/distributor/chart/{id}','TransactionController@chart')->name('transaction.distributor.chart');
// Route::get('transaction/datachart','TransactionController@datachart')->name('transaction.datachart');
Route::get('401', function () {
    return view('auth.401');
})->name('error.401');
Route::get('/company/profile/download','CompanyController@download')->name('company.profile.download');

Route::get('chart/agen/{id}','HomeController@chartagen');
Route::get('data/chart/agen/{id}','HomeController@datachartagen')->name('data.agen.chart');

Route::get('chart/customer/{id}','HomeController@chartcustomer');
Route::get('data/chart/customer/{id}','HomeController@datachartcustomer')->name('data.customer.chart');

// DOWNLOAD


// AJAX
Route::get('ajax/news','NewsController@news_data')->name('ajax.data.news');
Route::get('ajax/event','EventController@event_data')->name('ajax.data.event');
Route::get('ajax/customer/agen/{id}','CustomerController@customer_data')->name('ajax.data.customer.agen');
Route::get('ajax/salesorder/agen/{id}','SalesOrderController@salesorder_data')->name('ajax.data.salesorder.agen');
Route::get('ajax/deliveryorder/agen/{id}','DeliveryOrderController@deliveryorder_data')->name('ajax.data.deliveryorder.agen');
Route::get('ajax/user','UserController@user_data')->name('ajax.data.user');
Route::get('ajax/video','VideoController@video_data')->name('ajax.data.video');
Route::post('ajax/promo','PromoController@promo_data')->name('ajax.data.promo');

Route::middleware(['auth','admin'])->group(function (){
    Route::get('/', 'HomeController@index')->name('home.index');

    Route::get('/user/profile','UserController@profile')->name('profile.user');
    Route::get('/user/profile/edit','UserController@profileedit')->name('profile.edit');
    Route::put('/user/profile','UserController@profileupdate')->name('profile.update');

    Route::resource('news', 'NewsController');


    Route::resource('event', 'EventController');



    Route::middleware(['superadmin'])->group(function (){

        // CHART
        Route::get('home/chart/1','HomeController@chart1')->name('home.chart1');
        Route::get('home/chart/2','HomeController@chart2')->name('home.chart2');
        Route::get('home/chartmonthlydo','HomeController@dataChartMonthly')->name('home.chart_monthly');
        Route::get('home/chartmonthlyso','HomeController@dataChartSoMonthly')->name('home.chart_so_monthly');
        Route::get('home/chartpieroute','HomeController@dataChartRoute')->name('home.chart_route');


        Route::get('home/voucher','HomeController@voucher')->name('home.voucher');
        Route::get('home/deliveryorder/laut','HomeController@do_laut')->name('home.delivery.laut');
        Route::get('home/deliveryorder/darat','HomeController@do_darat')->name('home.delivery.darat');
        Route::get('home/deliveryorder/critic','HomeController@critics')->name('home.delivery.critic');

        Route::resource('category', 'CategoryController');

        Route::resource('promo', 'PromoController');


        Route::resource('agen', 'AgenController');

        Route::get('customer/coupon/{id}','CouponController@index')->name('customer.coupon.index');
        Route::get('customer/coupon/create/{id}','CouponController@create')->name('customer.coupon.create');
        Route::post('customer/coupon/store','CouponController@store')->name('customer.coupon.store');
        Route::delete('customer/coupon/delete/{id}','CouponController@destroy')->name('customer.coupon.destroy');
        Route::get('customer/coupon/deleteall/{id}','CouponController@deleteall')->name('customer.coupon.deleteall');
        Route::get('customer/coupon/print/{id}','CouponController@print')->name('customer.coupon.print');

        Route::get('customer/agen/{id}','CustomerController@index')->name('customer.agen.index');
        Route::get('customer/agen/create/{id}','CustomerController@create')->name('customer.agen.create');
        Route::get('customer/agen/detail/{id}','CustomerController@show')->name('customer.agen.show');
        Route::get('customer/agen/edit/{id}','CustomerController@edit')->name('customer.agen.edit');
        Route::delete('customer/agen/{id}','CustomerController@destroy')->name('customer.agen.destroy');
        Route::post('customer/agen/store/{id}','CustomerController@store')->name('customer.agen.store');
        Route::put('customer/agen/update/{id}','CustomerController@update')->name('customer.agen.update');


        Route::get('driver/agen/{id}','DriverController@index')->name('driver.agen.index');
        Route::get('driver/agen/create/{id}','DriverController@create')->name('driver.agen.create');
        Route::get('driver/agen/detail/{id}','DriverController@show')->name('driver.agen.show');
        Route::get('driver/agen/edit/{id}','DriverController@edit')->name('driver.agen.edit');
        Route::delete('driver/agen/{id}','DriverController@destroy')->name('driver.agen.destroy');
        Route::post('driver/agen/store/{id}','DriverController@store')->name('driver.agen.store');
        Route::put('driver/agen/update/{id}','DriverController@update')->name('driver.agen.update');

        Route::get('salesorder/agen/{id}','SalesOrderController@index')->name('salesorder.agen.index');
        Route::get('salesorder/agen/create/{id}','SalesOrderController@create')->name('salesorder.agen.create');
        Route::get('salesorder/agen/detail/{id}','SalesOrderController@show')->name('salesorder.agen.show');
        Route::get('salesorder/agen/edit/{id}','SalesOrderController@edit')->name('salesorder.agen.edit');
        Route::delete('salesorder/agen/{id}','SalesOrderController@destroy')->name('salesorder.agen.destroy');
        Route::post('salesorder/agen/store/{id}','SalesOrderController@store')->name('salesorder.agen.store');
        Route::put('salesorder/agen/update/{id}','SalesOrderController@update')->name('salesorder.agen.update');
        Route::get('salesorder/agen/notif/{id}','SalesOrderController@push_notif')->name('salesorder.agen.notif');


        Route::get('deliveryorder/agen/{id}','DeliveryOrderController@index')->name('deliveryorder.agen.index');
        Route::get('deliveryorder/agen/create/{id}','DeliveryOrderController@create')->name('deliveryorder.agen.create');
        Route::get('deliveryorder/agen/detail/{id}','DeliveryOrderController@show')->name('deliveryorder.agen.show');
        Route::get('deliveryorder/agen/edit/{id}','DeliveryOrderController@edit')->name('deliveryorder.agen.edit');
        Route::delete('deliveryorder/agen/{id}','DeliveryOrderController@destroy')->name('deliveryorder.agen.destroy');
        Route::post('deliveryorder/agen/store/{id}','DeliveryOrderController@store')->name('deliveryorder.agen.store');
        Route::put('deliveryorder/agen/update/{id}','DeliveryOrderController@update')->name('deliveryorder.agen.update');
        Route::get('deliveryorder/agen/print/{id}','DeliveryOrderController@print')->name('deliveryorder.agen.print');
        Route::get('deliveryorder/agen/notif/{id}','DeliveryOrderController@push_notif')->name('deliveryorder.agen.notif');
        Route::get('deliveryorder/agen/driver/notif/{id}','DeliveryOrderController@notif_driver')->name('deliveryorder.agen.driver.notif');



        Route::get('/user','UserController@index')->name('user.index');
        Route::get('/user/{id}','UserController@show')->name('user.show');


        Route::resource('admin', 'AdminController');

        Route::resource('video', 'VideoController');
        Route::resource('card', 'CardController');
        Route::resource('product', 'ProductController');


        Route::get('/company','CompanyController@index')->name('company.index');
        Route::get('/company/edit','CompanyController@edit')->name('company.edit');
        Route::put('/company/{id}','CompanyController@update')->name('company.update');

        Route::get('/data/uploads','UploadController@create')->name('uploads.create');
        Route::post('/data/uploads','UploadController@store')->name('uploads.store');
    });
    Route::get('deliveryorder/agen/download/{id}','DeliveryOrderController@download_excel')->name('deliveryorder.agen.download');
});
