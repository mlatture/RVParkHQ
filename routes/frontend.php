<?php

use App\Http\Controllers\Frontend\ParkController;
use App\Http\Controllers\Frontend\SubscriberController;


Route::name('rv-park.')->group(function () {
    Route::get('/', [\App\Http\Controllers\Frontend\HomeController::class, 'index'])->name('home');
    Route::get('/our-team', [\App\Http\Controllers\Frontend\TeamController::class, 'index'])->name('team');
    Route::get('/services', [\App\Http\Controllers\Frontend\ServiceController::class, 'index'])->name('service');
    Route::get('/contact', [\App\Http\Controllers\Frontend\ContactController::class, 'index'])->name('contact');

    Route::prefix('en-us/parks')->controller(ParkController::class)->group(function () {
        Route::get('/', 'index')->name('all-parks');
        Route::get('/confirm-review/{token}', 'confirmReview')->name('conform-review');
        Route::post('/pending', 'pendingReview')->name('pending-review');
        Route::get('/winner-park', 'winnerPark');
        Route::get('/usa', 'parkCountry')->name('park-country');
        Route::get('/{country}/{state}', 'index')->name('park');
        Route::get('{slug_path}', 'show')->name('park-show');
    });

    Route::post('/email/subscribe', [SubscriberController::class, 'store'])->name('email.subscribe');
    Route::get('/confirm-email', [SubscriberController::class, 'index'])->name('email-confirm.index');
    Route::post('/confirm-subscribe', [SubscriberController::class, 'conformSubscribe'])->name('confirm-subscribe.store');
    
    Route::get('/blogs/{slug}', [\App\Http\Controllers\Frontend\BlogController::class, 'show'])->name('blogs.show');
    Route::get('/blogs', [\App\Http\Controllers\Frontend\BlogController::class, 'index'])->name('blogs.index');

    Route::get('/suggest-park', [\App\Http\Controllers\Frontend\SuggestController::class, 'index'])->name('suggest.park');
    Route::post('/suggest-park', [\App\Http\Controllers\Frontend\SuggestController::class, 'store'])->name('suggest.park.store');
});
