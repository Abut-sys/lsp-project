<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserLoginController extends Controller
{
    // Menampilkan halaman login dengan email
    public function showEmailLoginForm()
    {
        if (auth()->check()) {
            return redirect()->route('user.profile');
        }

        return view('auth.user-login-email');
    }

    // Menampilkan halaman login dengan nomor telepon
    public function showPhoneLoginForm()
    {
        return view('auth.user-login-phone');
    }

    // Proses login menggunakan email
    public function loginWithEmail(Request $request)
    {
        $credentials = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials, $request->filled('remember'))) {
            $request->session()->regenerate();
            return redirect('/');
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->withInput();
    }

    // Proses login menggunakan nomor telepon
    public function loginWithPhone(Request $request)
    {
        $credentials = $request->validate([
            'phone_number' => ['required', 'numeric'],
            'password'     => ['required'],
        ]);

        if (Auth::attempt($credentials, $request->filled('remember'))) {
            $request->session()->regenerate();
            return redirect('/');
        }

        return back()->withErrors([
            'phone_number' => 'Nomor telepon atau password salah.',
        ])->withInput();
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}

