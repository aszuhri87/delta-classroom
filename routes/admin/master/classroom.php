<?php

use App\Http\Controllers\Admin\ClassroomController;
use App\Http\Controllers\Admin\PresenceController;
use Illuminate\Support\Facades\Route;

Route::prefix('admin/master')->middleware(['admin-handling'])->group(function () {
    Route::get('classroom', [ClassroomController::class, 'index']);

    Route::get('presence/{id}', [PresenceController::class, 'index']);

    Route::post('classroom', [ClassroomController::class, 'store']);

    Route::post('classroom/update/{id}', [ClassroomController::class, 'update']);

    Route::get('classroom/delete/{id}', [ClassroomController::class, 'delete']);
});
