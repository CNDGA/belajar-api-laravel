<?php

use App\Http\Controllers\API\AttendanceController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\API\EmployeeController;
use App\Http\Controllers\API\OfficeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('register', [AuthController::class, 'register']);


Route::post('login', [AuthController::class, 'login']);

//cek token if exists
Route::middleware('auth:api')->group(function () {
    Route::get('me', [AuthController::class, 'me']);
    Route::get('logout', [AuthController::class, 'logout']);
    Route::post('refresh', [AuthController::class, 'refresh']);

    //apiResource mencakupi semua methodd
    Route::apiResource('employee',  EmployeeController::class);
    Route::apiResource('office',  OfficeController::class);

    Route::post('attendanceIn', [AttendanceController::class, 'attendanceIn']);
});
