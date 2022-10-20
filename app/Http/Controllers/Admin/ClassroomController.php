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
        if (Auth::guard('admin')->user()->division_id != null) {
            $list = DB::table('classrooms')
            ->select([
                'classrooms.*',
                'users.name as teacher_name',
                'divisions.name as division',
            ])
            ->leftJoin('users', 'users.id', 'classrooms.user_id')
            ->leftJoin('divisions', 'divisions.id', 'classrooms.division_id')
            ->where('classrooms.division_id', Auth::guard('admin')->user()->division_id)
            ->whereNull('classrooms.deleted_at')
            ->paginate(10);
        } else {
            $list = DB::table('classrooms')
            ->select([
                'classrooms.*',
                'users.name as teacher_name',
                'divisions.name as division',
            ])
            ->leftJoin('users', 'users.id', 'classrooms.user_id')
            ->leftJoin('divisions', 'divisions.id', 'classrooms.division_id')
            ->whereNull('classrooms.deleted_at')
            ->paginate(10);
        }

        $division = DB::table('divisions')
            ->select(['*'])
            ->get();

        return view('admin.classroom-list', compact('list', 'division'));
    }

    public function store(Request $request)
    {
        if ($request->division) {
            $division = $request->division;
        } else {
            $division = Auth::guard('admin')->user()->division_id;
        }

        Classroom::create([
            'user_id' => Auth::guard('admin')->id(),
            'class_name' => $request->class_name,
            'presence_code' => mt_rand(10000, 99999),
            'division_id' => $division,
        ]);

        return Redirect::back();
    }

    public function update(Request $request, $id)
    {
        if ($request->division) {
            $division = $request->division;
        } else {
            $division = Auth::guard('admin')->user()->division_id;
        }

        Classroom::find($id)->update([
            'user_id' => Auth::guard('admin')->id(),
            'class_name' => $request->class_name,
            'presence_code' => mt_rand(10000, 99999),
            'division_id' => $division,
        ]);

        return Redirect::back();
    }

    public function delete(Request $request, $id)
    {
        Classroom::find($id)->delete();

        return Redirect::back();
    }
}
