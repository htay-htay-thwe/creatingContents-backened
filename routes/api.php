<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\DeleteController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\SaveController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ViewController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['check.jwt']], function () {

Route::group(['prefix' => 'basic-ui'], function () {
    Route::post('create/post', [PostController::class, 'postCreate']);
    Route::get('get/profile/post/{id}',[PostController::class,'getProfilePost']);
    Route::get('edit/post/{id}/{userId}',[PostController::class,'editPost']);
    Route::post('update/post',[PostController::class,'updatePost']);
    Route::get('get/read/content/{id}/{userId}',[PostController::class,'getReadPost']);
    Route::get('delete/profile/post/{id}',[PostController::class,'deletePost']);
    Route::get('restore/profile/post/{id}',[PostController::class,'restorePost']);
    Route::get('delete/permanent/profile/post/{id}',[PostController::class,'deletePermanentPost']);
    Route::get('create/view/content/{id}/{postIds}',[ViewController::class,'createView']);
    Route::get('get/view/content',[ViewController::class,'getView']);
    Route::get('show/comments/{id}',[CommentController::class,'showComments']);
    Route::get('create/comment/{id}/{parentId}/{comment}/{userId}',[CommentController::class,'createComments']);
    Route::post('reply/comment/{id}/{userId}',[CommentController::class,'reply']);
    Route::get('create/save/{id}/{userId}',[SaveController::class,'Save']);
    Route::get('unSave/{id}',[SaveController::class,'unSave']);
    Route::get('add/like/{id}/{userId}',[LikeController::class,'addLike']);
    Route::get('unlike/{id}/{userId}',[LikeController::class,'unLike']);
});

});

Route::group(['prefix' => 'userAuth'], function () {
    Route::post('create/user', [UserController::class, 'register']);
    Route::post('user/login', [UserController::class, 'login']);
    Route::post('upload/profileImage',[UserController::class,'uploadProfile']);
    Route::post('update/user/information',[UserController::class,'updateInfo']);
    Route::post('change/password',[UserController::class,'changePw']);
});
