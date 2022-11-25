<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use Redirect;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $login = [
            'email' => $request->email,
            'password' => $request->password,
        ];

        if (Auth::attempt($login)) {
            return redirect('/dashboard');
        } else {
            return Redirect::back()->withErrors(['message' => 'Login failed!, check your username and password!.'])->withInput();
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
