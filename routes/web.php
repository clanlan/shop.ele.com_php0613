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
//
//Route::get('/', function () {
//    return view('welcome');
//})->name('index');


//修改密码
Route::get('user/resetpwd','UserController@resetpwd')->name('user.resetpwd')->middleware('auth');
Route::post('user/{user}/updatepwd','UserController@updatepwd')->name('user.updatepwd')->middleware('auth');
//账号管理
Route::resource('user','UserController')    ;

//商品分类
Route::resource('goodsCategory','GoodsCategoryController')->middleware('auth');

//排序
Route::get('goods/price','GoodsController@price')->name('goods.price')->middleware('auth');
//商品管理
Route::resource('goods','GoodsController')->middleware('auth');
//商品上下架
Route::get('goods/{good}/upsale','GoodsController@upsale')->name('goods.upsale')->middleware('auth');
Route::get('goods/{good}/downsale','GoodsController@downsale')->name('goods.downsale')->middleware('auth');

//登陆
Route::get('login','LoginController@login')->name('login');
Route::post('login','LoginController@store')->name('login.store');
Route::get('logout','LoginController@destroy')->name('logout')->middleware('auth');

//活动中心
Route::get('/activity','ActivityController@index')->name('activity.index')->middleware('auth');
Route::get('/activity/{activity}','ActivityController@show')->name('activity.show')->middleware('auth');

//订单管理
Route::get('order','OrderController@index')->name('order.index')->middleware('auth');
Route::get('order/{order}','OrderController@show')->name('order.show')->middleware('auth');
Route::get('order/{order}/cancel','OrderController@updateStatus')->name('order.updateStatus')->middleware('auth');
//首页
Route::get('/','CountController@index')->name('index');