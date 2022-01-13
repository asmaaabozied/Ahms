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

Route::group(['prefix' => LaravelLocalization::setLocale(), 'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath']], function () {
    Route::prefix('dashboard')->name('dashboard.')->middleware(['auth'])->group(function () {
        //nes routes
        Route::resource('news_categories', 'NewsController');
//        Route::post('news/status/{id}', 'NewsController@statusPages')->name('pages.status');
        Route::resource('news_subcategories', 'SubNewsController');
        Route::get('news_subcategories/create/{cat_id}', 'SubNewsController@create')->name('news_subcategories.create_sub');

        Route::resource('newss_subcategories', 'NewssController');
        Route::resource('article_subcategories', 'ArticlesController');
        Route::resource('media_subcategories', 'MediaController');

//        NewssController   MediaController
//        Route::post('sub_news/status/{id}', 'SubNewsController@statusPages')->name('pages.status');
    });
});
