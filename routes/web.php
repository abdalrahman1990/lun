<?php

//use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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

Route::prefix('contact_us')->group(function () {
 
    Route::get('entrepreneur/{id}', [App\Http\Controllers\EntrepreneurController::class, 'getData']);

});


//Auth::routes();

// Route::get('/welcome', [App\Http\Controllers\NotificationController::class, 'index'])->name('home');

// Route::post('/fcm-token', [App\Http\Controllers\NotificationController::class, 'updateToken'])->name('store.token');

// Route::get('/send-web-notification',[App\Http\Controllers\NotificationController::class,'notification'])->name('notification');
