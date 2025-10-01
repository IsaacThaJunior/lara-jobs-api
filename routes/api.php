<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\EmployerJobController;
use App\Http\Controllers\JobApplicationController;
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

  Route::delete('/jobs/{id}', [TechJobController::class, 'destroy']);

  Route::post('/jobs/{id}/apply', [JobApplicationController::class, 'store']);
  Route::get('/user/applications', [JobApplicationController::class, 'show']);

  Route::post('/jobs', [EmployerJobController::class, 'store']);
  Route::patch('/jobs/{id}', [EmployerJobController::class, 'update']);
  Route::get('employer/jobs', [EmployerJobController::class, 'index']);
});

Route::get('/jobs', [TechJobController::class, 'index']);
Route::get('/jobs/{id}', [TechJobController::class, 'show']);
