<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Database\QueryException;

class RegisterController extends Controller
{
    public function index()
    {
        return view('auth.register');
    }

    public function store(Request $request)
    {
       $validatedData = $request->validate([
            'name' => 'required|max:100',
            'email' => ['required', 'email:dns', 'unique:users'],
            'password' => ['required', 'min:8'],
            'role' => ['required', 'in:admin,pengguna,operator']
       ]);

       $validatedData['password'] = bcrypt($validatedData['password']);

       try {
           User::create($validatedData);
       } catch (QueryException $e)
       {
        return redirect()->back()->with('error', 'Gagal daftar');
       }
       return redirect('/login')->with('success', 'Registration successfull! Please Login');
    }
}
