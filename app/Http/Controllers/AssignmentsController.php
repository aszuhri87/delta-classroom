<?php

namespace App\Http\Controllers;

use App\Models\Assignment;
use App\Models\AssignmentFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class AssignmentsController extends Controller
{
    public function store(Request $request)
    {
        if ($request->hasFile('file_path')) {
            $file = $request->file('file_path');
            $name = $request->name.'_'.date('Y-m-d_s').'.'.$file->extension();
            $file->move(storage_path().'/assignment_files/', $name);

            $value = $name;
        } else {
            $value = $request->file_path;
        }

        $assignment = Assignment::create([
            'student_id' => Auth::id(),
            'task_id' => $request->task_id,
            'name' => $request->name,
            'detail' => $request->detail,
        ]);

        AssignmentFile::create([
            'assignment_id' => $assignment->id,
            'name' => $request->name,
            'file_path' => $value,
        ]);

        return Redirect::back();
    }

    public function update(Request $request, $id)
    {
        $assignment = Assignment::find($id);
        if ($request->hasFile('file_path')) {
            $file = $request->file('file_path');
            $name = $request->name.'_'.date('Y-m-d_s').'.'.$file->extension();
            $file->move(storage_path().'/assignment_files/', $name);

            $value = $name;
        } else {
            $value = $request->file_path;
        }

        $assignment = Assignment::create([
            'student_id' => Auth::id(),
            'task_id' => $request->task_id,
            'name' => $request->name,
            'detail' => $request->detail,
        ]);

        AssignmentFile::create([
            'assignment_id' => $assignment->id,
            'name' => $request->name,
            'file_path' => $value,
        ]);

        return Redirect::back();
    }

    public function download(Request $request, $id)
    {
        $file = DB::table('assignment_files')
            ->select([
                'file_path',
            ])
            ->where('id', $id)
            ->whereNull('deleted_at')
            ->first();

        return response()->download(storage_path('assignment_files/'.$file->file_path));
    }
}
