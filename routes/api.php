
<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;
use  App\Http\Controllers;
//use Illuminate\Support\Facades\Auth;

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

                     //-------Auth routes---------//

Route::post('login', [App\Http\Controllers\AuthController::class, 'authenticate']);

Route::post('register', [App\Http\Controllers\AuthController::class, 'register']);

Route::post('refresh', [App\Http\Controllers\AuthController::class, 'refresh']);


Route::prefix('user')->group(function (){

    Route::post('logout', [App\Http\Controllers\AuthController::class, 'logout']);

    Route::post('user-profile', [App\Http\Controllers\UserController::class, 'editProfile']);

    Route::get('user-info', [App\Http\Controllers\UserController::class, 'userInfo']);

});


                    //-------jobs routes---------//

Route::prefix('job')->group(function () {

    Route::post('list', [App\Http\Controllers\JobController::class, 'list']);

    Route::post('title', [App\Http\Controllers\JobController::class, 'jobTitle']);

    Route::get('details/{id}', [App\Http\Controllers\JobController::class, 'index']);

    Route::get('job/{id}', [App\Http\Controllers\WebSiteController::class, 'getJob']);

    Route::get('cvs/{job_id}', [App\Http\Controllers\JobController::class, 'cvsJob']);

    Route::get('available', [App\Http\Controllers\JobController::class, 'availableJobs']);

    Route::get('jobs', [App\Http\Controllers\WebSiteController::class, 'availableList']);

    Route::get('general', [App\Http\Controllers\JobController::class, 'generalJobs']);

    Route::post('add', [App\Http\Controllers\JobController::class, 'store']);

    Route::post('update/{id}', [App\Http\Controllers\JobController::class, 'update']);

    Route::post('delete/{id}', [App\Http\Controllers\JobController::class, 'destroy']);

    Route::post('deleteAll', [App\Http\Controllers\JobController::class, 'deleteAll']);

    Route::get('titles', [App\Http\Controllers\WebSiteController::class, 'listOf_title']);

});


                    //----Applications routes---//

Route::prefix('contact_us')->group(function () {

    Route::post('list', [App\Http\Controllers\ApplicationController::class, 'list']);

    Route::get('details/{id}', [App\Http\Controllers\ApplicationController::class, 'index']);

    Route::post('add', [App\Http\Controllers\WebSiteController::class, 'storeApp']);

    Route::post('update/{id}', [App\Http\Controllers\ApplicationController::class, 'update']);

    Route::post('delete/{id}', [App\Http\Controllers\ApplicationController::class, 'destroy']);

    Route::post('deleteAll', [App\Http\Controllers\ApplicationController::class, 'deleteAll']);

    Route::post('add/steps', [App\Http\Controllers\WebSiteController::class, 'storeSteps']);

    //Route::get('entrepreneur', [App\Http\Controllers\EntrepreneurController::class, 'getData']);

    Route::get('generate-pdf', [App\Http\Controllers\EntrepreneurController::class, 'generatePDF']);


});

                    //----Subscribe routes---//

Route::prefix('subscribe')->group(function () {

    Route::post('list', [App\Http\Controllers\SubscriberController::class, 'list']);

    Route::post('delete/{id}', [App\Http\Controllers\SubscriberController::class, 'destroy']);

    Route::post('deleteAll', [App\Http\Controllers\SubscriberController::class, 'deleteAll']);

    Route::post('send', [App\Http\Controllers\SubscriberController::class,'send'])->name('email');

    Route::post('email', [App\Http\Controllers\SubscriberController::class, 'sendEmail']);

    Route::post('email/all', [App\Http\Controllers\SubscriberController::class, 'emailTo_all']);

    Route::post('subscribe', [App\Http\Controllers\WebSiteController::class, 'subscribe']);




});
                      //----CVs routes---//

Route::prefix('cv')->group(function () {


    Route::post('list', [App\Http\Controllers\C_vController::class, 'list']);

    Route::get('details/{id}', [App\Http\Controllers\C_vController::class, 'index']);

    Route::get('download/{file}', [App\Http\Controllers\WebSiteController::class, 'downloadFile']);

    Route::post('delete/{file}', [App\Http\Controllers\C_vController::class, 'deleteFile']);

    Route::post('deleteAll', [App\Http\Controllers\C_vController::class, 'deleteAll']);

    Route::post('add', [App\Http\Controllers\WebSiteController::class, 'storeCv']);

    Route::post('update/{id}', [App\Http\Controllers\C_vController::class, 'update']);

    Route::post('updateStatus/{id}', [App\Http\Controllers\C_vController::class, 'updateStatus']);

    Route::post('reason/{id}', [App\Http\Controllers\C_vController::class, 'cvReason']);

    Route::post('updateJob/{id}', [App\Http\Controllers\C_vController::class, 'jobCV']);

});

                    //----Rating routes---//

Route::prefix('rate')->group(function () {


    Route::get('list', [App\Http\Controllers\RateController::class, 'list']);

    Route::post('delete/{id}', [App\Http\Controllers\RateController::class, 'destroy']);

    Route::post('add', [App\Http\Controllers\WebSiteController::class, 'storeRate']);

});

                  //----Dashboard routes---//

Route::prefix('dashboard')->group(function () {

    Route::get('index', [App\Http\Controllers\DashboardController::class, 'index']);

    Route::get('notifications', [App\Http\Controllers\DashboardController::class, 'listNotification']);

    Route::get('top', [App\Http\Controllers\RateController::class, 'topRating']);

   // Route::get('view', [App\Http\Controllers\ApplicationController::class, 'show']);

    Route::post('visitors', [App\Http\Controllers\VisitorController::class, 'getVisitors']);

    Route::post('get_ip', [App\Http\Controllers\WebSiteController::class, 'getIP']);

    Route::get('recently-cv', [App\Http\Controllers\C_vController::class, 'lastCvs']);

});


            //----Firebase Notifications routes---//

Route::prefix('notification')->group(function () {

    Route::get('/send-notification', [App\Http\Controllers\NotificationController::class, 'sendNotification']);

    Route::get('/push-notificaiton', [App\Http\Controllers\NotificationController::class, 'index'])->name('push-notificaiton');

    Route::post('/fcm-token', [App\Http\Controllers\NotificationController::class, 'updateToken'])->name('store.token');

    Route::post('/send-web-notification', [App\Http\Controllers\NotificationController::class, 'sendWebNotification'])->name('send.web-notification');

    Route::post('notification',[App\Http\Controllers\NotificationController::class,'notification'])->name('notification');

});

                  //----clear cache---//

Route::get('/clear-cache', function() {

    Artisan::call('cache:clear');

    Artisan::call('config:cache');

    Artisan::call('route:cache');

    Artisan::call('route:clear');

    Artisan::call('config:cache');

    return ' Application  Cache Cleared';
});


