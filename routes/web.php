<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;

Route::get('/', [DashboardController::class, 'index']);
//exportCsv
Route::get('/export', [DashboardController::class, 'exportCsv']);
// NEW ROUTE: Update the threshold
Route::post('/update-threshold', [DashboardController::class, 'updateThreshold']);