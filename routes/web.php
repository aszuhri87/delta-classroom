<?php

use App\Http\Controllers\AssignmentsController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PresencesController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TasksController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect('login');
});

Route::middleware(['guest-handling'])->group(function () {
    Route::get('/', function () {
        return redirect('login');
    });

    Route::get('login', function (Request $request) {
        return view('login');
    });

    Route::post('login', [AuthController::class, 'login']);
});

Route::middleware(['auth-handling'])->group(function () {
    Route::get('/logout', [AuthController::class, 'logout']);

    Route::get('/dashboard', [TasksController::class, 'index']);

    Route::get('task/{id}', [TasksController::class, 'show']);

    Route::get('task/download/{id}', [TasksController::class, 'download']);

    Route::post('assignment', [AssignmentsController::class, 'store']);

    Route::post('assignment/update/{id}', [AssignmentsController::class, 'update']);

    Route::get('assignment/download/{id}', [AssignmentsController::class, 'download']);

    Route::get('assignment/stream/{id}', [AssignmentsController::class, 'stream']);

    Route::get('presence', [PresencesController::class, 'index']);

    Route::post('classroom/presence', [PresencesController::class, 'store']);

    Route::post('update/password', [ProfileController::class, 'update_password']);

    Route::get('profile', [ProfileController::class, 'profile']);
});

include base_path('routes/admin/admin.php');
include base_path('routes/admin/master/classroom.php');
include base_path('routes/admin/master/task.php');
include base_path('routes/admin/master/student.php');
include base_path('routes/admin/master/user.php');
include base_path('routes/admin/master/group.php');
include base_path('routes/admin/master/division.php');

include base_path('routes/tutorial.php');
