<?php

use App\Http\Controllers\Backend\Auth\ForgotPasswordController;
use App\Http\Controllers\Backend\Auth\LoginController;
use App\Http\Controllers\Backend\Auth\ResetPasswordController;

/*
|--------------------------------------------------------------------------
| Auth Routes
|--------------------------------------------------------------------------
|
| Authentication related routes.
|
*/

// Public User authentication routes.
Auth::routes();

// User authentication routes.
Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => 'guest'], function () {

    Route::get('/register', [LoginController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [LoginController::class, 'register'])->middleware('form.abuse')->name('register.submit');

    // Login Routes.
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login/submit', [LoginController::class, 'login'])->middleware('throttle:10,1')->name('login.submit');

    // Reset Password Routes.
    Route::get('/password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
    Route::post('/password/reset', [ResetPasswordController::class, 'reset'])->name('password.reset.submit');

    // Forget Password Routes.
    Route::get('/password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
    Route::post('/password/reset-password/submit', [ForgotPasswordController::class, 'reset'])->middleware('form.abuse')->name('password.update');
});

// Authenticated routes.
Route::group(['prefix' => 'admin', 'as' => 'admin.'], function () {
    // Logout Routes.
    Route::post('/logout/submit', [LoginController::class, 'logout'])->name('logout.submit');
});
