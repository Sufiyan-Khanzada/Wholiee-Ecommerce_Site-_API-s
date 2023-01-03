<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PassportController;
use App\Http\Controllers\CategoryController;




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

Route::post('register', [PassportController::class, 'register']);
Route::post('login', [PassportController::class, 'login']);
Route::get('get-users', [PassportController::class, 'allusers']);
Route::post('single-user/{id}', [PassportController::class, 'single_user']);
Route::post('reset-password', [PassportController::class, 'password_reset']);
Route::post('verify-otp', [PassportController::class, 'verifyOtp']);


Route::post('catadd', [CategoryController::class, 'store']);
Route::get('showall-cat', [CategoryController::class, 'allcat']);
Route::post('show-single_cat/{id}',[CategoryController::class, 'show_single_category']);
Route::post('delete-cat/{id}', [CategoryController::class, 'destroy_cat']);
Route::post('{id}/update-cat',[CategoryController::class,'update_cat']);





Route::middleware('auth:api')->group(function () {
    Route::post('user-detail', [PassportController::class, 'userDetail']);
    Route::post('logout', [PassportController::class, 'logout']);
});

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
