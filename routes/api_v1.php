<?php

use App\Http\Controllers\Api\V1\FileCreateController;
use App\Http\Controllers\Api\V1\FileSearchController;
use App\Http\Controllers\Api\V1\FileRemoveController;
use App\Http\Controllers\Api\V1\FileUploadController;
use App\Http\Controllers\Api\V1\IndexController;
use App\Http\Controllers\Api\V1\LoginController;
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

Route::get('/', IndexController::class);
Route::post('auth/login', LoginController::class);

Route::group(['middleware' => ['auth:api']], static function () {
    Route::post('file/create', FileCreateController::class);
    Route::post('file/upload', FileUploadController::class);
    Route::post('file/remove', FileRemoveController::class);
    Route::get('file/search', FileSearchController::class);
});
