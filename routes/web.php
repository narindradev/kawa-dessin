<?php

use App\Http\Controllers\Account\SettingsController;
use App\Http\Controllers\Auth\SocialiteLoginController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Documentation\ReferencesController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Logs\AuditLogsController;
use App\Http\Controllers\Logs\SystemLogsController;
use App\Http\Controllers\OfferController;
use App\Http\Controllers\PagesController;
use App\Http\Controllers\ProjectController;
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
    
    // Questionnaire offer
    Route::post('/questionnaireOffer/form_modal/{offer?}/{questionnaire?}', [QuestionnaireController::class, 'modal_form_offer']);
    Route::get('/questionnaireOffer/data_list_offer/{offer?}', [QuestionnaireController::class, 'data_list_offer']);
    Route::post('/questionnaireOffer/storeOffer/{offer?}/{questionnaire?}', [QuestionnaireController::class, 'storeOffer']);
    Route::post('/questionnaireOffer/deleteOffer/{questionnaire?}', [QuestionnaireController::class, 'deleteOffer']);
    
    //'Questionnaire preliminary info question
    Route::get('/questionnaire/preliminary_info', [QuestionnaireController::class, 'preliminary_info']);
    Route::get('/questionnaire/preliminary_info/data_list', [QuestionnaireController::class, 'preliminary_info_data_list']);
    Route::post('/questionnaire/preliminary_info/store', [QuestionnaireController::class, 'storePreliminary']);
    Route::post('/questionnaire/preliminary/modal_form', [QuestionnaireController::class, 'preliminary_modal']);
    Route::post('/questionnaire/deletePreliminary/{questionnaire}', [QuestionnaireController::class, 'deletePreliminary']);

    Route::get('/project', [ProjectController::class, 'index']);
    Route::get('/project/list', [ProjectController::class, 'data_list']);
    Route::get('/project/detail/{project}', [ProjectController::class, 'detail']);
    Route::get('/project/files/list/{project}', [ProjectController::class, 'project_files']);
    Route::get('/project/file/download/{file}', [ProjectController::class, 'download']);
    Route::get('/project/tab/description/{project}', [ProjectController::class, 'tab_description']);
    Route::get('/project/download/file/{file}', [ProjectController::class, 'download_file']);
    Route::post('/project/save_step2/info_ground/{project}', [ProjectController::class, 'save_info_ground']);
    
    /** Relaunch project */
    Route::post('/project/relaunch/summary/{project}', [ProjectController::class, 'relaunch']);
    Route::post('/project/relaunch/add/{project}', [ProjectController::class, 'add_relaunch']);
    Route::get('/project/relaunch/list/{project}', [ProjectController::class, 'relaunch_list']);
   
    /** Add  estimate for project */
    Route::post('/project/estimate/form/{project}', [ProjectController::class, 'estimat_form']);
    Route::post('/project/estimate/add/{project}', [ProjectController::class, 'add_estimate']);
    
    /** Users */ 
    Route::get('/users/list', [UsersController::class, 'index']);
    Route::get('/users/data_list', [UsersController::class, 'data_list']);
    Route::post('/users/form/user', [UsersController::class, 'form']);
    Route::post('/users/create/user', [UsersController::class, 'store']);
    
    
    // Client projects
    
    Route::get('/client/project/index', [ClientController::class, 'projects']);
    Route::get('/client/project/list', [ClientController::class, 'data_list']);
    /** Estimate */
    Route::post('/estimate/validation/{project}', [ClientController::class, 'estimate_validation']);
    Route::post('/project/accept/estimate/{project}', [ClientController::class, 'accept_estimate']);
    Route::post('/project/refuse/estimate/{project}', [ClientController::class, 'refuse_estimate']);
    Route::post('/project/estimate/save_refuse/{project}', [ClientController::class, 'save_refuse_estimate']);
    //Dashboard
    Route::get('dashboard/index', [DashboardController::class, 'index']);



});

//Home client 
Route::get('/home', [HomeController::class, 'index']);
Route::get('/home/index', [HomeController::class, 'index']);
Route::post('/home/request/save', [HomeController::class, 'save']);
Route::post('/user/email/exist', [UsersController::class, 'email_exist']);


/**
 * Socialite login using Google service
 * https://laravel.com/docs/8.x/socialite
 */
Route::get('/auth/redirect/{provider}', [SocialiteLoginController::class, 'redirect']);
require __DIR__.'/auth.php';
