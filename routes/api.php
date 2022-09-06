<?php

use App\Http\Controllers\Api\Auth\Login;
use App\Http\Controllers\Api\UsersController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->name('api.')->group(function () {
    Route::post('/login', [Login::class, 'authenticate']);

    Route::middleware('auth:api')->group(function () {
        Route::post('/users/{user}/upload-avatar', [UsersController::class, 'uploadAvatar'])->name('upload-avatar');
    });
});


