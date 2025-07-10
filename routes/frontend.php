<?php

use App\Http\Controllers\Frontend\ParkController;
use App\Http\Controllers\Frontend\SubscriberController;
use App\Http\Controllers\Frontend\AdvertiseController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\TeamController;
use App\Http\Controllers\Frontend\ServiceController;
use App\Http\Controllers\Frontend\ContactController;
use App\Http\Controllers\Frontend\BlogController;
use App\Http\Controllers\Frontend\SuggestController;
use App\Http\Controllers\Frontend\CampConnectController;

Route::name('rv-park.')->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::get('/our-team', [TeamController::class, 'index'])->name('team');
    Route::get('/services', [ServiceController::class, 'index'])->name('service');
    Route::get('/contact', [ContactController::class, 'index'])->name('contact');

    Route::prefix('en-us/parks')->controller(ParkController::class)->group(function () {
        Route::get('/', 'index')->name('all-parks');
        Route::get('/confirm-review/{token}', 'confirmReview')->name('conform-review');
        Route::post('/pending', 'pendingReview')->name('pending-review');
        Route::get('/winner-park', 'winnerPark');
        Route::get('/usa', 'parkCountry')->name('park-country');
        Route::get('/{country}/{state}', 'index')->name('park');
        Route::get('{slug_path}', 'show')->name('park-show');
        
        Route::get('{slug_path}/reviews/write', 'show')->name('park-show');
    });

    Route::get('/badges/{slug}/review-badge.png', [ParkController::class, 'generateBadge']);

    Route::controller(SubscriberController::class)->group(function () {
        Route::post('/email/subscribe', 'store')->name('email.subscribe');
        Route::get('/confirm-email', 'index')->name('email-confirm.index');
        Route::post('/confirm-subscribe', 'conformSubscribe')->name('confirm-subscribe.store'); 
    });
    
    Route::controller(BlogController::class)->group(function () {
        Route::get('/blogs/{slug}', 'show')->name('blogs.show');
        Route::get('/blogs', 'index')->name('blogs.index');
    });
    
    Route::controller(SuggestController::class)->group(function () {
        Route::get('/suggest-park', 'index')->name('suggest.park');
        Route::post('/suggest-park', 'store')->name('suggest.park.store');
    });
    
    Route::controller(AdvertiseController::class)->group(function () {
        Route::get('/advertise', 'index')->name('advertise.index');
        Route::post('/advertise/store', 'store')->name('advertise.store'); 
    });
    
    Route::get('/CampConnect', [CampConnectController::class, 'index'])->name('CampConnect.index');
});
