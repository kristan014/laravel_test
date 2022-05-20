<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\StudentController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});



Route::prefix('v1')->group(function () {
Route::post('/course',[CourseController::class, 'store']);
Route::put('/course/{id}',[CourseController::class, 'update']);
Route::get('/course/{id}',[CourseController::class, 'getone']);
Route::get('/course',[CourseController::class, 'getall']);
Route::delete('/course/{id}',[CourseController::class, 'destroy']);

Route::post('/student',[StudentController::class, 'store']);
Route::put('/student/{id}',[StudentController::class, 'update']);
Route::get('/student/{id}',[StudentController::class, 'getone']);
Route::delete('/student/{id}',[StudentController::class, 'destroy']);
});
