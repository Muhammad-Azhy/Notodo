<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProblemController;
use App\Http\Controllers\ReferenceController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\AttachmentController;
use App\Http\Middleware\AdminMiddleware;

/*
|--------------------------------------------------------------------------
| Public Auth Routes
|--------------------------------------------------------------------------
*/

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

/*
|--------------------------------------------------------------------------
| Authenticated Routes (JWT)
|--------------------------------------------------------------------------
*/

Route::middleware('auth:api')->group(function () {

    // Auth info
    Route::get('/me', [AuthController::class, 'me']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/refresh', [AuthController::class, 'refresh']);

    Route::get('/problems', [ProblemController::class, 'index']);
    Route::post('/problems', [ProblemController::class, 'store']);
    Route::get('/problems/{id}', [ProblemController::class, 'show']);
    Route::put('/problems/{id}', [ProblemController::class, 'update']);
    Route::delete('/problems/{id}', [ProblemController::class, 'destroy']);

  
    Route::apiResource('references', ReferenceController::class);
    Route::apiResource('tasks', TaskController::class);

  
    Route::apiResource('attachments', AttachmentController::class);
});

/*
    Admin Only Routes
*/

Route::middleware(['auth:api', AdminMiddleware::class])->group(function () {

    Route::get('/admin/users', [UserController::class, 'index']);
    Route::post('/admin/users', [UserController::class, 'store']);
    Route::get('/admin/users/{id}', [UserController::class, 'show']);
    Route::put('/admin/users/{id}', [UserController::class, 'update']);
    Route::delete('/admin/users/{id}', [UserController::class, 'destroy']);
});
