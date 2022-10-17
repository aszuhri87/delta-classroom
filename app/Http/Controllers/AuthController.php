<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use Redirect;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $this->validate($request, [
            'email' => 'required',
        ]);

        $user = \App\Models\Student::where('email', $request->email)->first();

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
