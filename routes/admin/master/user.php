<?php

use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;

Route::prefix('admin/master')->middleware(['admin-handling'])->group(function () {
    Route::get('user', [UserController::class, 'index']);

    Route::get('user/{id}', [UserController::class, 'show']);

    Route::post('user', [UserController::class, 'store']);

    Route::post('user/update/{id}', [UserController::class, 'update']);

    Route::get('user/delete/{id}', [UserController::class, 'delete']);
});
