<?php

use App\Http\Controllers\Account\SettingsController;
use App\Http\Controllers\Auth\SocialiteLoginController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\Documentation\ReferencesController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Logs\AuditLogsController;
use App\Http\Controllers\Logs\SystemLogsController;
use App\Http\Controllers\OfferController;
use App\Http\Controllers\PagesController;
use App\Http\Controllers\QuestionnaireController;
use App\Http\Controllers\UsersController;
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
    return redirect('index');
});

$menu = theme()->getMenu();
array_walk($menu, function ($val) {
    if (isset($val['path'])) {
        $route = Route::get($val['path'], [PagesController::class, 'index']);

        // Exclude documentation from auth middleware
        if (!Str::contains($val['path'], 'documentation')) {
            $route->middleware('auth');
        }
    }
});

// Documentations pages
Route::prefix('documentation')->group(function () {
    Route::get('getting-started/references', [ReferencesController::class, 'index']);
    Route::get('getting-started/changelog', [PagesController::class, 'index']);
});

Route::middleware('auth')->group(function () {
    // Account pages
    Route::prefix('account')->group(function () {
        Route::get('settings', [SettingsController::class, 'index'])->name('settings.index');
        Route::put('settings', [SettingsController::class, 'update'])->name('settings.update');
        Route::put('settings/email', [SettingsController::class, 'changeEmail'])->name('settings.changeEmail');
        Route::put('settings/password', [SettingsController::class, 'changePassword'])->name('settings.changePassword');
    });
    // Logs pages
    Route::prefix('log')->name('log.')->group(function () {
        Route::resource('system', SystemLogsController::class)->only(['index', 'destroy']);
        Route::resource('audit', AuditLogsController::class)->only(['index', 'destroy']);
    });
    //Offer 
    Route::get('/offer/index', [OfferController::class, 'index']);
    Route::post('/offer/form_modal/{offer?}', [OfferController::class, 'form_modal']);
    Route::post('/offer/store/{offer?}', [OfferController::class, 'store']);
    Route::post('/offer/delete/{offer?}', [OfferController::class, 'delete']);
    Route::get('/offer/data_list', [OfferController::class, 'data_list']);
    Route::get('/offer/detail/{offer?}', [OfferController::class, 'detail']);
    // Category
    Route::post('/category/modal_form/{offer?}/{category?}', [CategoryController::class, 'modal_form']);
    Route::post('/category/store/{offer?}/{category?}', [CategoryController::class, 'store']);
    Route::get('/category/data_list/{offer?}', [CategoryController::class, 'data_list']);
    Route::post('/category/delete/{category?}', [CategoryController::class, 'delete']);
    
    // Questionnaire
    Route::post('/questionnaire/list/{category?}', [QuestionnaireController::class, 'list']);
    Route::post('/questionnaire/modal_form/{category?}/{questionnaire?}', [QuestionnaireController::class, 'modal_form']);
    Route::post('/questionnaire/store/{category?}/{questionnaire?}', [QuestionnaireController::class, 'store']);
    Route::get('/questionnaire/data_list/{category?}', [QuestionnaireController::class, 'data_list']);
    Route::post('/questionnaire/delete/{questionnaire?}', [QuestionnaireController::class, 'delete']);
    
});

//Home client 

Route::get('/home', [HomeController::class, 'index']);
Route::get('/home/index', [HomeController::class, 'index']);
Route::post('/home/request/save', [HomeController::class, 'request']);

Route::resource('users', UsersController::class);
Route::post('/user/email/exist', [UsersController::class, 'email_exist']);
/**
 * Socialite login using Google service
 * https://laravel.com/docs/8.x/socialite
 */
Route::get('/auth/redirect/{provider}', [SocialiteLoginController::class, 'redirect']);

require __DIR__.'/auth.php';
