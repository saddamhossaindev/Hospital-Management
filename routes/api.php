<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\PatientController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('auth')->group(function () {
    Route::post('register', [RegisterController::class, 'register']);
    Route::post('login', [LoginController::class, 'ApiLogin']);
    Route::post('logout', [LogoutController::class, 'logout']);
});


Route::prefix('doctors')->group(function () {
    Route::post('create', [DoctorController::class, 'store']);
    Route::put('update/{id}', [DoctorController::class, 'update']);
    Route::delete('delete/{id}', [DoctorController::class, 'delete']);
    Route::get('{id}', [DoctorController::class, 'show']);
    Route::get('', [DoctorController::class, 'list']);
});


Route::apiResources([
    'patients' => PatientController::class,
]);
