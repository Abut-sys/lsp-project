<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use App\Models\User;
use App\Models\PasswordResetToken;
use App\Mail\SendOtpMail;

class ForgotPasswordController extends Controller
{
    // Menampilkan halaman lupa password
    public function showForgotPasswordForm()
    {
        return view('auth.forgot-password');
    }

    // Mengirim OTP ke email
    public function sendResetOtp(Request $request)
    {
        $request->validate(['email' => 'required|email|exists:users,email']);

        $user = User::where('email', $request->email)->first();
        $otp = rand(100000, 999999);

        // Simpan OTP ke database
        PasswordResetToken::updateOrCreate(
            ['email' => $user->email],
            ['token' => $otp, 'created_at' => now()]
        );

        // Kirim email OTP
        Mail::to($user->email)->send(new SendOtpMail($otp));

        // Simpan email di session untuk verifikasi OTP
        Session::put('reset_email', $user->email);

        return redirect()->route('password.verifyotp')->with('success', 'Kode OTP telah dikirim ke email Anda.');
    }

    // Menampilkan form verifikasi OTP
    public function showVerifyOtpForm()
    {
        return view('auth.passwords.verify-otp');
    }

    // Memeriksa OTP
    public function verifyOtp(Request $request)
    {
        $request->validate(['otp' => 'required|array|size:6', 'otp.*' => 'numeric']);

        // Combine the OTP array into a single string
        $otp = implode('', $request->otp);

        $email = Session::get('reset_email');
        $reset = PasswordResetToken::where('email', $email)->where('token', $otp)->first();

        if (!$reset) {
            return back()->withErrors(['otp' => 'Kode OTP salah atau kadaluarsa.']);
        }

        // Save email to session for password reset
        Session::put('verified_email', $email);

        // Delete the OTP after it's verified
        $reset->delete();

        // Redirect to the password reset page
        return redirect()->route('password.reset')->with('success', 'OTP valid. Silakan reset password.');
    }

    // Menampilkan form reset password
    public function showResetPasswordForm()
    {
        // Ambil email dari session setelah OTP diverifikasi
        $email = Session::get('verified_email');

        if (!$email) {
            return redirect()
                ->route('password.request')
                ->withErrors(['error' => 'Silakan verifikasi OTP terlebih dahulu.']);
        }

        return view('auth.passwords.reset', compact('email'));
    }

    // Memproses reset password
    public function resetPassword(Request $request)
    {
        $request->validate([
            'password' => 'required|min:6|confirmed',
        ]);

        $email = Session::get('verified_email');
        $user = User::where('email', $email)->first();

        if (!$user) {
            return redirect()
                ->route('password.request')
                ->withErrors(['email' => 'Email tidak ditemukan.']);
        }

        $user->update(['password' => Hash::make($request->password)]);

        // Hapus session email
        Session::forget('verified_email');
        Session::forget('reset_email');

        return redirect()->route('user.login.email')->with('success', 'Password berhasil diubah. Silakan login.');
    }
}
