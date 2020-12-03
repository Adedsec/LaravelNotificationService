<?php

use App\Mail\TopicCreated;
use App\Mail\UserRegistered;
use App\Services\Notification\Notification;
use App\User;
use Illuminate\Support\Facades\Mail;
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
    return view('home');
});

Route::get('/mail', function () {
    $notification = resolve(Notification::class);
    $notification->sendEmail(User::find(1), new TopicCreated);
});

Route::get('/notification/send-email', 'NotificationController@email')->name('notification.form.email');
Route::post('/notification/send-email', 'NotificationController@sendEmail')->name('notification.send.email');
Route::get('/notification/send-sms', 'NotificationController@sms')->name('notification.form.sms');
Route::post('/notification/send-sms', 'NotificationController@sendSms')->name('notification.send.sms');
