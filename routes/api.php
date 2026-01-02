<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProblemController;
use App\Http\Controllers\ReferenceController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\AttachmentController;
use App\Http\Controllers\AuthController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Protected 
Route::middleware('auth:sanctum')->group(function() {
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::apiResource('references', ReferenceController::class);
    Route::apiResource('problems', ProblemController::class);
    Route::apiResource('tasks', TaskController::class);
    Route::apiResource('attachments', AttachmentController::class);
});

// ===== Users =====
Route::get('/users', [UserController::class, 'index']);        // List all users
Route::post('/users', [UserController::class, 'store']);       // Create user
Route::get('/users/{id}', [UserController::class, 'show']);    // Show user
Route::put('/users/{id}', [UserController::class, 'update']);  // Update user
Route::delete('/users/{id}', [UserController::class, 'destroy']); // Delete user

// ===== Problems =====
Route::get('/problems', [ProblemController::class, 'index']);          // ?user_id=1
Route::post('/problems', [ProblemController::class, 'store']);
Route::get('/problems/{id}', [ProblemController::class, 'show']);      // ?user_id=1
Route::put('/problems/{id}', [ProblemController::class, 'update']);
Route::delete('/problems/{id}', [ProblemController::class, 'destroy']);

// ===== References =====
Route::get('/references', [ReferenceController::class, 'index']);      // ?user_id=1
Route::post('/references', [ReferenceController::class, 'store']);
Route::get('/references/{id}', [ReferenceController::class, 'show']);  // ?user_id=1
Route::put('/references/{id}', [ReferenceController::class, 'update']);
Route::delete('/references/{id}', [ReferenceController::class, 'destroy']);

// ===== Tasks =====
Route::get('/tasks', [TaskController::class, 'index']);                // ?user_id=1
Route::post('/tasks', [TaskController::class, 'store']);
Route::get('/tasks/{id}', [TaskController::class, 'show']);            // ?user_id=1
Route::put('/tasks/{id}', [TaskController::class, 'update']);
Route::delete('/tasks/{id}', [TaskController::class, 'destroy']);

// ===== Attachments =====
Route::get('/attachments', [AttachmentController::class, 'index']);    // ?user_id=1
Route::post('/attachments', [AttachmentController::class, 'store']);
Route::get('/attachments/{id}', [AttachmentController::class, 'show']); // ?user_id=1
Route::put('/attachments/{id}', [AttachmentController::class, 'update']);
Route::delete('/attachments/{id}', [AttachmentController::class, 'destroy']);

