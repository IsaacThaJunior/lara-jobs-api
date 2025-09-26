<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\TechJobController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
  return $request->user();
})->middleware('auth:sanctum');

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
  Route::post('/logout', [AuthController::class, 'logout']);
  Route::post('/jobs', [TechJobController::class, 'store']);
  Route::patch('/jobs/{id}', [TechJobController::class, 'update']);
  Route::delete('/jobs/{id}', [TechJobController::class, 'destroy']);
});

Route::get('/jobs', [TechJobController::class, 'index']);
Route::get('/jobs/{id}', [TechJobController::class, 'show']);
