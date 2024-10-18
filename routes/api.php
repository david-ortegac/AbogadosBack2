<?php

use App\Http\Controllers\api\AuthController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\HistoriesController;
use App\Http\Controllers\ProcessController;
use Illuminate\Support\Facades\Route;

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

Route::post('login', [AuthController::class, 'login']);
Route::post('register', [AuthController::class, 'register']);

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('profile', [AuthController::class, 'userProfile']);
    Route::patch('profile', [AuthController::class, 'updateProfile']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::patch('change-user-status', [AuthController::class, 'changeUserStatus']);

    //Registro de los casos
    Route::get('process', [ProcessController::class, 'getAll']);
    Route::get('get_all', [ProcessController::class, 'getAllWithoutPagination']);
    Route::get('get-by-document-dashboard/{documentType}/{documentNumber}', [ProcessController::class, 'getByIdIntranet']);
    Route::post('process', [ProcessController::class, 'store']);
    Route::patch('process', [ProcessController::class, 'update']);
    Route::patch('history', [HistoriesController::class, 'edit']);
});

Route::patch('deactivate-process/{id}', [ProcessController::class, 'deactivateProcess']);

//ver los datos
Route::get('get-by-process-id/{processId}',
    [ProcessController::class, 'getByIdPulic']);

//recaptcha
Route::post('captcha', [Controller::class, 'validateCaptcha']);


