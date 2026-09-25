<?php

use App\Http\Controllers\FileAccessController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\UserController;

use Illuminate\Http\Request;
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

Route::post('/registration', [UserController::class, "registration"]); //ok
Route::post('/authorization', [UserController::class, "authorization"]); //ok

Route::middleware('auth:sanctum')->group(function () {
        Route::get('/logout', [UserController::class, "logout"]); //ok
    });
