<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\KaryawanController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('login', [AuthController::class, 'login']);

Route::post('user/store', [UserController::class, 'store']);
Route::middleware(['jwt.auth'])->group(function () {
    Route::get('cek-token', [AuthController::class, 'cekToken']);
    // User Route
    Route::prefix('user')->group(function(){
        Route::get('/', [UserController::class, 'index']);
        Route::get('/{id}', [UserController::class, 'show']);
        Route::post('/update/{id}', [UserController::class, 'update']);
        Route::get('/delete/{id}', [UserController::class, 'destroy']);
    });

    // Karyawan Route
    Route::prefix('karyawan')->group(function(){
        Route::get('/', [KaryawanController::class, 'index']);
        Route::get('/{id}', [KaryawanController::class, 'show']);
        Route::get('/delete/{id}', [KaryawanController::class, 'destroy']);
    });
});
