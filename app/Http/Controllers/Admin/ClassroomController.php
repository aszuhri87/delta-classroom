<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Classroom;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class ClassroomController extends Controller
{
    public function index(Request $request)
    {
        $list = DB::table('classrooms')
            ->select([
                'classrooms.*',
                'users.name as teacher_name',
            ])
            ->leftJoin('users', 'users.id', 'classrooms.user_id')
            ->orderBy('classrooms.division', 'desc')
            ->paginate(10);

        return view('admin.classroom-list', compact('list'));
    }

    public function store(Request $request)
    {
        Classroom::create([
            'user_id' => Auth::guard('admin')->id(),
            'class_name' => $request->class_name,
            'presence_code' => Str::random(5),
            'division' => $request->division,
        ]);

        return Redirect::back();
    }

    public function update(Request $request, $id)
    {
        Classroom::find($id)->update([
            'user_id' => Auth::guard('admin')->id(),
            'class_name' => $request->class_name,
            'presence_code' => Str::random(5),
            'division' => $request->division,
        ]);

        return Redirect::back();
    }

    public function delete(Request $request, $id)
    {
        Classroom::find($id)->delete();

        return Redirect::back();
    }
}
