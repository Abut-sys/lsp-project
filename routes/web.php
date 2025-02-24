<?php

use App\Filament\Pages\UserLogin;
use Filament\Pages\Auth\EditProfile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\Auth\UserLoginController;
use App\Http\Controllers\Auth\UserRegisterController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        $user = Auth::user();
        return $user->role === 'admin'
            ? redirect()->route('filament.admin.pages.dashboard')
            : redirect()->route('welcome');
    })->name('dashboard');
});

Route::get('/register', [UserRegisterController::class, 'showRegisterForm'])->name('user.register.email');
Route::post('/register', [UserRegisterController::class, 'registerWithEmail'])->name('user.register.email.submit');

Route::get('/register/phone', [UserRegisterController::class, 'showRegisterPhoneForm'])->name('user.register.phone');
Route::post('/register/phone', [UserRegisterController::class, 'registerWithPhone'])->name('user.register.phone.submit');

Route::get('/login', [UserLoginController::class, 'showEmailLoginForm'])->name('user.login.email');
Route::get('/login/phone', [UserLoginController::class, 'showPhoneLoginForm'])->name('user.login.phone');

Route::post('/login', [UserLoginController::class, 'loginWithEmail'])->name('user.login.email.submit');
Route::post('/login/phone', [UserLoginController::class, 'loginWithPhone'])->name('user.login.phone.submit');

Route::post('/logout', [UserLoginController::class, 'logout'])->name('user.logout');
