<?php

use App\Http\Controllers\PostController;
use App\Http\Controllers\WebsiteController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


/**
 * endpoint for creating new posts
 */
Route::post('/posts/create', [PostController::class, 'create']);


/**
 * endpoint for subscribing to websites
 */
Route::post('/websites/subscribe', [WebsiteController::class, 'subscribe']);

Route::get('/websites/subscribers', [WebsiteController::class, 'get']);