<?php
use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;

Route::get('/tasks', [TaskController::class, 'index']);
Route::post('/tasks', [TaskController::class, 'store']);
Route::delete('/tasks/{id}', [TaskController::class, 'destroy']);
