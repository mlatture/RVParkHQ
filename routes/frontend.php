<?php

use App\Http\Controllers\Frontend\ParkController;
use App\Http\Controllers\Frontend\StateController;
use App\Http\Controllers\Frontend\SubscriberController;
use App\Http\Controllers\Frontend\AdvertiseController;
use App\Http\Controllers\Frontend\CampConnectController;
use App\Http\Controllers\Frontend\ClaimController;
use App\Http\Controllers\Frontend\Auth\FrontendLoginController;
use App\Http\Controllers\Frontend\Auth\FrontendRegisterController;
use App\Http\Controllers\Frontend\PaymentController;
use App\Http\Controllers\Frontend\BillController;
use App\Http\Controllers\Frontend\ProfileController;
use App\Http\Controllers\Frontend\CardController;
use App\Http\Controllers\Frontend\FreeMarketingController;


// State landing pages (before rv-park group to avoid conflicts)
Route::get('/campgrounds', [StateController::class, 'index'])->name('campgrounds.index');
Route::get('/campgrounds/{state}', [StateController::class, 'show'])->name('campgrounds.show');

Route::name('rv-park.')->group(function () {
    Route::get('/', [\App\Http\Controllers\Frontend\HomeController::class, 'index'])->name('home');
    Route::get('/our-team', [\App\Http\Controllers\Frontend\TeamController::class, 'index'])->name('team');
    Route::get('/services', [\App\Http\Controllers\Frontend\ServiceController::class, 'index'])->name('service');
    Route::get('/contact', [\App\Http\Controllers\Frontend\ContactController::class, 'index'])->name('contact');

    Route::prefix('en-us/parks')->controller(ParkController::class)->group(function () {
        Route::get('/{country?}/{state?}', 'index')->name('all-parks');
        Route::get('/confirm-review/{token}', 'confirmReview')->name('conform-review')->middleware(['signed', 'throttle:10,1']); // signed link + 10 req/min
        Route::post('/pending', 'pendingReview')->name('pending-review');
        Route::get('/winner-park', 'winnerPark');
        Route::get('{slug_path}/reviews/write', 'show')->name('park-show');
    });

    Route::get('en-us/park/state', [ParkController::class, 'parkCountry'])->name('park-country');

    Route::post('/email/subscribe', [SubscriberController::class, 'store'])->name('email.subscribe');
    Route::get('/confirm-email', [SubscriberController::class, 'index'])->name('email-confirm.index');
    Route::post('/confirm-subscribe', [SubscriberController::class, 'conformSubscribe'])->name('confirm-subscribe.store');

    Route::get('/blogs/{slug}', [\App\Http\Controllers\frontend\BlogController::class, 'show'])->name('blogs.show');
    Route::get('/blogs', [\App\Http\Controllers\frontend\BlogController::class, 'index'])->name('blogs.index');

    Route::get('/suggest-park', [\App\Http\Controllers\Frontend\SuggestController::class, 'index'])->name('suggest.park');
    Route::post('/suggest-park', [\App\Http\Controllers\Frontend\SuggestController::class, 'store'])->name('suggest.park.store');

    Route::get('/advertise', [AdvertiseController::class, 'index'])->name('advertise.index');
    Route::post('/advertise/store', [AdvertiseController::class, 'store'])->name('advertise.store');

    Route::get('/CampConnect', [CampConnectController::class, 'index'])->name('CampConnect.index');

    Route::middleware('auth')->group(function () {
        Route::post('/park/favorite', [ParkController::class, 'favoritePark'])->name('park.favorite');
        Route::post('/park/unfavorite', [ParkController::class, 'unfavoritePark'])->name('park.unfavorite');
        Route::post('/modal-profile-update', [\App\Http\Controllers\Frontend\ProfileController::class, 'modalProfileUpdate'])->name('modal.profile.update');

        Route::prefix('profile')->name('profile.')->group(function () {
            Route::get('/dashboard', [ProfileController::class, 'dashboard'])->name('dashboard');
            Route::get('/favourites', [ProfileController::class, 'favourites'])->name('favourites');
            Route::get('/cards', [CardController::class, 'cards'])->name('cards');
            Route::post('/add-card', [CardController::class, 'addCard'])->name('add-card');
            Route::delete('/card/{card}', [CardController::class, 'deleteCard'])->name('delete-card');
            Route::get('/Bills', [BillController::class, 'bill'])->name('bill');
            Route::get('/Bill/payments/{id}', [BillController::class, 'paymentHistory'])->name('bill.payments');
            Route::post('/update', [ProfileController::class, 'update'])->name('update');
        });

        Route::get('/profiles/edit', [ProfileController::class, 'edit'])->name('profiles.edit');

        Route::get('/pay-bill/{token}', [PaymentController::class, 'showPaymentForm'])->name('pay-bill');
        Route::post('/pay-bill/{token}', [PaymentController::class, 'processPayment'])->name('pay-bill.process');

        Route::get('/pay-bill/card/{id}', [PaymentController::class, 'showCardPaymentFormCard'])->name('pay-bill.card');
        Route::post('/pay-bill/card/{id}', [PaymentController::class, 'processCardPayment'])->name('pay-bill.card.process');
    });

    Route::post('/claim-park', [ClaimController::class, 'store'])->name('claim-park.store');
    Route::get('/claim-park/verify/{token}', [ClaimController::class, 'verify']);
    
    Route::get('/free-marketing', [FreeMarketingController::class, 'index'])->name('free_marketing.index');
    Route::post('/log/marketing-schedule', [FreeMarketingController::class, 'marketingSchedule'])->name('log.marketing.schedule');
});

Route::post('/modal-login', [FrontendLoginController::class, 'loginModal'])->name('modal.login');
Route::post('/modal-register', [FrontendRegisterController::class, 'registerModal'])->name('modal.register');
Route::get('/frontend-verify/{id}/{hash}', [FrontendRegisterController::class, 'verify'])->name('frontend.verification.verify');


Route::get('email/verify', [FrontendLoginController::class, 'showVerificationNotice'])->name('verification.notice');
Route::get('email/verify/{id}/{hash}', [FrontendLoginController::class, 'verifyEmail'])->middleware(['signed'])->name('verification.verify');
Route::post('email/verification-notification', [FrontendLoginController::class, 'resendVerification'])->middleware(['auth', 'throttle:6,1'])->name('verification.send');
