<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;

class ProfileController extends Controller
{
    public function profile()
    {
        $student = Student::where('id', Auth::id())
        ->select(['*'])
        ->first();

        return view('profile', compact('student'));
    }

    public function update_password(Request $request)
    {
        if ($request->password == $request->c_password) {
            $pass = Hash::make($request->password);
            $student = Student::find(Auth::id());
            $student->update([
                'password' => $pass,
            ]);

            return Redirect::back()->with('success', 'Update sukses!');
        } else {
            return Redirect::back()->withErrors(['message' => 'Update password gagal!, password dan konfirmasi password tidak sama.'])->withInput();
        }
    }
}
