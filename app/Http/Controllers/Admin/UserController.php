<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $list = DB::table('users')
            ->select([
                'users.id',
                'users.name',
                'users.email',
            ])
            ->orderBy('users.created_at', 'desc')
            ->whereNull('users.deleted_at')
            ->paginate(10);

        return view('admin.user-list', compact('list'));
    }

    public function show(Request $request, $id)
    {
        $user = \DB::table('users')
        ->select([
            'users.id',
            'users.name',
            'users.email',
        ])
        ->where('users.id', $id)
        ->whereNull('users.deleted_at')
        ->first();

        $classroom = DB::table('classrooms')
        ->select([
            'classrooms.id',
            'classrooms.class_name',
            'classrooms.presence_code',
            'classrooms.division',
        ])
        ->where('classrooms.user_id', $id)
        ->whereNull('classrooms.deleted_at')
        ->paginate(10);

        $task = DB::table('tasks')
        ->select([
            'tasks.id',
            'tasks.name',
            'tasks.expired_at',
            'groups.name as group',
        ])
        ->leftJoin('groups', 'groups.id', 'tasks.group_id')
        ->where('tasks.user_id', $id)
        ->whereNull('tasks.deleted_at')
        ->paginate(10);

        return view('admin.user-detail', compact('user', 'classroom', 'task'));
    }

    public function store(Request $request)
    {
        $value = Hash::make($request->password);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $value,
        ]);

        return Redirect::back();
    }

    public function update(Request $request, $id)
    {
        $edit = User::find($id);
        $edit->update([
            'name' => $request->name ? $request->name : $edit->name,
            'email' => $request->email ? $request->email : $edit->email,
            'password' => Hash::make($request->new_password) ? Hash::make($request->new_password) : $edit->password,
        ]);

        return Redirect::back();
    }

    public function delete(Request $request, $id)
    {
        User::find($id)->delete();

        return Redirect::back();
    }
}
