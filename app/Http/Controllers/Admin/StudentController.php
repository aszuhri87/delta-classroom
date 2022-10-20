<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Imports\ImportStudent;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Maatwebsite\Excel\Facades\Excel;

class StudentController extends Controller
{
    public function index(Request $request)
    {
        $list = DB::table('students')
            ->select([
                'students.id',
                'students.name',
                'groups.name as group_name',
                'students.phone_number',
                'students.number',
            ])
            ->leftJoin('groups', 'groups.id', 'students.group_id')
            ->orderBy('students.group_id', 'asc')
            ->whereNull('students.deleted_at')
            ->paginate(10);

        $group = DB::table('groups')
            ->select([
                'groups.*',
            ])
            ->whereNull('deleted_at')
            ->paginate(10);

        return view('admin.student-list', compact('list', 'group'));
    }

    public function show(Request $request, $id)
    {
        $student = DB::table('students')
        ->select([
            'students.id',
            'students.name',
            'students.school_origin',
            'groups.name as group_name',
            'students.group_id',
            'students.phone_number',
            'students.email',
            'students.number',
            'students.birth',
        ])
        ->leftJoin('groups', 'groups.id', 'students.group_id')
        ->where('students.id', $id)
        ->whereNull('students.deleted_at')
        ->first();

        $group = DB::table('groups')
        ->select([
            'groups.*',
        ])
        ->whereNull('deleted_at')
        ->get();

        $history = DB::table('presences')
        ->select([
            'presences.student_id',
            'presences.classroom_id',
            'presences.datetime',
            'classrooms.*',
            DB::raw('COUNT(presences.student_id) as presence_total'),
        ])
        ->leftJoin('classrooms', 'classrooms.id', 'presences.classroom_id')
        ->groupBy('presences.student_id', 'presences.classroom_id', 'classrooms.id', 'presences.datetime')
        ->whereNull('presences.deleted_at')
        ->where('presences.student_id', $id)
        ->where(function ($query) {
            if (\Auth::guard('admin')->user()->division_id) {
                $query->where('classrooms.division_id', \Auth::guard('admin')->user()->division_id);
            }
        })
        ->whereNull('presences.deleted_at')
        ->orderBy('presences.datetime', 'desc')
        ->paginate(10);

        return view('admin.student-detail', compact('student', 'group', 'history'));
    }

    public function store(Request $request)
    {
        $date = date('d-m-Y', strtotime($request->birth));

        $pass = str_replace('-', '', $date);

        $value = Hash::make($pass);

        $student = Student::create([
            'name' => $request->name,
            'group_id' => $request->group,
            'phone_number' => $request->phone_number,
            'email' => $request->email,
            'birth' => $request->birth,
            'password' => $value,
            'number' => $request->number,
            'school_origin' => $request->school_origin,
        ]);

        return Redirect::back();
    }

    public function update(Request $request, $id)
    {
        $edit = Student::find($id);
        $edit->update([
            'name' => $request->name ? $request->name : $edit->name,
            'group_id' => $request->group ? $request->group : $edit->group_id,
            'phone_number' => $request->phone_number ? $request->phone_number : $edit->phone_number,
            'email' => $request->email ? $request->email : $edit->email,
            'birth' => $request->birth ? $request->birth : $edit->birth,
            'password' => Hash::make($request->new_password) ? Hash::make($request->new_password) : $edit->password,
            'number' => $request->number ? $request->number : $edit->number,
            'school_origin' => $request->school_origin ? $request->school_origin : $edit->school_origin,
        ]);

        return Redirect::back();
    }

    public function download(Request $request, $id)
    {
        $file = DB::table('students')
            ->select([
                'students.file_path',
            ])
            ->where('id', $id)
            ->whereNull('deleted_at')
            ->first();

        return response()->download(storage_path('files/'.$file->file_path));
    }

    public function delete(Request $request, $id)
    {
        Student::find($id)->delete();

        return redirect('admin/student');
    }

    public function import(Request $request)
    {
        Excel::import(new ImportStudent(), $request->file('file'));

        return Redirect::back();
    }
}
