<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::group(['prefix' => '{locale}'], function() {
    Route::post('/testing' , 'api\v1\AuthController@testing');
    Route::middleware(['auth:api'])->post('/notify' , 'api\v1\NotificationController@sendNotify');

});



Route::group(['prefix' => '{locale}'], function() {
//
Route::post('job_create','api\v1\JobController@createjobs');

Route::post('uploadimages','api\v1\JobController@uploadimages');

//users by asmaa

    Route::post('visitors','api\v1\VisitorController@AddVisitor');


    Route::get('listofnotifications','api\v1\NotifyController@shownotifications')->middleware(['auth:api']);

    Route::get('listofcities','api\v1\CityController@cities');

    Route::get('listofsponsers','api\v1\SponserController@listofsponsers');

    Route::get('listofjobs','api\v1\CityController@jobs');

//    Route::get('termsconditions','api\v1\ConditionController@terms_condtions');

    Route::post('create_inquiry','api\v1\LawercaseController@create_inquiry')->middleware(['auth:api']);


    //consulations
    Route::post('Requestconsultation','api\v1\consultationController@Requestconsultation')->middleware(['auth:api']);

    Route::get('Myconsulting','api\v1\consultationController@detailconsulting')->middleware(['auth:api']);

    Route::get('videoconsultations','api\v1\consultationController@videoconsultations')->middleware(['auth:api']);

    Route::get('typeconsultations','api\v1\consultationController@typeconsultations')->middleware(['auth:api']);

    Route::get('listofconsultations','api\v1\consultationController@listofconsultations')->middleware(['auth:api']);



    //users
    Route::post('login','api\v1\AuthController@login');

    Route::post('/register' , 'api\v1\AuthController@register');

//    Route::post('password/email','api\v1\ForgotPasswordController@forgot');
//    Route::post('password/reset', 'api\v1\ForgotPasswordController@reset');

    Route::post('password/email','api\v1\ForgotPasswordController@sendResetLinkEmail');

//    Route::post('password/reset','api\v1\ResetPasswordController@reset');

//    Route::post('resetpassword','api\v1\AuthController@resetpassword');

    Route::post('changepassword','api\v1\AuthController@changepassword');

    Route::Put('updateprofile','api\v1\AuthController@updateprofile')->middleware(['auth:api']);

    Route::get('logout','api\v1\AuthController@logout')->middleware(['auth:api']);

    Route::get('showprofile','api\v1\AuthController@showprofile')->middleware(['auth:api']);
    //cases

    Route::get('listofcases','api\v1\LawercaseController@listofcases')->middleware(['auth:api']);

    Route::get('detailscases','api\v1\LawercaseController@detailscases');


   //catogeries
    Route::get('listofcatogery','api\v1\CatogeryController@listofcatogery');

    Route::get('subcatogery','api\v1\CatogeryController@subcatogery');

    Route::get('differentiationprinciples','api\v1\CatogeryController@differentiationprinciples');

    Route::get('commercial','api\v1\CatogeryController@commercial');

    Route::get('principleofgeneral','api\v1\CatogeryController@principleofgeneral');

    Route::get('mediacenter_news','api\v1\MediacenterController@mediacenter_news');

    Route::get('mediacenter_article','api\v1\MediacenterController@mediacenter_article');

    Route::get('mediacenter_video','api\v1\MediacenterController@mediacenter_video');

    Route::get('details_mediacenter','api\v1\MediacenterController@details_mediacenter');

    Route::post('contact_us','api\v1\ContactController@contact_us');

    Route::get('settings','api\v1\SettingController@settings');









});



