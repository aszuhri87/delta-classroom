<?php

namespace App\Http\Controllers;

use App\Models\Assignment;
use App\Models\AssignmentFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Redirect;

class AssignmentsController extends Controller
{
    public function store(Request $request)
    {
        if ($request->hasFile('file_path')) {
            $file = $request->file('file_path');
            $name = str_replace('.'.$file->extension(), '_', str_replace(' ', '_', $file->getClientOriginalName())).'_'.date('Y-m-d_s').'.'.$file->extension();
            $file->move(storage_path().'/app/public/assignment_files/', $name);

            $value = $name;
        } else {
            $value = $request->file_path;
        }

        $assignment = Assignment::create([
            'student_id' => Auth::id(),
            'task_id' => $request->task_id,
            'detail' => $request->detail,
        ]);

        AssignmentFile::create([
            'assignment_id' => $assignment->id,
            'name' => $value,
            'file_path' => storage_path().'/app/public/assignment_files/',
        ]);

        return Redirect::back();
    }

    public function update(Request $request, $id)
    {
        $assignment = Assignment::find($id);
        if ($request->hasFile('file_path')) {
            $file = $request->file('file_path');
            $name = str_replace('.'.$file->extension(), '_', str_replace(' ', '_', $file->getClientOriginalName())).'_'.date('Y-m-d_s').'.'.$file->extension();
            $file->move(storage_path().'/app/public/assignment_files/', $name);

            $value = $name;
        } else {
            $value = $request->file_path;
        }

        $assignment->update([
            'student_id' => Auth::id(),
            'task_id' => $request->task_id,
            'detail' => $request->detail,
        ]);

        $assignment_file = AssignmentFile::where('assignment_id', $id);
        $assignment_file->update([
            'assignment_id' => $assignment->id,
            'name' => $value,
            'file_path' => storage_path().'/app/public/assignment_files/',
        ]);

        return Redirect::back();
    }

    public function download(Request $request, $id)
    {
        $filex = DB::table('assignment_files')
            ->select([
                'name',
                DB::raw('CONCAT(assignment_files.file_path,assignment_files.name) as file_path'),
            ])
            ->where('id', $id)
            ->whereNull('deleted_at')
            ->first();

        $mime = File::mimeType($filex->file_path);

        $file = 'storage/assignment_files/'.$filex->name;

        return view('stream', compact('file', 'mime'));
    }
}
