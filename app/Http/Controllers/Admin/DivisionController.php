<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Division;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class DivisionController extends Controller
{
    public function index(Request $request)
    {
        $list = DB::table('divisions')
            ->select([
                'divisions.id',
                'divisions.name',
            ])
            ->orderBy('divisions.created_at', 'desc')
            ->paginate(10);

        return view('admin.division-list', compact('list'));
    }

    public function show(Request $request, $id)
    {
        $division = DB::table('divisions')
        ->select([
            'divisions.id',
            'divisions.name',
        ])
        ->where('divisions.id', $id)
        ->first();

        return view('admin.division-detail', compact('division'));
    }

    public function store(Request $request)
    {
        $division = Division::create([
            'name' => $request->name,
        ]);

        return Redirect::back();
    }

    public function update(Request $request, $id)
    {
        $edit = Division::find($id);
        $edit->update([
            'name' => $request->name ? $request->name : $edit->name,
        ]);

        return Redirect::back();
    }

    public function delete(Request $request, $id)
    {
        Division::find($id)->delete();

        return Redirect::back();
    }
}
