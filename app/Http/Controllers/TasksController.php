<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TasksController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $student = Student::find(Auth::id())->first();

        $list = DB::table('tasks')
            ->select([
                'tasks.*',
                'tasks.name as task_name',
                'users.name as teacher_name',
                'groups.name as group_name',
            ])
            ->leftJoin('users', 'users.id', 'tasks.user_id')
            ->leftJoin('groups', 'groups.id', 'tasks.group_id')
            ->where('tasks.group_id', $student->group_id)
            ->whereNull('tasks.deleted_at')
            ->orderBy('tasks.created_at', 'desc')
            ->paginate(10);

        return view('dashboard', compact('list'));
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

        $assignment = DB::table('assignment_files')
            ->select([
                'assignment_files.id',
                'assignment_files.name as assign_name',
                'assignment_files.file_path',
                DB::raw('CASE WHEN assignments.score IS NULL THEN 0 ELSE assignments.score END AS score'),
                DB::raw("CASE WHEN assignments.detail IS NULL THEN '-' ELSE assignments.detail END AS detail"),
                'assignment_files.created_at',
                'assignment_files.assignment_id',
            ])
            ->leftJoin('assignments', 'assignments.id', 'assignment_files.assignment_id')
            ->where('assignments.student_id', Auth::id())
            ->where('assignments.task_id', $task->id)
            ->whereNull('assignment_files.deleted_at')
            ->first();

        return view('task-detail', compact('task', 'assignment'));
    }

    public function download(Request $request, $id)
    {
        $file = DB::table('tasks')
            ->select([
                'tasks.file_path',
            ])
            ->where('id', $id)
            ->whereNull('deleted_at')
            ->first();

        return response()->download(storage_path('files/'.$file->file_path));
    }
}
