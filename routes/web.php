<?php

declare(strict_types=1);

use App\Http\Controllers\Backend\ActionLogController;
use App\Http\Controllers\Backend\DashboardController;
use App\Http\Controllers\Backend\ModulesController;
use App\Http\Controllers\Backend\OverPassController;
use App\Http\Controllers\Backend\ParkController;
use App\Http\Controllers\Backend\PermissionsController;
use App\Http\Controllers\Backend\RolesController;
use App\Http\Controllers\Backend\UsersController;
use App\Http\Controllers\Backend\SettingsController;
use App\Http\Controllers\Backend\ProfilesController;
use App\Http\Controllers\Backend\TranslationController;
use App\Http\Controllers\Backend\UserLoginAsController;
use App\Http\Controllers\Backend\LocaleController;
use App\Http\Controllers\Backend\AmenityController;
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

require __DIR__.'/frontend.php';

//Route::get('/', 'HomeController@redirectAdmin')->name('index');
//Route::get('/home', 'HomeController@index')->name('home');

Route::get('/admin', function () {
    return redirect()->route('admin.dashboard');
});
/**
 * Admin routes.
 */
Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => ['auth']], function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('roles', RolesController::class);

    // Permissions Routes.
    Route::get('/permissions', [PermissionsController::class, 'index'])->name('permissions.index');
    Route::get('/permissions/{id}', [PermissionsController::class, 'show'])->name('permissions.show');

    // Modules Routes.
    Route::get('/modules', [ModulesController::class, 'index'])->name('modules.index');
    Route::post('/modules/toggle-status/{module}', [ModulesController::class, 'toggleStatus'])->name('modules.toggle-status');
    Route::post('/modules/upload', [ModulesController::class, 'store'])->name('modules.store');
    Route::delete('/modules/{module}', [ModulesController::class, 'destroy'])->name('modules.delete');

    // Settings Routes.
    Route::get('/settings', [SettingsController::class, 'index'])->name('settings.index');
    Route::post('/settings', [SettingsController::class, 'store'])->name('settings.store');

    // Translation Routes
    Route::get('/translations', [TranslationController::class, 'index'])->name('translations.index');
    Route::post('/translations', [TranslationController::class, 'update'])->name('translations.update');
    Route::post('/translations/create', [TranslationController::class, 'create'])->name('translations.create');

    // Login as & Switch back
    Route::resource('users', UsersController::class);
    Route::get('users/{id}/login-as', [UserLoginAsController::class, 'loginAs'])->name('users.login-as');
    Route::post('users/switch-back', [UserLoginAsController::class, 'switchBack'])->name('users.switch-back');

    // Action Log Routes.
    Route::get('/action-log', [ActionLogController::class, 'index'])->name('actionlog.index');

    Route::resource('parks', ParkController::class);

    Route::post('parks/openAi', [ParkController::class, 'openAi'])->name('parks.openAi');
    Route::post('parks/search-park', [ParkController::class, 'searchPark'])->name('parks.searchPark');

    Route::resource('campground', OverPassController::class);
    Route::get('campground-import', [OverPassController::class, 'importCreate'])->name('campground.import');
    Route::post('campground-overpass', [OverPassController::class, 'fetchCampgroundsByState'])->name('campground.overpass');

    Route::get('/review/{campground}/{filename?}', [OverPassController::class, 'track']);
    
    Route::resource('amenities', AmenityController::class);
});

/**
 * Profile routes.
 */
Route::group(['prefix' => 'profile', 'as' => 'profile.', 'middleware' => ['auth']], function () {
    Route::get('/edit', [ProfilesController::class, 'edit'])->name('edit');
    Route::put('/update', [ProfilesController::class, 'update'])->name('update');
});

Route::get('/locale/{lang}', [LocaleController::class, 'switch'])->name('locale.switch');

