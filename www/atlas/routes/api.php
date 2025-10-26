<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\WorkOrderCnsdController;
use App\Http\Controllers\WorkOrderTfpController;
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

Route::get('/schedule', [ScheduleController::class, 'getScheduleData']);

Route::get('/work-orders/cnsd', [WorkOrderCnsdController::class, 'index'])->name('wo.cnsd.index');

Route::get('/work-orders/tfp', [WorkOrderTfpController::class, 'index'])->name('wo.tfp.index');

