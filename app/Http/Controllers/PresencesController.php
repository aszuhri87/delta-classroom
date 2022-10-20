<?php

namespace App\Http\Controllers;

use App\Models\Classroom;
use App\Models\Presence;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class PresencesController extends Controller
{
    public function index(Request $request)
    {
        $list = DB::table('classrooms')
            ->select([
                'classrooms.*',
                'users.name as teacher_name',
                'divisions.name as division',
            ])
            ->leftJoin('divisions', 'divisions.id', 'classrooms.division_id')
            ->leftJoin('users', 'users.id', 'classrooms.user_id')
            ->whereNull('classrooms.deleted_at')
            ->paginate(10);

        $history = DB::table('presences')
            ->select([
                'presences.student_id',
                'presences.classroom_id',
                'presences.datetime',
                'divisions.name as division',
                'classrooms.*',
            ])
            ->leftJoin('classrooms', 'classrooms.id', 'presences.classroom_id')
            ->leftJoin('divisions', 'divisions.id', 'classrooms.division_id')
            ->whereNull('presences.deleted_at')
            ->where('presences.student_id', Auth::id())
            ->whereNull('presences.deleted_at')
            ->orderBy('presences.datetime', 'desc')
            ->paginate(10);

        return view('presence-list', compact('list', 'history'));
    }

    public function store(Request $request)
    {
        $class = Classroom::where('presence_code', $request->presence_code)->first();

        if (!$class) {
            return Redirect::back()->withErrors(['message' => 'Presensi gagal!, Kode tidak dikenal.'])->withInput();
        }

        $presence = Presence::where('classroom_id', $class->id)->first();

        if ($presence) {
            return Redirect::back()->withErrors(['message' => 'Presensi gagal!, Anda presensi di kelas ini'])->withInput();
        }

        if ($request->presence_code == $class->presence_code) {
            Presence::create([
                'student_id' => Auth::id(),
                'classroom_id' => $class->id,
                'datetime' => date('Y-m-d H:i:s'),
            ]);

            return Redirect::back()->with('success', 'Presence success!');
        } else {
            return Redirect::back()->withErrors(['message' => 'Presensi gagal!, Kode Tidak Dikenal.'])->withInput();
        }
    }
}
