<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CourseController;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
/*use App\Http\Controllers\Admin\UserController;

|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {

    return $request->user();






 
    


});


Route::get('/courses', [CourseController::class, 'index']);
Route::get('/courses/{course}', [CourseController::class, 'show']);
Route::post('/courses', [CourseController::class, 'store']);         
Route::put('/courses/{course}', [CourseController::class, 'update']); 
Route::delete('/courses/{course}', [CourseController::class, 'destroy']); 
// Route::apiResource('courses', CourseController::class);





Route::post('register',[AuthController::class,'register']);
Route::post('login',[AuthController::class,'login']);
Route::post('logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
Route::get('test',[AuthController::class,'test'])->middleware('auth:sanctum'); 

Route::post('/courses/{id}/enroll', [CourseController::class, 'enroll'])->middleware('auth:sanctum');
Route::get('/my-courses', [CourseController::class, 'myCourses'])->middleware('auth:sanctum');


 Route::middleware('auth:sanctum')->group(function () {
    Route::get('/users', [UserController::class, 'index']);
    Route::post('/users', [UserController::class, 'store']);
    Route::put('/users/{user}', [UserController::class, 'update']);
    Route::delete('/users/{user}', [UserController::class, 'destroy']);
});