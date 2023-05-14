<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\AuthController;
use App\Http\Controllers\api\ProverbController;
use App\Http\Controllers\api\ProfileController;
use App\Http\Controllers\api\NativeLanguageController;
use App\Http\Controllers\api\SubtribeController;

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
const SANCTUM="auth:sanctum";

Route::group(['prefix' => 'v1/'], function () {

    Route::group(['prefix' => 'auth'], function () {
        Route::post('/register', [AuthController::class, 'register']);
        Route::post('/login', [AuthController::class, 'login']);
        Route::post('/logout', [AuthController::class, 'logout']);
    });
    Route::group(['prefix' => 'profile',SANCTUM], function () {
        Route::get('/{id}', [ProfileController::class, 'show']);
        Route::put('/{id}', [ProfileController::class, 'update']);
    });
    Route::group(['prefix' => 'proverbs'], function () {
        Route::middleware(SANCTUM)->post('/', [ProverbController::class, 'store']);
        Route::get('/', [ProverbController::class, 'index']);
        Route::get('/search', [ProverbController::class, 'search']);
    });
    Route::group(['prefix' => 'subtribe',SANCTUM], function () {
        Route::get('/', [SubtribeController::class, 'index']);
        Route::post('/', [SubtribeController::class, 'store']);
        Route::put('/{id}', [SubtribeController::class, 'update']);
    });
    Route::group(['prefix' => 'native-languages',SANCTUM], function () {
        Route::get('/', [NativeLanguageController::class, 'index']);
        Route::post('/', [NativeLanguageController::class, 'store']);
        Route::put('/{id}', [NativeLanguageController::class, 'update']);
    });
});
