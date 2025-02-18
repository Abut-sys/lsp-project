<?php

namespace App\Http\Controllers;

use Filament\Http\Controllers\Auth\LoginController as FilamentLoginController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminLoginController extends FilamentLoginController
{
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            if ($user->role !== 'admin') {
                Auth::logout();
                return redirect('/login')->withErrors(['email' => 'Anda bukan admin!']);
            }

            return redirect('/admin');
        }

        return back()->withErrors(['email' => 'Email atau password salah!']);
    }
}
