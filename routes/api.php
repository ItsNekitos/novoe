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
        Route::post('/files', [FileController::class, "add"]); //ok
        Route::get('/files/disk', [FileController::class, "viewfiles"]);
        Route::patch('/files/{file_id}', [FileController::class, "rename"]); //ok
        Route::delete('/files/{file_id}', [FileController::class, "delete"]); //ok
        Route::get('/files/{file_id}', [FileController::class, "download"]); //ok
        Route::post('/files/{file_id}/accesses', [FileAccessController::class, "addaccess"]); //ok
        Route::delete('/files/{file_id}/accesses', [FileAccessController::class, "removeaccess"]);//ok
        Route::get('/shared', [FileAccessController::class, "shared"]); //ok
    });
