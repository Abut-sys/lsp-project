<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserRegisterController extends Controller
{
    /**
     * Form Register Email
     */
    public function showRegisterForm()
    {
        return view('auth.register-email');
    }

    /**
     * Form Register Nomor Telepon
     */
    public function showRegisterPhoneForm()
    {
        return view('auth.register-phone');
    }

    /**
     * Register dengan Email
     */
    public function registerWithEmail(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email|max:255',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        Auth::login($user);
        return redirect()->route('user.login.email')->with('success', 'Registrasi berhasil! Silakan login.');
    }

    /**
     * Register dengan Nomor Telepon
     */
    public function registerWithPhone(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone_number' => 'required|string|unique:users,phone_number|regex:/^8[1-9][0-9]{7,11}$/',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $user = User::create([
            'name' => $request->name,
            'phone_number' => '+62' . $request->phone_number,
            'password' => Hash::make($request->password),
        ]);

        Auth::login($user);
        return redirect()->route('user.login.phone')->with('success', 'Registrasi berhasil! Silakan login.');
    }
}

