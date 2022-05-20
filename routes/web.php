<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\StudentController;





/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/',[LoginController::class, 'index'])->name('login');
Route::get('/login',[LoginController::class, 'index'])->name('login');
Route::post('/login',[LoginController::class, 'store'])->name('login');
Route::post('/logout',[LogoutController::class, 'store'])->name('logout');


Route::middleware(['auth','prevent-back-history'])->get('/dashboard',[DashboardController::class, 'index'])->name('dashboard');


Route::middleware(['auth','prevent-back-history'])->get('/course',[CourseController::class, 'index'])->name('courses.index');
Route::middleware(['auth','prevent-back-history'])->get('/courses-datatable',[CourseController::class, 'datatable'])->name('courses.datatable');


Route::middleware(['auth','prevent-back-history'])->get('/student',[StudentController::class, 'index'])->name('students.index');
Route::middleware(['auth','prevent-back-history'])->get('/student-datatable',[StudentController::class, 'datatable'])->name('students.datatable');













