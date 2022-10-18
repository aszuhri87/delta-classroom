<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PresenceController extends Controller
{
    public function index(Request $request, $id)
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
        ])
        ->leftJoin('groups', 'groups.id', 'students.group_id')
        ->whereNull('students.deleted_at');

        $list = DB::table('presences')
        ->select([
            'presences.student_id',
            'presences.classroom_id',
            'students.name as student_name',
            'students.group_name',
            'students.number as student_number',
            'classrooms.*',
            DB::raw('COUNT(presences.student_id) as presence_total'),
        ])->leftJoin('classrooms', 'classrooms.id', 'presences.classroom_id')
        ->leftJoinSub($student, 'students', function ($join) {
            $join->on('students.id', '=', 'presences.student_id');
        })
        ->groupBy('presences.student_id', 'presences.classroom_id', 'classrooms.id', 'students.name', 'students.group_name', 'students.number')
        ->whereNull('presences.deleted_at')
        ->where('presences.classroom_id', $id)
        ->paginate(10);

        return view('admin.presence-list', compact('list'));
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
        ])
        ->leftJoin('groups', 'groups.id', 'students.group_id')
        ->where('students.id', $id)
        ->first();

        $group = DB::table('groups')
        ->select([
            'groups.*',
        ])
        ->whereNull('deleted_at')
        ->get();

        return view('admin.student-detail', compact('student', 'group'));
    }

    public function store(Request $request)
    {
        $value = Hash::make($request->password);

        $student = Student::create([
            'name' => $request->name,
            'group_id' => $request->group,
            'phone_number' => $request->phone_number,
            'email' => $request->email,
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

        return Redirect::back();
    }
}
