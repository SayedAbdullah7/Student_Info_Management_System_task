<?php

use App\Http\Controllers\CourseController;
use App\Http\Controllers\EnrollmentController;
use App\Http\Controllers\GradeController;
use App\Http\Controllers\StudentController;
use App\Models\Level;
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

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});
//Route::group(['middleware' => 'auth:sanctum'], function() {
Route::get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/levels', [\App\Http\Controllers\LevelController::class, 'index']);

Route::get('/students', [StudentController::class, 'index'])->name('students.index');
Route::get('/students/all', [StudentController::class, 'getAll'])->name('students.getAll');
Route::get('/students/{id}', [StudentController::class, 'show'])->name('students.show');
Route::post('/students', [StudentController::class, 'store'])->name('students.store');
Route::put('/students/{id}', [StudentController::class, 'update'])->name('students.update');
Route::delete('/students/{id}', [StudentController::class, 'destroy'])->name('students.destroy');


Route::get('/courses', [CourseController::class, 'index']);
Route::get('/courses/all', [CourseController::class, 'getAll']);
Route::get('courses/available-for-student/{student_id}', [CourseController::class, 'availableCoursesForStudent']);
Route::get('/courses/{id}', [CourseController::class, 'show']);


// get coures students
Route::get('/enrollments/{courseId}', [EnrollmentController::class, 'index'])->name('enrollments.index');
Route::post('/enrollments', [EnrollmentController::class, 'enrollStudent'])->name('enrollments.store');
Route::delete('/enrollments/{id}', [EnrollmentController::class, 'removeStudent'])->name('enrollments.destroy');

Route::get('/grade-items', [\App\Http\Controllers\GradeItemController::class, 'index']);

