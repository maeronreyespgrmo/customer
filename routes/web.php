<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\FormController;
use App\Http\Controllers\PDFController;
use App\Http\Controllers\ChartController;
use App\Http\Controllers\SurveyController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\HospitalController;
use App\Http\Controllers\OfficeController;
use App\Http\Controllers\ManagerController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ImportController;
use App\Http\Controllers\ChartSettingController;
use App\Http\Controllers\TableController;
use App\Http\Controllers\WordController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return redirect('/login');
});

//LOGIN
Route::get('/login', function () {
    return view('login');
})->name('login');

//LOGIN EXEC
Route::post('/login_auth', [UserController::class, 'login']);
Route::get('/logout', [UserController::class, 'logout']);

//MIDDLEWARE
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index']);
    Route::get('/user', [DashboardController::class, 'user']);
    Route::get('/services', [DashboardController::class, 'services']);
    Route::get('/services/csm', [DashboardController::class, 'services_csm']);
    Route::get('/doctor', [DashboardController::class, 'doctor']);
    Route::get('/hospital', [DashboardController::class, 'hospital']);
    Route::get('/office', [DashboardController::class, 'office']);
    Route::get('/office/csm', [DashboardController::class, 'office_csm']);
    Route::get('/manager', [DashboardController::class, 'manager']);
    Route::get('/view/css', [DashboardController::class, 'view_css']);
    Route::get('/view/pss', [DashboardController::class, 'view_pss']);
    Route::get('/view/csm', [DashboardController::class, 'view_csm']);
    Route::get('/comments/css', [DashboardController::class, 'comments_css']);
    Route::get('/comments/pss', [DashboardController::class, 'comments_pss']);
    Route::get('/import/css', [DashboardController::class, 'import_css']);
    Route::get('/import/pss', [DashboardController::class, 'import_pss']);
    Route::get('/chart_settings', [DashboardController::class, 'chart_settings']);
});

//USER
Route::get('/select_user', [UserController::class, 'display']);
Route::post('/select_user2', [UserController::class, 'display']);
Route::post('/save_user', [UserController::class, 'create']);
Route::post('/update_user', [UserController::class, 'update']);
Route::post('/delete_user', [UserController::class, 'destroy']);
Route::post('/reactivate_user', [UserController::class, 'reactivate']);
Route::get('/search_user', [UserController::class, 'search']);

Route::post('/tb', [UserController::class, 'table']);

Route::get('/table', function () {
    return view('test_table');
});

//SERVICE MODULE CSS
Route::get('/select_services', [ServiceController::class, 'display']);
Route::post('/select_services2', [ServiceController::class, 'display']);
Route::post('/save_services', [ServiceController::class, 'create']);
Route::post('/update_services', [ServiceController::class, 'update']);
Route::post('/delete_services', [ServiceController::class, 'destroy']);

//SERVICE MODULE CSM
Route::get('/select_services_csm', [ServiceController::class, 'display_csm']);
Route::post('/select_services2_csm', [ServiceController::class, 'display_csm']);
Route::post('/save_services_csm', [ServiceController::class, 'create_csm']);
Route::post('/update_services_csm', [ServiceController::class, 'update_csm']);
Route::post('/delete_services_csm', [ServiceController::class, 'destroy_csm']);

//DOCTOR MODULE
Route::get('/select_doctor', [DoctorController::class, 'display']);
Route::post('/select_doctor2', [DoctorController::class, 'display']);
Route::post('/save_doctor', [DoctorController::class, 'create']);
Route::post('/update_doctor', [DoctorController::class, 'update']);
Route::post('/delete_doctor', [DoctorController::class, 'destroy']);

//HOSPITAL MODULE
Route::get('/select_hospital', [HospitalController::class, 'display']);
Route::post('/select_hospital2', [HospitalController::class, 'display']);
Route::post('/save_hospital', [HospitalController::class, 'create']);
Route::post('/update_hospital', [HospitalController::class, 'update']);
Route::post('/delete_hospital', [HospitalController::class, 'destroy']);

//OFFICE MODULE CSS
Route::get('/select_office', [OfficeController::class, 'display']);
Route::post('/select_office2', [OfficeController::class, 'display']);
Route::post('/save_office', [OfficeController::class, 'create']);
Route::post('/update_office', [OfficeController::class, 'update']);
Route::post('/delete_office', [OfficeController::class, 'destroy']);
Route::get('/dropdown_manager', [OfficeController::class, 'dropdown_manager']);

//OFFICE MODULE CSM
Route::get('/select_office_csm', [OfficeController::class, 'display_csm']);
Route::post('/select_office2_csm', [OfficeController::class, 'display_csm']);
Route::post('/save_office_csm', [OfficeController::class, 'create_csm']);
Route::post('/update_office_csm', [OfficeController::class, 'update_csm']);
Route::post('/delete_office_csm', [OfficeController::class, 'destroy_csm']);
Route::get('/dropdown_manager_csm', [OfficeController::class, 'dropdown_manager_csm']);


//MANAGER MODULE
Route::get('/select_manager', [ManagerController::class, 'display']);
Route::post('/select_manager2', [ManagerController::class, 'display']);
Route::post('/save_manager', [ManagerController::class, 'create']);
Route::post('/update_manager', [ManagerController::class, 'update']);
Route::post('/delete_manager', [ManagerController::class, 'destroy']);

//FORM MODULE
Route::get('/form/css', function () {
    return view('form_css');
});

Route::get('/form/pss', function () {
    return view('form_pss');
});

Route::get('/form/csm', function () {
    return view('form_csm');
});

Route::get('/reports/css', function () {
    return view('report_css');
});

Route::get('/reports/pss', function () {
    return view('report_pss');
});

Route::get('/reports/csm', function () {
    return view('report_csm');
});
//CSS
Route::post('/save_css', [FormController::class, 'save_css']);
Route::post('/edit_css', [FormController::class, 'edit_css']);
Route::post('/delete_css', [FormController::class, 'destroy_css']);

//PSS
Route::post('/save_pss', [FormController::class, 'save_pss']);
Route::post('/edit_pss', [FormController::class, 'edit_pss']);
Route::post('/delete_pss', [FormController::class, 'destroy_pss']);
//CSM
Route::post('/save_csm', [FormController::class, 'save_csm']);
Route::post('/edit_csm', [FormController::class, 'edit_csm']);
Route::post('/delete_csm', [FormController::class, 'destroy_csm']);

Route::get('/office_dropdown', [FormController::class, 'office_dropdown']);
Route::get('/office_dropdown_csm', [FormController::class, 'office_dropdown_csm']);
Route::post('/service_dropdown', [FormController::class, 'service_dropdown']);
Route::get('/municipality_dropdown', [FormController::class, 'municipality_dropdown']);
Route::post('/change_dropdown', [FormController::class, 'change_dropdown']);
Route::post('/change_dropdown_csm', [FormController::class, 'change_dropdown_csm']);

//PDF
Route::get('/reports1/css/{monthyear}/{year}/{month}/{office_name}', [PDFController::class, 'report_css']);
Route::get('/reports1/pss/{year}/{hospital_name}', [PDFController::class, 'report_pss']);
Route::get('/reports1/csm/{monthyear}/{year}/{month}/{office_name}', [PDFController::class, 'report_csm']);

Route::get('/test', [PDFController::class, 'test']);
//CHARTS
Route::get('/count_chart', [ChartController::class, 'count_survey']);
Route::get('/monthly_css', [ChartController::class, 'monthly_css']);
Route::get('/monthly_pss', [ChartController::class, 'monthly_pss']);
Route::get('/monthly_csm', [ChartController::class, 'monthly_csm']);
Route::get('/prediction_css', [ChartController::class, 'prediction_css']);
Route::get('/prediction_pss', [ChartController::class, 'prediction_pss']);
//SURVEY
Route::get('/select_css', [SurveyController::class, 'display_css']);
Route::post('/select_css2', [SurveyController::class, 'display_css']);

Route::get('/select_csm', [SurveyController::class, 'display_csm']);
Route::post('/select_csm2', [SurveyController::class, 'display_csm']);

Route::get('/select_pss', [SurveyController::class, 'display_pss']);
Route::post('/select_pss2', [SurveyController::class, 'display_pss']);

Route::get('/select_csm', [SurveyController::class, 'display_csm']);
Route::post('/select_csm2', [SurveyController::class, 'display_csm']);

Route::post('/view_css', [FormController::class, 'view_css']);
Route::post('/view_pss', [FormController::class, 'view_pss']);
Route::post('/view_csm', [FormController::class, 'view_csm']);

Route::get('/dropdown_offices', [SurveyController::class, 'display_offices']);
Route::get('/dropdown_hospitals', [SurveyController::class, 'display_hospitals']);

//COMMENTS
Route::get('/select_comments_css', [CommentController::class, 'display_css']);
Route::post('/select_comments_css2', [CommentController::class, 'display_css']);
Route::post('/search_display_css', [CommentController::class, 'search_display_css']);
Route::post('/activate_comments_css', [CommentController::class, 'activate_css']);
Route::post('/deactivate_comments_css', [CommentController::class, 'deactivate_css']);
Route::get('/select_comments_pss', [CommentController::class, 'display_pss']);
Route::post('/select_comments_pss2', [CommentController::class, 'display_pss']);
Route::post('/search_display_pss', [CommentController::class, 'search_display_pss']);
Route::post('/activate_comments_pss', [CommentController::class, 'activate_pss']);
Route::post('/deactivate_comments_pss', [CommentController::class, 'deactivate_pss']);

//IMPORT
Route::get('/select_import_css', [ImportController::class, 'display_css']);
Route::post('/select_import_css2', [ImportController::class, 'display_css']);
Route::get('/select_import_pss', [ImportController::class, 'display_pss']);
Route::post('/select_import_pss2', [ImportController::class, 'display_pss']);
Route::post('/import_css', [ImportController::class, 'import_css']);
Route::get('/import_test', [ImportController::class, 'import_test']);
Route::post('/import_pss', [ImportController::class, 'import_pss']);


//CHART SETTINGS
Route::get('/select_chart_settings_css', [ChartSettingController::class, 'view_css']);
Route::get('/select_chart_settings_pss', [ChartSettingController::class, 'view_pss']);

Route::post('/save_chart_settings', [ChartSettingController::class, 'update']);

//WORD MODULE
Route::get('/wordcss/{monthyear}/{year}/{month}/{office_name}', [WordController::class, 'generateWordCSS']);
Route::get('/wordpss/{currentdate}/{year}/{hospital_name}', [WordController::class, 'generateWordPSS']);

Route::get('/view/css/{id}', [TableController::class, 'view_css']);
Route::get('/view/pss/{id}', [TableController::class, 'view_pss']);
Route::get('/view/csm/{id}', [TableController::class, 'view_csm']);

Route::get('/edit/css/{id}', function () {
    return view('form_css');
});

Route::get('/edit/csm/{id}', function () {
    return view('form_csm');
});

// Route::get('/view/pss/{id}', function () {
//     return view('table_pss');
// });

Route::get('/edit/pss/{id}', function () {
    return view('form_pss');
});


Route::get('/404', function () {
    return view('404');
});

Route::get('/bcode', function () {
    return view('test');
});
