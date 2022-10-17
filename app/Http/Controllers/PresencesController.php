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
            ])
            ->leftJoin('users', 'users.id', 'classrooms.user_id')
            ->orderBy('classrooms.division', 'desc')
            ->paginate(10);

        $history = DB::table('presences')
            ->select([
                'presences.student_id',
                'presences.classroom_id',
                'presences.datetime',
                'classrooms.*',
                DB::raw('COUNT(presences.student_id) as presence_total'),
            ])->leftJoin('classrooms', 'classrooms.id', 'presences.classroom_id')
            ->groupBy('presences.student_id', 'presences.classroom_id', 'classrooms.id', 'presences.datetime')
            ->whereNull('presences.deleted_at')
            ->where('presences.student_id', Auth::id())
            ->orderBy('presences.datetime', 'desc')
            ->paginate(10);

        return view('presence-list', compact('list', 'history'));
    }

    public function store(Request $request)
    {
        $class = Classroom::where('presence_code', $request->presence_code)->first();

        $presence = Presence::where('classroom_id', $class->id)->first();

        if ($presence) {
            return Redirect::back()->withErrors(['message' => 'Presensi gagal!, Anda sudah masuk ke kelas ini'])->withInput();
        }

        if (!$class) {
            return Redirect::back()->withErrors(['message' => 'Presensi gagal!, Kode Tidak Dikenal.'])->withInput();
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
