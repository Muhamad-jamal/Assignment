<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\EmployeeController;
use App\Http\Controllers\Api\V1\PositionController;

/*
|--------------------------------------------------------------------------
| API V1 Routes
|--------------------------------------------------------------------------
*/

Route::prefix('auth')->group(function () {
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);

    Route::middleware('auth:sanctum')->group(function () {
        Route::post('logout', [AuthController::class, 'logout']);
    });
});

Route::middleware('auth:sanctum')->group(function () {
    Route::get('employees/search', [EmployeeController::class, 'search']);
    Route::get('employees/export/csv', [EmployeeController::class, 'exportCsv']);
    Route::post('employees/import/csv', [EmployeeController::class, 'importCsv']);
    Route::get('employees/without-recent-salary-change', [EmployeeController::class, 'withoutRecentSalaryChange']);
    Route::apiResource('positions', PositionController::class);
    Route::apiResource('employees', EmployeeController::class);
    Route::get('employees/{employee}/hierarchy/names', [EmployeeController::class, 'hierarchyNames']);
    Route::get('employees/{employee}/hierarchy/names-salaries', [EmployeeController::class, 'hierarchyNamesSalaries']);
});
