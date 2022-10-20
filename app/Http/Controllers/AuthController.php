<?php

namespace App\Http\Controllers;

use Auth;
use Hash;
use Illuminate\Http\Request;
use Redirect;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $this->validate($request, [
            'email' => 'required',
        ]);

        $user = \App\Models\Student::where('email', $request->email)->whereNull('deleted_at')->first();

        if (!$user) {
            return Redirect::back()->withErrors(['message' => 'Login failed!, check your email or password.'])->withInput();
            if (!Hash::check($request->password, $user->password)) {
                return Redirect::back()->withErrors(['message' => 'Login failed!, check your password.'])->withInput();
            }
        }

        if ($user && Auth::login($user)) {
            return redirect('/task');
        } else {
            return Redirect::back()->withErrors(['message' => 'Login failed!, check your email.'])->withInput();
        }
    }

    public function logout()
    {
        if (Auth::check()) {
            Auth::logout();
            session()->flush();
        }

        return redirect('/');
    }
}
