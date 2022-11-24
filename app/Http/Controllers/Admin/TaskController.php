<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Assignment;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Redirect;

class TaskController extends Controller
{
    public function index(Request $request)
    {
        if (Auth::guard('admin')->user()->division_id != null) {
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
            ->whereNull('tasks.deleted_at')
            ->where('tasks.division_id', Auth::guard('admin')->user()->division_id)
            ->paginate(10);
        } else {
            $list = DB::table('tasks')
            ->select([
                'tasks.*',
                'tasks.name as task_name',
                'users.name as teacher_name',
                'groups.name as group_name',
            ])
            ->leftJoin('users', 'users.id', 'tasks.user_id')
            ->leftJoin('groups', 'groups.id', 'tasks.group_id')
            ->whereNull('tasks.deleted_at')
            ->orderBy('tasks.created_at', 'desc')
            ->paginate(10);
        }

        $group = DB::table('groups')
            ->select([
                'groups.*',
            ])
            ->whereNull('deleted_at')
            ->get();

        $division = DB::table('divisions')
            ->select(['*'])
            ->get();

        return view('admin.task-list', compact('list', 'group', 'division'));
    }

    public function show(Request $request, $id)
    {
        $task = DB::table('tasks')
            ->select([
                'tasks.*',
                'tasks.name as task_name',
                'users.name as teacher_name',
                'groups.name as group_name',
                'groups.id as group_id',
                'divisions.name as division',
                'tasks.division_id',
            ])
            ->leftJoin('users', 'users.id', 'tasks.user_id')
            ->leftJoin('groups', 'groups.id', 'tasks.group_id')
            ->leftJoin('divisions', 'divisions.id', 'tasks.division_id')
            ->where('tasks.id', $id)
            ->whereNull('tasks.deleted_at')
            ->orderBy('tasks.created_at', 'desc')
            ->first();

        $task->task_file = str_replace('storage/files/', '', $task->file_path);

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
            'assignment_files.id',
            'assignment_files.assignment_id',
            'assignment_files.name as assignment_name',
            'students.name as student_name',
            'assignments.detail',
            'assignments.created_at as submitted_at',
            DB::raw('CONCAT(assignment_files.file_path,assignment_files.name) as file_path'),
            DB::raw('CASE WHEN assignments.score IS NULL THEN 0 ELSE assignments.score END AS score'),
        ])
        ->leftJoin('assignments', 'assignments.id', 'assignment_files.assignment_id')
        ->leftJoin('students', 'students.id', 'assignments.student_id')
        ->where('assignments.task_id', $id)
        ->whereNull('assignments.deleted_at')
        ->orderBy('assignments.created_at', 'desc')
        ->paginate(10);

        $division = DB::table('divisions')
        ->select(['*'])
        ->get();

        return view('admin.task-detail', compact('task', 'group', 'classroom', 'assignment', 'division'));
    }

    public function store(Request $request)
    {
        if ($request->hasFile('file_path')) {
            $file = $request->file('file_path');
            $name = str_replace(' ', '_', $request->name).'_'.date('Y-m-d_s').'_.'.$file->extension();
            $file->move(storage_path().'/app/public/files', $name);

            $value = 'storage/files/'.$name;
        } else {
            $value = $request->file_path;
        }

        if ($request->division) {
            $division = $request->division;
        } else {
            $division = Auth::guard('admin')->user()->division_id;
        }

        Task::create([
            'user_id' => Auth::guard('admin')->id(),
            'group_id' => $request->group,
            'name' => $request->name,
            'detail' => $request->detail,
            'file_path' => $value,
            'expired_at' => $request->expired_at,
            'division_id' => $division,
        ]);

        return Redirect::back();
    }

    public function update(Request $request, $id)
    {
        if ($request->hasFile('file_path')) {
            $file = $request->file('file_path');
            $name = str_replace(' ', '_', $request->name).'_'.date('Y-m-d_s').'_.'.$file->extension();
            $file->move(storage_path().'/app/public/files', $name);

            $value = 'storage/files/'.$name;
        } else {
            $value = $request->file_path;
        }

        if ($request->division) {
            $division = $request->division;
        } else {
            $division = Auth::guard('admin')->user()->division_id;
        }

        Task::find($id)->update([
            'user_id' => Auth::guard('admin')->id(),
            'group_id' => $request->group,
            'name' => $request->name,
            'detail' => $request->detail,
            'file_path' => $value,
            'expired_at' => $request->expired_at,
            'division_id' => $division,
        ]);

        return Redirect::back();
    }

    public function scoring(Request $request)
    {
        $id = $request->assignment_id;

        Assignment::find($id)->update([
            'score' => $request->score,
        ]);

        return Redirect::back();
    }

    public function download(Request $request, $id)
    {
        $filex = DB::table('tasks')
            ->select([
                'file_path',
            ])
            ->where('id', $id)
            ->whereNull('deleted_at')
            ->first();

        $mime = File::mimeType(storage_path('/app/public/files', $filex->file_path));

        $file = 'storage/files/'.$filex->file_path;

        return view('admin.stream', compact('file', 'mime'));
    }

    public function download_assign(Request $request, $id)
    {
        $filex = DB::table('assignment_files')
        ->select([
            'name',
            DB::raw('CONCAT(assignment_files.file_path,assignment_files.name) as file_path'),
        ])
        ->where('assignment_id', $id)
        ->whereNull('deleted_at')
        ->first();

        $mime = File::mimeType($filex->file_path);

        $ext = File::extension($filex->file_path);

        $file = 'storage/assignment_files/'.$filex->name;

        return view('admin.stream', compact('file', 'mime'));
    }

    public function delete(Request $request, $id)
    {
        Task::find($id)->delete();

        return Redirect::back();
    }
}
