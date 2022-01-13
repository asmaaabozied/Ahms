<?php

Route::group(['prefix' => LaravelLocalization::setLocale(), 'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath']],
    function () {

        Route::prefix('dashboard')->name('dashboard.')->middleware(['auth'])->group(function () {

            Route::get('/', 'WelcomeController@index')->name('welcome');


            ///consulation



            Route::resource('catogeryjobs', 'CatogeryjobController')->except(['show']);

            Route::Post('catogeryjobs/status/{id}','CatogeryjobController@change_status')->name('catogeryjobs.status');







            Route::get('users/details/{id}','ConsultationRequest@detailsuser')->name('users.details');


            //messages
            Route::resource('contacts', 'ContactController')->except(['show']);

            Route::get('reportcases', 'ReportController@reportcases')->name('reportcases');

            Route::get('reportvisitor', 'ReportController@reportvisitor')->name('reportvisitor');

            Route::delete('visitors/destroy/{id}','ReportController@destroy')->name('visitors.destroy');




//            Route::Post('inquiress/status/{id}','InqyiryController@change_status')->name('inquiress.status');

            Route::Post('contacts/status/{id}','ContactController@change_status')->name('contacts.status');

            //typecases


            //tag routes
            Route::resource('tags', 'TagController')->except(['show']);



            //user routes
            Route::resource('users', 'UserController')->except(['show']);
            //setting
            Route::resource('settings', 'SettingController');

            Route::post('settings','SettingController@updateAll')->name('settings.updateAll');

            Route::post('users/block/{id}', 'UserController@block')->name('users.block');

            Route::resource('roles', 'RoleController')->except(['show']);

    });//end of dashboard routes
});




