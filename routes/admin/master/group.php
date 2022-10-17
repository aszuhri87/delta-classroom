<?php

use App\Http\Controllers\Admin\GroupController;
use Illuminate\Support\Facades\Route;

Route::prefix('admin/master')->middleware(['admin-handling'])->group(function () {
    Route::get('group', [GroupController::class, 'index']);

    Route::get('group/{id}', [GroupController::class, 'show']);

    Route::post('group', [GroupController::class, 'store']);

    Route::post('group/update/{id}', [GroupController::class, 'update']);

    Route::get('group/delete/{id}', [GroupController::class, 'delete']);
});
