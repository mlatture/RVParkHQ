<?php

use App\Http\Controllers\Frontend\ParkController;


Route::name('rv-park.')->group(function () {
    Route::get('/', [\App\Http\Controllers\Frontend\HomeController::class, 'index'])->name('home');
    Route::get('/about', [\App\Http\Controllers\Frontend\AboutController::class, 'index'])->name('about');
    Route::get('/services', [\App\Http\Controllers\Frontend\ServiceController::class, 'index'])->name('service');
    Route::get('/contact', [\App\Http\Controllers\Frontend\ContactController::class, 'index'])->name('contact');

    Route::prefix('en-us/parks')->controller(ParkController::class)->group(function () {
        Route::get('/', 'index')->name('park');
        Route::get('/confirm-review/{token}', 'confirmReview')->name('conform-review');
        Route::post('/pending', 'pendingReview')->name('pending-review');
        Route::get('/winner-park', 'winnerPark');
        Route::get('{slug_path}', 'show')->name('park-show');
    });
});
