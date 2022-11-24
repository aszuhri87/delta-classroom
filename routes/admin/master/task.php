<?php

use App\Http\Controllers\Admin\TaskController;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')->middleware(['admin-handling'])->group(function () {
    Route::get('task', [TaskController::class, 'index']);

    Route::get('task/{id}', [TaskController::class, 'show']);

    Route::post('task', [TaskController::class, 'store']);

    Route::post('task/update/{id}', [TaskController::class, 'update']);

    Route::post('assignment/score', [TaskController::class, 'scoring']);

    Route::get('task/download/{id}', [TaskController::class, 'download']);

    Route::get('task/download_assignment/{id}', [TaskController::class, 'download_assign']);

    Route::get('assignment/stream/{id}', [AssignmentsController::class, 'stream']);

    Route::get('task/delete/{id}', [TaskController::class, 'delete']);
});
