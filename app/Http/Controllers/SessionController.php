<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;



class SessionController extends Controller
{
    public function create()
    {
        return view('auth.login');
    }

    public function store()
    {
        // validate
        $attributes = request()->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);
        // attempt to login the user
        Auth::attempt($attributes);
        // regenerate the session token
        request()->session()->regenerate();
        // redirect

        return redirect('/jobs');
    }

    public function destroy()
    {
        Auth::logout();

        return redirect('/');
    }
}
