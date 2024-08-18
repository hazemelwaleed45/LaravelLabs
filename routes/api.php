<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\StudentController;

use App\Http\Controllers\Api\TrackController;
use App\Http\Controllers\Api\CourseController;
// use App\Http\Controllers\CourseController;
// use App\Http\Controllers\TrackController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::apiResource('students',StudentController::class);

Route::apiResource('tracks',TrackController::class);


Route::apiResource('courses',CourseController::class);
