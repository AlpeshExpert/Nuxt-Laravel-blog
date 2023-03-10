<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CommentController;
use App\Http\Controllers\Api\PostController;

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
Route::middleware('auth:sanctum')->group(function(){
    Route::controller(PostController::class)->prefix('post')->group(function(){
        Route::post('store','store');
        Route::post('update/{id}','update');
        Route::get('edit/{id}','edit');
    });
    Route::post('comment/store',[CommentController::class,'store']);
});

Route::get('posts',[PostController::class,'index']);
Route::get('post/show/{id}',[PostController::class,'show']);
