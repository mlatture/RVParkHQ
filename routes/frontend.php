<?php


Route::get('/', [\App\Http\Controllers\Frontend\HomeController::class, 'index'])->name('rv-park.home');
Route::get('/about', [\App\Http\Controllers\Frontend\AboutController::class, 'index'])->name('rv-park.about');
Route::get('/services', [\App\Http\Controllers\Frontend\ServiceController::class, 'index'])->name('rv-park.service');
Route::get('/contact', [\App\Http\Controllers\Frontend\ContactController::class, 'index'])->name('rv-park.contact');
