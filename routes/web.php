<?php

use App\Http\Controllers\Account\SettingsController;
use App\Http\Controllers\Auth\SocialiteLoginController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Documentation\ReferencesController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\Logs\AuditLogsController;
use App\Http\Controllers\Logs\SystemLogsController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\OfferController;
use App\Http\Controllers\PagesController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\QuestionnaireController;
use App\Http\Controllers\SettingController;
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
    /** Projects */
    Route::get('/project', [ProjectController::class, 'index']);
    Route::get('/project/list', [ProjectController::class, 'data_list']);
    Route::get('/project/detail/{project}', [ProjectController::class, 'detail']);
    Route::get('/project/files/list/{project}', [ProjectController::class, 'project_files']);
    Route::get('/project/file/download/{file}', [ProjectController::class, 'download']);
    Route::get('/project/tab/description/{project}', [ProjectController::class, 'tab_description']);
    Route::get('/project/download/file/{file}', [ProjectController::class, 'download_file']);
    Route::post('/project/save_step2/info_ground/save/{project}', [ProjectController::class, 'save_info_ground']);
    Route::post('/project/save_step2/responses_of_question/save/{project}', [ProjectController::class, 'save_responses_of_question']);
    Route::get('/project/kanban/index', [ProjectController::class, 'kanban']);
    Route::post('/kanban/data/source', [ProjectController::class, 'kanban_data']);
    
    /** Projects members */
    Route::get('/project_member/data_list_member', [ProjectController::class, 'data_list_member']);
    Route::post('/project_member/add_member_modal_form', [ProjectController::class, 'add_member_modal_form']);
    Route::post('/project_member/delete/', [ProjectController::class, 'delete_member']);
    Route::post('/project_member/assign/{project?}', [ProjectController::class, 'assign_member']);
    /** Relaunch project */
    Route::post('/project/relaunch/summary/{project}', [ProjectController::class, 'relaunch']);
    Route::post('/project/relaunch/add/{project}', [ProjectController::class, 'add_relaunch']);
    Route::post('/project/relaunch/add2/{project}', [ClientController::class, 'add_relaunch']);
    Route::post('/project/relaunch/mark/seen', [ClientController::class, 'mark_as_seen']);
    Route::get('/project/relaunch/list/{project}', [ProjectController::class, 'relaunch_list']);
    Route::post('/project/set/start', [ProjectController::class, 'set_start']);
    Route::post('/project/set/finish', [ProjectController::class, 'set_finish']);
    Route::post('/project/set/correction', [ProjectController::class, 'set_correction']);
   
    /** Add  estimate for project */
    Route::post('/project/estimate/form/{project}', [ProjectController::class, 'estimat_form']);
    Route::post('/project/estimate/add/{project}', [ProjectController::class, 'add_estimate']);
    /* Start a project */
    Route::post('/project/start/form/{project}', [ProjectController::class, 'start_form']);
    Route::post('/project/start/add/{project}', [ProjectController::class, 'add_start']);
    /** Users */ 
    Route::get('/users/list', [UsersController::class, 'index']);
    Route::get('/users/data_list', [UsersController::class, 'data_list']);
    Route::post('/users/form/user', [UsersController::class, 'form']);
    Route::post('/users/create/user', [UsersController::class, 'store']);
    Route::post('/send/email', [UsersController::class, 'send_email']);
    Route::post('/users/save/theme', [UsersController::class, 'save_theme_mode']);
    
    Route::group(['middleware' => ['auth'] ], function() {
         // Client projects
        Route::get('/client/project/index', [ClientController::class, 'projects']);
        Route::get('/client/project/list', [ClientController::class, 'data_list']);
        /** Estimate */
        Route::post('/estimate/validation/{project}', [ClientController::class, 'estimate_validation']);
        Route::post('/project/accept/estimate/{project}', [ClientController::class, 'accept_estimate']);
        Route::post('/project/refuse/estimate/{project}', [ClientController::class, 'refuse_estimate']);
        Route::post('/project/estimate/save_refuse/{project}', [ClientController::class, 'save_refuse_estimate']);
        //Project invoice 
        Route::get('/project/invoice/preview/{invoice}', [InvoiceController::class, 'preview']);
        Route::get('/project/invoice/pdf/{invoice}', [InvoiceController::class, 'pdf']);
        Route::post('/project/invoice/checkout-form/{invoice}', [InvoiceController::class, 'checkout_form']);
        Route::post('/project/invoice/checkout/{invoice}', [InvoiceController::class, 'checkout']);
        Route::get('/project/invoice/download/{invoiceItem}', [InvoiceController::class, 'download_invoice']);
      });
    //Dashboard
    Route::get('dashboard/index', [DashboardController::class, 'index']);
    
    // settings
    Route::group(['middleware' => ['admin'] ], function() {
    Route::get('/app/setting/index', [SettingController::class, 'index']);
    Route::get('/app/setting/notification', [SettingController::class, 'notification_form']);
    Route::post('/app/setting/notification/save', [SettingController::class, 'save_sett_notification']);
    Route::get('/app/setting/general', [SettingController::class, 'general_form']);
    Route::post('/app/setting/general/save', [SettingController::class, 'save_sett_general']);
    Route::get('/app/setting/payment_method', [SettingController::class, 'payment_method_form']);
    Route::post('/app/setting/payment_method/save', [SettingController::class, 'save_sett_payment_method']);
     });
   //Dashboard
   Route::get('dashboard/index', [DashboardController::class, 'index']);
   // activity
   Route::post('/load/more/activities', [AuditLogsController::class, 'load_more']);
   
   
   Route::post('/notification/set/seen', [NotificationController::class, 'set_as_senn']);
  
   Route::post('/message/chat', [MessageController::class, 'chat']);
   Route::post('/message/send', [MessageController::class, 'message']);
   Route::post('/message/set/seen', [MessageController::class, 'mark_seen']);
   Route::post('/message/set/delete', [MessageController::class, 'mark_deleted']);
   Route::post('/message/get_message', [MessageController::class, 'get_message']);
   Route::post('/message/load/more', [MessageController::class, 'load_more']);
   Route::get('/message/download/file/{file}', [MessageController::class, 'download_file']);
   Route::post('/message/relaunch/{project}', [ClientController::class, 'relaunch']);

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
