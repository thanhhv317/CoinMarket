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

Route::get('/', function () {
    return view('welcome');
});

Route::group(['prefix'=>'coinMarket'],function(){
	Route::group(['prefix'=>'coin'],function(){
		Route::get('list',['as'=>'coinMarket.coin.list','uses'=>'CoinController@getData']);
		Route::get('api',['as'=>'coinMarket.coin.api','uses'=>'CoinController@getApi']);
		Route::get('info/{id}',['as'=>'coinMarket.coin.info','uses'=>'CoinController@getInfo']);
		Route::get('generate-pdf',['as'=>'coinMarket.coin.generate-pdf','uses'=>'CoinController@generatePDF']);
		Route::get('export-excel',['as'=>'coinMarket.coin.export-excel','uses'=>'CoinController@exportExcel']);
	});
	Route::group(['prefix'=>'detail'],function(){
		Route::get('list',['as'=>'coinMarket.detail.list','uses'=>'DetailController@getData']);
		Route::get('api',['as'=>'coinMarket.detail.api','uses'=>'DetailController@getApi']);
		
	});
	Route::group(['prefix'=>'quote'],function(){
		Route::get('list',['as'=>'coinMarket.quote.list','uses'=>'QuoteController@getData']);
		Route::get('api',['as'=>'coinMarket.quote.api','uses'=>'QuoteController@getApi']);
		Route::get('test',['as'=>'coinMarket.quote.test','uses'=>'QuoteController@testAPI']);
		
	});
});
