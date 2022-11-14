<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }

    public function authenticate(Request $request)
    {
       $credentials = $request->validate([
            'email' => ['required', 'email:dns'],
            'password' => ['required']
        ]);

        if(auth()->attempt($credentials))
        {
            $role = auth()->user()->role;
            if( $role === 'admin')
            {
                return redirect('/dashboard');
            }
                else if($role === 'operator')
            {
                return redirect('/operator');
            }
                else
            {
                return redirect('/pengguna');
            }
        }

        return back()->with('loginError', 'Login failed!');
    }

}
