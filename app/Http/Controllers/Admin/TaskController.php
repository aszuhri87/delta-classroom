<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Assignment;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class TaskController extends Controller
{
    public function index(Request $request)
    {
        $list = DB::table('tasks')
            ->select([
                'tasks.*',
                'tasks.name as task_name',
                'users.name as teacher_name',
                'groups.name as group_name',
            ])
            ->leftJoin('users', 'users.id', 'tasks.user_id')
            ->leftJoin('groups', 'groups.id', 'tasks.group_id')
            ->orderBy('tasks.created_at', 'desc')
            ->paginate(10);

        $group = DB::table('groups')
            ->select([
                'groups.*',
            ])
            ->whereNull('deleted_at')
            ->get();

        return view('admin.task-list', compact('list', 'group'));
    }

    public function show(Request $request, $id)
    {
        $task = \DB::table('tasks')
            ->select([
                'tasks.*',
                'tasks.name as task_name',
                'users.name as teacher_name',
                'groups.name as group_name',
                'groups.id as group_id',
            ])
            ->leftJoin('users', 'users.id', 'tasks.user_id')
            ->leftJoin('groups', 'groups.id', 'tasks.group_id')
            ->orderBy('tasks.created_at', 'desc')
            ->first();

        $group = DB::table('groups')
            ->select([
                'groups.*',
            ])
            ->whereNull('deleted_at')
            ->get();

        $classroom = DB::table('classrooms')
            ->select([
                'classrooms.*',
            ])
            ->whereNull('deleted_at')
            ->get();

        $assignment = DB::table('assignment_files')
        ->select([
            'assignment_files.assignment_id',
            'assignment_files.name as assignment_name',
            'students.name as student_name',
            'assignment_files.file_path',
            DB::raw('CASE WHEN assignments.score IS NULL THEN 0 ELSE assignments.score END AS score'),
            'assignments.detail as assignment_detail',
        ])
        ->leftJoin('assignments', 'assignments.id', 'assignment_files.assignment_id')
        ->leftJoin('students', 'students.id', 'assignments.student_id')
        ->where('assignments.task_id', $id)
        ->orderBy('assignments.created_at', 'desc')
        ->paginate(10);

        return view('admin.task-detail', compact('task', 'group', 'classroom', 'assignment'));
    }

    public function store(Request $request)
    {
        if ($request->hasFile('file_path')) {
            $file = $request->file('file_path');
            $name = 'Task_'.date('Y-m-d_s').'_'.$file->getClientOriginalName();
            $file->move(storage_path().'/files/', $name);

            $value = $name;
        } else {
            $value = $request->file_path;
        }

        Task::create([
            'user_id' => Auth::guard('admin')->id(),
            'group_id' => $request->group,
            'name' => $request->name,
            'detail' => $request->detail,
            'file_path' => $value,
            'expired_at' => $request->expired_at,
        ]);

        return Redirect::back();
    }

    public function update(Request $request, $id)
    {
        if ($request->hasFile('file_path')) {
            $file = $request->file('file_path');
            $name = 'Task_'.date('Y-m-d_s').'_'.$file->getClientOriginalName();
            $file->move(storage_path().'/files/', $name);

            $value = $name;
        } else {
            $value = $request->file_path;
        }

        Task::find($id)->update([
            'user_id' => Auth::guard('admin')->id(),
            'group_id' => $request->group,
            'name' => $request->name,
            'detail' => $request->detail,
            'file_path' => $value,
            'expired_at' => $request->expired_at,
        ]);

        return Redirect::back();
    }

    public function scoring(Request $request, $id)
    {
        Assignment::find($id)->update([
            'score' => $request->score,
        ]);

        return Redirect::back();
    }

    public function download(Request $request, $id)
    {
        $file = \DB::table('tasks')
            ->select([
                'tasks.file_path',
            ])
            ->where('id', $id)
            ->whereNull('deleted_at')
            ->first();

        return response()->download(storage_path('files/'.$file->file_path));
    }

    public function delete(Request $request, $id)
    {
        Task::find($id)->delete();

        return Redirect::back();
    }
}
