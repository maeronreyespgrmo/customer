<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\APIController;
use App\Http\Controllers\UserController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('/api_save_css', [APIController::class, 'api_save_css']);

Route::post('/api_save_pss', [APIController::class, 'api_save_pss']);

Route::post('/wew', [APIController::class, 'wew']);

Route::get('/test', [APIController::class, 'test']);

Route::get('/api_services_dropdown_default', [APIController::class, 'api_services_dropdown_default']);

Route::post('/api_services_dropdown', [APIController::class, 'api_services_dropdown']);

Route::get('/api_office_dropdown', [APIController::class, 'api_office_dropdown']);

Route::get('/api_view_survey_css', [APIController::class, 'api_view_survey_css']);

Route::get('/api_load_more_view_survey_css/{offset}/{limit}', [APIController::class, 'api_load_more_view_survey_css']);

Route::get('/api_view_survey_pss', [APIController::class, 'api_view_survey_pss']);

Route::get('/monthly_pss', [APIController::class, 'monthly_pss']);

Route::get('/counting', [APIController::class, 'count_survey']);

Route::middleware('auth:sanctum')->group(function () {
    // return $request->user();
    // Route::get('/test', [APIController::class, 'test']);
});
