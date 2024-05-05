<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function login()
    {
        // Check if user is already authenticated, if yes, redirect to home
        if (Auth::check()) {
            return redirect()->route('home');
        } else {
            return view('admin.login');
        }
        
        return view('admin.login');
    }

    public function doLogin(Request $request) 
    {
        $credentials = $request->validate([
            'username' => ['required'],
            'password' => ['required'],
        ]);
    
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            
            // Store user in session
            $user = Auth::user();
            $request->session()->put('user', $user);
            
            return redirect()->route('home');
        } else {
            Session::flash('error', 'Username atau Password Salah');
            return redirect()->back()->with('error', 'Username atau Password Salah');
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('landing');
    }
}
