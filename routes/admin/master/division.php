<?php

use App\Http\Controllers\Admin\DivisionController;
use Illuminate\Support\Facades\Route;

Route::prefix('admin/master')->middleware(['admin-handling'])->group(function () {
    Route::get('division', [DivisionController::class, 'index']);

    Route::get('division/{id}', [DivisionController::class, 'show']);

    Route::post('division', [DivisionController::class, 'store']);

    Route::post('division/update/{id}', [DivisionController::class, 'update']);

    Route::get('division/delete/{id}', [DivisionController::class, 'delete']);
});
