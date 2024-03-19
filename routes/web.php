<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Auth\EmailVerificationRequest;


Route::get('/', function () {return view('welcome');});
Route::get('/faq', function () {return view('faq');})->name('faq');
Route::get('/about', function () {return view('about');})->name('about');
Route::get('/contact', function () {return view('contact');})->name('contact');

Auth::routes();

Route::get('/email/verify', function () {return view('auth.verify');})->middleware(['auth'])->name('verification.notice');
Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
    return redirect('/home');
})->middleware(['auth', 'signed'])->name('verification.verify');

use Illuminate\Http\Request;
 
Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
 
    return back()->with('message', 'Verification link sent!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.resend');


Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::get('/coming', [App\Http\Controllers\HomeController::class, 'coming'])->name('coming');

    Route::get('/pulsa', [App\Http\Controllers\PaymentController::class, 'pulsaShow'])->name('pulsa');
    Route::post('/pulsa', [App\Http\Controllers\PaymentController::class, 'pulsaPay'])->name('pulsa.pay');

    Route::get('/topup', [App\Http\Controllers\PaymentController::class, 'topupShow'])->name('topup');
    Route::post('/topup', [App\Http\Controllers\PaymentController::class, 'topupPay'])->name('topup.pay');

    Route::get('/history', [App\Http\Controllers\PaymentController::class, 'history'])->name('history');
    
    Route::get('/profile', [App\Http\Controllers\HomeController::class, 'profile'])->name('profile');
    Route::post('/profile', [App\Http\Controllers\HomeController::class, 'profileUpdate'])->name('profile.update');
});