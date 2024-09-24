<?php

use App\Http\Controllers\api\AuthController;
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
    Route::post('logout', [AuthController::class, 'logout']);
    Route::get('change-user-status/{userId}/{status}', [AuthController::class, 'changeUserStatus']);

    //Registro de los casos
    Route::get('get-all', [ProcessController::class, 'getAll']);
    Route::get('get-by-document-dashboard/{documentType}/{documentNumber}',
    [ProcessController::class, 'getByIdIntranet']);
    Route::post('save-process', [ProcessController::class, 'store']);
    Route::patch('update-process', [ProcessController::class, 'update']);
    Route::patch('deactivate', [ProcessController::class, 'deactivate']);
});

//ver los datos
Route::get('get-by-document/{documentType}/{documentNumber}/{validationKey}',
    [ProcessController::class, 'getByIdPulic']);

Route::get('get_all', [ProcessController::class, 'getAllWithoutPagination']);
