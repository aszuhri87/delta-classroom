<?php

use App\Http\Controllers\Admin\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|
| Here is where you can register admin routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "admin" middleware group. Now create something great!
|
*/

Route::prefix('admin')->middleware(['guest-admin-handling'])->group(function () {
    Route::get('login', function (Request $request) {
        return view('admin.login');
    });

    Route::post('login', [AuthController::class, 'login']);
});

Route::prefix('admin')->middleware(['admin-handling'])->group(function () {
    Route::get('/logout', [AuthController::class, 'logout']);
});
