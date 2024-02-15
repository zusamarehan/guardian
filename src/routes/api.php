<?php

use Illuminate\Support\Facades\Route;
use RehanKanak\Guardian\Http\Controllers\GenerateController;
use RehanKanak\Guardian\Http\Controllers\RespondController;
use RehanKanak\Guardian\Http\Controllers\StatusController;

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

Route::post('/api/guardian/generate', GenerateController::class)->name('guardian.generate');
Route::post('/api/guardian/respond', RespondController::class)->name('guardian.respond');
Route::post('/api/guardian/status', StatusController::class)->name('guardian.status');
