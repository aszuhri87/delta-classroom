<?php

use App\Http\Controllers\Admin\StudentController;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')->middleware(['admin-handling'])->group(function () {
    Route::get('student', [StudentController::class, 'index']);

    Route::get('student/{id}', [StudentController::class, 'show']);

    Route::post('student', [StudentController::class, 'store']);

    Route::post('student/update/{id}', [StudentController::class, 'update']);

    Route::get('student/download/{id}', [StudentController::class, 'download']);

    Route::get('student/delete/{id}', [StudentController::class, 'delete']);
});
