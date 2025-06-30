<?php

use App\Http\Controllers\Frontend\ParkController;
use App\Http\Controllers\Frontend\SubscriberController;


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

    Route::post('/email/subscribe', [SubscriberController::class, 'store'])->name('email.subscribe');
    Route::get('/confirm-email', [SubscriberController::class, 'index'])->name('email-confirm.index');
    Route::post('/confirm-subscribe', [SubscriberController::class, 'conformSubscribe'])->name('confirm-subscribe.store');
    
    Route::get('/blogs/{slug}', [\App\Http\Controllers\frontend\BlogController::class, 'show'])->name('blogs.show');
    Route::get('/blogs', [\App\Http\Controllers\frontend\BlogController::class, 'index'])->name('blogs.index');

    Route::get('/suggest-park', [\App\Http\Controllers\Frontend\SuggestController::class, 'index'])->name('suggest.park');
    Route::post('/suggest-park', [\App\Http\Controllers\Frontend\SuggestController::class, 'store'])->name('suggest.park.store');
});
