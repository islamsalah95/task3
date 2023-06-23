<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostController;

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


Route::post('/Auth/register', [AuthController::class, 'register']);
Route::post('/Auth/login', [AuthController::class, 'login']);




Route::middleware('IsAuth')->group(function () {
    Route::post('posts/store', [PostController::class, 'store']);
    Route::get('posts/userPost', [PostController::class, 'userPost']);

});