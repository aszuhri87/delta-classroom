<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Group;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class GroupController extends Controller
{
    public function index(Request $request)
    {
        $list = DB::table('groups')
            ->select([
                'groups.id',
                'groups.name',
            ])
            ->orderBy('groups.created_at', 'desc')
            ->whereNull('groups.deleted_at')
            ->paginate(10);

        return view('admin.group-list', compact('list'));
    }

    public function show(Request $request, $id)
    {
        $group = DB::table('groups')
        ->select([
            'groups.id',
            'groups.name',
        ])
        ->where('groups.id', $id)
        ->whereNull('groups.deleted_at')
        ->first();

        return view('admin.group-detail', compact('group'));
    }

    public function store(Request $request)
    {
        $group = Group::create([
            'name' => $request->name,
        ]);

        return Redirect::back();
    }

    public function update(Request $request, $id)
    {
        $edit = Group::find($id);
        $edit->update([
            'name' => $request->name ? $request->name : $edit->name,
        ]);

        return Redirect::back();
    }

    public function delete(Request $request, $id)
    {
        Group::find($id)->delete();

        return Redirect::back();
    }
}
